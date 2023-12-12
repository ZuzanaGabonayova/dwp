<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once '../config/db.php';
require_once '../news/UpdateNewsCrud.php';
require_once '../news/ReadNewsCrud.php';
require_once '../utils/uploadNewsImage.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $shortDescription = $_POST['shortDescription'];
    $content = $_POST['content'];
    $imageAlt = $_POST['image_alt'];

    // Fetch current image path in case no new image is uploaded
    $readNewsCrud = new ReadNewsCrud($conn);
    $currentNewsPost = $readNewsCrud->readNewsPost($id);
    $currentImagePath = $currentNewsPost['image'];

    $image = $currentImagePath; // Default to current image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadNewsImage($_FILES['image']);
        if (isset($uploadResult['success'])) {
            $image = $uploadResult['success'];
        } else {
            die('Image upload failed: ' . $uploadResult['error']);
        }
    }

    $updateNewsCrud = new UpdateNewsCrud($conn);
    if ($updateNewsCrud->updateNewsPost($id, $title, $shortDescription, $content, $image, $imageAlt)) {
        header('Location: ../views/admin/news.php');
        exit();
    } else {
        echo "Error updating news post.";
    }
}
?>
