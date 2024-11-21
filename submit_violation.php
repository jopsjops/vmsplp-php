<?php
// Enable error reporting for debugging during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary headers for CORS and JSON responses
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Database connection
$servername = "tj5iv8piornf713y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "vl9ieik1ttwerlmd"; // Your DB username
$password = "dxn55zzkhyp5ek1e";     // Your DB password
$dbname = "z6vet51amyrj9ci0"; // Your DB name

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection and handle connection errors
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Validate the JSON data
    if (isset($data['studentId'], $data['studentName'], $data['department'], $data['program'], $data['violation'], $data['offense'], $data['status'], $data['date'])) {
        $studentId = $data['studentId'];
        $studentName = $data['studentName'];
        $department = $data['department'];
        $program = $data['program'];
        $violation = $data['violation'];
        $offense = $data['offense'];
        $status = $data['status'];
        $date = $data['date'];

        // Prepare the SQL statement for insertion (auto-increment handles 'id' automatically)
        $stmt = $conn->prepare("INSERT INTO student_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $studentId, $studentName, $department, $program, $violation, $offense, $status, $date);

        // Execute and check for errors
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Record added successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Required fields are missing"]);
    }
} else {
    // Respond with 405 Method Not Allowed for non-POST requests
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}

// Close the database connection
$conn->close();
?>