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
        .sidebar {
            position: fixed;
            top: 60px;
            width: 60px;
            height: calc(100% - 60px);
            background: #059212;
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

        .sidebar ul li.archive a {
            color: #059212;
            background: #fff;
        }

        .sidebar ul li a:hover {
            color: #059212;
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
            color: #059212;
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
            color: #059212;
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
            background-color: #059212;
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
            color: #059212;
            background-color: transparent;
        }

        button.archive {
            color: #059212;
            background-color: transparent;
        }


        button.add {
            width: 50px; /* Set the width of the circle */
            height: 50px; /* Set the height to be the same as the width */
            border-radius: 50%; /* This makes the button round */
            background-color: #059212; /* Background color of the button */
            color: white; /* Icon color */
            border: none; /* Remove border */
            display: flex; /* Center icon inside the button */
            justify-content: center; /* Horizontally center the icon */
            align-items: center; /* Vertically center the icon */
            cursor: pointer; /* Add a pointer on hover */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            position: fixed; /* Make the button stay in a fixed position */
            bottom: 20px; /* Distance from the bottom of the screen */
            right: 20px; /* Distance from the right side of the screen */
        }

        #moveDataModal {
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Dark overlay background */
            display: flex;
            padding: 20px;            /* Add some padding to prevent the modal from touching the edges */
        }


#modalContent {
    background-color: #fff;
    padding: 30px 40px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Soft shadow */
    text-align: center;
    position: relative;
    font-family: Arial, sans-serif;
    color: #333;
    margin-left: 520px;
    margin-top: 200px;
    
}

.close {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 1.5em;
    font-weight: bold;
    color: #888;
    cursor: pointer;
    transition: color 0.3s;
}

.close:hover {
    color: #333; /* Darker on hover */
}

/* Input fields styling */
#moveDataForm input[type="text"],
#moveDataForm button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1em;
}

#moveDataForm input[type="text"]:focus {
    border-color: #5a9; /* Light green border on focus */
    outline: none;
}

/* Button styling */
#moveDataForm button {
    background-color: #28a745; /* Green background */
    color: white;
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s;
}

#moveDataForm button:hover {
    background-color: #218838; /* Darker green on hover */
}

#moveDataForm button:active {
    background-color: #1e7e34; /* Darkest green on click */
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
                <li class="tables">
                    <a href="view_semviolation.php">
                        <i class='bx bx-table'></i>
                        <div>View Tables</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <h1>STUDENT ARCHIVE</h1>
            <div class="main-content">
                <div class="table-container">
                    <?php
                    include 'dbconnection.php';        
                    // Fetch archive records
                    $sql = "SELECT id, Student_ID, Student_Name, Department, Program, Violation, Status, Date FROM archive_info ORDER BY Date DESC";
                    $result = $conn->query($sql);
                    ?>
                    <table id="archiveTable">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Program</th>
                                <th>Violation</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>" . htmlspecialchars($row['Student_ID']) . "</td>
                                        <td>" . htmlspecialchars($row['Student_Name']) . "</td>
                                        <td>" . htmlspecialchars($row['Department']) . "</td>
                                        <td>" . htmlspecialchars($row['Program']) . "</td>
                                        <td>" . htmlspecialchars($row['Violation']) . "</td>
                                        
                                        <td>" . htmlspecialchars($row['Status']) . "</td>
                                        <td>" . htmlspecialchars($row['Date']) . "</td>
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
                        </tbody>
                    </table>
                    <button class="add" id="addButton" onclick="document.getElementById('moveDataModal').style.display='block'">
                        <i class='bx bxs-data'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div id="moveDataModal" style="display:none;">
        <div id="modalContent">
            <span class="close" onclick="document.getElementById('moveDataModal').style.display='none'">&times;</span>
            <form id="moveDataForm" action="move_data.php" method="post">
                <label for="newTableName">Enter New Table Name: (Ex: Sem_AY)</label>
                <input type="text" id="newTableName" name="newTableName" required>

                <label>Do you want to transfer all data from archive_info to the new table?</label>
                <button type="submit">Confirm Transfer</button>
            </form>
        </div>
    </div>

    <script>
        function editRow(id) {
            // Confirm if the user wants to edit the specific student record
            const userConfirmed = confirm("Do you want to edit the data for this record?");

            // If confirmed, redirect to the edit page with the specific ID
            if (userConfirmed) {
                const url = 'edit_archive.php?id=' + id;
                window.location.href = url;
            }
        }

        // Transfer from Archive back to Student Info
        function transferRow(id) {
            const userConfirmed = confirm("Are you sure you want to restore this student with ID: " + id + "?");

            if (userConfirmed) {
                fetch('transfer_archive.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id }) // Send student ID for restoration
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message); // Show success message
                        window.location.reload(); // Reload the page to update the table
                    } else {
                        alert("Error: " + data.message); // Show error message
                    }
                })
                .catch(error => console.error('Error:', error)); // Log any errors
            }
        }

        // Search functionality
        document.getElementById('search').addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#archiveTable tbody tr');
            let rowCount = 0;

            rows.forEach(function (row) {
                const rowText = row.textContent.toLowerCase();
                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                    rowCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Display "No records found" if no rows match the search query
            const noRecordsRow = document.getElementById('noRecords');
            if (rowCount === 0) {
                noRecordsRow.style.display = '';
            } else {
                noRecordsRow.style.display = 'none';
            }
        });

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