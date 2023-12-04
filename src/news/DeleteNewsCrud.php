<?php

require_once 'src/config/db.php';

class DeleteNewsPostCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteNewsPost($postId) {
        // Assuming you have a specific table for news posts
        $stmt = $this->conn->prepare("DELETE FROM NewsPosts WHERE PostID = ?");
        $stmt->bind_param("i", $postId);
        return $stmt->execute();
    }
}

?>