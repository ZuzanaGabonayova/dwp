<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer
require 'db.php'; // Your database connection file

// The rest of your

// Function to sanitize form input
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'send.one.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@zuzanagabonayova.eu';
        $mail->Password   = 'dwp2023'; // Replace with your password
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('info@zuzanagabonayova.eu', 'Website Contact Form');
        $mail->addAddress('vitkai.laca1@gmail.com'); // Replace with your email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "You have received a new message from $name.<br>Email: $email<br>Message: $message";
        $mail->AltBody = "You have received a new message from $name.\nEmail: $email\nMessage: $message";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    header('Location: contact.html');
}
?>
