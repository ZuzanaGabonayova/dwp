<?php

require_once 'src/config/db.php';

class CreateNewsCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createNewsPost($title, $shortDescription, $content, $image, $imageAlt) {
        $stmt = $this->conn->prepare("INSERT INTO news_posts (title, short_description, content, image, image_alt) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $shortDescription, $content, $image, $imageAlt);
        return $stmt->execute();
    }
}
?>