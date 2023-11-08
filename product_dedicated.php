<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Include CRUD operations file
require 'crud_operations.php';
require 'db.php';

// Assume $productID is provided to query the product
$productID = 8; // Example product ID

// Fetch product data
$product = readProduct($productID);

// Check if product data is available
if ($product) {
    // Start of HTML content
    echo '<div class="container mx-auto mt-10">';
    echo '<div class="flex flex-wrap -mx-4">';

    // Display product details
    echo '<div class="w-full md:w-1/2 px-4 mb-8">';
    echo '<img class="w-full h-auto rounded shadow" src="' . $product['ProductMainImage'] . '" alt="Product Image">';
    echo '</div>';

    echo '<div class="w-full md:w-1/2 px-4 mb-8">';
    echo '<h2 class="text-2xl font-bold mb-2">' . $product['Model'] . '</h2>';
    echo '<p class="text-gray-700 mb-4">' . $product['Description'] . '</p>';
    echo '<p class="text-gray-700 mb-4"><strong>Price:</strong> $' . $product['Price'] . '</p>';
    echo '<p class="text-gray-700 mb-4"><strong>Color:</strong> ' . $product['Color'] . '</p>';
    echo '<p class="text-gray-700 mb-4"><strong>Size:</strong> ' . $product['Size'] . '</p>';
    echo '<p class="text-gray-700 mb-4"><strong>Stock Quantity:</strong> ' . $product['StockQuantity'] . '</p>';
    echo '</div>';

    // End of HTML content
    echo '</div>';
    echo '</div>';
} else {
    echo 'Product not found.';
}
?>
