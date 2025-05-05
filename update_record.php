<?php
include 'dbconnection.php';

// Get the 'id' from the URL
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];
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
    $uploadStatus = ''; // Default value for upload status
    if (isset($_FILES['Sanction_Proof']) && $_FILES['Sanction_Proof']['error'] == 0) {
        $fileTmpPath = $_FILES['Sanction_Proof']['tmp_name'];
        $fileName = $_FILES['Sanction_Proof']['name'];
        $fileSize = $_FILES['Sanction_Proof']['size'];
        $fileType = $_FILES['Sanction_Proof']['type'];

        // Generate unique file name based on date and time
        $newFileName = date('Y-m-d_H-i-s') . '_' . $fileName;
        
        // Define the folder path to store the images
        $uploadFolder = 'sanctionsproof/' . htmlspecialchars($studentName) . '/';
        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777, true); // Create directory if it doesn't exist
        }

        // Define the full path to store the file
        $dest_path = $uploadFolder . $newFileName;

        // Move the uploaded file to the destination folder
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $sanctionProofPath = $dest_path; // Store the file path
            $uploadStatus = 'File uploaded successfully!';
        } else {
            $uploadStatus = 'Error uploading the file!';
        }
    } else {
        $uploadStatus = 'No file uploaded or error with file upload!';
    }

    // Update query using the unique id to target the exact record
    $sql = "UPDATE student_info SET Student_Name=?, Department=?, Program=?, Violation=?, Offense=?, Status=?, Personnel=?, Sanction=?, Date=?, Time=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $studentName, $department, $program, $violation, $offense, $status, $personnel, $sanction, $date, $time, $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Record updated successfully. $uploadStatus');
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
