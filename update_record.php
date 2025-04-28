<?php
include 'dbconnection.php';

// Check if id and other details are posted
if (isset($_POST['id']) && isset($_POST['Student_Name']) && isset($_POST['Department']) && isset($_POST['Program']) && isset($_POST['Violation']) && isset($_POST['Offense']) && isset($_POST['Status']) && isset($_POST['Date'])) {
    $id = $_POST['id'];
    $studentName = $_POST['Student_Name'];
    $department = $_POST['Department'];
    $program = $_POST['Program'];
    $violation = $_POST['Violation'];
    $offense = $_POST['Offense'];
    $status = $_POST['Status'];
    $date = $_POST['Date'];

    // Update query using the unique id to target the exact record
    $sql = "UPDATE student_info SET Student_Name=?, Department=?, Program=?, Violation=?, Offense=?, Status=?, Date=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $studentName, $department, $program, $violation, $offense, $status, $date, $id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Record updated successfully');
                window.location.href = 'students_page.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating record: " . $stmt->error . "');
                window.location.href = 'students_page.php';
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>
            alert('Incomplete data provided for update.');
            window.location.href = 'students_page.php';
          </script>";
}

$conn->close();
?>