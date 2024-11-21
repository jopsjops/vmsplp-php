<?php
// Database connection
$servername = "tj5iv8piornf713y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "vl9ieik1ttwerlmd"; // Your DB username
$password = "dxn55zzkhyp5ek1e";     // Your DB password
$dbname = "z6vet51amyrj9ci0"; // Your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Correctly retrieve the student ID from the URL
if (isset($_GET['student_id'])) {
    $studentid = $_GET['student_id'];

    // Fetch the record from the database
    $sql = "SELECT * FROM student_info WHERE Student_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $studentid); // Use 's' for string if Student_ID is a string
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the data
    $data = $result->fetch_assoc();
    $stmt->close();
} else {
    die("No student ID provided.");
}

// If there is no record found, handle it accordingly
if (!$data) {
    die("No record found for the given Student ID.");
}
?>

<style>
    /* General styles for the form */
*{
    font-family: 'Poppins', sans-serif;
}

form {
    width: 100%;
    max-width: 600px; /* Limits the form width on larger screens */
    margin: 50px auto; /* Centers the form */
    padding: 20px;
    background-color: #f7f7f7;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Form title */
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Label styles */
label {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
    color: #555;
}

/* Input and select fields */
input[type="text"], input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

/* Focus state for inputs */
input[type="text"]:focus, input[type="date"]:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
}

select{
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

/* Submit button */
button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4169E1;
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}



/* Adjusting form layout for smaller screens */
@media (max-width: 768px) {
    form {
        padding: 15px;
    }

    button[type="submit"] {
        font-size: 16px;
    }
}

</style>

<!-- HTML Form to Edit the Record -->
<h2>Edit Student Record</h2>
<form action="update_coed.php" method="post">
    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($data['Student_ID']); ?>">

    <label for="Student_Name">Student Name:</label>
    <input type="text" name="Student_Name" value="<?php echo htmlspecialchars($data['Student_Name']); ?>" required>

    <label for="Department">Department:</label>
    <select id ="Department"name="Department" value="" required>
        <option><?php echo htmlspecialchars($data['Department']); ?></option>
    </select>

    <label for="Program">Program:</label>
    <select id="Program"name="Program" value="" required>
        <option><?php echo htmlspecialchars($data['Program']); ?></option>
        <option value="BEED">BEED</option>
        <option value="BSED">BSED</option>
    </select>

    <label for="YrSec">Year & Section:</label>
    <input type="text" name="YrSec" value="<?php echo htmlspecialchars($data['YrSec']); ?>" required>

    <label for="Violation">Violation:</label>
    <input type="text" name="Violation" value="<?php echo htmlspecialchars($data['Violation']); ?>" required>

    <label for="Status">Status:</label>
    <select name="Status" value="" required>
        <option><?php echo htmlspecialchars($data['Status']); ?></option>
        <option value="Warning">Warning</option>
        <option value="1st Offense">1st Offense</option>
        <option value="2nd Offense">2nd Offense</option>
        <option value="3rd Offense">3rd Offense</option>
    </select>

    <label for="Date">Date:</label>
    <input type="date" name="Date" value="<?php echo htmlspecialchars($data['Date']); ?>" required>

    <button type="submit">Update Record</button>
</form>
