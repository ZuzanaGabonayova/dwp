
<?php

require 'db.php'; // ensures that the file is included only once


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