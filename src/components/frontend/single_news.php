<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start(); // Initialize the session for counting the cart items

require_once '../../config/db.php';
require_once '../../product/ReadNewsCrud.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $readNewsCrud = new ReadNewsCrud($conn); // Create an instance of ReadNewsCrud
    $news = $readNewsCrud->readNewsPost($id); // Call the method using the instance
}

$conn->close();
?>
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

