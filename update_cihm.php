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

// Get the form data
$student_id = $_POST['student_id'];
$student_name = $_POST['Student_Name'];
$department = $_POST['Department'];
$program = $_POST['Program'];
$violation = $_POST['Violation'];
$status = $_POST['Status'];
$date = $_POST['Date'];

// Prepare the SQL statement
$sql = "UPDATE student_info SET 
    Student_Name = ?, 
    Department = ?, 
    Program = ?, 
    Violation = ?, 
    Status = ?, 
    Date = ? 
    WHERE Student_ID = ?";

// Debugging: Print out the variables to check their values
echo "Updating Student_ID: " . htmlspecialchars($student_id) . "<br>";
echo "New values: $student_name, $department, $program, $violation, $status, $date<br>";

// Prepare the statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param('ssssssss', $student_name, $department, $program, $violation, $status, $date, $student_id);

// Execute the statement
if ($stmt->execute()) {
    // Output a JavaScript snippet that shows an alert and redirects after "OK"
    echo '<script type="text/javascript">';
    echo 'alert("Record updated successfully!");';
    echo 'window.location.href = "cihm_dean.php";'; // Redirect to the desired page after "OK"
    echo '</script>';
} else {
    // If there's an error, display it
    echo '<script type="text/javascript">';
    echo 'alert("Error updating record: ' . $stmt->error . '");';
    echo 'window.history.back();'; // Redirect back to the form if there's an error
    echo '</script>';
}


// Close statement and connection
$stmt->close();
$conn->close();
?>