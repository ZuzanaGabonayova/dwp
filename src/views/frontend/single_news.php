<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../news/ReadNewsCrud.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $readNewsCrud = new ReadNewsCrud($conn); 
    $news = $readNewsCrud->readNewsPost($id); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $newsPost['title']; ?></title>
    <meta name="description" content="<?php echo $newsPost['short_description']; ?>">
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>
<body>
    <div>

        <?php

        $content = __DIR__ . '/../../components/frontend/single_news.php';
        include_once __DIR__ . '../../../layouts/frontend.php';

        ?>

    </div>
</body>
</html>