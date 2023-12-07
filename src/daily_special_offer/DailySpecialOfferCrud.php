<?php
ini_set('display_errors', 1);   
ini_set('display_startup_errors', 1);

require_once '../config/db.php';

class DailySpecialOfferCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createOrUpdateSpecialOffer($productId) {
        // Check if a special offer already exists
        $checkSql = "SELECT DailySpecialOfferID FROM DailySpecialOffer";
        $checkResult = $this->conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            // Update the existing special offer
            $stmt = $this->conn->prepare("UPDATE DailySpecialOffer SET ProductID = ?");
            $stmt->bind_param("i", $productId);
        } else {
            // Create a new special offer
            $stmt = $this->conn->prepare("INSERT INTO DailySpecialOffer (ProductID) VALUES (?)");
            $stmt->bind_param("i", $productId);
        }

        return $stmt->execute();
    }

    public function getCurrentSpecialOffer() {
        $sql = "SELECT * FROM DailySpecialOffer";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>
