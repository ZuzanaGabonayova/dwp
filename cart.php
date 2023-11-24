<?php
session_start();

// Handle adding products to the cart
if ($_GET["action"] == "add" && isset($_GET["id"])) {
    $productID = $_GET["id"];
    $productModel = $_GET["hidden_name"];
    $productPrice = $_GET["hidden_price"];

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
}

// Handle removing products from the cart
if ($_GET["action"] == "delete" && isset($_GET["id"])) {
    $productID = $_GET["id"];

    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $key => $cart_item) {
            if ($cart_item['item_id'] == $productID) {
                unset($_SESSION["shopping_cart"][$key]);
                break;
            }
        }
    }
}

// Handle increasing product quantity in the cart
if ($_GET["action"] == "increase" && isset($_GET["id"])) {
    $productID = $_GET["id"];

    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as &$cart_item) {
            if ($cart_item['item_id'] == $productID) {
                $cart_item['item_quantity']++;
                break;
            }
        }
    }
}

// Handle decreasing product quantity in the cart
if ($_GET["action"] == "decrease" && isset($_GET["id"])) {
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

// Redirect to prevent form resubmission
header('Location: cart.php');
exit();
?>


<!-- Your HTML for Cart page goes here -->
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
    <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:max-w-7xl lg:gap-x-8 lg:px-8 py-16 sm:py-24 bg-white">
        <h1 class="text-3xl font-bold mb-2 tracking-tight">Shopping Cart</h1>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Product</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($_SESSION["shopping_cart"])) {
                    $total = 0;
                    foreach ($_SESSION["shopping_cart"] as $key => $value) {
                        ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $value["item_name"]; ?></td>
                            <td class="border px-4 py-2">$<?= $value["item_price"]; ?></td>
                            <td class="border px-4 py-2"><?= $value["item_quantity"]; ?></td>
                            <td class="border px-4 py-2">$<?= number_format($value["item_quantity"] * $value["item_price"], 2); ?></td>
                            <td class="border px-4 py-2">
                                <a href="cart.php?action=increase&id=<?= $value["item_id"]; ?>">+</a>
                                <a href="cart.php?action=decrease&id=<?= $value["item_id"]; ?>">-</a>
                                <a href="cart.php?action=delete&id=<?= $value["item_id"]; ?>">Remove</a>
                            </td>
                        </tr>
                        <?php
                        $total += ($value["item_quantity"] * $value["item_price"]);
                    }
                    ?>
                    <tr>
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
