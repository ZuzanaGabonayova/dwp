<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';
require_once '../config/db.php';

// Stripe configuration
$stripe = new \Stripe\StripeClient('sk_test_51OMqZxD7CQBEfsgzCUQ19XaHyqwJHTK9ejG5IjlGs4CaQUpBPSP8M4no8rgXkzfSm5DU0LIxUneFODPiblzB8lMQ0000soVBL9'); // Your secret key
$endpoint_secret = 'whsec_d2764021b1d8ac9649dc817afef5f5c2b0b6ae20b82d6540942028480400ffc8'; // Your endpoint secret

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

    // Prepare an insert statement
    $stmt = $mysqli->prepare("INSERT INTO orders (session_id, payment_intent_id, amount_total, currency, customer_id, customer_email, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Extracting data from the session
    $sessionId = $session->id;
    $paymentIntentId = $session->payment_intent;
    $amountTotal = $session->amount_total;
    $currency = $session->currency;
    $customerId = $session->customer;
    $customerEmail = $session->customer_details->email; // Make sure this exists
    $paymentStatus = $session->payment_status;

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ssissss", $sessionId, $paymentIntentId, $amountTotal, $currency, $customerId, $customerEmail, $paymentStatus);

    // Execute the query
    if ($stmt->execute()) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
    break;
  // ... handle other event types
  default:
    echo 'Received unknown event type ' . $event->type;
}

// Close connection
$mysqli->close();

http_response_code(200);
?>
