<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../vendor/autoload.php';
require_once '../config/secrets.php';
require_once '../config/db.php'; // Include the database configuration

\Stripe\Stripe::setApiKey($stripeSecretKey);
session_start();

$YOUR_DOMAIN = 'https://zuzanagabonayova.eu/';

// Retrieve cart items from session
$cartItems = $_SESSION["shopping_cart"] ?? [];

// Prepare line items for Stripe Checkout
$line_items = array_map(function ($item) {
    return [
        'price' => $item['stripe_price_id'], 
        'quantity' => $item['item_quantity'],
    ];
}, $cartItems);

// Create the Checkout Session
$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => $line_items,
    'phone_number_collection' => ['enabled' => true],
    'mode' => 'payment',
    'shipping_address_collection' => ['allowed_countries' => ['DK']],
    'success_url' => $YOUR_DOMAIN . 'src/views/frontend/success.html',
    'cancel_url' => $YOUR_DOMAIN . 'src/views/frontend/cancel.html',
]);

// Redirect to Stripe Checkout
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);

// Handle successful payment
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    // Retrieve the payment intent ID from the query parameters
    $paymentIntentId = $_GET['payment_intent'];

    // Retrieve the customer details from the payment intent metadata
    $customerName = $_GET['customer_name'];
    $customerEmail = $_GET['customer_email'];
    $customerPhone = $_GET['customer_phone'];
    $shippingAddress = $_GET['shipping_address'];

    // Insert order details into the database
    $sql = "INSERT INTO orders (payment_intent_id, customer_name, customer_email, customer_phone, shipping_address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssss", $paymentIntentId, $customerName, $customerEmail, $customerPhone, $shippingAddress);
        $stmt->execute();
        $stmt->close();
    }
    
    // Clear the shopping cart
    $_SESSION["shopping_cart"] = [];
    
    // Redirect to a thank you page or any other appropriate page
    header("Location: " . $YOUR_DOMAIN . 'src/views/frontend/thank_you.html');
    exit();
}

