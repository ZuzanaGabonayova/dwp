<?php
require_once '../news/CreateNewsCrud.php';
require_once '../config/db.php';

// Include the function for uploading an image
require_once '../utils/uploadNewsImage.php'; // Adjust the path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instantiate the CRUD class
    $createCrud = new CreateNewsCrud($conn);

    // Get the form data
    $title = $_POST['title'];
    $shortDescription = $_POST['short_description'];
    $content = $_POST['content'];

    // Handle the image upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadNewsImage($_FILES['image']);

        if (isset($uploadResult['success'])) {
            $imagePath = $uploadResult['success']; // Path of the uploaded image
        } else {
            // Handle the error, e.g., show an error message to the user
            die('Image upload failed: ' . $uploadResult['error']);
        }
    }

    // Image alt text
    $imageAlt = $_POST['image_alt'] ?? '';

    // Insert the news post
    $result = $createCrud->createNewsPost($title, $shortDescription, $content, $imagePath, $imageAlt);

    if ($result) {
        echo "News post created successfully.";
        // Redirect or further processing
        header('Location: ../../views/admin/news.php');
    exit;
    } else {
        echo "Error creating news post.";
        // Error handling
    }
}
?>
