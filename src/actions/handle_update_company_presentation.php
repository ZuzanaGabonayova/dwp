<?php
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
    // Retrieve other fields similarly

    // Update the company presentation
    if ($updateCrud->updateCompanyPresentation($description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID)) {
     // Redirect to company.php after successful update
        header('Location: ../views/admin/company.php');
        exit();
    } else {
        echo "Error updating company presentation.";
        // Error handling
    }
}
?>
