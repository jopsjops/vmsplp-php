<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/plp.png">
    <title>Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /*topbar*/
        .topbar {
            position: fixed;
            background: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.08);
            width: 100%;
            height: 60px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 10fr 0.4fr 1fr;
            align-items: center;
            z-index: 1;
        }

        .logo h2 {
            color: #950c00;
        }

        .search {
            position: relative;
            width: 60%;
            justify-self: center;
        }

        .search input {
            width: 100%;
            height: 40px;
            padding: 0 40px;
            font-size: 16px;
            outline: none;
            border: none;
            border-radius: 10px;
            background: #f5f5f5;
        }

        .search i {
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
        }

        .logo a {
            color: #950c00;
            font-size: 24px;
            text-decoration: none;
            font-weight: bold;
        }

        .user {
            position: relative;
            width: 50px;
            height: 50px;
            left: 49px;
        }

        .user img {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .user {
            position: relative;
            width: 50px;
            height: 50px;
        }

        .user:hover {
            cursor: pointer;
        }

        .dropdown-content {
            transform: translateY(55px);
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-content ul {
            display: flex;
            flex-direction: column;
        }

        /*sidebar*/
        .sidebar {
            position: fixed;
            top: 60px;
            width: 60px;
            height: calc(100% - 60px);
            background: #950c00;
            overflow-x: hidden;
            overflow-y: auto;
            transition: width 0.3s;
            white-space: nowrap;
            z-index: 1;
        }

        .sidebar:hover {
            width: 260px;
        }

        .sidebar ul {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar ul li {
            width: 100%;
            list-style: none;
            margin: 5px;
        }

        .sidebar ul li a {
            width: 100%;
            text-decoration: none;
            color: #fff;
            height: 60px;
            display: flex;
            align-items: center;
            transition: color 0.2s, background-color 0.2s;
            border-radius: 10px 0 0 10px;
        }

        .sidebar ul li a i {
            min-width: 60px;
            font-size: 24px;
            text-align: center;
        }

        .sidebar ul li.stud a {
            color: #950c00;
            background: #fff;
        }

        .sidebar ul li a:hover {
            color: #950c00;
            background: #fff;
        }

        .sidebar ul li span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar:hover .sidebar-item-text {
            opacity: 1;
        }

        .main {
            margin-left: 60px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .sidebar:hover+.main {
            margin-left: 260px;
        }

        /*main content*/
        .main h1 {
            margin-top: 70px;
            margin-bottom: 20px;
            color: #950c00;
        }

        .main-content {
            display: flex;
            flex-wrap: wrap;
        }

        .main-content .table-container {
            flex: 2;
            display: flex;
            flex-direction: column;
        }

        .main-content #charts {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding-left: 30px;
            padding-top: 30px;
            padding-top: 30px;
            padding-bottom: 30px;
            margin-left: 20px;
            margin-right: 10px;
            border-radius: 10px 10px 0 0;
            background-color: transparent;
            outline: #950c00;
            outline-style: auto;
        }

        #charts div {
            min-width: 250px;
            max-width: 400px;
            border-radius: 8px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #charts h2 {
            font-size: 18px;
            color: #950c00;
            margin-bottom: 10px;
        }

        #charts canvas {
            width: 100% !important;
            height: 200px;
        }

        table {
            border-radius: 5px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #950c00;
            color: #fff;
            margin: 0;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            opacity: 0.9;
        }

        button.edit {
            color: #950c00;
            background-color: transparent;
        }

        button.archive {
            color: #950c00;
            background-color: transparent;
        }


        button.add {
            width: 50px;
            /* Set the width of the circle */
            height: 50px;
            /* Set the height to be the same as the width */
            border-radius: 50%;
            /* This makes the button round */
            background-color: #950c00;
            /* Background color of the button */
            color: white;
            /* Icon color */
            border: none;
            /* Remove border */
            display: flex;
            /* Center icon inside the button */
            justify-content: center;
            /* Horizontally center the icon */
            align-items: center;
            /* Vertically center the icon */
            cursor: pointer;
            /* Add a pointer on hover */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Add a subtle shadow */
            align-self: flex-end;
        }

        #addModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            /* Prevents scrolling inside the modal */
            background-color: rgba(0, 0, 0, 0.4);
        }

        #modalContent {
            background-color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Centers the modal content */
            padding: 20px;
            border: 1px solid #ddd;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input,
        form select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        form button {
            color: #fff;
            background-color: #950c00;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <a href="dashboarddb.php">SSO.</a>
            </div>
            <div class="search">
                <input type="text" id="search" placeholder="Search by Student Number">
            </div>

            <div class="user">
                <img src="img/plp.png" alt="Profile Image" id="profileImage">
                <div class="dropdown-content" id="dropdownContent">
                <a href="admin_changepass.php" id="changePasswordButton"><i class='bx bx-lock'></i> Change Password</a>
                    <a href="index.php" id="logoutButton"><i class='bx bx-log-out'></i> Log Out</a>
                </div>
            </div>
        </div>
        <div class="sidebar">
            <ul>
                <li class="dash">
                    <a href="dashboarddb.php">
                        <i class='bx bxs-dashboard'></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="stud">
                    <a href="students_page.php">
                        <i class='bx bxs-group'></i>
                        <div>Student</div>
                    </a>
                </li>
                <li class="pred">
                    <a href="prediction.php">
                        <i class='fas fa-chart-line'></i>
                        <div>Prediction</div>
                    </a>
                </li>
                <li class="archive">
                    <a href="archive.php">
                        <i class='bx bxs-archive'></i>
                        <div>Archive</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <h1>STUDENT VIOLATION RECORDS (CIHM) </h1>
            <div class="main-content">
                <div class="table-container">
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

                    // Fetch data from the database
                    $sql = "SELECT * FROM student_info WHERE Department = 'CIHM'";
                    $result = $conn->query($sql);

                    ?>
                    <table id="violationTable">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Program</th>
                                <th>Violation</th>
                                <th>Offense</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through the results and display them in the table
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Determine the background color based on the status value
                                    $statusColor = '';
                                    switch ($row['Status']) {
                                        case 'Warning':
                                            $statusColor = 'background-color: #FCEFB4;'; // Warning
                                            break;
                                        case '1st Offense':
                                            $statusColor = 'background-color: #FFB480;'; // 1st Offense
                                            break;
                                        case '2nd Offense':
                                            $statusColor = 'background-color: #FF6961;'; // 2nd Offense
                                            break;
                                        case '3rd Offense':
                                            $statusColor = 'background-color: #CECECD;'; // No Violation
                                            break;
                                        default:
                                            $statusColor = 'background-color: gray;'; // Default color for any other status
                                            break;
                                    }

                                    // Output the row with htmlspecialchars and styled status cell
                                    echo "<tr>
                                    <td>" . htmlspecialchars($row['Student_ID']) . "</td>
                                    <td>" . htmlspecialchars($row['Student_Name']) . "</td>
                                    <td>" . htmlspecialchars($row['Department']) . "</td>
                                    <td>" . htmlspecialchars($row['Program']) . "</td>
                                    <td>" . htmlspecialchars($row['Violation']) . "</td>
                                    <td>" . htmlspecialchars($row['Offense']) . "</td>
                                    <td style='{$statusColor}'>" . htmlspecialchars($row['Status']) . "</td>
                                    <td>" . htmlspecialchars($row['Date']) . "</td>
                                    <td>
                                        <button class='edit' onclick='editRow(\"" . htmlspecialchars($row['id']) . "\")'>
                                            <i class='fas fa-pencil-alt'></i>
                                        </button>
                                        <button class='archive' onclick='transferRow(\"" . htmlspecialchars($row['id']) . "\")'>
                                            <i class='fa-solid fa-folder-plus'></i>
                                        </button>
                                    </td>
                                </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No records found</td></tr>";
                            }

                            ?>
                            <tr id="noRecords" style="display:none;">
                                <td colspan="9" style="text-align:center;">No records found</td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="add" id="addButton"
                        onclick="document.getElementById('addModal').style.display='block'">
                        <i class='bx bxs-add-to-queue'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="addModal">
    <div id="modalContent">
        <span class="close" onclick="document.getElementById('addModal').style.display='none'">&times;</span>
        <form id="addForm" action="add_cihm.php" method="post">
            <label for="studentId">Student ID:</label>
            <input type="text" id="studentId" name="studentId" required>

            <label for="name">Student Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="program">Department:</label>
            <select id="program" name="program" required>
                <option value="CCS">CCS</option>
                <option value="CAS">CAS</option>
                <option value="CBA">CBA</option>
                <option value="CON">CON</option>
                <option value="COE">COE</option>
                <option value="COED">COED</option>
                <option value="CIHM">CIHM</option>
            </select>

            <label for="course">Program</label>
            <select id="course" name="course" required>
                <option value="BEED">BEED</option>
                <option value="BSED">BSED</option>
                <option value="BSA">BSA</option>
                <option value="BSBA">BSBA</option>
                <option value="BSENT">BSENT</option>
                <option value="BSHM">BSHM</option>
                <option value="BSCS">BSCS</option>
                <option value="BSIT">BSIT</option>
                <option value="BSECE">BSECE</option>
                <option value="BSN">BSN</option>
            </select>



            <label for="violation">Violation:</label>
            <select id="violation" name="violation" required>
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

            <label for="offense">Offense:</label>
            <select id="offense" name="offense" required>
                <option value="">Select Offense</option>
                <option value="Major">Major</option>
                <option value="Minor">Minor</option>
            </select>

            <label for="status">Status</label>
            <input type="text" id="status" name="status" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</div>

    <script>
        function editRow(id) {
            // Confirm if the user wants to edit the specific student record
            const userConfirmed = confirm("Do you want to edit the data for this record?");

            // If confirmed, redirect to the edit page with the specific ID
            if (userConfirmed) {
                const url = 'edit_record.php?id=' + id;
                window.location.href = url;
            }
        }

        function transferRow(id) {
    const userConfirmed = confirm("Are you sure you want to archive this student with ID: " + id + "?");

    if (userConfirmed) {
        fetch('transfer_student.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);  // Alert the user for successful archival
                window.location.reload();  // Reload the page to reflect changes
            } else {
                alert("Error: " + data.message);  // Show error if there is any
            }
        })
        .catch(error => console.error("Error:", error));  // Catch any potential errors
    }
}


    document.getElementById("profileImage").onclick = function() {
        var dropdown = document.getElementById("dropdownContent");
        dropdown.style.display = (dropdown.style.display === "none" || dropdown.style.display === "") ? "block" : "none";
    }

    window.onclick = function(event) {
        if (!event.target.matches('#profileImage')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                }
            }
        }
    }

    document.getElementById("logoutButton").onclick = function(event) {
        var confirmLogout = confirm("Are you sure you want to log out?");
        if (!confirmLogout) {
            event.preventDefault();
        }
    };

     // Attach an event listener to the search input
     document.getElementById("search").addEventListener("input", function () {
        const searchValue = this.value.toLowerCase(); // Convert input to lowercase for case-insensitive search
        const rows = document.querySelectorAll("#violationTable tbody tr"); // Select all table rows

        rows.forEach(row => {
            const studentId = row.querySelector("td:nth-child(1)").textContent.toLowerCase(); // Get the Student ID column
            if (studentId.includes(searchValue)) {
                row.style.display = ""; // Show the row if it matches
            } else {
                row.style.display = "none"; // Hide the row if it doesn't match
            }
        });
    });
    </script>
</body>
</html>
