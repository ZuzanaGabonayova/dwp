<?php
require 'db.php';

function deleteProduct($productId, $conn) {
    // Delete associations in related tables first
    $conn->query("DELETE FROM ProductColor WHERE ProductID = " . intval($productId));
    $conn->query("DELETE FROM ProductSize WHERE ProductID = " . intval($productId));
    
    // Now delete the product
    $stmt = $conn->prepare("DELETE FROM Product WHERE ProductID = ?");
    $stmt->bind_param("i", $productId);
    return $stmt->execute();
}

if (isset($_GET['ProductID'])) {
    $productId = $_GET['ProductID'];
    if (deleteProduct($productId, $conn)) {
        header("Location: list_product.php?delete=success");
    } else {
        header("Location: list_product.php?delete=fail");
    }
} else {
    header("Location: list_product.php?delete=fail");
}

$conn->close();
