<?php
// Database connection
$servername = "tj5iv8piornf713y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "vl9ieik1ttwerlmd"; // Your DB username
$password = "dxn55zzkhyp5ek1e";     // Your DB password
$dbname = "z6vet51amyrj9ci0"; // Your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if id and other details are posted
if (isset($_POST['id']) && isset($_POST['Student_Name']) && isset($_POST['Department']) && isset($_POST['Program']) && isset($_POST['Violation']) && isset($_POST['Offense']) && isset($_POST['Status']) && isset($_POST['Date'])) {
    $id = $_POST['id'];
    $studentName = $_POST['Student_Name'];
    $department = $_POST['Department'];
    $program = $_POST['Program'];
    $violation = $_POST['Violation'];
    $offense = $_POST['Offense'];
    $status = $_POST['Status'];
    $date = $_POST['Date'];

    // Update query using the unique id to target the exact record
    $sql = "UPDATE archive_info SET Student_Name=?, Department=?, Program=?, Violation=?, Offense=?, Status=?, Date=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $studentName, $department, $program, $violation, $offense, $status, $date, $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Record updated successfully');
                window.location.href = 'archive.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating record: " . $stmt->error . "');
                window.location.href = 'archive.php';
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>
            alert('Incomplete data provided for update.');
            window.location.href = 'archive.php';
          </script>";
}

$conn->close();
?>