<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../config/db.php';
require_once '../product/DeleteProductCrud.php';

if (isset($_GET['ProductID']) && is_numeric($_GET['ProductID'])) {
    $productId = $_GET['ProductID'];

    $deleteCrud = new DeleteProductCrud($conn);
    if ($deleteCrud->deleteProduct($productId)) {
        // Redirect to a confirmation page or the list of products
        header('Location: ../views/list_product.php?message=Product deleted successfully');
        exit();
    } else {
        // Handle deletion error
        header('Location: ../views/list_product.php?error=Error deleting product');
        exit();
    }
} else {
    // Handle invalid deletion request
    header('Location: ../views/list_product.php?error=Invalid request');
    exit();
}
?>
