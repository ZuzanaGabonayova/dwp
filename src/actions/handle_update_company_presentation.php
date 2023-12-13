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
    $description = $_POST['DescriptionOfCompany'];
    $openingHours = $_POST['OpeningHours'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];
    $street = $_POST['Street'];
    $houseNumber = $_POST['HouseNumber'];
    $postalCodeID = $_POST['PostalCodeID'];
    $title = $_POST['Title'];
    $image = $_FILES['Image'];
    // Retrieve other fields similarly

    // Update the company presentation
    if ($updateCrud->updateCompanyPresentation($description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID, $title, $image)) {
     // Redirect to company.php after successful update
        header('Location: ../views/admin/company.php');
        exit();
    } else {
        echo "Error updating company presentation.";
        // Error handling
    }
}
?>
