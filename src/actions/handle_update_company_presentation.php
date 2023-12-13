<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

require_once '../config/db.php';
require_once '../company/UpdateCompanyCrud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instantiate the CRUD class
    $updateCrud = new UpdateCompanyCrud($conn);

    // Get the form data
    $description = $_POST['description'];
    $openingHours = $_POST['openingHours'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $street = $_POST['street'];
    $houseNumber = $_POST['houseNumber'];
    $postalCodeID = $_POST['postalCodeID'];
    $title = $_POST['title'];
    $image = $_FILES['image'];
    $icon1Image = $_FILES['icon1Image'];
    $icon2Image = $_FILES['icon2Image'];
    $icon3Image = $_FILES['icon3Image'];
    $icon1Description = $_POST['icon1Description'];
    $icon2Description = $_POST['icon2Description'];
    $icon3Description = $_POST['icon3Description'];
    // Retrieve other fields similarly

    // Update the company presentation
    if ($updateCrud->updateCompanyPresentation($description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID, $title, $image, $icon1Image, $icon1Description, $icon2Image, $icon2Description, $icon3Image, $icon3Description)) {
     // Redirect to company.php after successful update
        header('Location: ../views/admin/company.php');
        exit();
    } else {
        echo "Error updating company presentation.";
        // Error handling
    }
}
?>
