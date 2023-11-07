<?php
// Database configuration
require 'db.php';
// SQL to fetch image paths
$sql = "SELECT image_path, alt_text FROM product_images WHERE product_id = 4 LIMIT 4";
$result = $conn->query($sql);

$images = [];

if ($result->num_rows > 0) {
    // Fetch images
    while($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
} else {
    echo "No images found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php foreach ($images as $image): ?>
            <div class="border rounded overflow-hidden">
                <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($image['alt_text']); ?>" class="w-full h-auto">
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
