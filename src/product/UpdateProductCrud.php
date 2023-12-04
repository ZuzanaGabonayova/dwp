<?php

require_once __DIR__ . '/../../db.php';
require_once './src/utils/upload.php';

class UpdateProductCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

      public function getCategories() {
        return $this->conn->query("SELECT CategoryID, CategoryName FROM ProductCategory")->fetch_all(MYSQLI_ASSOC);
    }

    public function getBrands() {
        return $this->conn->query("SELECT BrandID, BrandName FROM ProductBrand")->fetch_all(MYSQLI_ASSOC);
    }

    public function getColors() {
        return $this->conn->query("SELECT ColorID, ColorName FROM Color")->fetch_all(MYSQLI_ASSOC);
    }

    public function getSizes() {
        return $this->conn->query("SELECT SizeID, Size FROM Size")->fetch_all(MYSQLI_ASSOC);
    }


    public function readProduct($productId) {
        $stmt = $this->conn->prepare("SELECT * FROM Product WHERE ProductID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : false;
    }

    public function getCurrentAttributes($productId, $attributeTable, $idField) {
        $stmt = $this->conn->prepare("SELECT $idField FROM $attributeTable WHERE ProductID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return array_column($result, $idField);
    }

    public function updateProduct($formData, $fileData, $productId) {
        // Extract and sanitize data from $formData
        $productNumber = $formData["ProductNumber"];
        $model = $formData["Model"];
        $description = $formData["Description"];
        $price = $formData["Price"];
        $stockQuantity = $formData["StockQuantity"];
        $categoryID = $formData["CategoryID"];
        $brandID = $formData["BrandID"];
        $selectedColors = $formData["colors"] ?? [];
        $selectedSizes = $formData["sizes"] ?? [];

        // Process file upload
        if (isset($fileData["ProductMainImage"]) && $fileData["ProductMainImage"]["error"] === UPLOAD_ERR_OK) {
            $uploadResult = uploadFile($fileData["ProductMainImage"]);
            if (isset($uploadResult['success'])) {
                $mainImage = $uploadResult['success'];
                $stmt = $this->conn->prepare("UPDATE Product SET ProductMainImage = ? WHERE ProductID = ?");
                $stmt->bind_param("si", $mainImage, $productId);
                $stmt->execute();
            } else {
                return ['error' => $uploadResult['error']];
            }
        }

        // Update product data in the database
        $stmt = $this->conn->prepare("UPDATE Product SET ProductNumber = ?, Model = ?, Description = ?, Price = ?, StockQuantity = ?, CategoryID = ?, BrandID = ? WHERE ProductID = ?");
        $stmt->bind_param("sssdiiii", $productNumber, $model, $description, $price, $stockQuantity, $categoryID, $brandID, $productId);
        $stmt->execute();

        // Update color associations
        $this->conn->query("DELETE FROM ProductColor WHERE ProductID = $productId");
        $colorStmt = $this->conn->prepare("INSERT INTO ProductColor (ProductID, ColorID) VALUES (?, ?)");
        foreach ($selectedColors as $colorID) {
            $colorStmt->bind_param("ii", $productId, $colorID);
            $colorStmt->execute();
        }

        // Update size associations
        $this->conn->query("DELETE FROM ProductSize WHERE ProductID = $productId");
        $sizeStmt = $this->conn->prepare("INSERT INTO ProductSize (ProductID, SizeID) VALUES (?, ?)");
        foreach ($selectedSizes as $sizeID) {
            $sizeStmt->bind_param("ii", $productId, $sizeID);
            $sizeStmt->execute();
        }

        return ['success' => true];
    }
}
