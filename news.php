<?php
require 'db.php'; // Make sure this path is correct
require 'crud_operations.php'; // This should contain a function to read news posts

// Get the list of news posts
$newsPosts = readNewsPosts();
?>
<?php
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <div class="flex justify-between items-center pb-6">
        <div>
            <h2 class="text-4xl font-semibold">Latest News</h2>
        </div>
    </div>

    <!-- News Grid -->
    <div class="grid md:grid-cols-3 gap-6">
        <?php if ($newsPosts && $newsPosts->num_rows > 0): ?>
            <?php while ($newsPost = $newsPosts->fetch_assoc()): ?>
                <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white">
                    <img class="w-full" src="<?php echo htmlspecialchars($newsPost['image']); ?>" alt="<?php echo htmlspecialchars($newsPost['image_alt']); ?>">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2"><?php echo htmlspecialchars($newsPost['title']); ?></div>
                        <p class="text-gray-700 text-base">
                            <?php echo htmlspecialchars($newsPost['short_description']); ?>
                        </p>
                    </div>
                    <div class="px-6 py-4">
                        <?php echo nl2br(htmlspecialchars($newsPost['content'])); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No news posts found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
