<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../product/CreateProductCrud.php';

$crud = new CreateProductCrud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $crud->processProductForm($_POST, $_FILES);
    if (isset($result['error'])) {
        // Redirect back to the form with error message
        header("Location: ../views/add_product.php?error=" . urlencode($result['error']));
        exit();
    } else {
        $crud->closeConnection();
        header("Location: ../views/list_product.php?add=success");
        exit();
    }
}
