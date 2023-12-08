<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('__DIR__');
$dotenv->load();
?>

<h1>hello</h1>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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