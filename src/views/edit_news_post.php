<?php
require_once '../config/db.php';
require_once '../news/ReadNewsCrud.php';
    
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

    <form action="../actions/handle_update_news_post.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($newsId); ?>">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($newsPost['title']); ?>" required>

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

        <button type="submit">Update News Post</button>
    </form>

</body>
</html>