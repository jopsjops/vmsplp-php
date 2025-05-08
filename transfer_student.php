<?php
ob_clean();
include 'dbconnection.php';

$id = $_POST['student_id'] ?? null;
$accomplished = $_POST['date_accomplished'] ?? null;
$base64 = $_POST['evidence_base64'] ?? null;

// Upload proof from archive modal
if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'proof/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $proofFileName = time() . '_' . basename($_FILES['proof']['name']);
    move_uploaded_file($_FILES['proof']['tmp_name'], $uploadDir . $proofFileName);
}

// Save base64 image from Upload button if available
if (!empty($base64)) {
    $uploadDir = 'proof/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
    $decoded = base64_decode($base64);
    $uniqueName = $uploadDir . time() . '_upload_image.jpg';
    file_put_contents($uniqueName, $decoded);
}

// Insert into archive_info WITHOUT image
if (!empty($id) && !empty($accomplished)) {
    $conn->begin_transaction();

    try {
        $selectQuery = "SELECT * FROM student_info WHERE id = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();

            $insertQuery = "INSERT INTO archive_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Sanction, Personnel, Accomplished)
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
                $student['Sanction'],
                $student['Personnel'],
                $accomplished
            );

            if ($insertStmt->execute()) {
                $deleteQuery = "DELETE FROM student_info WHERE id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("s", $id);
                $deleteStmt->execute();

                $conn->commit();

                echo "<script>alert('Student record archived successfully!'); window.location.href='students_page.php';</script>";
                exit;
            } else {
                throw new Exception("Failed to insert into archive_info: " . $insertStmt->error);
            }
        } else {
            throw new Exception("Student not found.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='students_page.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid input.'); window.location.href='students_page.php';</script>";
    exit;
}

$conn->close();
?>
