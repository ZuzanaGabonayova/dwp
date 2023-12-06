<?php
require_once '../config/db.php';
require_once '../company/UpdateCompanyCrud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instantiate the CRUD class
    $updateCrud = new UpdateCompanyCrud($conn);

    // Get the form data
    $description = $_POST['description'];
    // Retrieve other fields similarly

    // Update the company presentation
    if ($updateCrud->updateCompanyPresentation($description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID)) {
        echo "Company presentation updated successfully.";
        // Redirect or further processing
    } else {
        echo "Error updating company presentation.";
        // Error handling
    }
}
?>
