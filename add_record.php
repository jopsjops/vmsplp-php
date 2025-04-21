<?php
include 'dbconnection.php';

// Get the form data
$student_id = $_POST['studentId'];
$student_name = $_POST['name'];
$department = $_POST['program'];
$program = $_POST['course'];
$violation = $_POST['violation'];
$offense = $_POST['offense'];
$status = $_POST['status'];
$date = $_POST['date'];

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
    $sql_insert = "INSERT INTO student_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Date) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssssssss", $student_id, $student_name, $department, $program, $violation, $offense, $status, $date);

    if ($stmt_insert->execute()) {
        header("Location: students_page.php?message=Record+added+successfully");
        exit();
    } else {
        echo "Error inserting record: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>
