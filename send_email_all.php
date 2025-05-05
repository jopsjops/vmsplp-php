<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// DB connection
$conn = new mysqli("localhost", "root", "", "violationdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Add email_sent column if it doesn't exist
$conn->query("ALTER TABLE violation ADD COLUMN IF NOT EXISTS email_sent TINYINT(1) DEFAULT 0");

// Get all students who haven't received an email
$sql = "SELECT id, name, email, violation FROM violations WHERE email_sent = 0";
$result = $conn->query($sql);

// Loop through each student
while ($row = $result->fetch_assoc()) {
    $studentName = $row['name'];
    $studentEmail = $row['email'];
    $violation = $row['violation'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'eunicekhater@gmail.com';           // <-- your Gmail
        $mail->Password = 'qonrdmejkaimrzqo';              // <-- your App Password from Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('eunicekhater@gmail.com', 'Admin');
        $mail->addAddress($studentEmail, $studentName);

        $mail->Subject = 'Violation Notice';
        $mail->Body = "Dear $studentName,\n\nYou committed the following violation:\n\n\"$violation\"\n\nPlease address this issue promptly.";

        $mail->send();

        // Mark as emailed
        $id = $row['id'];
        $conn->query("UPDATE violations SET email_sent = 1 WHERE id = $id");

        echo "Email sent to $studentName ($studentEmail)<br>";
    } catch (Exception $e) {
        echo "Failed to send email to $studentName ($studentEmail). Error: {$mail->ErrorInfo}<br>";
    }
}

$conn->close();
?>