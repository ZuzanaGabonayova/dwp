<?php

require_once 'src/config/db.php';

class UpdateNewsCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateNewsPost($id, $title, $shortDescription, $content, $image, $imageAlt) {
        $stmt = $this->conn->prepare("UPDATE news_posts SET title = ?, short_description = ?, content = ?, image = ?, image_alt = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->bind_param("sssssi", $title, $shortDescription, $content, $image, $imageAlt, $id);
        return $stmt->execute();
    }
}
?>
