<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

// DB connection
$conn = new mysqli("localhost", "root", "", "violationdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Add emailSent column if it doesn't exist
$conn->query("ALTER TABLE student_info ADD COLUMN IF NOT EXISTS emailSent TINYINT(1) DEFAULT 0");

// Get all students who haven't received an email
$sql = "SELECT id, Student_Name, Email, Violation FROM student_info WHERE emailSent = 0";
$result = $conn->query($sql);

// Loop through each student
while ($row = $result->fetch_assoc()) {
    $studentName = $row['Student_Name'];
    $studentEmail = $row['Email'];
    $violation = $row['Violation'];

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
        $conn->query("UPDATE student_info SET emailSent = 1 WHERE id = $id");

        echo "Email sent to $studentName ($studentEmail)<br>";
    } catch (Exception $e) {
        echo "Failed to send email to $studentName ($studentEmail). Error: {$mail->ErrorInfo}<br>";
    }
}

$conn->close();
?>