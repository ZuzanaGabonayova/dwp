<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once '../product/CreateProductCrud.php';

$crud = new CreateProductCrud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $crud->processProductForm($_POST, $_FILES);
    if ($result) {
        echo "News post created successfully.";
        header("Location: ../views/admin/products.php");
        exit();
    } else {
        echo "Error creating news post.";
        // Additional error handling can be added here
    }
}
