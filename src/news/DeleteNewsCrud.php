<?php

require_once '../config/db.php';

class DeleteNewsCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteNewsPost($id) {
        $stmt = $this->conn->prepare("DELETE FROM news_posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>

