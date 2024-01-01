<?php
//session_start(); // Initialize the session for counting the cart items
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../news/ReadNewsCrud.php';
require_once '../../admin_authentication/loggedin.php';
// Call the function to update last activity time
updateLastActivityTime();
    
    $newsId = $_GET['id'] ?? null;

    if ($newsId) {
        $readNewsCrud = new ReadNewsCrud($conn);
        $newsPost = $readNewsCrud->readNewsPost($newsId);
    }

    if (!$newsPost) {
        echo "News post not found.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News Post</title>
</head>
<body>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl rounded-xl bg-white shadow-[0px_0px_0px_1px_rgba(9,9,11,0.07),0px_2px_2px_0px_rgba(9,9,11,0.05)]">
                <form action="../../actions/handle_update_news_post.php" method="post" enctype="multipart/form-data" class="space-y-8">
                    <h1 class="text-lg/7 font-semibold tracking-[-0.015em] text-zinc-950 sm:text-base/7">Edit News Post</h1>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($newsId); ?>">

                    <label for="title" class="select-none text-base/6 text-zinc-950 data-[disabled]:opacity-50 sm:text-sm/6">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($newsPost['title']); ?>" required class="relative block w-full appearance-none rounded-lg px-[calc(theme(spacing[3.5])-1px)] py-[calc(theme(spacing[2.5])-1px)] sm:px-[calc(theme(spacing[3])-1px)] sm:py-[calc(theme(spacing[1.5])-1px)] text-base/6 text-zinc-950 placeholder:text-zinc-500 sm:text-sm/6">

                    <label for="shortDescription">Short Description:</label>
                    <input type="text" id="shortDescription" name="shortDescription" value="<?php echo htmlspecialchars($newsPost['short_description']); ?>">

                    <label for="content">Content:</label>
                    <textarea id="content" name="content" required><?php echo htmlspecialchars($newsPost['content']); ?></textarea>

                    <label for="image">Current Image:</label>
                    <?php if ($newsPost['image']): ?>
                        <img src="<?php echo htmlspecialchars($newsPost['image']); ?>" alt="<?php echo htmlspecialchars($newsPost['image_alt']); ?>" style="max-width: 200px;">
                    <?php else: ?>
                        <p>No image available.</p>
                    <?php endif; ?>

                    <label for="image">Upload New Image:</label>
                    <input type="file" id="image" name="image" accept="image/*">

                    <label for="image_alt">Image Alt Text:</label>
                    <input type="text" id="image_alt" name="image_alt" value="<?php echo htmlspecialchars($newsPost['image_alt']); ?>">

                    <button type="submit">Update News Post</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../assets/js/admin_inactivity.js"></script>
</body>
</html>
