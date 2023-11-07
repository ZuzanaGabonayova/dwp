<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer
require 'db.php'; // Your database connection file

// Function to sanitize form input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

header('Content-Type: application/json'); // Specify the content type as JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $message = test_input($_POST["message"]);

    // Save to database
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => 'Could not save to database.']);
        exit;
    }
    $stmt->close();

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        // ... your existing code ...

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Message has been sent.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Request must be POST.']);
}
?>
