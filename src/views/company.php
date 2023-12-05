<?php
    // Include your PHP function file here
    require './src/config/db.php';
    require 'crud_operations.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Presentation Table</title>
    <link rel="stylesheet" href="./assets/css/output.css">
</head>
<body class="m-8">
    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr>
                <th class="border border-gray-300">Description</th>
                <th class="border border-gray-300">Opening Hours</th>
                <th class="border border-gray-300">Email</th>
                <th class="border border-gray-300">Phone</th>
                <th class="border border-gray-300">Street</th>
                <th class="border border-gray-300">House Number</th>
                <th class="border border-gray-300">Postal Code ID</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $companyData = readPresentationOfCompany($conn);
                foreach ($companyData as $row) {
                    echo "<tr>";
                    echo "<td class='border border-gray-300'>" . htmlspecialchars($row['DescriptionOfCompany']) . "</td>";
                    echo "<td class='border border-gray-300'>" . htmlspecialchars($row['OpeningHours']) . "</td>";
                    echo "<td class='border border-gray-300'>" . htmlspecialchars($row['Email']) . "</td>";
                    echo "<td class='border border-gray-300'>" . htmlspecialchars($row['Phone']) . "</td>";
                    echo "<td class='border border-gray-300'>" . htmlspecialchars($row['Street']) . "</td>";
                    echo "<td class='border border-gray-300'>" . htmlspecialchars($row['HouseNumber']) . "</td>";
                    echo "<td class='border border-gray-300'>" . htmlspecialchars($row['PostalCodeID']) . "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>