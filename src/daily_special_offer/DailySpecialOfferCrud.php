<?php

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
            $stmt = $this->conn->prepare("UPDATE DailySpecialOffer SET ProductID = ? WHERE DailySpecialOfferID = ?");
            $offerId = $checkResult->fetch_assoc()['DailySpecialOfferID'];
            $stmt->bind_param("ii", $productId, $offerId);
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
