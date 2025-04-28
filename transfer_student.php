<?php
header('Content-Type: application/json');
ob_clean();


include 'dbconnection.php';
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];  // The ID of the student to be transferred

if (!empty($id)) {
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
            $insertQuery = "INSERT INTO archive_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Date)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param(
                "ssssssss",
                $student['Student_ID'],
                $student['Student_Name'],
                $student['Department'],
                $student['Program'],
                $student['Violation'],
                $student['Offense'],
                $student['Status'],
                $student['Date']
            );

            if ($insertStmt->execute()) {
                // Step 3: Delete the student record from the student_info table
                $deleteQuery = "DELETE FROM student_info WHERE id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("s", $id);
                $deleteStmt->execute();

                // Commit the transaction after successful insert and delete
                $conn->commit();
                echo json_encode(['success' => true, 'message' => 'Student record transferred to archive successfully!']);
            } else {
                throw new Exception("Failed to insert into archive_info: " . $insertStmt->error); // Display specific error
            }

            $insertStmt->close();
            $deleteStmt->close();
        } else {
            throw new Exception("Student record not found.");
        }

        $stmt->close();
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid student ID.']);
}

$conn->close();
?>
