 <?php
    require_once '../daily_special_offer/DailySpecialOfferCrud.php'; // Adjust the path
    require_once '../product/ReadProductCrud.php'; // Adjust the path

    $specialOfferCrud = new DailySpecialOfferCrud($conn);
    $currentOffer = $specialOfferCrud->getCurrentSpecialOffer();
    $productDetails = null;

    if ($currentOffer) {
        $productId = $currentOffer['ProductID'];
        $readProductCrud = new ReadProductCrud($conn);
        $productDetails = $readProductCrud->readProduct($productId);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Special Offer</title>
</head>
<body>

    <h2>Daily Special Offer</h2>

    <?php if ($productDetails): ?>
        <div>
            <p><strong>Product Name:</strong> <?= htmlspecialchars($productDetails['Model']) ?></p> <!-- Adjust field names based on your database -->
            <p><strong>Price:</strong> <?= htmlspecialchars($productDetails['Price']) ?></p>
            <p><strong>Description</strong> <?= htmlspecialchars($productDetails['Description']) ?></p>
            <!-- Add more product details as needed -->
        </div>
    <?php else: ?>
        <p>No special offer available at the moment.</p>
    <?php endif; ?>

</body>
</html>
