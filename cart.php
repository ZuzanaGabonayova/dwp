<?php
session_start();

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
    <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:max-w-7xl lg:gap-x-8 lg:px-8 py-16 sm:py-24 bg-white">
        <h1 class="text-3xl font-bold mb-2 tracking-tight">Shopping Cart</h1>
        <table class="table-auto w-full">
            <thead>
                <!-- Table headers -->
            </thead>
            <tbody>
                <?php
                // Loop through cart items
                if (!empty($_SESSION["shopping_cart"])) {
                    $total = 0;
                    foreach ($_SESSION["shopping_cart"] as $key => $value) {
                        ?>
                        <tr>
                            <!-- Product details -->
                            <td class="border px-4 py-2"><?= $value["item_name"]; ?></td>
                            <td class="border px-4 py-2">$<?= $value["item_price"]; ?></td>
                            <td class="border px-4 py-2">
                                <!-- Quantity with buttons -->
                                <form method="GET" action="cart.php" class="flex items-center">
                                    <input type="hidden" name="action" value="setQuantity">
                                    <input type="hidden" name="id" value="<?= $value["item_id"]; ?>">
                                    <button type="submit" class="text-gray-600 focus:outline-none focus:text-gray-700" name="decrease">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <input type="number" name="quantity" value="<?= $value["item_quantity"]; ?>" min="1" max="20" class="w-10 text-center" />
                                    <button type="submit" class="text-gray-600 focus:outline-none focus:text-gray-700" name="increase">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </button>
                                    <button type="submit" class="ml-2 text-red-500 focus:outline-none focus:text-red-700" name="delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM6 9a1 1 0 011-1h6a1 1 0 010 2H7a1 1 0 01-1-1zm2-5a1 1 0 011 1v6a1 1 0 11-2 0V5a1 1 0 011-1zm7.707-.293a1 1 0 111.414 1.414L12.414 10l3.707 3.707a1 1 0 11-1.414 1.414L11 11.414l-3.707 3.707a1 1 0 01-1.414-1.414L9.586 10 5.879 6.293a1 1 0 111.414-1.414L11 8.586l3.707-3.707z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                            <!-- Total price for each item -->
                            <td class="border px-4 py-2">$<?= number_format($value["item_quantity"] * $value["item_price"], 2); ?></td>
                        </tr>
                        <?php
                        $total += ($value["item_quantity"] * $value["item_price"]);
                    }
                    ?>
                    <tr>
                        <!-- Total row -->
                        <td colspan="3" align="right">Total</td>
                        <td align="right">$<?= number_format($total, 2); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
