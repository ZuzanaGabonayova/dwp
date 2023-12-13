<?php

require_once __DIR__ . '../../../vendor/autoload.php'; 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/uploadProductImage.php';

\Stripe\Stripe::setApiKey('sk_test_51OMqZxD7CQBEfsgzCUQ19XaHyqwJHTK9ejG5IjlGs4CaQUpBPSP8M4no8rgXkzfSm5DU0LIxUneFODPiblzB8lMQ0000soVBL9');

class CreateProductCrud {
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

    public function processProductForm($formData, $fileData) {
        // Extract and sanitize form data
        $productNumber = trim($formData["ProductNumber"]);
        $model = trim($formData["Model"]);
        $description = trim($formData["Description"]);
        $price = filter_var($formData["Price"], FILTER_VALIDATE_FLOAT);
        $stockQuantity = filter_var($formData["StockQuantity"], FILTER_VALIDATE_INT);
        $categoryID = filter_var($formData["CategoryID"], FILTER_SANITIZE_NUMBER_INT);
        $brandID = filter_var($formData["BrandID"], FILTER_SANITIZE_NUMBER_INT);
        $selectedColors = $formData["colors"] ?? [];
        $selectedSizes = $formData["sizes"] ?? [];

        // Validate the data
        if ($price === false || $price > 9999.99) {
            return ['error' => "Invalid price format or exceeds maximum allowed price"];
        }
        if ($stockQuantity === false) {
            return ['error' => "Invalid stock quantity format"];
        }

        // Handle file upload
        $mainImage = '';
        if (isset($fileData["ProductMainImage"]) && $fileData["ProductMainImage"]["error"] === UPLOAD_ERR_OK) {
            $uploadResult = uploadFile($fileData["ProductMainImage"]);
            if (isset($uploadResult['success'])) {
                $mainImage = $uploadResult['success'];
            } else {
                return ['error' => $uploadResult['error']];
            }
        }

        // Insert product data into the database
        $stmt = $this->conn->prepare("INSERT INTO Product (ProductNumber, Model, Description, Price, StockQuantity, CategoryID, BrandID, ProductMainImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiiis", $productNumber, $model, $description, $price, $stockQuantity, $categoryID, $brandID, $mainImage);
        if (!$stmt->execute()) {
            return ['error' => $this->conn->error];
        }
        $productID = $this->conn->insert_id;

        // Create a Stripe product
        $stripeProduct = \Stripe\Product::create(['name' => $model]);

        // Create a Stripe price for the product
        $stripePrice = \Stripe\Price::create([
            'unit_amount' => $price * 100, // Convert price to cents
            'currency' => 'usd',
            'product' => $stripeProduct->id,
        ]);

        // Save the Stripe Price ID in your database
        $stripePriceId = $stripePrice->id;
        $updateStmt = $this->conn->prepare("UPDATE Product SET StripePriceID = ? WHERE ProductID = ?");
        $updateStmt->bind_param("si", $stripePriceId, $productID);
        $updateStmt->execute();

        // Insert color associations
        if (!empty($selectedColors)) {
            $colorStmt = $this->conn->prepare("INSERT INTO ProductColor (ProductID, ColorID) VALUES (?, ?)");
            foreach ($selectedColors as $colorID) {
                $colorStmt->bind_param("ii", $productID, $colorID);
                if (!$colorStmt->execute()) {
                    return ['error' => $this->conn->error];
                }
            }
        }

        // Insert size associations
        if (!empty($selectedSizes)) {
            $sizeStmt = $this->conn->prepare("INSERT INTO ProductSize (ProductID, SizeID) VALUES (?, ?)");
            foreach ($selectedSizes as $sizeID) {
                $sizeStmt->bind_param("ii", $productID, $sizeID);
                if (!$sizeStmt->execute()) {
                    return ['error' => $this->conn->error];
                }
            }
        }

        return ['success' => true];
    }

    public function closeConnection() {
        $this->conn->close();
    }
}