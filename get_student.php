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
        echo "<script>alert('No record found.'); window.location.href='index.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No ID provided.'); window.location.href='index.php';</script>";
    exit;
}
$conn->close();
?>

<!-- Form starts here -->

<form action="update_record.php" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">

    <label for="Student_ID">Student ID:</label>
    <input type="text" name="Student_ID" value="<?php echo htmlspecialchars($data['Student_ID']); ?>" required>

    <label for="Student_Name">Student Name:</label>
    <input type="text" name="Student_Name" value="<?php echo htmlspecialchars($data['Student_Name']); ?>" required>

    <label for="Department">Department:</label>
    <select id="Department" name="Department" required>
        <option value="CCS" <?php if ($data['Department'] === 'CCS')
            echo 'selected'; ?>>CCS</option>
        <option value="CAS" <?php if ($data['Department'] === 'CAS')
            echo 'selected'; ?>>CAS</option>
        <option value="CBA" <?php if ($data['Department'] === 'CBA')
            echo 'selected'; ?>>CBA</option>
        <option value="CON" <?php if ($data['Department'] === 'CON')
            echo 'selected'; ?>>CON</option>
        <option value="COE" <?php if ($data['Department'] === 'COE')
            echo 'selected'; ?>>COE</option>
        <option value="COED" <?php if ($data['Department'] === 'COED')
            echo 'selected'; ?>>COED</option>
        <option value="CIHM" <?php if ($data['Department'] === 'CIHM')
            echo 'selected'; ?>>CIHM</option>
    </select>

    <label for="Program">Program:</label>
    <input type="text" id="Program" name="Program" value="<?php echo htmlspecialchars($data['Program']) ?>"
        required></input>

    <label for="Violation">Violation:</label>
    <select name="Violation" required>
        <option value="<?php echo htmlspecialchars($data['Violation']); ?>" selected>
            <?php echo htmlspecialchars($data['Violation']); ?>
        </option>
        <!-- Add your violation options here -->
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
        <option value="Major" <?php if ($data['Offense'] === 'Major')
            echo 'selected'; ?>>Major</option>
        <option value="Minor" <?php if ($data['Offense'] === 'Minor')
            echo 'selected'; ?>>Minor</option>
    </select>

    <label for="Status">Status:</label>
    <select name="Status" required>
        <option value="Pending" <?php if ($data['Status'] === 'Pending')
            echo 'selected'; ?>>Pending</option>
        <option value="Settled" <?php if ($data['Status'] === 'Settled')
            echo 'selected'; ?>>Settled</option>
    </select>

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

<script>
    const programSelect = document.getElementById('program');
    const courseSelect = document.getElementById('course');
    const currentCourse = "<?php echo $data['Program']; ?>";

    const programCourses = {
        CCS: ['BSCS', 'BSIT'],
        CAS: ['AB Psych'],
        CBA: ['BSBA', 'BSENT', 'BSA'],
        CON: ['BSN'],
        COE: ['BSECE'],
        COED: ['BEED', 'BSED'],
        CIHM: ['BSHM']
    };

    function populateCourses(program) {
        courseSelect.innerHTML = '';
        const options = programCourses[program] || ['N/A'];
        options.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt;
            option.textContent = opt;
            if (opt === currentCourse) {
                option.selected = true;
            }
            courseSelect.appendChild(option);
        });
    }

    // Populate on page load
    window.addEventListener('DOMContentLoaded', () => {
        populateCourses(programSelect.value);
    });

    // Update courses when department changes
    programSelect.addEventListener('change', () => {
        populateCourses(programSelect.value);
    });
</script>