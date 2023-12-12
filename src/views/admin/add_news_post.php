<?php 
require_once '../../admin_authentication/loggedin.php';
// Call the function to update last activity time
updateLastActivityTime();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create News Post</title>
</head>
<body>
    <form action="../../actions/handle_create_news_post.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="short_description">Short Description:</label>
        <input type="text" id="short_description" name="short_description">

        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>

        <label for="image">Image URL:</label>
        <input type="file" id="image" name="image" accept="image/*">

        <label for="image_alt">Image Alt Text:</label>
        <input type="text" id="image_alt" name="image_alt">

        <button type="submit">Create News Post</button>
    </form>
</body>
</html>
