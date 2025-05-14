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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

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
            color: #059212;
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
            color: #059212;
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
         /* Sidebar */
         .sidebar {
            position: fixed;
            top: 60px;
            width: 200px;
            height: calc(100% - 60px);
            background: #fff;
            overflow-x: hidden;
            overflow-y: auto;
            white-space: nowrap;
            z-index: 1;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar list */
        .sidebar ul {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar list items */
        .sidebar ul li {
            width: 100%;
            list-style: none;
            margin: 5px;
            position: relative;
        }

        /* Sidebar icons */
        .sidebar ul li a i {
            min-width: 60px;
            font-size: 24px;
            text-align: center;
        }

        /* Sidebar links */
        .sidebar ul li a {
            width: 100%;
            text-decoration: none;
            color: #333; /* Always dark font */
            height: 60px;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
            border-radius: 10px 0 0 10px;
            padding-left: 10px;
        }

        .sidebar ul li a::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10px;
            width: 5px;
            height: 40px;
            background-color: #059212;
            border-radius: 5px;
            opacity: 0;
            transform: scaleY(0);
            transition: all 0.3s ease;
        }

                /* Hover effect */
        .sidebar ul li a:hover::before {
            opacity: 1;
            transform: scaleY(1);
        }

        /* ✅ Active tab: Only shows a green side bar */
        .sidebar ul li.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10px;
            width: 5px;
            height: 40px;
            background-color: #059212;
            border-radius: 5px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }

        .profile-logo img {
            width: 45px;
            height: 45px;
            border-radius: 50%; /* Makes the logo circular */
            object-fit: cover;
        }

        .profile-info span {
            font-size: 12px;
            color: #777;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }


        .logout {
            position: absolute;  /* Use absolute to anchor within the sidebar */
            bottom: 70px;         /* Same visual offset as translateY(70px) */
            width: 100%;          /* Optional: full width of sidebar */
            text-align: center;
            padding: 10px;
        }

        .logout a {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
        }

        .logout i {
            margin-right: 8px;
        }

        /*main content*/
        .main {
            position: absolute;
            width: calc(100% - 260px);
            min-height: calc(100vh - 60px);
            margin-left: 200px;
            padding: 20px;
            transition: margin-left 0.3s, width 0.3s; /* Smooth transition */
            display: flex;
            gap: 20px;
            flex-wrap: wrap; /* Allow content to wrap on smaller screens */
        }

        .main h1 {
            margin-top: 70px;
            margin-bottom: 20px;
            color: #059212;
        }

        .main-content {
            display: flex;
            flex-wrap: wrap;
        }

        .main-content .table-container {
            position: absolute; /* Make the table fixed in place */
            top: 110px; /* Adjust top position to ensure it's below the top bar */
            left: 20px;
            right: 0;
            width: 100%; /* Ensure the table takes the full width */
            border-collapse: collapse;
            margin-top: 20px; /* Adjust top margin if needed */
            background-color: #fff; /* White background for the table */
            border-radius: 5px;
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
            outline: #059212;
            outline-style: auto;
        }

        

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff; /* White background for the table */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            border-radius: 5px;
        }

        table,
        th,
        td {
            border: 1px solid #e0e0e0; /* Light gray border for a minimalistic look */
        }

        th,
        td {
            padding: 10px 15px; /* Reduced padding for a clean look */
            text-align: center; /* Left align the text for a modern style */
            font-size: 15px; /* Slightly smaller text for minimalism */
        }

        th {
            background-color: #f7f7f7; /* Light gray background for table headers */
            color: #333; /* Dark text color for readability */
            font-weight: bold; /* Make headers bold */
            text-transform: uppercase; /* All caps for headers for a minimalistic feel */
        }

        tr:nth-child(even) {
            background-color: #fafafa; /* Very light gray background for even rows */
        }

        tr:hover {
            background-color: #f1f1f1; /* Slight hover effect for rows */
        }

        td {
            color: #333; /* Dark text color for the data */
        }

        button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            color: #333;
            background-color: transparent;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #f1f1f1; /* Hover effect for buttons */
            opacity: 0.9;
        }

        button.edit {
            color: #333;
            background-color: transparent;
        }

        button.archive {
            color: #333;
            background-color: transparent;
        }


        button.add {
            width: 50px;              /* Set the width of the circle */
            height: 50px;             /* Set the height to be the same as the width */
            border-radius: 50%;       /* This makes the button round */
            background-color: #333; /* Background color of the button */
            color: white;             /* Icon color */
            border: none;             /* Remove border */
            display: flex;            /* Center icon inside the button */
            justify-content: center;  /* Horizontally center the icon */
            align-items: center;      /* Vertically center the icon */
            cursor: pointer;          /* Add a pointer on hover */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            position: fixed;          /* Make the button fixed to the viewport */
            bottom: 20px;             /* Distance from the bottom of the viewport */
            right: 20px;              /* Distance from the right of the viewport */
            z-index: 1000;            /* Ensure it stays on top of other elements */
        }

        button.print-pdf {
            width: 50px;              /* Set the width of the circle */
            height: 50px;             /* Set the height to be the same as the width */
            border-radius: 50%;       /* This makes the button round */
            background-color: #333; /* Background color of the button */
            color: white;             /* Icon color */
            border: none;             /* Remove border */
            display: flex;            /* Center icon inside the button */
            justify-content: center;  /* Horizontally center the icon */
            align-items: center;      /* Vertically center the icon */
            cursor: pointer;          /* Add a pointer on hover */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            position: fixed;          /* Make the button fixed to the viewport */
            bottom: 90px;             /* Distance from the bottom of the viewport */
            right: 20px;              /* Distance from the right of the viewport */
            z-index: 1000;            /* Ensure it stays on top of other elements */
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
            background-color: #059212;
            width: 100%;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 500px;
        }

        .move-btn {
            background: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        .cancel-btn {
            margin-top: 5px;
            padding: 10px;
            background:rgb(122, 122, 122);
            border: none;
            cursor: pointer;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <h2>VMS.</h2>
            </div>
            <div class="search">
                <input type="text" id="search" placeholder="Search">
            </div>
        </div>
        <div class="sidebar">
            <div class="profile">
                <div class="profile-logo">
                    <img src="img/plp.png" alt="Logo">
                </div>
                <div class="profile-info">
                    <span>Welcome,</span>
                    <h4>Admin</h4>
                </div>
            </div>
            <ul>
                <li>
                    <a href="dashboarddb.php">
                        <i class='bx bxs-dashboard'></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="students_page.php">
                        <i class='bx bxs-group'></i>
                        <div>Students</div>
                    </a>
                </li>
                <li>
                    <a href="prediction.php">
                        <i class='fas fa-chart-line'></i>
                        <div>Data Analysis</div>
                    </a>
                </li>
                <li class="active">
                    <a href="archive.php">
                        <i class='bx bxs-archive'></i>
                        <div>Archive</div>
                    </a>
                </li>
                <li class="tables">
                    <a href="view_semviolation.php">
                        <i class='bx bx-table'></i>
                        <div>View Tables</div>
                    </a>
                </li>
                <li>
                    <a href="reference_page.php">
                        <i class='bx bx-book-open'></i>
                        <div>Reference</div>
                    </a>
                </li>
            </ul>
            <div class="logout">
                <a href="logout.php" onclick="return confirmLogout()">
                    <i class='bx bx-log-out'></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        <div class="main">
            <h1>STUDENT VIOLATION ARCHIVES</h1>
            <div class="main-content">
                <div class="table-container">
                    <?php
                    // Database connection
                    include 'dbconnection.php';

                    // Fetch data from the database
                    $sql = "SELECT id, Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Personnel, Accomplished, Sanction, Proof
                             FROM archive_info ORDER BY Accomplished DESC";

                    $result = $conn->query($sql);
                    ?>
                    <table id="violationTable">
                        <thead>
                        <tr>    
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Department & Program</th>
                                <th>Violation</th>
                                <th>Offense & Status</th>
                                <th>Personnel</th>
                                <th>Date Accomplished</th>
                                <th>Sanction</th>
                                <th>Proof</th>
                                <th>Actions</th>               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $sanctionText = "";
                                    echo "<tr>
                                        <td>" . htmlspecialchars($row['Student_ID']) . "</td>
                                        <td>" . htmlspecialchars($row['Student_Name']) . "</td>
                                        <td>" . htmlspecialchars($row['Department']) . " - " . htmlspecialchars($row['Program']) . "</td>
                                        <td>" . htmlspecialchars($row['Violation']) . "</td>
                                        <td>" . htmlspecialchars($row['Offense']) . " - " . htmlspecialchars($row['Status']) . "</td>
                                        <td>" . htmlspecialchars($row['Personnel']) . "</td>
                                        <td>" . htmlspecialchars($row['Accomplished']) . "</td>

                                        <td>" . htmlspecialchars($row['Sanction']) . "</td>
                                        <td><img src='proof/" . htmlspecialchars($row['Proof']) . "' alt='Proof Image' width='80' height='80'></td>
                                        <td>
                                            <button class='edit' onclick='editRow(" . $row['id'] . ")'>
                                                <i class='fas fa-pencil-alt'></i>
                                            </button>
                                            <button class='archive' onclick='transferRow(" . $row['id'] . ")'>
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

                    <button id="printPdfButton" class="print-pdf" onclick="printTableToPDF()">
                        <i class='bx bx-printer'></i>
                    </button>
                    <button class="add" id="addButton" onclick="document.getElementById('moveDataModal').style.display='flex'">
                        <i class='bx bxs-data'></i> 
                    </button>

                </div>
            </div>
        </div>
    </div>

    <div id="moveDataModal" class="modal">
    <div class="modal-content">
        <h3>Move Data to Semester</h3>
        <form action="move_data.php" method="POST">
            <label for="newTableName">Enter Semester Table Name:</label><br>
            <input type="text" name="newTableName" id="newTableName" required><br><br>
            <button type="submit" class="move-btn">Move</button>
            <button type="button" class="cancel-btn" onclick="document.getElementById('moveDataModal').style.display='none'">Cancel</button>
        </form>
    </div>
</div>


    <div id="addModal">
    <div id="modalContent">
        <span class="close" onclick="document.getElementById('addModal').style.display='none'">&times;</span>
        <form id="addForm" action="add_record.php" method="post">
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


    function confirmLogout() {
        return confirm("Are you sure you want to log out?");
    }


     // Your search script
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search"); // The search input
            const rows = document.querySelectorAll("#violationTable tbody tr"); // All rows in the table
            const noRecords = document.getElementById("noRecords"); // "No records found" row (hidden by default)

            // Listen for input in the search field
            searchInput.addEventListener("input", function () {
                const searchValue = this.value.toLowerCase(); // Get the input and make it lowercase
                let found = false; // To check if any row matches

                // Loop through each row in the table
                rows.forEach(row => {
                    const rowText = row.innerText.toLowerCase(); // Get the row's text content and make it lowercase
                    if (rowText.includes(searchValue)) {
                        row.style.display = ""; // If it matches, show the row
                        found = true;
                    } else {
                        row.style.display = "none"; // If it doesn't match, hide the row
                    }
                });

                // Handle "No records found" row
                if (searchValue && !found) {
                    noRecords.style.display = ""; // Show if no results are found
                } else {
                    noRecords.style.display = "none"; // Hide it when there are matches
                }
            });
        });


    function printTableToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add a custom header
    doc.setFontSize(12); // Set smaller font size for the header
    doc.text("Student Violation Records (Active)", 105, 10, { align: "center" }); // Centered text at the top
    doc.setFontSize(8); // Set smaller font size for the date
    doc.text("Generated on: " + new Date().toLocaleDateString(), 105, 16, { align: "center" }); // Centered date below the main header

    // Add a margin for the header
    const marginTop = 20;

    // Select the table
    const table = document.getElementById("violationTable");

    // Extract headers (excluding the Actions column)
    const headers = Array.from(table.querySelectorAll("thead th"))
        .map(th => th.textContent.trim())
        .filter((_, index) => index !== table.querySelectorAll("thead th").length - 1); // Exclude "Actions"

    // Extract rows (excluding the Actions column)
    const rows = Array.from(table.querySelectorAll("tbody tr")).map(row =>
        Array.from(row.querySelectorAll("td"))
            .map(td => td.textContent.trim())
            .filter((_, index) => index !== row.querySelectorAll("td").length - 1) // Exclude "Actions"
    );

    // Generate the PDF with 30 rows per page
    doc.autoTable({
        head: [headers],
        body: rows,
        styles: { fontSize: 8, cellPadding: 2 }, // Smaller font and adjusted padding for readability
        margin: { top: marginTop, left: 10, right: 10 }, // Adjust margins
        pageBreak: 'auto', // Automatically paginate
        showHead: 'everyPage', // Show table headers on every page
        theme: 'grid', // Simple grid theme for readability
    });

    // Save the PDF
    doc.save("Student_Violation_Records.pdf");
}

    </script>
</body>
</html>
