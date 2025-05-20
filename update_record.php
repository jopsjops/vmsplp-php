<?php
session_start();
include 'dbconnection.php';

// Get username from session (adjust if session key differs)
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown';

// Get the 'id' from the POST
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
    $studentId = $_POST['Student_ID'];
    $studentName = $_POST['Student_Name'];
    $department = $_POST['Department'];
    $program = $_POST['Program'];
    $violation = $_POST['Violation'];
    $offense = $_POST['Offense'];
    $status = $_POST['Status'];
    $personnel = $_POST['Personnel'];
    $sanction = $_POST['Sanction'];
    $date = $_POST['Date'];
    $time = $_POST['Time']; 

    // Handle image upload
    $sanctionProofPath = '';
    $uploadStatus = '';
    if (isset($_FILES['Sanction_Proof']) && $_FILES['Sanction_Proof']['error'] == 0) {
        $fileTmpPath = $_FILES['Sanction_Proof']['tmp_name'];
        $fileName = $_FILES['Sanction_Proof']['name'];
        $fileSize = $_FILES['Sanction_Proof']['size'];
        $fileType = $_FILES['Sanction_Proof']['type'];

        $newFileName = date('Y-m-d_H-i-s') . '_' . $fileName;
        $uploadFolder = 'sanctionsproof/' . htmlspecialchars($studentName) . '/';
        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }
        $dest_path = $uploadFolder . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $sanctionProofPath = $dest_path;
            $uploadStatus = 'File uploaded successfully!';
        } else {
            $uploadStatus = 'Error uploading the file!';
        }
    } else {
        $uploadStatus = 'No file uploaded or error with file upload!';
    }

    // Optional: Fetch old data before update (to compare changes)
    $oldDataSql = "SELECT * FROM student_info WHERE id = ?";
    $oldStmt = $conn->prepare($oldDataSql);
    $oldStmt->bind_param("i", $id);
    $oldStmt->execute();
    $oldResult = $oldStmt->get_result();
    $oldData = $oldResult->fetch_assoc();
    $oldStmt->close();

    // Update query
    $sql = "UPDATE student_info SET Student_ID=?, Student_Name=?, Department=?, Program=?, Violation=?, Offense=?, Status=?, Personnel=?, Sanction=?, Date=?, Time=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $studentId, $studentName, $department, $program, $violation, $offense, $status, $personnel, $sanction, $date, $time, $id);

    if ($stmt->execute()) {
        // Prepare audit trail message — list changed fields for clarity
        $changes = [];
        if ($oldData['Student_ID'] !== $studentId) $changes[] = "Student_ID: '{$oldData['Student_ID']}' → '$studentId'";
        if ($oldData['Student_Name'] !== $studentName) $changes[] = "Student_Name: '{$oldData['Student_Name']}' → '$studentName'";
        if ($oldData['Department'] !== $department) $changes[] = "Department: '{$oldData['Department']}' → '$department'";
        if ($oldData['Program'] !== $program) $changes[] = "Program: '{$oldData['Program']}' → '$program'";
        if ($oldData['Violation'] !== $violation) $changes[] = "Violation changed";
        if ($oldData['Offense'] !== $offense) $changes[] = "Offense changed";
        if ($oldData['Status'] !== $status) $changes[] = "Status: '{$oldData['Status']}' → '$status'";
        if ($oldData['Personnel'] !== $personnel) $changes[] = "Personnel: '{$oldData['Personnel']}' → '$personnel'";
        if ($oldData['Sanction'] !== $sanction) $changes[] = "Sanction: '{$oldData['Sanction']}' → '$sanction'";
        if ($oldData['Date'] !== $date) $changes[] = "Date: '{$oldData['Date']}' → '$date'";
        if ($oldData['Time'] !== $time) $changes[] = "Time: '{$oldData['Time']}' → '$time'";

        $message = count($changes) > 0 ? "Updated student record Student ID: $studentId. Changes: " . implode(", ", $changes) : "Updated student record ID $id with no changes detected.";

        // Insert audit trail record
        $audit_sql = "INSERT INTO audit_trail (username, action, message, event_type, timestamp) VALUES (?, 'update', ?, 'Student Record Update', NOW())";
        $audit_stmt = $conn->prepare($audit_sql);
        $audit_stmt->bind_param("ss", $username, $message);
        $audit_stmt->execute();
        $audit_stmt->close();

        echo "<script>
                alert('Record updated successfully');
                window.location.href = 'students_page.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating record: " . $stmt->error . ". $uploadStatus');
                window.location.href = 'students_page.php';
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>
            alert('No ID provided.');
            window.location.href = 'students_page.php';
          </script>";
}

$conn->close();
?>
