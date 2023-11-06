<?php

require 'db.php'; // Make sure this points to the correct path where your db.php file is

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

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
function createProduct($name, $description, $price, $image) {
    global $conn;
    
    // Sanitize input
    $name = sanitizeInput($name);
    $description = sanitizeInput($description);
    $price = sanitizeInput($price);
    $image = sanitizeInput($image);

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image);
    
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
    
    $sql = "SELECT * FROM products";
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
function updateProduct($id, $name, $description, $price, $image) {
    global $conn;
    
    // Sanitize input
    $id = sanitizeInput($id);
    $name = sanitizeInput($name);
    $description = sanitizeInput($description);
    $price = sanitizeInput($price);
    $image = sanitizeInput($image);

    // Prepare statement
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
    
    return $stmt->execute();
}

/**
 * Delete a product
 */
function deleteProduct($id) {
    global $conn;
    
    // Sanitize input
    $id = sanitizeInput($id);

    // Prepare statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

/**
 * Read a single product by its ID
 */
function readProduct($id) {
    global $conn;
    
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    // Execute the statement and get the result
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the product data
    if ($product = $result->fetch_assoc()) {
        return $product;
    } else {
        return null; // No product found with the given ID
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