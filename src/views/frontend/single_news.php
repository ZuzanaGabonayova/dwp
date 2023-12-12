<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Initialize the session for counting the cart items

require '../config/db.php'; // Make sure this path is correct
require '../news/ReadNewsCrud.php'; // This should contain a function to read news posts

// Get the list of news posts


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $readNewsCrud = new ReadNewsCrud($conn); // Create an instance of ReadNewsCrud
    $news = $readNewsCrud->readNewsPost($id); // Call the method using the instance
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="output.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/output.css">
</head>
<body>
    <div>
    <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:max-w-7xl lg:gap-x-8 lg:px-8 py-16 sm:py-24">
        <?php if ($news): ?>
                <article class="prose lg:prose-xl mx-auto">
                    <div class="">
                        <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['image_alt']) ?>" class="aspect-[16/10] w-full object-cover rounded-4xl">
                    </div>
                    <p class="mt-1">Posted on <?= htmlspecialchars($news['created_at']) ?></p>
                    <div class="px-8 mt-20 lg:mt-0 sm:px:0 sm:mt-16 ">
                        <h1 class="text-3xl font-bold mb-2 tracking-tight"><?= htmlspecialchars($news['title']) ?></h1>
                        <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
                    </div>
                </article>
        <?php else: ?>
            <p class="text-center">News post not found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

