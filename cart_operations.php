<?php
session_start();

function addToCart($productId, $quantity) {
    // Ensure we have a cart array to work with
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update product quantity in cart
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
        // Assuming getProductById is a function that retrieves product details by ID
        $product = getProductById($productId);
        if ($product) {
            $_SESSION['cart'][$productId] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        } else {
            // Handle error - product does not exist
            return false;
        }
    }
    return true;
}

function updateQuantity($productId, $quantity) {
    if (isset($_SESSION['cart'][$productId])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        } else {
            // If the quantity is zero or less, remove the item from the cart
            unset($_SESSION['cart'][$productId]);
        }
        return true;
    }
    return false;
}

function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        return true;
    }
    return false;
}

function clearCart() {
    $_SESSION['cart'] = [];
}

// Implement `getProductById` if not already implemented
function getProductById($productId) {
    // This should interface with your product storage to retrieve a product by ID.
    // This is a placeholder for the actual implementation.
    // You would typically perform a database query here.
    // For now, we'll return a dummy array for the sake of demonstration.

    require 'crud_operations.php'; // Assuming this is where your CRUD operations are defined

    return readProduct($productId); // This function should return the product array or false if not found
}
