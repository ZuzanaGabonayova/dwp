<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable('../../.');
$dotenv->load();


require '../../vendor/autoload.php'; // If using Composer
require '../config/db.php'; // Your database connection file

// Prevent direct access to the script
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "This script cannot be accessed directly.";
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
$secretKey = $_ENV['HCAPTCHA_SECRET'];
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
    $response['message'] = 'Captcha verification failed, please try again.';
    echo json_encode($response);
    exit;
}

try {
    // Sanitize input
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $message = test_input($_POST["message"]);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format.';
        echo json_encode($response);
        exit;
    }

    // Validate name (letters and white space only)
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $response['message'] = 'Only letters and white space allowed in name.';
        echo json_encode($response);
        exit;
    }

    // Validate message length
    if (empty($message)) {
        $response['message'] = 'Message cannot be empty.';
        echo json_encode($response);
        exit;
    } elseif (strlen($message) > 1000) {
        $response['message'] = 'Message is too long.';
        echo json_encode($response);
        exit;
    }

    // Save to database
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = $_ENV['MAIL_HOST'];       // Or getenv('MAIL_HOST')
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['MAIL_USERNAME'];   // Or getenv('MAIL_USERNAME')
    $mail->Password   = $_ENV['MAIL_PASSWORD'];   // Or getenv('MAIL_PASSWORD')
    $mail->SMTPSecure = $_ENV['MAIL_SMTPSECURE']; // Or getenv('MAIL_SMTPSECURE')
    $mail->Port       = $_ENV['MAIL_PORT'];       // Or getenv('MAIL_PORT')

    // Recipients
    $mail->setFrom('info@zuzanagabonayova.eu', 'Website Contact Form');
    $mail->addAddress('vitkai.laca1@gmail.com'); 

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body    = "You have received a new message from $name.<br>Email: $email<br>Message: $message";
    $mail->AltBody = "You have received a new message from $name.\nEmail: $email\nMessage: $message";

    $mail->send();
    $response['status'] = true;
    $response['message'] = 'Message has been sent successfully.';

} catch (Exception $e) {
    $response['message'] = 'Message could not be sent. Please try again later.';
}



try {
    // Your PHP code logic here

    // Send success response
    $response['status'] = true;
    $response['message'] = 'Message sent successfully.';
} catch (Exception $e) {
    // Handle exceptions
    $response['status'] = false;
    $response['message'] = 'Message could not be sent. Error: ' . $e->getMessage();
}

// Set header as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
