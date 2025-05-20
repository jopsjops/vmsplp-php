<?php
session_start();
include 'dbconnection.php'; // make sure this file connects to your DB

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    // ✅ Log logout to audit_trail
    $action = "logout";
    $message = "User logged out.";
    $event_type = "Authentication";

    $log_stmt = $conn->prepare("INSERT INTO audit_trail (username, action, message, event_type) VALUES (?, ?, ?, ?)");
    $log_stmt->bind_param("ssss", $username, $action, $message, $event_type);
    $log_stmt->execute();
    $log_stmt->close();
}

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: index.php");
exit();
?>
