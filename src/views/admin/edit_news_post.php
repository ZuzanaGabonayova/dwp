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
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>
<body>
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl rounded-xl bg-white shadow-[0px_0px_0px_1px_rgba(9,9,11,0.07),0px_2px_2px_0px_rgba(9,9,11,0.05)]">
                <div class="p-6 py-8 sm:p-8 lg:p-12">
                    <form action="../../actions/handle_update_news_post.php" method="post" enctype="multipart/form-data">
                        <div class="space-y-12">
                            <h1 class="text-lg/7 font-semibold tracking-[-0.015em] text-zinc-950 sm:text-base/7">Edit News Post</h1>
                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($newsId); ?>">
                                <div class="col-span-full">
                                    <label for="title" class="block text-base/6 text-zinc-950">Title:</label>
                                    <div class="mt-2">
                                         <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($newsPost['title']); ?>" required class="rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                                    </div>
                                </div>
                            </div>

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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../assets/js/admin_inactivity.js"></script>
</body>
</html>
