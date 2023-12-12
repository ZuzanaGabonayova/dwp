

<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('/home/master/applications/phqmbyaurd/public_html'); // Adjusted path to load .env from two directories back
$dotenv->load();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../src/config/db.php'; // Adjusted path to load db.php from two directories back

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

// hCaptcha verification
$secretKey = $_ENV['HCAPTCHA_SECRET'] ?? null;
$token = $_POST['h-captcha-response'];

// Log hCaptcha response token
error_log("hCaptcha response token: " . $token);

$verify = curl_init();
curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
curl_setopt($verify, CURLOPT_POST, true);
curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query(['secret' => $secretKey, 'response' => $token]));
curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);

// Log curl execution response
error_log("hCaptcha verification response: " . $verificationResponse);

$responseData = json_decode(curl_exec($verify));
curl_close($verify);

// Log decoded response data
error_log("Decoded response data: " . json_encode($responseData));

// Check if hCaptcha was successful
if (!$responseData->success) {
    // hCaptcha failed, return an error
    echo json_encode(['status' => false, 'message' => 'Captcha verification failed, please try again.']);
    exit;
}

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
