<?php

require_once __DIR__ . '/../config/db.php';

class ReadProductCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Read all products
    public function readProducts() {
        $sql = "SELECT * FROM Product";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Read a single product by its ProductID
    public function readProduct($productID) {
        $stmt = $this->conn->prepare("SELECT * FROM Product WHERE ProductID = ?");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($product = $result->fetch_assoc()) {
            return $product;
        } else {
            return null; // No product found with the given ProductID
        }
    }

    // Function to get color names for a product
    public function getProductColors($productId) {
        $colors = [];
        $sql = "SELECT c.ColorName FROM `ProductColor` pc
                JOIN `Color` c ON pc.ColorID = c.ColorID
                WHERE pc.ProductID = " . intval($productId);
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $colors[] = $row["ColorName"];
        }
        return $colors;
    }

    // Function to get size names for a product
    public function getProductSizes($productId) {
        $sizes = [];
        $sql = "SELECT s.Size FROM `ProductSize` ps
                JOIN `Size` s ON ps.SizeID = s.SizeID
                WHERE ps.ProductID = " . intval($productId);
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row["Size"];
        }
        return $sizes;
    }

    // Function to get the category name for a product
    public function getCategoryName($categoryId) {
        $sql = "SELECT CategoryName FROM `ProductCategory` WHERE CategoryID = " . intval($categoryId);
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["CategoryName"];
        } else {
            return null;
        }
    }

    // Function to get the brand name for a product
    public function getBrandName($brandId) {
        $sql = "SELECT BrandName FROM `ProductBrand` WHERE BrandID = " . intval($brandId);
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["BrandName"];
        } else {
            return null;
        }
    }

    // Function to get the author name for a product
    public function getAuthorName($AdminID) {
        $sql = "SELECT FirstName, LastName FROM Admin WHERE AdminID = " . intval($AdminID);
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["FirstName"] . " " . $row["LastName"];
        } else {
            return null;
        }
    }

     // Read products by category
    public function readProductsByCategory($categoryName) {
        $stmt = $this->conn->prepare("SELECT p.* FROM Product p
                                      JOIN ProductCategory pc ON p.CategoryID = pc.CategoryID
                                      WHERE pc.CategoryName = ?");
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Read a limited number of random products by category
    public function readRandomProductsByCategory($categoryName, $limit = 4) {
        $stmt = $this->conn->prepare("SELECT p.* FROM Product p
                                    JOIN ProductCategory pc ON p.CategoryID = pc.CategoryID
                                    WHERE pc.CategoryName = ? ORDER BY RAND() LIMIT ?");
        $stmt->bind_param("si", $categoryName, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }
}

?>
