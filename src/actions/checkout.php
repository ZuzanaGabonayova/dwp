<?php

require_once '../../vendor/autoload.php';
require_once '../config/secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'https://zuzanagabonayova.eu/';

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
    'price' => '{{PRICE_ID}}',
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . 'src/views/frontend/success.html',
  'cancel_url' => $YOUR_DOMAIN . 'src/views/frontend//cancel.html',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);