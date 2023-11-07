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
<h1>dedicated product page</h1>
<div class="container mx-auto px-4 py-6">
    <!-- Main Image Display -->
    <?php if (!empty($images)): ?>
        <div class="w-full mb-4">
            <img id="mainImage" src="<?php echo htmlspecialchars($images[0]['image_path']); ?>" alt="<?php echo htmlspecialchars($images[0]['alt_text']); ?>" class="w-full h-auto object-cover rounded-lg shadow-md">
        </div>

        <!-- Thumbnails -->
        <div class="flex -mx-2">
            <?php foreach (array_slice($images, 1) as $image): ?>
                <div class="flex-1 px-2">
                    <img src="<?php echo htmlspecialchars($image['image_path']); ?>" alt="<?php echo htmlspecialchars($image['alt_text']); ?>" class="w-full h-auto object-cover rounded-lg shadow-md cursor-pointer" onclick="document.getElementById('mainImage').src='<?php echo htmlspecialchars($image['image_path']); ?>'">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    // You can add additional JavaScript here if needed
</script>

</body>
</html>
