<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/plp.png">
    <title>VMS. (CON)</title>
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
            color: rgba(180, 70, 150, 1);
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
            background-color: rgba(180, 70, 150, 1);
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
            background-color: rgba(180, 70, 150, 1);
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
            border-radius: ; /* Makes the logo circular */
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
            position: absolute;   /* Needed to use 'bottom' positioning */
            bottom: 70px;        /* Replaces translateY(330px) */
            padding: 10px;
            text-align: center;
            width: 100%;   
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
            color: rgba(180, 70, 150, 1);
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
            outline: #059212;
            outline-style: auto;
        }

        
        table {
            position: absolute; /* Make the table fixed in place */
            top: 110px; /* Adjust top position to ensure it's below the top bar */
            left: 20px;
            right: 0;
            width: 100%; /* Ensure the table takes the full width */
            border-collapse: collapse;
            margin-top: 20px; /* Adjust top margin if needed */
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
            bottom: 20px;             /* Distance from the bottom of the viewport */
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

        .sorting-section {
        display: flex;
        align-items: center;
        margin-left: 15px; /* slight space from the search bar */
        font-size: 14px;
        }

        .sorting-section label {
            margin-right: 5px;
            font-weight: bold;
            color: #333;
        }

        .sorting-section select {
            padding: 5px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
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
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .status-text {
            margin-top: 5px;
            font-size: 0.9em;
        }

        .modal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.4);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 320px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        .highlighted {
    background-color:rgb(142, 255, 181) !important; /* Light green */
    transition: background-color 0.3s ease;
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
            
            <div class="sorting-section">
            <label for="sortDropdown" title="Sort By">
                <i class="fa-solid fa-list"></i>
            </label>
                <select id="sortDropdown">
                    <option value="">Select Type</option>
                    <option value="name">Name (Alphabetical)</option>
                    <option value="date">Date</option>
                    <option value="violation">Violation</option>
                </select>
            </div>
    </div>
        </div>
        <div class="sidebar">
            <div class="profile">
                <div class="profile-logo">
                    <img src="img/new_con.png" alt="Logo">
                </div>
                <div class="profile-info">
                    <span>Welcome,</span>
                    <h4>CON Dean</h4>
                </div>
            </div>
            <ul>
                <li class="active">
                    <a href="con_dean.php">
                        <i class='bx bxs-group'></i>
                        <div>Students</div>
                    </a>
                </li>
                <li class="archive">
                    <a href="archive_con.php">
                        <i class='bx bxs-archive'></i>
                        <div>Archive</div>
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
            <h1>STUDENT VIOLATION RECORDS</h1>
            <div class="main-content">
                <div class="table-container">
                    <?php
                    // Database connection
                    include 'dbconnection.php';

                    // Fetch data from the database
                    $sql = "SELECT id, Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Personnel, Date, Time, Sanction
                             FROM student_info WHERE Department = 'CON' ORDER BY Date DESC";

                    $result = $conn->query($sql);
                    ?>
                    <table id="violationTable">
                        <thead>
                            <tr>    
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Program</th>
                                <th>Violation</th>
                                <th>Offense & Status</th>
                                <th>Personnel</th>
                                <th>Date & Time</th>
                                <th>Sanction</th>
                                
                                                  
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr id="row-<?php echo $row['id']; ?>">
                                    <td><?php echo htmlspecialchars($row['Student_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Student_Name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Program']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Violation']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($row['Offense']) . ' - ' . htmlspecialchars($row['Status']); ?>
                                    </td>

                                    <td><?php echo htmlspecialchars($row['Personnel']); ?></td>
                                    <td>
                                        <?php
                                            $timestamp = strtotime($row['Date'] . ' ' . $row['Time']);
                                            echo htmlspecialchars(date('m/d/Y', $timestamp)) . '<br>' . htmlspecialchars(date('h:i A', $timestamp));
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['Sanction']); ?></td>
                                    
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='11' style='text-align:center;'>No records found</td></tr>";
                        }
                        ?>
                            <tr id="noRecords" style="display:none;">
                                <td colspan="11" style="text-align:center;">No records found</td>
                            </tr>
                        </tbody>
                    </table>

                    <button id="printPdfButton" class="print-pdf" onclick="printTableToPDF()">
                        <i class='bx bx-printer'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    doc.save("Student_Violation_Records(CON).pdf");
}

    document.addEventListener("DOMContentLoaded", function () {
    const sortDropdown = document.getElementById("sortDropdown");
    const table = document.getElementById("violationTable");

    sortDropdown.addEventListener("change", function () {
        const sortType = this.value;

        // Match dropdown value to table column index
        let columnIndex;
        switch (sortType) {
            case "department":
                columnIndex = 2;
                break;
            case "name":
                columnIndex = 1;
                break;
            case "violation":
                columnIndex = 4;
                break;
            case "date":
                columnIndex = 8;
                break;
            default:
                return; // Do nothing if no valid option is selected
        }

        const tbody = table.querySelector("tbody");
        
        // Always get FRESH visible rows
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const visibleRows = rows.filter(row => row.style.display !== "none");

        // Sort visible rows
        visibleRows.sort((a, b) => {
            const aText = a.querySelectorAll("td")[columnIndex]?.innerText.trim() || "";
            const bText = b.querySelectorAll("td")[columnIndex]?.innerText.trim() || "";

            if (sortType === "date") {
                return new Date(aText) - new Date(bText);
            } else {
                return aText.localeCompare(bText);
            }
        });

        // Remove ALL rows (visible and hidden)
        rows.forEach(row => tbody.removeChild(row));

        // Re-append sorted visible rows
        visibleRows.forEach(row => tbody.appendChild(row));

        // Then re-append hidden rows (still hidden)
        const hiddenRows = rows.filter(row => row.style.display === "none");
        hiddenRows.forEach(row => tbody.appendChild(row));
    });
});

function toggleActiveViolation(button) {
    const rowId = button.getAttribute('data-row-id');
    const row = document.getElementById(rowId);

    if (row.classList.contains('highlighted')) {
        row.classList.remove('highlighted');
    } else {
        row.classList.add('highlighted');
    }
}

    function sendEmail(userId) {
        fetch('send_email.php?id=' + userId)
            .then(response => response.text())
            .then(data => alert(data))
            .catch(error => console.error('Error:', error));
    }

</script>
</body>
</html>
