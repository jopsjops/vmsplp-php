<?php
ob_clean();
include 'dbconnection.php';

$id = $_POST['student_id'] ?? null;
$accomplished = $_POST['date_accomplished'] ?? null;

$proofFileName = null;

// Debugging: Show file upload details
if (isset($_FILES['proof'])) {
    echo '<pre>';
    print_r($_FILES['proof']);
    echo '</pre>';

    if ($_FILES['proof']['error'] !== UPLOAD_ERR_OK) {
        echo "Upload Error: " . $_FILES['proof']['error'];
        exit;
    }
}

if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'proof/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $proofFileName = time() . '_' . basename($_FILES['proof']['name']);
    $proofFilePath = $uploadDir . $proofFileName;

    if (!move_uploaded_file($_FILES['proof']['tmp_name'], $proofFilePath)) {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file uploaded or file upload error.']);
    exit;
}

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

            $insertQuery = "INSERT INTO archive_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Sanction, Personnel, Accomplished, Sanction_Proof)
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
                $deleteQuery = "DELETE FROM student_info WHERE id = ?";
                $deleteStmt = $conn->prepare($deleteQuery);
                $deleteStmt->bind_param("s", $id);
                $deleteStmt->execute();

                $conn->commit();

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
