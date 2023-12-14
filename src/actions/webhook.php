<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Dotenv\Dotenv;

require_once __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../config/db.php';

$dotenv = Dotenv::createImmutable('/home/master/applications/phqmbyaurd/public_html'); // Adjusted path to load .env from two directories back
$dotenv->load();

// Stripe configuration
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY'] ?? null);
$stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY'] ?? null);

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
} catch (\UnexpectedValueException $e) {
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit();
}

// Handle the event
switch ($event->type) {
    case 'checkout.session.completed':
        $session = $event->data->object;

        $customerEmail = isset($session->customer_details->email) ? $session->customer_details->email : null;
        $paymentMethodTypes = json_encode($session->payment_method_types);
        $shippingAddress = json_encode($session->shipping_details);

        $stmt = $conn->prepare("INSERT INTO orders (session_id, payment_intent_id, amount_total, currency, customer_id, customer_email, payment_status, customer_name, customer_phone, shipping_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $sessionId = $session->id;
        $paymentIntentId = $session->payment_intent;
        $amountTotal = $session->amount_total;
        $currency = $session->currency;
        $customerId = $session->customer;
        $paymentStatus = $session->payment_status;
        $customerName = $session->customer_details->name;
        $customerPhone = $session->customer_details->phone;

        $stmt->bind_param("ssisssssss", $sessionId, $paymentIntentId, $amountTotal, $currency, $customerId, $customerEmail, $paymentStatus, $customerName, $customerPhone, $shippingAddress);

        if ($stmt->execute()) {
            echo "New record created successfully";
            $order_id = $conn->insert_id;

            // Fetch line items from Stripe
            $lineItems = $stripe->checkout->sessions->allLineItems($sessionId, ['limit' => 5]);
            foreach ($lineItems->data as $item) {
                $productName = $item->description;
                $quantity = $item->quantity;

                $stmtLineItem = $conn->prepare("INSERT INTO order_line_items (order_id, product_name, quantity) VALUES (?, ?, ?)");
                $stmtLineItem->bind_param("isi", $order_id, $productName, $quantity);

                if (!$stmtLineItem->execute()) {
                    echo "Error inserting line item: " . $stmtLineItem->error;
                }
                $stmtLineItem->close();
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        break;
    // ... [Other cases]
}

$conn->close();
http_response_code(200);
?>
