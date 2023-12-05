<?php
require_once 'src/news/CreateNewsCrud.php';
require_once 'src/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instantiate the CRUD class
    $createCrud = new CreateNewsCrud($conn);

    // Get the form data
    $title = $_POST['title'];
    $shortDescription = $_POST['short_description'];
    $content = $_POST['content'];
    $image = $_POST['image'];
    $imageAlt = $_POST['image_alt'];

    // Insert the news post
    $result = $createCrud->createNewsPost($title, $shortDescription, $content, $image, $imageAlt);

    if ($result) {
        echo "News post created successfully.";
        // Redirect or further processing
    } else {
        echo "Error creating news post.";
        // Error handling
    }
}
?>
