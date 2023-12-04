<?php

require_once __DIR__ . '/../../db.php';

// Read all products
function readProducts() {
    global $conn;
    
    $sql = "SELECT * FROM Product";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}

// Read a single product by its ProductID
function readProduct($productID) {
    global $conn;
    
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM Product WHERE ProductID = ?");
    $stmt->bind_param("i", $productID);
    
    // Execute the statement and get the result
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the product data
    if ($product = $result->fetch_assoc()) {
        return $product;
    } else {
        return null; // No product found with the given ProductID
    }
}

// Function to get color names for a product
function getProductColors($productId, $conn) {
    $colors = [];
    $sql = "SELECT c.ColorName FROM `ProductColor` pc
            JOIN `Color` c ON pc.ColorID = c.ColorID
            WHERE pc.ProductID = " . intval($productId);
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $colors[] = $row["ColorName"];
    }
    return $colors;
}


// Function to get size names for a product
function getProductSizes($productId, $conn) {
    $sizes = [];
    $sql = "SELECT s.Size FROM `ProductSize` ps
            JOIN `Size` s ON ps.SizeID = s.SizeID
            WHERE ps.ProductID = " . intval($productId);
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $sizes[] = $row["Size"];
    }
    return $sizes;
}

// Function to get the category name for a product
function getCategoryName($categoryId, $conn) {
    $sql = "SELECT CategoryName FROM `ProductCategory` WHERE CategoryID = " . intval($categoryId);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["CategoryName"];
    } else {
        return null;
    }
}

// Function to get the brand name for a product
function getBrandName($brandId, $conn) {
    $sql = "SELECT BrandName FROM `ProductBrand` WHERE BrandID = " . intval($brandId);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["BrandName"];
    } else {
        return null;
    }
}

// Function to get the author name for a product
function getAuthorName($AdminID, $conn) {
    // This assumes you have a table named `Authors` with fields `AuthorID` and `AuthorName`
    // Adjust the table and field names according to your schema
    $sql = "SELECT FirstName, LastName FROM Admin WHERE AdminID = " . intval($AdminID);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["FirstName"] . " " . $row["LastName"];
    } else {
        return null;
    }
}


?>

