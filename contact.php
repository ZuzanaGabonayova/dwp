<?php

require 'db.php'; // Include the database connection

// Function to validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Create connection using PDO to utilize prepared statements
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Process the form data if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $name = test_input($_POST['name']);
    $email = test_input($_POST['email']);
    $message = test_input($_POST['message']);

    // Check if email is a valid email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    try {
        $stmt->execute();

        // Send email to the owner
        $to = 'vitkai.laca1@gmail.com'; // Replace with the owner's email address
        $subject = 'New Contact Form Submission - DWP';
        $headers = "From: info@zuzanagabonyova.eu" . "\r\n" . // Replace with the sender's email address
                   "Reply-To: $email" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();
        $email_content = "You have received a new message from the contact form on your website.\n\n" .
                         "Name: $name\n" .
                         "Email: $email\n\n" .
                         "Message:\n$message\n";

        if (mail($to, $subject, $email_content, $headers)) {
            echo "Thank you for contacting us, $name. We will get back to you shortly.";
        } else {
            echo "The email could not be sent.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

// Close connection
$conn = null;
?>


