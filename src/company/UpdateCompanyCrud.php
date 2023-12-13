<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

require_once '../config/db.php';
require_once '../utils/uploadCompanyImage.php'; // Include the file upload function

class UpdateCompanyCrud {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateCompanyPresentation($description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID, $title, $image, $icon1Image, $icon1Description, $icon2Image, $icon2Description, $icon3Image, $icon3Description) {
    // Handle file uploads
    $imageUploadResult = uploadCompanyImage($image);
    if (isset($imageUploadResult['error'])) {
        // Handle error
        return false;
    }
    $imagePath = $imageUploadResult['success'];

    $icon1ImageUploadResult = uploadCompanyImage($icon1Image);
    if (isset($icon1ImageUploadResult['error'])) {
        // Handle error
        return false;
    }
    $icon1ImagePath = $icon1ImageUploadResult['success'];

    $icon2ImageUploadResult = uploadCompanyImage($icon2Image);
    if (isset($icon2ImageUploadResult['error'])) {
        // Handle error
        return false;
    }
    $icon2ImagePath = $icon2ImageUploadResult['success'];

    $icon3ImageUploadResult = uploadCompanyImage($icon3Image);
    if (isset($icon3ImageUploadResult['error'])) {
        // Handle error
        return false;
    }
    $icon3ImagePath = $icon3ImageUploadResult['success'];

    // Prepare the SQL statement
    $stmt = $this->conn->prepare("UPDATE company SET description = ?, openingHours = ?, email = ?, phone = ?, street = ?, houseNumber = ?, postalCodeID = ?, title = ?, image = ?, icon1Image = ?, icon1Description = ?, icon2Image = ?, icon2Description = ?, icon3Image = ?, icon3Description = ? WHERE id = 1");

    // Bind the parameters
    $stmt->bind_param("ssssssissssssss", $description, $openingHours, $email, $phone, $street, $houseNumber, $postalCodeID, $title, $imagePath, $icon1ImagePath, $icon1Description, $icon2ImagePath, $icon2Description, $icon3ImagePath, $icon3Description);

    // Execute the statement
    return $stmt->execute();
}
}
?>