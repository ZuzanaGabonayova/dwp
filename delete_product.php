<?php

require 'db.php'; // Include the database connection
require 'crud_operations.php'; // Include the CRUD operations

// Function to get the base URL of the script
function baseUrl() {
    // Normally you would make this dynamic or configured, but for localhost it's simple
    return 'https://zuzanagabonayova.eu/';
}

// Check if the 'id' GET parameter is set and the form has been submitted
if (isset($_POST['id']) && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $id = $_POST['id'];
    $result = deleteProduct($id);

    if ($result) {
        // If the product was deleted successfully, redirect back to the product list
        header('Location: product_list.php');
        exit;
    } else {
        $error = 'There was an error deleting the product.';
        // Handle the error, perhaps pass the message back to product_list.php
    }
}

// If there's a GET request without form submission, display the confirmation
if (isset($_GET['id']) && !isset($_POST['confirm'])) {
    $id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Confirmation</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="container mx-auto">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p class="mb-4">Are you sure you want to delete this product?</p>

        <form action="delete_product.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <button type="submit" name="confirm" value="yes" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Yes, delete it!
            </button>
            <a href="<?php echo baseUrl(); ?>product_list.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                No, go back
            </a>
        </form>
    </div>
</body>
</html>

<?php
    // End the script to not display anything else
    exit;
}
// Redirect to the product list if the id parameter is not set
header('Location: product_list.php');
exit;
