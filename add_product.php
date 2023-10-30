<?php
require('./model/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);

    if ($name === false || $description === false || $price === false) {
        echo "Invalid input. Please check your data.";
    } else {
        // Handle file upload
        $image = 'images/' . basename($_FILES['image']['name']);

        // Check if it's an image
        $fileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        if (getimagesize($_FILES['image']['tmp_name']) === false || !in_array($fileType, array('jpg', 'jpeg', 'png', 'gif'))) {
            echo "Invalid image file. Only JPG, JPEG, PNG, and GIF allowed.";
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
                $sql = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssds", $name, $description, $price, $image);
                if ($stmt->execute()) {
                    header("Location: index.php");
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Error uploading the image.";
            }
        }
    }
}
?>
<!-- The HTML form for adding a product goes here -->
