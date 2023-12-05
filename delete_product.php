<?php

require './src/product/DeleteProductCrud.php';

$crud = new DeleteProductCrud($conn);

if (isset($_GET['ProductID'])) {
    $productId = $_GET['ProductID'];
    if ($crud->deleteProduct($productId)) {
        header("Location: list_product.php?delete=success");
    } else {
        header("Location: list_product.php?delete=fail");
    }
} else {
    header("Location: list_product.php?delete=fail");
}