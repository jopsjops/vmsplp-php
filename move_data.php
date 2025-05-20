<?php
session_start(); // Start session to access the logged-in username
include 'dbconnection.php';

// Use current session username or fallback
$loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';

// Connect to target database (sem_violations)
$conn = new mysqli($servername, $username, $password, $targetDb);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize new table name
$newTableName = preg_replace('/[^A-Za-z0-9_]/', '', $_POST['newTableName']);

$checkTableQuery = "SHOW TABLES LIKE '$newTableName'";
$checkResult = $conn->query($checkTableQuery);

$success = false;
$message = "";
$auditMessage = "";
$auditEventType = "";

if ($checkResult->num_rows > 0) {
    $message = "Table '$newTableName' already exists.";
    $auditMessage = "Attempted to transfer archive data, but table '$newTableName' already exists.";
    $auditEventType = "Transfer-exists";
} else {
    // Create new table and transfer data from archive_info
    $createTableQuery = "CREATE TABLE $newTableName AS SELECT * FROM $sourceDb.archive_info";

    if ($conn->query($createTableQuery) === TRUE) {
        // Clear original archive_info
        $clearTableQuery = "DELETE FROM $sourceDb.archive_info";

        if ($conn->query($clearTableQuery) === TRUE) {
            $message = "Data successfully transferred to '$newTableName' and cleared from `archive_info`.";
            $auditMessage = "Transferred archive_info to '$newTableName' and cleared source table.";
            $auditEventType = "Transfer-success";
            $success = true;
        } else {
            $message = "Data transferred, but error clearing archive_info: " . $conn->error;
            $auditMessage = "Transferred to '$newTableName', but failed to clear archive_info: " . $conn->error;
            $auditEventType = "Transfer-partial";
        }
    } else {
        $message = "Error creating table '$newTableName': " . $conn->error;
        $auditMessage = "Failed to create table '$newTableName': " . $conn->error;
        $auditEventType = "Transfer-failed";
    }
}

// ✅ Insert audit trail into violationsdb.audit_trail
$auditConn = new mysqli($servername, $username, $password, $sourceDb);
if (!$auditConn->connect_error) {
    $insertAudit = "INSERT INTO audit_trail (username, message, event_type) VALUES (?, ?, ?)";
    $auditStmt = $auditConn->prepare($insertAudit);
    $auditStmt->bind_param("sss", $loggedInUser, $auditMessage, $auditEventType);
    $auditStmt->execute();
    $auditStmt->close();
    $auditConn->close();
} else {
    error_log("Audit DB connection failed: " . $auditConn->connect_error);
}

$conn->close();
?>

<!-- Client-side response -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Transfer Status</title>
</head>
<body>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const success = <?php echo json_encode($success); ?>;
            const message = <?php echo json_encode($message); ?>;
            const confirmMessage = confirm(message);

            if (confirmMessage || success) {
                window.location.href = 'archive.php';
            }
        });
    </script>
</body>
</html>
