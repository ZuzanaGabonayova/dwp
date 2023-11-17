<?php
session_start(); // Start the session.

require 'db.php'; // Make sure this path is correct.
require 'crud_operations.php'; // Make sure this path is correct.

// If the cart is not set in the session, initialize it as an empty array.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Function to update cart item quantity
function updateCartItem($productId, $quantity) {
    if ($quantity == 0) {
        unset($_SESSION['cart'][$productId]);
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

// Function to remove an item from the cart
function removeCartItem($productId) {
    unset($_SESSION['cart'][$productId]);
}

// Check if update/remove actions have been requested
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $productId = intval($_POST['ProductID']);
        $quantity = intval($_POST['quantity']);
        updateCartItem($productId, $quantity);
    } elseif (isset($_POST['remove'])) {
        $productId = intval($_POST['ProductID']);
        removeCartItem($productId);
    }
    // After updating, redirect back to the cart page to see the changes
    header('Location: view_cart.php');
    exit;
}

// Get product details for items in the cart
$cartItems = array();
foreach ($_SESSION['cart'] as $productId => $quantity) {
    $product = readProduct($productId); // You would need to implement this function to get product details by ID.
    if ($product) {
        $cartItems[$productId] = $product;
        $cartItems[$productId]['quantity'] = $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <link rel="stylesheet" href="output.css">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <h2 class="text-4xl font-semibold mb-6">Shopping Cart</h2>

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="flex flex-col">
            <?php foreach ($cartItems as $id => $item): ?>
                <div class="flex justify-between items-center bg-white p-4 mb-4 rounded shadow">
                    <div class="flex items-center">
                        <img class="w-16 h-16 mr-4" src="<?php echo htmlspecialchars($item['ProductMainImage']); ?>" alt="<?php echo htmlspecialchars($item['Model']); ?>">
                        <div>
                            <div class="font-bold"><?php echo htmlspecialchars($item['Model']); ?></div>
                            <div>$<?php echo htmlspecialchars(number_format($item['Price'], 2)); ?></div>
                        </div>
                    </div>
                    <form class="flex items-center" action="view_cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                        <input class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" class="form-input rounded mr-2">
                        <button type="submit" name="update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mr-2">Update</button>
                        <button type="submit" name="remove" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
