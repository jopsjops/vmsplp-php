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

<style>
    * {
        font-family: 'Poppins', sans-serif;
    }

    form {
        width: 100%;
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #f7f7f7;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 16px;
        margin-bottom: 5px;
        color: #555;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="time"]:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    button[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #059212;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    @media (max-width: 768px) {
        form {
            padding: 15px;
        }

        button[type="submit"] {
            font-size: 16px;
        }
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
        margin-left: 10px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 25px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 19px;
        width: 19px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #059212;
    }

    input:checked + .slider:before {
        transform: translateX(25px);
    }
</style>

<h2>Edit Student Record</h2>
<form action="update_record.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" id="studentIdInput" value="<?php echo htmlspecialchars($data['id']); ?>">

    <label for="Student_ID">Student ID:</label>
    <input type="text" name="Student_ID" value="<?php echo htmlspecialchars($data['Student_ID']); ?>" required>

    <label for="Student_Name">Student Name:</label>
    <input type="text" name="Student_Name" value="<?php echo htmlspecialchars($data['Student_Name']); ?>" required>

    <label for="Department">Department:</label>
    <select id="Department" name="Department" required>
        <option><?php echo htmlspecialchars($data['Department']); ?></option>
        <option value="CCS">CCS</option>
        <option value="CAS">CAS</option>
        <option value="CBA">CBA</option>
        <option value="CON">CON</option>
        <option value="COE">COE</option>
        <option value="COED">COED</option>
        <option value="CIHM">CIHM</option>
    </select>

    <label for="Program">Program:</label>
    <select id="Program" name="Program" required>
        <option><?php echo htmlspecialchars($data['Program']); ?></option>
    </select>

    <label for="Violation">Violation:</label>
    <select name="Violation" required>
        <option value="<?php echo htmlspecialchars($data['Violation']); ?>"><?php echo htmlspecialchars($data['Violation']); ?></option>
        <optgroup label="Major Offense Violations">
            <option value="Cheating">Cheating</option>
            <option value="Forgery & Plagiarism">Forgery & Plagiarism</option>
            <option value="False Representation">False Representation</option>
            <option value="Defamation">Defamation</option>
            <option value="Substance Influence">Substance Influence</option>
            <option value="Unauthorized Entry">Unauthorized Entry</option>
            <option value="Theft">Theft</option>
            <option value="Drug Possession/Use">Drug Possession/Use</option>
            <option value="Insubordination">Insubordination</option>
            <option value="Physical Injury">Physical Injury</option>
            <option value="Threats & Bullying">Threats & Bullying</option>
            <option value="Gambling">Gambling</option>
            <option value="Hazing">Hazing</option>
            <option value="Unauthorized Name Use">Unauthorized Name Use</option>
            <option value="Financial Misconduct">Financial Misconduct</option>
            <option value="Unauthorized Sales">Unauthorized Sales</option>
            <option value="Extortion">Extortion</option>
            <option value="Vandalism">Vandalism</option>
            <option value="Degrading Treatment">Degrading Treatment</option>
            <option value="Deadly Weapons">Deadly Weapons</option>
            <option value="Abusive Behavior">Abusive Behavior</option>
        </optgroup>
        <optgroup label="Minor Offense Violations">
            <option value="Policy Violation">Policy Violation</option>
            <option value="Violating dress protocol">Violating dress protocol</option>
            <option value="Incomplete uniform">Incomplete uniform</option>
            <option value="Littering">Littering</option>
            <option value="Loitering in hallways">Loitering in hallways</option>
            <option value="Class disturbance">Class disturbance</option>
            <option value="Shouting">Shouting</option>
            <option value="Eating in class">Eating in class</option>
            <option value="Public affection">Public affection</option>
            <option value="Kissing">Kissing</option>
            <option value="Suggestive poses">Suggestive poses</option>
            <option value="Inappropriate touching">Inappropriate touching</option>
            <option value="No ID card">No ID card</option>
            <option value="Using others' ID">Using others' ID</option>
            <option value="Caps indoors">Caps indoors</option>
            <option value="Noise in quiet areas">Noise in quiet areas</option>
            <option value="Discourtesy">Discourtesy</option>
            <option value="Malicious calls">Malicious calls</option>
            <option value="Refusing ID check">Refusing ID check</option>
            <option value="Blocking passageways">Blocking passageways</option>
            <option value="Unauthorized charging">Unauthorized charging</option>
            <option value="Academic non-compliance">Academic non-compliance</option>
        </optgroup>
    </select>

    <label for="Offense">Offense:</label>
    <select name="Offense" required>
        <option><?php echo htmlspecialchars($data['Offense']); ?></option>
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

