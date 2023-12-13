<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require __DIR__ . '/../../src/config/db.php'; // Include the database configuration

// Initialize shopping cart if not set
if (!isset($_SESSION["shopping_cart"]) || !is_array($_SESSION["shopping_cart"])) {
    $_SESSION["shopping_cart"] = array();
}
// Redirection flag
$shouldRedirect = false;

// Function to calculate total price
function calculateTotalPrice($cart) {
    $totalPrice = 0;
    foreach ($cart as $item) {
        $totalPrice += $item['item_price'] * $item['item_quantity'];
    }
    return $totalPrice;
}

$subtotal = calculateTotalPrice($_SESSION["shopping_cart"]);

// Define shipping fee conditionally
if ($subtotal > 1000 || $subtotal == 0) {
    $shippingFee = 0;
} else {
    $shippingFee = 50;
}

// Calculate total price with shipping fee
$totalPriceWithShipping = $totalPriceWithShipping = $subtotal + $shippingFee;

if (isset($_GET["action"])) {
    $action = $_GET["action"];

    if ($action == "add" && isset($_GET["id"])) {
        $productID = $_GET["id"];
        $productModel = isset($_GET["hidden_name"]) ? $_GET["hidden_name"] : '';
        $productPrice = isset($_GET["hidden_price"]) ? $_GET["hidden_price"] : '';
        $selectedSize = isset($_GET["selected_size"]) ? $_GET["selected_size"] : ''; // Fetch selected size from the URL parameter

        $found = false;

        if (!empty($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as &$cart_item) {
                if ($cart_item['item_id'] == $productID && $cart_item['selected_size'] == $selectedSize) {
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
                'item_quantity' => 1,
                'selected_size' => $selectedSize
            );
            $_SESSION["shopping_cart"][] = $item_array;

            // Add the selected size to the selected_sizes session array
            $_SESSION['selected_sizes'][$productID] = $selectedSize;

        }
    } elseif (($action == "increase" || $action == "decrease") && isset($_GET["id"])) {
        $productID = $_GET["id"];
        $quantityChange = ($action == "increase") ? 1 : -1;

        if (!empty($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as &$cart_item) {
                if ($cart_item['item_id'] == $productID) {
                    $cart_item['item_quantity'] += $quantityChange;
                    if ($cart_item['item_quantity'] <= 0 || $cart_item['item_quantity'] > 10) {
                        unset($_SESSION["shopping_cart"][$key]);
                    }
                    break;
                }
            }
        }
    }

    $shouldRedirect = true; // Set the redirection flag
}

if (isset($_POST["action"]) && $_POST["action"] === "delete" && isset($_POST["id"])) {
    $productID = $_POST["id"];

    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $key => $cart_item) {
            if ($cart_item['item_id'] == $productID) {
                unset($_SESSION["shopping_cart"][$key]);
                break;
            }
        }
    }
    // Redirect to prevent form resubmission
    header('Location: cart.php');
    exit();
}

    // Fetch product details from the database based on the product IDs in the shopping cart
    $productIds = array_column($_SESSION["shopping_cart"], 'item_id');
    $productDetails = [];

    if (!empty($productIds)) {
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $sql = "SELECT *, StripePriceID FROM Product WHERE ProductID IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                foreach ($_SESSION["shopping_cart"] as &$cartItem) {
                    if ($cartItem['item_id'] == $row['ProductID']) {
                        $cartItem['quantity'] = $cartItem['item_quantity'];
                        $cartItem['selected_size'] = $cartItem['selected_size'];
                        $cartItem['stripe_price_id'] = $row['StripePriceID']; // Store Stripe Price ID in session
                        $productDetails[] = array_merge($row, $cartItem);
                        break;
                    }
                }
            }
        }
    }

// Handling the POST request to update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_quantity' && isset($_POST['id']) && isset($_POST['quantity'])) {
    $productID = $_POST['id'];
    $newQuantity = $_POST['quantity'];

    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as &$cart_item) {
            if ($cart_item['item_id'] == $productID) {
                $cart_item['item_quantity'] = $newQuantity;
                break;
            }
        }
    }

    // Redirect to prevent form resubmission
    header('Location: cart.php');
    exit();
}

// Redirect to prevent form resubmission
if ($shouldRedirect) {
    header('Location: cart.php'); // Redirect only when needed
    exit();
}
?>