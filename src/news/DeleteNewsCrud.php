<?php

require_once 'src/config/db.php';

class DeleteNewsPostCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteNewsPost($postId) {
        // Corrected table name and column name
        $stmt = $this->conn->prepare("DELETE FROM news_posts WHERE id = ?");
        $stmt->bind_param("i", $postId);
        return $stmt->execute();
    }
}
?>