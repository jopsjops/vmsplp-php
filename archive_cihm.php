<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/cihm1.png">
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

        .user {
            position: relative;
            width: 50px;
            height: 50px;
            left: 49px;
        }

        .user img {
            position: absolute;
            top: -3px;
            left: 0;
            height: 160%;
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

        .sidebar ul li.archive a {
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
                <h2>CIHM.</h2>
            </div>
            <div class="search">
                <input type="text" id="search" placeholder="Search here">
                <label for="search"><i class='bx bx-search'></i></label>
            </div>
            <div class="user">
                <img src="img/cihm.png" alt="Profile Image" id="profileImage">
                <div class="dropdown-content" id="dropdownContent">
                    <a href="cihm_changepass.php" id="changePasswordButton"><i class='bx bx-lock'></i> Change
                        Password</a>
                        <a href="index.php" id="logoutButton"><i class='bx bx-log-out'></i> Log Out</a>
                        </div>
            </div>
        </div>
        <div class="sidebar">
            <ul>
                <li class="stud">
                    <a href="cihm_dean.php">
                        <i class='bx bxs-group'></i>
                        <div>Student</div>
                    </a>
                </li>
                <li class="archive">
                    <a href="archive_cihm.php">
                        <i class='bx bxs-archive'></i>
                        <div>Archive</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <h1>ARCHIVE (CIHM) </h1>
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
                    $sql = "SELECT * FROM archive_info WHERE Department = 'CIHM'";
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
                                            $statusColor = 'background-color: #80ef80;'; // Default color for any other status
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
                                </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9'>No records found</td></tr>"; // Updated colspan to match the number of columns
                            }
                            ?>
                            <tr id="noRecords" style="display:none;">
                                <td colspan="9" style="text-align:center;">No records found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("profileImage").onclick = function () {
            var dropdown = document.getElementById("dropdownContent");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        };

        window.onclick = function (event) {
            if (!event.target.matches('#profileImage')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        };

        document.getElementById("logoutButton").onclick = function (event) {
            var confirmLogout = confirm("Are you sure you want to log out?");
            if (!confirmLogout) {
                event.preventDefault();
            }
        };

        document.getElementById('search').addEventListener('keyup', function () {
            var searchValue = this.value.toLowerCase();
            var rows = document.querySelectorAll('#violationTable tbody tr:not(#noRecords)');
            var noRecordsRow = document.getElementById('noRecords');
            var rowCount = 0;

            rows.forEach(function (row) {
                var rowText = row.textContent.toLowerCase();
                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                    rowCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (rowCount === 0) {
                noRecordsRow.style.display = '';
            } else {
                noRecordsRow.style.display = 'none';
            }
        });
    </script>
</body>
</html>
