<?php
session_start();

// Database connection
$servername = "tj5iv8piornf713y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "vl9ieik1ttwerlmd"; // Your DB username
$password = "dxn55zzkhyp5ek1e";     // Your DB password
$dbname = "z6vet51amyrj9ci0"; // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database.<br>";
}

// Sample data for admin and college deans
$users = [
    ['username' => 'finance', 'password' => 'financePassword123', 'college' => 'FINANCE'],
    ['username' => 'registrar', 'password' => 'registrarPassword123', 'college' => 'REGISTRAR'],
    ['username' => 'admin', 'password' => 'adminPassword123', 'college' => 'ADMIN'],
    ['username' => 'coe_dean', 'password' => 'passwordCOE123', 'college' => 'COE'],
    ['username' => 'ccs_dean', 'password' => 'passwordCCS123', 'college' => 'CCS'],
    ['username' => 'cas_dean', 'password' => 'passwordCAS123', 'college' => 'CAS'],
    ['username' => 'cba_dean', 'password' => 'passwordCBA123', 'college' => 'CBA'],
    ['username' => 'cihm_dean', 'password' => 'passwordCIHM123', 'college' => 'CIHM'],
    ['username' => 'con_dean', 'password' => 'passwordCON123', 'college' => 'CON'],
    ['username' => 'coed_dean', 'password' => 'passwordCOEd123', 'college' => 'COEd'],
];

// Prepare statement for inserting data
$stmt = $conn->prepare("INSERT INTO dean_login (username, password, college) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $username, $hashed_password, $college);

// Insert each user's credentials
foreach ($users as $user) {
    $username = $user['username'];
    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
    $college = $user['college'];

    echo "Inserting: Username: $username, Password: $hashed_password, College: $college<br>";

    // Check if the username already exists
    $check_query = $conn->prepare("SELECT username FROM dean_login WHERE username = ?");
    if (!$check_query) {
        die("Check query prepare failed: " . $conn->error);
    }
    $check_query->bind_param("s", $username);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows === 0) {
        if ($stmt->execute()) {
            echo "New record created successfully for " . $college . "<br>";
        } else {
            echo "Error inserting record for $college: " . $stmt->error . "<br>";
        }
    } else {
        echo "Username already exists for " . $college . "<br>";
    }
    $check_query->close();
}

$stmt->close();
$conn->close();
?>