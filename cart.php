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
                                <!-- Quantity and buttons -->
                                <span><?= $value["item_quantity"]; ?></span>
                                <form method="GET" action="cart.php">
                                    <input type="hidden" name="action" value="increase">
                                    <input type="hidden" name="id" value="<?= $value["item_id"]; ?>">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" name="increase">+</button>
                                </form>
                                <form method="GET" action="cart.php">
                                    <input type="hidden" name="action" value="decrease">
                                    <input type="hidden" name="id" value="<?= $value["item_id"]; ?>">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" name="decrease">-</button>
                                </form>
                            </td>
                            <!-- Total price for each item -->
                            <td class="border px-4 py-2">$<?= number_format($value["item_quantity"] * $value["item_price"], 2); ?></td>
                            <!-- Actions -->
                            <td class="border px-4 py-2">
                                <form method="GET" action="cart.php">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $value["item_id"]; ?>">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" name="delete">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                        $total += ($value["item_quantity"] * $value["item_price"]);
                    }
                    ?>
                    <tr>
                        <!-- Total row -->
                        <td colspan="3" align="right">Total</td>
                        <td align="right">$<?= number_format($total, 2); ?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
