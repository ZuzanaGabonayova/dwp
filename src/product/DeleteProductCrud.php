<?php

require_once __DIR__ . '/../../config/db.php';

class DeleteProductCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteProduct($productId) {
        // Delete associations in related tables first
        $this->conn->query("DELETE FROM ProductColor WHERE ProductID = " . intval($productId));
        $this->conn->query("DELETE FROM ProductSize WHERE ProductID = " . intval($productId));
        
        // Now delete the product
        $stmt = $this->conn->prepare("DELETE FROM Product WHERE ProductID = ?");
        $stmt->bind_param("i", $productId);
        return $stmt->execute();
    }
}