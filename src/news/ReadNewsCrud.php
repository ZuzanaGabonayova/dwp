<?php

require_once 'src/config/db.php';

class ReadNewsCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function readAllNewsPosts() {
        $sql = "SELECT * FROM news_posts ORDER BY created_at DESC";
        return $this->conn->query($sql);
    }

    public function readNewsPost($id) {
        $stmt = $this->conn->prepare("SELECT * FROM news_posts WHERE id = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>