<?php

require_once '../config/db.php';
require_once '../news/ReadNewsCrud.php';

$readNewsCrud = new ReadNewsCrud($conn);
$newsPosts = $readNewsCrud->readAllNewsPosts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All News Posts</title>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($post = $newsPosts->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td>
                        <a href="edit_news_post.php?id=<?php echo $post['id']; ?>">Edit</a>
                        <a href="../actions/handle_delete_news_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
