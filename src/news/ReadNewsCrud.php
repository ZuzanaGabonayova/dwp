<?php

require_once 'src/config/db.php';

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

?>