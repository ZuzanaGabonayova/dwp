<h1>hello</h1>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require '.src/actions/load_env.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $value = getenv('MAIL_HOST'); 
    ?>
    <a href="./src/views/list_product.php">Product list</a><br>
    <a href="./src/views/news_post_form.php">Add news post</a><br>
    <a href="./src/views/company.php">Company presentation</a><br>
    <a href="./src/views/all_news_posts.php">All news posts</a><br>
    <a href="./src/components/contact_form.php">Contact form</a><br>
    <a href="./src/views/visitor_product_page.php">Visitor products</a><br>
    <a href="./src/views/news.php">Visitor news</a><br>
    <a href="./src/views/AdminDashboard.php">Admin dashboard</a><br>
    <a href="./src/views/daily-special-offer.php">Daily special offer</a><br>
</body>
</html>