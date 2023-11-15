<?php
require 'crud_operations.php'; // This should contain a function to read news posts
require 'db.php'; // This should contain a database connection variable $conn

// Include all your provided functions here

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $news = readNewsPost($id, $conn);
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
</head>
<body>
    <div>
    <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:max-w-7xl lg:gap-x-8 lg:px-8 py-16 sm:py-24">
        <?php if ($news): ?>
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <article class="prose lg:prose-xl">
                    <div class="aspect-square rounded-lg ">
                        <img src="<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['image_alt']) ?>" class="h-full w-full object-cover object-center">
                    </div>
                    <div class="px-8 mt-20 lg:mt-0 sm:px:0 sm:mt-16 ">
                        <h1 class="text-3xl font-bold mb-2 tracking-tight"><?= htmlspecialchars($news['title']) ?></h1>
                        <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
                        <p class="mt-1">Posted on <?= htmlspecialchars($news['created_at']) ?></p>
                    </div>
                </article>
                
            </div>
        <?php else: ?>
            <p class="text-center">News post not found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

