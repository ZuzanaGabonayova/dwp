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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="px-6 pb-24 pt-20 sm:pb-32 lg:px-8 lg:py-24">
         <form class="mx-auto" action="edit_product.php" method="post" enctype="multipart/form-data">
        <div class="mx-auto max-w-xl lg:max-w-lg">
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-neutral-800">Shoes Webshop Admin</h1>
                <h2 class="text-3xl">Edit product</h2>
            </div>
            <div class="grid grid-cols-1 gap-x-8 gap-y-6">
                <div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <label for="first-name" class="block text-sm font-semibold leading-6 text-gray-900">Product Name</label>
                    <div class="mt-2.5">
                        <input value="<?php echo $name; ?>" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" name="name" required><br>
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-semibold leading-6 text-gray-900">Description</label>
                    <div class="mt-2.5">
                        <textarea  name="description" id="description" rows="4" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"><?php echo $description; ?></textarea>
                    </div>
                </div>
                <div>
                    <label for="price" class="block text-sm font-semibold leading-6 text-gray-900">Price</label>
                    <div class="mt-2.5">
                        <input value="<?php echo $price; ?>" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="number" name="price" required><br>
                    </div>
                </div>
                <div>
                    <label for="current_image" class="block text-sm font-semibold leading-6 text-gray-900">Current Image</label>
                    <div class="mt-2.5">
                        <img src="<?php echo $image; ?>" width="100">
                    </div>
                </div>
                  <div>
                    <label for="image" class="block text-sm font-semibold leading-6 text-gray-900">Upload image</label>
                    <div class="mt-2.5">
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none  p-1" aria-describedby="file_input_help" id="file_input" name="image" type="file" accept="image/*">
                        <p class="mt-1 text-sm text-gray-500 " id="file_input_help">SVG, PNG, JPG (MAX. 800x400px).</p>
                    </div>
                </div>
            <div class="mt-8 flex justify-end">
                <button type="submit" value="Update Product" class="rounded-md bg-[#FF8C42] px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-[#FF8C42]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Edit product</button>
            </div>
            </div>
        </div>
    </form>
    </div>
   
</body>
</html>
