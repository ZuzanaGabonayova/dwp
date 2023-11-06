<?php
session_start();

// Include your crud_operations.php file to access the readProduct function
require 'crud_operations.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;  // Default to 1 if not set

    // Use the readProduct function to fetch the product details
    $product = readProduct($productId);

    if (!$product) {
        // Handle error - product does not exist
        exit('Product not found.');
    }

    // Initialize cart array in session if not present
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add product to cart or update the quantity if it already exists
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity
        ];
    }

    // Redirect back to the product list or to the cart page
    header('Location: visitor_product_page.php'); // Redirect to the visitor product page
    exit();
}
?>