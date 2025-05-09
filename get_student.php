<?php
include 'dbconnection.php';

// Get the 'id' from the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM student_info WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        die("No record found for the given ID.");
    }
} else {
    die("No ID provided.");
}
$conn->close();
?>

<!-- Form starts here -->
<form action="update_record.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">

    <label for="Student_ID">Student ID:</label>
    <input type="text" name="Student_ID" value="<?php echo htmlspecialchars($data['Student_ID']); ?>" required>

    <label for="Student_Name">Student Name:</label>
    <input type="text" name="Student_Name" value="<?php echo htmlspecialchars($data['Student_Name']); ?>" required>

    <label for="Department">Department:</label>
    <select name="Department" required>
        <option value="<?php echo htmlspecialchars($data['Department']); ?>">
            <?php echo htmlspecialchars($data['Department']); ?></option>
        <option value="CCS">CCS</option>
        <option value="CAS">CAS</option>
        <option value="CBA">CBA</option>
        <option value="CON">CON</option>
        <option value="COE">COE</option>
        <option value="COED">COED</option>
        <option value="CIHM">CIHM</option>
    </select>

    <label for="Program">Program:</label>
    <input type="text" name="Program" value="<?php echo htmlspecialchars($data['Program']); ?>" required>

    <label for="Violation">Violation:</label>
    <select name="Violation" required>
        <option value="<?php echo htmlspecialchars($data['Violation']); ?>">
            <?php echo htmlspecialchars($data['Violation']); ?></option>
        <!-- Add your violation options here -->
    </select>

    <label for="Offense">Offense:</label>
    <select name="Offense" required>
        <option value="<?php echo htmlspecialchars($data['Offense']); ?>">
            <?php echo htmlspecialchars($data['Offense']); ?></option>
        <option value="Major">Major</option>
        <option value="Minor">Minor</option>
    </select>

    <label for="Status">Status:</label>
    <input type="text" name="Status" value="<?php echo htmlspecialchars($data['Status']); ?>" required>

    <label for="Personnel">Personnel:</label>
    <input type="text" name="Personnel" value="<?php echo htmlspecialchars($data['Personnel']); ?>" required>

    <label for="Sanction">Sanction:</label>
    <input type="text" name="Sanction" value="<?php echo htmlspecialchars($data['Sanction']); ?>">

    <label for="Time">Time:</label>
    <input type="time" name="Time" value="<?php echo htmlspecialchars($data['Time']); ?>" required>

    <label for="Date">Date:</label>
    <input type="date" name="Date" value="<?php echo htmlspecialchars($data['Date']); ?>" required>

    <button type="submit">Update Record</button>
</form>