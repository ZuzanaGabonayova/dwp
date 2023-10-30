<?php
require('./model/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the product details for editing
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $image = $row['image'];
    } else {
        echo "Product not found.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);

    if ($name === false || $description === false || $price === false) {
        echo "Invalid input. Please check your data.";
    } else {
        // Check if a new image was uploaded
        if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
            // Handle file upload
            $image = 'images/' . basename($_FILES['image']['name']);

            // Check if it's an image
            $fileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            if (getimagesize($_FILES['image']['tmp_name']) === false || !in_array($fileType, array('jpg', 'jpeg', 'png', 'gif'))) {
                echo "Invalid image file. Only JPG, JPEG, PNG, and GIF allowed.";
            } else {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
                    // Update product information, including the new image
                    $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
                    if ($stmt->execute()) {
                        header("Location: index.php");
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Error uploading the image.";
                }
            }
        } else {
            // No new image uploaded, update product information excluding the image
            $sql = "UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdi", $name, $description, $price, $id);
            if ($stmt->execute()) {
                header("Location: index.php");
            } else {
                echo "Error: " . $conn->error;
            }
        }
    }
}
?>
<!-- The HTML form for editing a product goes here -->

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="edit_product.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Product Name: <input type="text" name="name" value="<?php echo $name; ?>" required><br>
        Description: <textarea name="description"><?php echo $description; ?></textarea><br>
        Price: <input type="number" name="price" value="<?php echo $price; ?>" required><br>
        Current Image: <img src="<?php echo $image; ?>" width="100"><br>
        New Image: <input type="file" name="image" accept="image/*"><br>
        <input type="submit" value="Update Product">
    </form>
    
</body>
</html>
