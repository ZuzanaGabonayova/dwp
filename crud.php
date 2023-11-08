<?php
require 'db.php'; // Include the database 


function createProduct($conn, $productNumber, $model, $description, $price, $mainImage, $categoryID, $brandID, $author, $sizes, $colors) {
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // Insert product
        $stmt = $conn->prepare("INSERT INTO Product (ProductNumber, Model, Description, Price, ProductMainImage, CategoryID, BrandID, Author) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdissi", $productNumber, $model, $description, $price, $mainImage, $categoryID, $brandID, $author);
        $stmt->execute();
        $productId = $stmt->insert_id; // Get the ID of the inserted product

        // Insert sizes
        $stmt = $conn->prepare("INSERT INTO ProductSize (ProductID, SizeID) VALUES (?, ?)");
        foreach ($sizes as $sizeId) {
            $stmt->bind_param("ii", $productId, $sizeId);
            $stmt->execute();
        }

        // Insert colors
        $stmt = $conn->prepare("INSERT INTO ProductColor (ProductID, ColorID) VALUES (?, ?)");
        foreach ($colors as $colorId) {
            $stmt->bind_param("ii", $productId, $colorId);
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();
    } catch (Exception $e) {
        // An error occurred, roll back the transaction
        $conn->rollback();
        throw $e;
    }
}

function listProducts($conn) {
    $sql = "SELECT p.*, GROUP_CONCAT(DISTINCT ps.SizeID) as Sizes, GROUP_CONCAT(DISTINCT pc.ColorID) as Colors FROM Product p LEFT JOIN ProductSize ps ON p.ProductID = ps.ProductID LEFT JOIN ProductColor pc ON p.ProductID = pc.ProductID GROUP BY p.ProductID";
    
    $result = $conn->query($sql);
    
    // Process result and return an array of products
    // Each product will have an array of size IDs and color IDs
}

?>