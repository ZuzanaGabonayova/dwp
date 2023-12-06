<?php
require_once '../product/UpdateProductCrud.php';

$crud = new UpdateProductCrud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ProductID"])) {
    $result = $crud->updateProduct($_POST, $_FILES, $_POST["ProductID"]);
    if (isset($result['error'])) {
        // Pass the error message to the update form
        header("Location: ../views/update_product.php?ProductID=" . $_POST["ProductID"] . "&error=" . urlencode($result['error']));
    } else {
        header("Location: ../views/list_product.php?update=success");
    }
    exit();
}
