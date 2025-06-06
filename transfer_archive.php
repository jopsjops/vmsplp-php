<?php
header('Content-Type: application/json');
ob_clean();

// Database connection
$servername = "tj5iv8piornf713y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "vl9ieik1ttwerlmd"; // Your DB username
$password = "dxn55zzkhyp5ek1e";     // Your DB password
$dbname = "z6vet51amyrj9ci0"; // Your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];  // The ID of the student to be transferred from archive

if (!empty($id)) {
    $conn->begin_transaction();

    try {
        // Step 1: Select the student record from the archive_info table
        $selectQuery = "SELECT * FROM archive_info WHERE id = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();

            // Step 2: Insert the student record into the student_info table
            $insertQuery = "INSERT INTO student_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Date)
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
                // Step 3: Delete the student record from the archive_info table
                $deleteQuery = "DELETE FROM archive_info WHERE id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("s", $id);
                $deleteStmt->execute();

                // Commit the transaction after successful insert and delete
                $conn->commit();
                echo json_encode(['success' => true, 'message' => 'Student record restored from archive successfully!']);
            } else {
                throw new Exception("Failed to insert into student_info.");
            }

            $insertStmt->close();
            $deleteStmt->close();
        } else {
            throw new Exception("Student record not found in archive.");
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
