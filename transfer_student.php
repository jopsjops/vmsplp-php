<?php
ob_clean();
include 'semviolations.php';

$studentId = $_POST['student_id'];
$accomplished = $_POST['date_accomplished'];
$evidenceBase64 = $_POST['evidence_base64'];
$proofFileName = null;

// Handle uploaded image
if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'proof/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $proofFileName = time() . '_' . basename($_FILES['proof']['name']);
    move_uploaded_file($_FILES['proof']['tmp_name'], $uploadDir . $proofFileName);
}
// Handle base64 image (if image not uploaded using input[type=file])
elseif (!empty($evidenceBase64)) {
    $uploadDir = 'proof/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $evidenceBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $evidenceBase64);
    $decoded = base64_decode($evidenceBase64);
    $proofFileName = time() . '_upload_image.jpg';
    file_put_contents($uploadDir . $proofFileName, $decoded);
}

if (!empty($studentId) && !empty($accomplished)) {
    $conn->begin_transaction();

    try {
        // Get student details
        $selectQuery = "SELECT * FROM student_info WHERE id = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("s", $studentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();

            // Insert into archive_info including proof image
            $insertQuery = "INSERT INTO archive_info 
                (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Sanction, Personnel, Accomplished, Proof)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param(
                "sssssssssss",
                $student['Student_ID'],
                $student['Student_Name'],
                $student['Department'],
                $student['Program'],
                $student['Violation'],
                $student['Offense'],
                $student['Status'],
                $student['Sanction'],
                $student['Personnel'],
                $accomplished,
                $proofFileName
                
            );

            if ($insertStmt->execute()) {
                // Delete from student_info
                $deleteQuery = "DELETE FROM student_info WHERE id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("s", $studentId);
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