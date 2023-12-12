<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

// Loading .env variables
$dotenv = Dotenv\Dotenv::createImmutable('/home/master/applications/phqmbyaurd/public_html');
$dotenv->load();

require __DIR__ . '/../../src/config/db.php'; // Database connection file

// Prevent direct access to the script
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['status' => false, 'message' => 'This script cannot be accessed directly.']);
    exit;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Initialize response array
$response = ['status' => false, 'message' => ''];

try {
    // Sanitize input
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $message = test_input($_POST["message"]);

    // Save to database
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = $_ENV['MAIL_HOST'] ?? null;
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['MAIL_USERNAME'] ?? null;
    $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? null;
    $mail->SMTPSecure = $_ENV['MAIL_SECURE'] ?? null;
    $mail->Port       = $_ENV['MAIL_PORT'] ?? null;

    // Recipients
    $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'] ?? null, 'DWP Contact Form');
    $mail->addAddress($_ENV['MAIL_TO_ADDRESS'] ?? null);  

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body    = "You have received a new message from $name.<br>Email: $email<br>Message: $message";
    $mail->AltBody = "You have received a new message from $name.\nEmail: $email\nMessage: $message";

    if (!$mail->send()) {
        throw new Exception('Mail could not be sent.');
    }

    $response['status'] = true;
    $response['message'] = 'Message has been sent successfully.';
} catch (Exception $e) {
    $response['status'] = false;
    $response['message'] = 'Message could not be sent. Please try again later.';
}

// Return response
echo json_encode($response);
exit;
?>
