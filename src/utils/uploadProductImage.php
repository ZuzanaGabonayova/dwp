<?php

/**
 * Upload a file and return the new file path if successful, or an error message if not.
 */
function uploadFile($file, $uploadDir = '../../assets/images/') {
    // Define the allowed file types
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $maxFileSize = 5 * 1024 * 1024; // 5 MB

    // Check if there was an error
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'An error occurred during file upload.'];
    }

    // Check file size
    if ($file['size'] > $maxFileSize) {
        return ['error' => 'The file is too large.'];
    }

    // Verify the file type is allowed
    if (!in_array($file['type'], $allowedTypes)) {
        return ['error' => 'The file type is not allowed.'];
    }

    // Secure the file name
    $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid('prod_') . '.' . $fileExt;

    // Check if uploadDir exists, if not create it
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Specify the path to save the uploaded file
    $filePath = $uploadDir . basename($fileName);

    // Move the file to the final location
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        return ['success' => $filePath];
    } else {
        return ['error' => 'Failed to move uploaded file.'];
    }
}
