<?php
// Database connection
$servername = "tj5iv8piornf713y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "vl9ieik1ttwerlmd"; // Your DB username
$password = "dxn55zzkhyp5ek1e";     // Your DB password
$dbname = "z6vet51amyrj9ci0"; // Your DB name

$conn = new mysqli($servername, $username, $password, $targetDb);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the new table name from the form submission
$newTableName = $_POST['newTableName'];

// Sanitize the new table name to prevent SQL injection
$newTableName = preg_replace('/[^A-Za-z0-9_]/', '', $newTableName);

// Check if the table already exists in `sem_violations` database
$checkTableQuery = "SHOW TABLES LIKE '$newTableName'";
$checkResult = $conn->query($checkTableQuery);

$success = false;
$message = "";

if ($checkResult->num_rows > 0) {
    $message = "Table '$newTableName' already exists.";
} else {
    // Create the new table in `sem_violations` and transfer data
    $createTableQuery = "CREATE TABLE $newTableName AS SELECT * FROM $sourceDb.archive_info";

    if ($conn->query($createTableQuery) === TRUE) {
        // If data is successfully transferred, clear the `archive_info` table in `violationdb`
        $clearTableQuery = "DELETE FROM $sourceDb.archive_info";

        if ($conn->query($clearTableQuery) === TRUE) {
            $message = "Data successfully transferred to '$newTableName' and cleared from `archive_info`.";
            $success = true;
        } else {
            $message = "Data transferred, but error clearing archive_info: " . $conn->error;
        }
    } else {
        $message = "Error creating table in `sem_violations`: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transfer Status</title>
</head>

<body>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Show confirmation message to the user
            const success = <?php echo json_encode($success); ?>;
            const message = <?php echo json_encode($message); ?>;

            // Show an alert dialog to confirm the action
            const userConfirmed = confirm(message);

            if (userConfirmed || success) {
                // Redirect to the archive page
                window.location.href = 'archive.php';
            }
        });
    </script>
</body>

</html>