<?php
session_start();
require 'db.php'; // Include the database configuration

// Redirection flag
$shouldRedirect = false;

if (isset($_GET["action"])) {
    $action = $_GET["action"];

    if ($action == "add" && isset($_GET["id"])) {
        $productID = $_GET["id"];
        $productModel = isset($_GET["hidden_name"]) ? $_GET["hidden_name"] : '';
        $productPrice = isset($_GET["hidden_price"]) ? $_GET["hidden_price"] : '';

        $found = false;

        if (!empty($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as &$cart_item) {
                if ($cart_item['item_id'] == $productID) {
                    $cart_item['item_quantity']++;
                    $found = true;
                    break;
                }
            }
        }

        if (!$found) {
            $item_array = array(
                'item_id' => $productID,
                'item_name' => $productModel,
                'item_price' => $productPrice,
                'item_quantity' => 1
            );
            $_SESSION["shopping_cart"][] = $item_array;
        }
    } elseif ($action == "delete" && isset($_GET["id"])) {
        $productID = $_GET["id"];

        if (!empty($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as $key => $cart_item) {
                if ($cart_item['item_id'] == $productID) {
                    unset($_SESSION["shopping_cart"][$key]);
                    break;
                }
            }
        }
    } elseif ($action == "increase" && isset($_GET["id"])) {
        $productID = $_GET["id"];

        if (!empty($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as &$cart_item) {
                if ($cart_item['item_id'] == $productID) {
                    $cart_item['item_quantity']++;
                    break;
                }
            }
        }
    } elseif ($action == "decrease" && isset($_GET["id"])) {
        $productID = $_GET["id"];

        if (!empty($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as $key => &$cart_item) {
                if ($cart_item['item_id'] == $productID) {
                    $cart_item['item_quantity']--;
                    if ($cart_item['item_quantity'] <= 0) {
                        unset($_SESSION["shopping_cart"][$key]);
                    }
                    break;
                }
            }
        }
    }
    $shouldRedirect = true; // Set the redirection flag
}

$productDetails = array(); // Initialize an array to hold product details

if (!empty($_SESSION["shopping_cart"])) {
    foreach ($_SESSION["shopping_cart"] as $key => $value) {
        $productId = $value['item_id'];

        // Fetch product details from the database based on the product ID
        $sql = "SELECT * FROM Product WHERE ProductID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Store fetched product details in the array
            $productDetails[$key] = $row;
            $productDetails[$key]['quantity'] = $value['item_quantity']; // Add quantity to product details
        }
    }
}

// Redirect to prevent form resubmission
if ($shouldRedirect) {
    header('Location: cart.php'); // Redirect only when needed
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="output.css">
</head>
<body class="">
    <?php include './inc/navigationbar.php'; ?>
    
    <!-- Shopping Cart content -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-4 shadow-md rounded-md">
                <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
                <div class="space-y-4">
                    <?php foreach ($productDetails as $key => $product): ?>
                        <div class="flex items-center border-b pb-4">
                            <img src="<?= htmlspecialchars($product['ProductMainImage']) ?>" alt="Product Image" class="w-20 h-20 rounded-md object-cover mr-4">
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold"><?= htmlspecialchars($product['Model']) ?></h2>
                                <p class="text-gray-600">Price: $<?= htmlspecialchars($product['Price']) ?></p>
                                <p class="text-gray-600">Size: <?= htmlspecialchars($product['Size']) ?></p>
                                <select class="mt-2 p-2 border border-gray-300 rounded-md" name="quantity">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?= $i ?>" <?= ($i == $product['quantity']) ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="bg-white p-4 shadow-md rounded-md">
    <h1 class="text-2xl font-bold mb-4">Order Summary</h1>
    <?php
    // Calculate subtotal
    $subtotal = 0;
    foreach ($productDetails as $product) {
        $subtotal += $product['Price'] * $product['quantity'];
    }

    // Calculate tax (assuming 20%)
    $tax = $subtotal * 0.2;

    // Define shipping fee (you can set your own logic for shipping fee calculation)
    $shippingFee = 10; // Example: $10 shipping fee

    // Calculate total order price
    $totalOrderPrice = $subtotal + $tax + $shippingFee;
    ?>
    
    <div class="flex justify-between mb-4">
        <span>Subtotal:</span>
        <span>$<?= number_format($subtotal, 2) ?></span>
    </div>
    
    <div class="flex justify-between mb-4">
        <span>Shipping Fee:</span>
        <span>$<?= number_format($shippingFee, 2) ?></span>
    </div>
    
    <div class="flex justify-between mb-4">
        <span>Tax (20%):</span>
        <span>$<?= number_format($tax, 2) ?></span>
    </div>
    
    <div class="flex justify-between border-t pt-4">
        <span class="font-bold">Total Order Price:</span>
        <span class="font-bold">$<?= number_format($totalOrderPrice, 2) ?></span>
    </div>
    
    <button class="mt-6 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Checkout</button>
</div>
        </div>
    </div>

</body>
</html>
