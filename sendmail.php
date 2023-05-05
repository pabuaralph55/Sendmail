<?php
// Include PHPMailer library
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Database configuration
$servername = "localhost";
$username = "root";
$password = "@Camiguin5597890";
$dbname = "sendemail";

// Arguments
$messageID = $argv[1];
$recipientEmail = $argv[2];

// Connect to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

// Retrieve email details from the database based on the Message ID
$sql = "SELECT `from_address`, `subject`, `message_body` FROM `messages` WHERE `message_id` = '$messageID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fromAddress = $row['from_address'];
    $subject = $row['subject'];
    $messageBody = $row['message_body'];

    // Create a new PHPMailer instance
    $mailer = new PHPMailer();

    // Enable SMTP debugging (optional)
    $mailer->SMTPDebug = 2;

    // Set the SMTP server and authentication information
    $mailer->isSMTP();
    $mailer->Host = 'smtp.gmail.com';
    $mailer->SMTPAuth = true;
    $mailer->Username = 'pabua.ralph55@gmail.com'; // Your Gmail email address
    $mailer->Password = 'csqkgeskrafehekl'; // Your Gmail account password
    $mailer->SMTPSecure = 'tls'; // Enable TLS encryption
    $mailer->Port = 587; // TCP port to connect to

    // Set email details
    $mailer->setFrom($fromAddress);
    $mailer->addAddress($recipientEmail);
    $mailer->Subject = $subject;
    $mailer->Body = $messageBody;

    // Send email
    if ($mailer->send()) {
        echo "Email sent successfully";
    } else {
        echo "Error sending email: " . $mailer->ErrorInfo;
    }
} else {
    echo "No email found for the given MessageID";
}

// Close the database connection
$conn->close();
?>



