<?php

require 'db.php'; // Include the database connection
require 'crud_operations.php'; // Include the CRUD operations

// Attempt to fetch all news posts
$newsPosts = readNewsPosts();

// Function to get the base URL of the script
function baseUrl() {
    return 'https://zuzanagabonayova.eu/'; // Adjust this to your actual base URL
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Post List</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-6">News Post List</h2>

    <a href="<?php echo baseUrl(); ?>news_post_form.php" class="mb-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Add News Post
    </a>

    <table class="table-auto w-full mb-6">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Title</th>
                <th class="py-3 px-6 text-left">Short Description</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php if ($newsPosts && $newsPosts->num_rows > 0): ?>
                <?php while ($newsPost = $newsPosts->fetch_assoc()): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap"><?php echo htmlspecialchars($newsPost['title']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($newsPost['short_description']); ?></td>
                        <td class="py-3 px-6 text-center">
                            <a href="<?php echo baseUrl(); ?>news_post_form.php?id=<?php echo $newsPost['id']; ?>" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Edit</a>
                            <a href="<?php echo baseUrl(); ?>delete_news_post.php?id=<?php echo $newsPost['id']; ?>" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="py-3 px-6 text-center">No news posts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
