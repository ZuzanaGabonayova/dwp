<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once '../product/UpdateProductCrud.php';

$crud = new UpdateProductCrud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ProductID"])) {
    $result = $crud->updateProduct($_POST, $_FILES, $_POST["ProductID"]);
    if (isset($result['error'])) {
        // Pass the error message to the update form
        header("Location: ../views/update_product.php?ProductID=" . $_POST["ProductID"] . "&error=" . urlencode($result['error']));
    } else {
        header("Location: ../views/admin/products.php?update=success");
    }
    exit();
}
