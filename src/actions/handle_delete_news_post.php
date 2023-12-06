<?php
require_once '../config/db.php';
require_once '../news/DeleteNewsCrud.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $newsId = $_GET['id'];

    $deleteCrud = new DeleteNewsCrud($conn);
    if ($deleteCrud->deleteNewsPost($newsId)) {
        // Redirect to a confirmation page or the list of news posts
        header('Location: ../views/all_news_posts.php?message=News post deleted successfully');
        exit();
    } else {
        // Handle deletion error
        header('Location: ../views/all_news_posts.php?error=Error deleting news post');
        exit();
    }
} else {
    // Handle invalid deletion request
    header('Location: ../views/all_news_posts.php?error=Invalid request');
    exit();
}
?>
