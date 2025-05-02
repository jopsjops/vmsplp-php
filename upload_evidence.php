<?php
include 'dbconnection.php';

$id = $_POST['student_id'] ?? null;

if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === UPLOAD_ERR_OK && $id) {
    $uploadDir = 'evidence/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $evidenceFileName = time() . '_' . basename($_FILES['evidence']['name']);
    $evidenceFilePath = $uploadDir . $evidenceFileName;

    if (move_uploaded_file($_FILES['evidence']['tmp_name'], $evidenceFilePath)) {
        $stmt = $conn->prepare("UPDATE student_info SET Evidence = ? WHERE id = ?");
        $stmt->bind_param("ss", $evidenceFileName, $id);
        $stmt->execute();
    }
}

$conn->close();
header("Location: students_page.php"); // reloads the page to show the image
exit;
?>
