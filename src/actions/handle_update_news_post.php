<?php
require_once '../config/db.php';
require_once '../news/UpdateNewsCrud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the data from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $shortDescription = $_POST['shortDescription'];
    $content = $_POST['content'];
    $image = $_POST['image'];
    $imageAlt = $_POST['imageAlt'];

    // Update the news post
    $updateNewsCrud = new UpdateNewsCrud($conn);
    if ($updateNewsCrud->updateNewsPost($id, $title, $shortDescription, $content, $image, $imageAlt)) {
        // Redirect after successful update
        header('Location: all_news_posts.php');
        exit();
    } else {
        // Handle update error
        echo "Error updating news post.";
    }
}
?>
