<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../product/ReadProductCrud.php';


if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $readProductCrud = new ReadProductCrud($conn); // Create an instance of ReadProductCrud
    $product = $readProductCrud->readProduct($productID); // Call the method using the instance
    $productColors = $readProductCrud->getProductColors($productID); // Use the class method
    $productSizes = $readProductCrud->getProductSizes($productID);
    $categoryName = $readProductCrud->getCategoryName($product['CategoryID']);
    $brandName = $readProductCrud->getBrandName($product['BrandID']);
    $authorName = $readProductCrud->getAuthorName($product['AdminID']); // Adjust as per your table structure
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['add_to_cart'])) {
        $selectedSize = $_GET['selected_size'] ?? null;
        if ($selectedSize === null || empty($selectedSize)) {
            echo '<p>Please select a size before adding to cart.</p>';
        } else{
            $_SESSION['selected_sizes'][$productID] = $selectedSize;
            header('Location: cart.php?action=add&id=' . $productID . '&hidden_name=' . urlencode($product['Model']) . '&hidden_price=' . urlencode($product['Price']) . '&selected_size=' . $selectedSize);
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['Model'] ?></title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>
<body class="">
    
    <?php

        $content = __DIR__ . '/../../components/frontend/single_product.php';
        include_once __DIR__ . '../../../layouts/frontend.php';

    ?>

</body>
</html>
