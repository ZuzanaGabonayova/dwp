<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '../../../vendor/autoload.php';
require_once __DIR__ . '../../config/db.php';

// Stripe configuration
$stripe = new \Stripe\StripeClient('sk_test_51OMqZxD7CQBEfsgzCUQ19XaHyqwJHTK9ejG5IjlGs4CaQUpBPSP8M4no8rgXkzfSm5DU0LIxUneFODPiblzB8lMQ0000soVBL9'); // Your secret key
$endpoint_secret = 'whsec_Tfe8ILTXdbZ80jc9UwTIAeV9LJWJFozK'; // Your endpoint secret

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
} catch (\UnexpectedValueException $e) {
  http_response_code(400); // Invalid payload
  exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
  http_response_code(400); // Invalid signature
  exit();
}



// Handle the event
switch ($event->type) {
  case 'checkout.session.completed':
    $session = $event->data->object;

    // Check if customer details and email are set
    $customerEmail = isset($session->customer_details->email) ? $session->customer_details->email : null;

    // Serialize payment method types and shipping address
    $paymentMethodTypes = json_encode($session->payment_method_types);
    $shippingAddress = json_encode($session->shipping_details);

    // Prepare an insert statement
    $stmt = $conn->prepare("INSERT INTO orders (session_id, payment_intent_id, amount_total, currency, customer_id, customer_email, payment_status, shipping_address, customer_name, customer_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");


    // Extracting data from the session
    $sessionId = $session->id;
    $paymentIntentId = $session->payment_intent;
    $amountTotal = $session->amount_total;
    $currency = $session->currency;
    $customerId = $session->customer; // Can be null
    $paymentStatus = $session->payment_status;
    $customerName = $session->customer_details->name;
    $customerPhone = $session->customer_details->phone;


    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ssissssss", $sessionId, $paymentIntentId, $amountTotal, $currency, $customerId, $customerEmail, $paymentStatus, $shippingAddress, $customerName, $customerPhone);

    // Execute the query
    if ($stmt->execute()) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
    break;
  // ... [Other cases]
}


// Close connection
$conn->close();

http_response_code(200);
?>
