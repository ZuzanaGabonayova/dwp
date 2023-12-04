<?php

require_once 'src/news/DeleteNewsPostCrud.php';
require_once 'src/utils/url_helpers.php'; 

$crud = new DeleteNewsPostCrud($conn);

// Check if the 'id' GET parameter is set and the form has been submitted
if (isset($_POST['id']) && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $id = $_POST['id'];
    $result = $crud->deleteNewsPost($id);

    if ($result) {
        // If the news post was deleted successfully, redirect back to the news post list
        header('Location: news_post_list.php');
        exit;
    } else {
        $error = 'There was an error deleting the news post.';
        // Handle the error, perhaps pass the message back to news_post_list.php
    }
}

// If there's a GET request without form submission, display the confirmation
if (isset($_GET['id']) && !isset($_POST['confirm'])) {
    $id = $_GET['id'];
    // HTML form for confirmation
    // ...
    exit;
}

// Redirect to the news post list if the id parameter is not set
header('Location: news_post_list.php');
exit;

?>
