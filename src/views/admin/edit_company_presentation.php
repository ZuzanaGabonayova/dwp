<?php
session_start(); // Initialize the session for counting the cart items
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../company/ReadCompanyCrud.php';

$readCrud = new ReadCompanyCrud($conn);
$companyData = $readCrud->readCompanyPresentation();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Company Presentation</title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>
<body class="bg-gray-100 p-8">


    <div class="container mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Edit Company Presentation</h2>

        <form action="../../actions/handle_update_company_presentation.php" method="post" class="space-y-4">
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Description:</label>
                <textarea id="description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required><?php echo htmlspecialchars($companyData['DescriptionOfCompany']); ?></textarea>
            </div>

            <div>
                <label for="openingHours" class="block mb-2 text-sm font-medium text-gray-700">Opening Hours:</label>
                <input type="text" id="openingHours" name="openingHours" value="<?php echo htmlspecialchars($companyData['OpeningHours']); ?>" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($companyData['Email']); ?>" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($companyData['Phone']); ?>" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label for="street" class="block mb-2 text-sm font-medium text-gray-700">Street:</label>
                <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($companyData['Street']); ?>" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label for="houseNumber" class="block mb-2 text-sm font-medium text-gray-700">House Number:</label>
                <input type="text" id="houseNumber" name="houseNumber" value="<?php echo htmlspecialchars($companyData['HouseNumber']); ?>" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div>
                <label for="postalCodeID" class="block mb-2 text-sm font-medium text-gray-700">Postal Code:</label>
                <input type="number" id="postalCodeID" name="postalCodeID" value="<?php echo htmlspecialchars($companyData['PostalCodeID']); ?>" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Update Company Presentation</button>
        </form>
    </div>

</body>
</html>
