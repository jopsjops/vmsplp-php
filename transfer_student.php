<?php
ob_clean();
include 'dbconnection.php';

$id = $_POST['student_id'] ?? null;
$accomplished = $_POST['date_accomplished'] ?? null;

if (!empty($id) && !empty($accomplished)) {
    $conn->begin_transaction();

    try {
        // Step 1: Select the student record from the student_info table
        $selectQuery = "SELECT * FROM student_info WHERE id = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();

            // Step 2: Insert the student record into the archive_info table
            $insertQuery = "INSERT INTO archive_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Date, Sanction, Accomplished)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param(
                "ssssssssss",
                $student['Student_ID'],
                $student['Student_Name'],
                $student['Department'],
                $student['Program'],
                $student['Violation'],
                $student['Offense'],
                $student['Status'],
                $student['Date'],
                $student['Sanction'],
                $accomplished
            );

            if ($insertStmt->execute()) {
                // Step 3: Delete from student_info
                $deleteQuery = "DELETE FROM student_info WHERE id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("s", $id);
                $deleteStmt->execute();

                $conn->commit();

                // ✅ Display alert and redirect
                echo "<script>alert('Student record transferred to archive successfully!'); window.location.href='students_page.php';</script>";
                exit;
            } else {
                throw new Exception("Failed to insert into archive_info: " . $insertStmt->error);
            }

            $insertStmt->close();
            $deleteStmt->close();
        } else {
            throw new Exception("Student record not found.");
        }

        $stmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='students_page.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid student ID or date accomplished.'); window.location.href='students_page.php';</script>";
    exit;
}

$conn->close();
?>
