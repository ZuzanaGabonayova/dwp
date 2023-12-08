<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
$secretKey = "ES_901c5c3c7262407d901507f356dee21d"; // Replace with your actual secret key
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

    // Save to database
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'send.one.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@zuzanagabonayova.eu';
    $mail->Password   = 'dwp2023';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

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

// Return response
echo json_encode($response);
?>
