<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '../../../vendor/autoload.php'; 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/uploadProductImage.php';

\Stripe\Stripe::setApiKey('sk_test_51OMqZxD7CQBEfsgzCUQ19XaHyqwJHTK9ejG5IjlGs4CaQUpBPSP8M4no8rgXkzfSm5DU0LIxUneFODPiblzB8lMQ0000soVBL9');

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

    public function updateProduct($formData, $fileData, $productId) {
        $productNumber = $formData["ProductNumber"];
        $model = $formData["Model"];
        $description = $formData["Description"];
        $price = $formData["Price"];
        $stockQuantity = $formData["StockQuantity"];
        $categoryID = $formData["CategoryID"];
        $brandID = $formData["BrandID"];
        $selectedColors = $formData["colors"] ?? [];
        $selectedSizes = $formData["sizes"] ?? [];

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

        $stmt = $this->conn->prepare("UPDATE Product SET ProductNumber = ?, Model = ?, Description = ?, Price = ?, StockQuantity = ?, CategoryID = ?, BrandID = ? WHERE ProductID = ?");
        $stmt->bind_param("sssdiiii", $productNumber, $model, $description, $price, $stockQuantity, $categoryID, $brandID, $productId);
        $stmt->execute();

        $this->conn->query("DELETE FROM ProductColor WHERE ProductID = $productId");
        $colorStmt = $this->conn->prepare("INSERT INTO ProductColor (ProductID, ColorID) VALUES (?, ?)");
        foreach ($selectedColors as $colorID) {
            $colorStmt->bind_param("ii", $productId, $colorID);
            $colorStmt->execute();
        }

        $this->conn->query("DELETE FROM ProductSize WHERE ProductID = $productId");
        $sizeStmt = $this->conn->prepare("INSERT INTO ProductSize (ProductID, SizeID) VALUES (?, ?)");
        foreach ($selectedSizes as $sizeID) {
            $sizeStmt->bind_param("ii", $productId, $sizeID);
            $sizeStmt->execute();
        }

          // Fetch the current Stripe Price ID for the product
        $stmt = $this->conn->prepare("SELECT StripePriceID FROM Product WHERE ProductID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentStripeData = $result->fetch_assoc();

         if ($currentStripeData && $currentStripeData['StripePriceID']) {
            // Retrieve the Stripe Price object
            $stripePriceId = $currentStripeData['StripePriceID'];
            $stripePrice = \Stripe\Price::retrieve($stripePriceId);

            // Extract the Product ID from the Stripe Price object
            $stripeProductId = $stripePrice->product;

            // Update Stripe price (create new price as Stripe prices are immutable)
            $newStripePrice = \Stripe\Price::create([
                'unit_amount' => $price * 100, // Convert to cents
                'currency' => 'dkk',
                'product' => $stripeProductId,
            ]);

            // Optionally deactivate the old price
            \Stripe\Price::update($stripePriceId, ['active' => false]);

            // Update the new Stripe Price ID in your database
            $newStripePriceId = $newStripePrice->id;
            $updateStmt = $this->conn->prepare("UPDATE Product SET StripePriceID = ? WHERE ProductID = ?");
            $updateStmt->bind_param("si", $newStripePriceId, $productId);
            $updateStmt->execute();
        }

        return ['success' => true];
    }

    public function closeConnection() {
        $this->conn->close();
    }
}