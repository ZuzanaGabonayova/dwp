<?php

require 'db.php'; // Include the database connection
require 'crud_operations.php'; // Include the CRUD operations
require_once 'src/utils/url_helpers.php'; // Include the URL helper functions


// Check if the 'id' GET parameter is set and the form has been submitted
if (isset($_POST['id']) && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $id = $_POST['id'];
    $result = deleteNewsPost($id);

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete News Post Confirmation</title>
    <!-- Include Tailwind CSS -->
    <link rel="stylesheet" href="output.css">
</head>
<body class="bg-gray-100 p-10">
    <div class="container mx-auto">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p class="mb-4">Are you sure you want to delete this news post?</p>

        <form action="delete_news_post.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <button type="submit" name="confirm" value="yes" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Yes, delete it!
            </button>
            <a href="<?php echo baseUrl(); ?>news_post_list.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                No, go back
            </a>
        </form>
    </div>
</body>
</html>

<?php
    // End the script to not display anything else
    exit;
}
// Redirect to the news post list if the id parameter is not set
header('Location: news_post_list.php');
exit;
