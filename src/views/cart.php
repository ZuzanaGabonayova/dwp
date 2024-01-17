<?php
/* error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); */
error_reporting(E_ALL);

session_start();
require '../config/db.php'; // Include the database configuration
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

        $uniqueCartItemId = $productID . "_" . $selectedSize; // Create a unique ID for each product-size combination

        $found = false;
        foreach ($_SESSION["shopping_cart"] as &$cart_item) {
            if ($cart_item['unique_id'] === $uniqueCartItemId) { // Check unique ID instead of just item_id
                $cart_item['item_quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $item_array = array(
                'unique_id' => $uniqueCartItemId, // Add unique ID to the item array
                'item_id' => $productID,
                'item_name' => $productModel,
                'item_price' => $productPrice,
                'item_quantity' => 1,
                'selected_size' => $selectedSize
            );
            $_SESSION["shopping_cart"][] = $item_array;
        }

        /* if (!empty($_SESSION["shopping_cart"])) {
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
        } */
    } 
    /* elseif ($action == "delete" && isset($_GET["id"])) {
        $productID = $_GET["id"];
    
        if (!empty($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as $key => $cart_item) {
                if ($cart_item['item_id'] == $productID) {
                    unset($_SESSION["shopping_cart"][$key]);
                    echo "Deleted product with ID: " . $productID; // Debugging output
                    break;
                }
            }
        } else {
            echo "Shopping cart is empty"; // Debugging output
        }
        $shouldRedirect = true; // Set the flag to redirect after removing the item
        
    } */ elseif (($action == "increase" || $action == "decrease") && isset($_GET["id"])) {
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body class="">
    <?php include '../components/frontend/navigationbar.php'; ?>
    <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            Shopping Cart
        </h1>
        <div class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
            <!-- Cart heading -->
            <div aria-labelledby="cart-heading" class="lg:col-span-7">
                <h2 class="sr-only">Items in your shopping cart</h2>
                <?php if (empty($_SESSION["shopping_cart"])): ?>
                    <div class="flex items-center justify-center h-64">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold mb-4 text-gray-700">Your cart is empty</h2>
                            <p class="text-gray-500">Looks like you haven't added any items yet.</p>
                            <a href="../../index.php" class="mt-4 inline-block px-4 py-2 rounded-md bg-amber-500 px-4 py-3 text-base font-semibold hover:bg-amber-600 transition duration-300">Continue Shopping</a>
                        </div>
                    </div>
                <?php else : ?>
                    <?php foreach ($_SESSION["shopping_cart"] as $cartItem): ?>
                        <ul role="list" class="border-b border-t border-gray-300">
                            <li class="flex py-6 sm:py-10">
                                <div class="flex-shrink-0">
                                    <a href="./frontend/single_product.php?ProductID=<?php echo $cartItem['item_id']; ?>" >
                                        <img src="<?= htmlspecialchars($cartItem['ProductMainImage']) ?>" alt="" class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48" />
                                    </a>
                                </div>
                                <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                    <div class="relative pr-10 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                        <div>
                                            <div class="flex justify-between">
                                                <!-- Product Name -->
                                                <h3 class="text-sm">
                                                    <a href="./frontend/single_product.php?ProductID=<?php echo $cartItem['item_id']; ?>" class="font-semibold text-gray-700"><?= htmlspecialchars($cartItem['item_name']) ?></a>
                                                </h3>
                                            </div>
                                            <div class="mt-1 text-sm">
                                                <!-- Size -->
                                                <p class="text-gray-500">Selected Size: <?= htmlspecialchars($cartItem['selected_size']) ?></p>
                                            </div>
                                            <!-- Price -->
                                            <p class="mt-1 text-sm font-semibold text-gray-900"><?= htmlspecialchars($cartItem['item_price']) ?></p>
                                        </div>
                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                            <form method="post" action="cart.php">
                                                <input type="hidden" name="action" value="update_quantity">
                                                <input type="hidden" name="id" value="<?= $cartItem['item_id'] ?>">
                                                <label class="sr-only" for="quantity-<?= $key ?>">
                                                    Quantity Product Name</label>
                                                <select name="quantity" id="quantity-<?= $key ?>" class="max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-semibold leading-5 text-gray-700 shadow-sm sm:text-sm" onchange="this.form.submit()">
                                                    <?php for ($i = 1; $i <= 10; $i++) : ?>
                                                        <option value="<?= $i ?>" <?= ($i == $cartItem['quantity']) ? 'selected' : '' ?>><?= $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="absolute right-0 top-0">
                                            <form method="post" action="cart.php">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $cartItem['item_id'] ?>">
                                                <button type="submit" class="r-[-0.5rem] text-gray400 p-2" name="delete">
                                                    <span class="sr-only">Remove</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-5 w-5">
                                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="mt-4 flex text-sm text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-5 w-5 flex-shrink-0 text-green-500">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span> In stock</span>
                                    </p>
                                    <div class="mt-1 text-sm">
                                        <p class="text-gray-500">Total: <?= number_format($cartItem['item_price'] * $cartItem['quantity'], 2) ?> kr.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                <h2 id="summary-heading" class="text-lg font-semibold text-gray-900">
                    Order summary
                </h2>
                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">
                            <?php 
                                $subtotal = calculateTotalPrice($_SESSION["shopping_cart"]); 
                                echo number_format($subtotal, 2) . " kr.";
                            ?>
                        </dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-300 pt-4">
                        <dt class="flex items-center text-sm text-gray-600">
                            <span>Shipping estimate</span>
                            <a class="ml-2 flex-shrink-0" href="#">
                                <span class="sr-only">Learn more about how shipping is calculated</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="h-6 w-6">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </dt>
                        <dd class="text-sm font-medium text-gray-900"><?= number_format($shippingFee, 2) ?> kr.</dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-300 pt-4">
                        <dt class="text-base font-medium text-gray-900">Order total</dt>
                        <dd class="text-base font-medium text-gray-900">
                            <?php 
                                echo number_format($totalPriceWithShipping, 2) . " kr.";
                            ?>
                        </dd>
                    </div>
                </dl>
                <form action="../actions/checkout.php" method="post">
                    <div class="mt-6">
                        <button type="submit" class="w-full rounded-md border border-transparent bg-amber-500 px-4 py-3 text-base font-medium shadow-sm hover:bg-amber-600 transition duration-300">
                            Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>