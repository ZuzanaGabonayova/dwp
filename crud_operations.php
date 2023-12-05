<?php

require './src/config/db.php'; 

/**
 * Read all products
 */
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

/**
 * Read a single product by its ProductID
 */
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

/**
 * Read all news posts
 */
function readNewsPosts() {
    // Assuming $conn is your database connection variable from db.php
    global $conn;

    $sql = "SELECT * FROM news_posts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result === false) {
        // Handle error - Optional: log this error using error_log($conn->error);
        return false;
    }

    return $result;
}

/**
 * Read news posts by id
 */
function readNewsPost($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM news_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result;
}

/**
 * Create news posts
 */
function createNewsPost($title, $short_description, $content, $image, $image_alt) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO news_posts (title, short_description, content, image, image_alt) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $short_description, $content, $image, $image_alt);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Update news posts
 */
function updateNewsPost($id, $title, $short_description, $content, $image, $image_alt) {
    global $conn;
    $stmt = $conn->prepare("UPDATE news_posts SET title = ?, short_description = ?, content = ?, image = ?, image_alt = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $title, $short_description, $content, $image, $image_alt, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Delete news posts
 */
function deleteNewsPost($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM news_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Read PresentationOfCompany
 */
function readPresentationOfCompany($conn) {
    $query = "SELECT * FROM PresentationOfCompany";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_free_result($result);

    return $data;
}