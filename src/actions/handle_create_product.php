<?php

require_once '../product/CreateProductCrud.php';

$crud = new CreateProductCrud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $crud->processProductForm($_POST, $_FILES);
    if ($result) {
        echo "News post created successfully.";
        header("Location: ../views/list_product.php.php");
        exit();
    } else {
        echo "Error creating news post.";
        // Additional error handling can be added here
    }
}
