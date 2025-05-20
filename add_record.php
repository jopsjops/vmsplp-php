<?php
session_start(); // make sure session is started to get username

include 'dbconnection.php';

// Get current logged-in username for audit
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';

// Get the form data
$student_id = $_POST['studentId'];
$student_name = $_POST['name'];
$department = $_POST['program'];
$program = $_POST['course'];
$violation = $_POST['violation'];
$offense = $_POST['offense'];
$status = $_POST['status'];
$personnel = $_POST['personnel'];
$date = $_POST['date'];
$time = $_POST['time'];
$sanction = $_POST['sanction'];

// Check if the student ID already exists
$sql_check = "SELECT Violation, Offense FROM student_info WHERE Student_ID = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $student_id);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    // Student exists, append violation and offense
    $row = $result->fetch_assoc();
    $updated_violation = $row['Violation'] . "; " . $violation;
    $updated_offense = $row['Offense'] . "; " . $offense;

    $sql_update = "UPDATE student_info SET Violation = ?, Offense = ?, Status = ?, Date = ? WHERE Student_ID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssss", $updated_violation, $updated_offense, $status, $date, $student_id);

    if ($stmt_update->execute()) {
        header("Location: students_page.php?message=Record+updated+successfully");
        exit();
    } else {
        echo "Error updating record: " . $stmt_update->error;
    }

    $stmt_update->close();
} else {
    // Insert a new record
    $sql_insert = "INSERT INTO student_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Personnel, Date, Time, Sanction) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sssssssssss", $student_id, $student_name, $department, $program, $violation, $offense, $status, $personnel, $date, $time, $sanction);

    if ($stmt_insert->execute()) {
        // Audit insert action only here
        $action = "insert";
        $event_type = "Student Record Insert";
        $message = "Added new student record for Student_ID: $student_id, Name: $student_name";

        $audit_sql = "INSERT INTO audit_trail (username, action, message, event_type, timestamp) VALUES (?, ?, ?, ?, NOW())";
        $audit_stmt = $conn->prepare($audit_sql);
        $audit_stmt->bind_param("ssss", $username, $action, $message, $event_type);
        $audit_stmt->execute();
        $audit_stmt->close();

        echo "<script>
            alert('Record has been added successfully!');
            window.location.href = 'students_page.php';
        </script>";
        exit();
    } else {
        echo "Error inserting record: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>
