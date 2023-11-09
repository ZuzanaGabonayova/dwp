
<?php

require 'db.php'; // ensures that the file is included only once

/**
 * Sanitize input data
 */
function sanitizeInput($data) {
    global $conn;
    return htmlspecialchars($conn->real_escape_string($data));
}


/**
 * Create a new product
 */
function createProduct($productNumber, $model, $color, $size, $description, $price, $stockQuantity, $productMainImage, $categoryID, $brandID) {
    global $conn;
    
    // Sanitize input
    $productNumber = sanitizeInput($productNumber);
    $model = sanitizeInput($model);
    $color = sanitizeInput($color);
    $size = sanitizeInput($size);
    $description = sanitizeInput($description);
    $price = sanitizeInput($price);
    $stockQuantity = sanitizeInput($stockQuantity);
    $productMainImage = sanitizeInput($productMainImage);
    $categoryID = sanitizeInput($categoryID);
    $brandID = sanitizeInput($brandID);

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO Product (ProductNumber, Model, Color, Size, Description, Price, StockQuantity, ProductMainImage, CategoryID, BrandID, CreatedAt, EditedAt, Author) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)");
    $stmt->bind_param("sssssdisisi", $productNumber, $model, $color, $size, $description, $price, $stockQuantity, $productMainImage, $categoryID, $brandID, $author);
    
    if($stmt->execute()) {
        return $conn->insert_id; // Return the id of the inserted product
    } else {
        return false;
    }
}

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
 * Update a product
 */
/* function updateProduct($productID, $productNumber, $model, $color, $size, $description, $price, $stockQuantity, $productMainImage, $categoryID, $brandID) {
    global $conn;
    
    // Sanitize input
    $productID = sanitizeInput($productID);
    $productNumber = sanitizeInput($productNumber);
    $model = sanitizeInput($model);
    $color = sanitizeInput($color);
    $size = sanitizeInput($size);
    $description = sanitizeInput($description);
    $price = sanitizeInput($price);
    $stockQuantity = sanitizeInput($stockQuantity);
    $productMainImage = sanitizeInput($productMainImage);
    $categoryID = sanitizeInput($categoryID);
    $brandID = sanitizeInput($brandID);

    // Prepare statement
    $stmt = $conn->prepare("UPDATE Product SET ProductNumber = ?, Model = ?, Color = ?, Size = ?, Description = ?, Price = ?, StockQuantity = ?, ProductMainImage = ?, CategoryID = ?, BrandID = ?, EditedAt = NOW() WHERE ProductID = ?");
    $stmt->bind_param("sssssdisisi", $productNumber, $model, $color, $size, $description, $price, $stockQuantity, $productMainImage, $categoryID, $brandID, $productID);
    
    return $stmt->execute();
}
 */
/**
 * Delete a product
 */
function deleteProduct($productID) {
    global $conn;
    
    // Sanitize input
    $productID = sanitizeInput($productID);

    // Prepare statement
    $stmt = $conn->prepare("DELETE FROM Product WHERE ProductID = ?");
    $stmt->bind_param("i", $productID);
    
    return $stmt->execute();
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