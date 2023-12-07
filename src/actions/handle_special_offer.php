<?php
ini_set('display_errors', 1);   
ini_set('display_startup_errors', 1);

require_once '../config/db.php';
require_once '../daily_special_offer/DailySpecialOfferCrud.php';

$specialOfferCrud = new DailySpecialOfferCrud($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["productId"])) {
    $productId = $_POST["productId"];
    $specialOfferCrud->createOrUpdateSpecialOffer($productId);
    // Redirect or show a success message
    header("Location: ../views/daily-special-offer.php");
}
?>
