<?php

require 'crud_operations.php'; // Make sure this path is correct
require 'upload.php'; // Make sure this path is correct

$newsPost = ['id' => '', 'title' => '', 'short_description' => '', 'content' => '', 'image' => '', 'image_alt' => ''];

// Check if we're editing an existing news post
if (isset($_GET['id'])) {
    $newsPost = readNewsPost($_GET['id']);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect input data
    $title = $_POST['title'];
    $short_description = $_POST['short_description'];
    $content = $_POST['content'];
    $image_alt = $_POST['image_alt'];
    $imagePath = $newsPost['image']; // Default to the existing image

    // Handle file upload if a new file is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $uploadResult = uploadFile($_FILES['image']);
        if (isset($uploadResult['error'])) {
            // Handle error - for example, return a message to the user
            $error = $uploadResult['error'];
        } else {
            $imagePath = $uploadResult['success'];
        }
    }

    // Check if we're updating an existing news post or creating a new one
    if (!empty($_POST['id'])) {
        // Update the news post
        $id = $_POST['id'];
        $result = updateNewsPost($id, $title, $short_description, $content, $imagePath, $image_alt);
    } else {
        // Create a new news post
        $result = createNewsPost($title, $short_description, $content, $imagePath, $image_alt);
    }

    // Based on $result, redirect or display a success/error message
    if ($result) {
        // Redirect to news post list or display success message
        header('Location: news_post_list.php');
        exit;
    } else {
        // Handle error
        $error = 'There was an error saving the news post.';
    }
}

function baseUrl() {
    return 'http://localhost/dwp/'; // Adjust this to your actual base URL
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Post Form</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="md:flex">
            <div class="p-8">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">News Post Form</div>
                
                <form action="news_post_form.php" method="post" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($newsPost['id']); ?>">

                    <label class="block">
                        <span class="text-gray-700">Title</span>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($newsPost['title']); ?>" class="mt-1 block w-full" required>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Short Description</span>
                        <textarea name="short_description" class="mt-1 block w-full" rows="3" required><?php echo htmlspecialchars($newsPost['short_description']); ?></textarea>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Content</span>
                        <textarea name="content" class="mt-1 block w-full" rows="5" required><?php echo htmlspecialchars($newsPost['content']); ?></textarea>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Main Image</span>
                        <input type="file" name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-1">
                        <?php if ($newsPost['image']): ?>
                            <img src="<?php echo baseUrl() . $newsPost['image']; ?>" alt="Current Image" class="mt-2 w-32 h-32 object-cover">
                        <?php endif; ?>
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700">Image Alt Text</span>
                        <input type="text" name="image_alt" value="<?php echo htmlspecialchars($newsPost['image_alt']); ?>" class="mt-1 block w-full">
                    </label>

                    <div class="mt-6 flex justify-between">
                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white text-sm font-medium rounded hover:bg-indigo-400">Save News Post</button>
                        <a href="<?php echo baseUrl(); ?>news_post_list.php" class="px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded hover:bg-gray-600">Back to News List</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
