<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // If using Composer
require '../config/db.php'; // Your database connection file

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
$secretKey = getenv('HC_SECRET'); // Using .env variable
$token = $_POST['h-captcha-response'];
$verify = curl_init();
curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
curl_setopt($verify, CURLOPT_POST, true);
curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query(['secret' => $secretKey, 'response' => $token]));
curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
$responseData = json_decode(curl_exec($verify));
curl_close($verify);

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

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();

    // Server settings
    $mail->isSMTP();
    $mail->Host       = $_ENV('MAIL_HOST');
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV('MAIL_USERNAME');
    $mail->Password   = $_ENV('MAIL_PASSWORD');
    $mail->SMTPSecure = $_ENV('MAIL_ENCRYPTION');
    $mail->Port       = $_ENV('MAIL_PORT');

    // Recipients
    $mail->setFrom('info@zuzanagabonayova.eu', 'Website Contact Form');
    $mail->addAddress('vitkai.laca1@gmail.com'); 

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
