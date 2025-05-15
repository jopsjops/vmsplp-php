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
    <?php
    include 'dbconnection.php';
    $data = null;

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM student_info WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    }
    ?>

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
            color: #333;
            /* Always dark font */
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
            border-radius: 50%;
            /* Makes the logo circular */
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
            transition: margin-left 0.3s, width 0.3s;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            
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
            position: absolute;
            /* Make the table fixed in place */
            top: 180px;
            /* Adjust top position to ensure it's below the top bar */
            left: 20px;
            right: 0;
            width: 100%;
            /* Ensure the table takes the full width */
            border-collapse: collapse;
            margin-top: 20px;
            /* Adjust top margin if needed */
            background-color: #fff;
            /* White background for the table */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
            border-radius: 5px;
        }


        table,
        th,
        td {
            border: 1px solid #e0e0e0;
            /* Light gray border for a minimalistic look */
        }

        th,
        td {
            padding: 10px 15px;
            /* Reduced padding for a clean look */
            text-align: center;
            /* Left align the text for a modern style */
            font-size: 15px;
            /* Slightly smaller text for minimalism */
        }

        th {
            background-color: #f7f7f7;
            /* Light gray background for table headers */
            color: #333;
            /* Dark text color for readability */
            font-weight: bold;
            /* Make headers bold */
            text-transform: uppercase;
            /* All caps for headers for a minimalistic feel */
        }

        tr:nth-child(even) {
            background-color: #fafafa;
            /* Very light gray background for even rows */
        }

        tr:hover {
            background-color: #f1f1f1;
            /* Slight hover effect for rows */
        }

        td {
            color: #333;
            /* Dark text color for the data */
        }
        
        .table-selection-container {
            position: absolute; 
            top: 120px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            margin: 10px 0 25px 0;
            width: 100%;
            flex-wrap: wrap;
            background: transparent;
            box-shadow: none;
            border-radius: 0;
        }

        .table-selection-container select {
            padding: 6px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            min-width: 200px;
            max-width: 100%;
        }

        .table-selection-container button {
            padding: 6px 12px;
            background-color: #2E7D32;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.2s ease-in-out;
        }

        .table-selection-container button:hover {
            background-color: #256428;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <h2>VMS.</h2>
            </div>
            
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
            <li class="">
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
            <li class="archive">
                <a href="archive.php">
                    <i class='bx bxs-archive'></i>
                    <div>Archive</div>
                </a>
            </li>
            <li class="active">
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
        <h1 class="page-title">VIEW PAST RECORDS</h1>
        <div class="table-selection-container">
            <form action="" method="post">
                <select id="tableName" name="tableName" required>
                    <?php
                    include 'dbconnection.php';
                    $conn = new mysqli($servername, $username, $password);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SHOW TABLES FROM $targetDb";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array()) {
                            echo "<option value='" . $row[0] . "'>" . htmlspecialchars($row[0]) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No tables found</option>";
                    }

                    $conn->close();
                    ?>
                </select>
                <button type="submit">Show Table</button>
            </form>
        </div>
        <div class="main-content">
            <div class="table-container">
                <table id="violationTable">
                    <tbody>
                        <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tableName'])) {
                        $selectedTable = $_POST['tableName'];
                        $conn = new mysqli($servername, $username, $password, $targetDb);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM $selectedTable";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table>";
                            echo "<thead><tr>";
                            $fields = $result->fetch_fields();

                            // Store the field names that should be displayed
                            $displayFields = [];
                            foreach ($fields as $field) {
                                if ($field->name !== 'id' && $field->name !== 'Proof' && $field->name !== 'Date'
                                && $field->name !== 'Time' && $field->name !== 'Status') {
                                    $displayFields[] = $field->name;
                                    echo "<th>" . htmlspecialchars($field->name) . "</th>";
                                }
                            }
                            echo "</tr></thead><tbody>";

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                foreach ($displayFields as $fieldName) {
                                    echo "<td>" . htmlspecialchars($row[$fieldName]) . "</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p>No data found in the selected table.</p>";
                        }

                        $conn->close();
                    }
                ?>
                    </tbody>
                </table>

                
            </div>
        </div>
    </div>
    </div>

    
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>
</body>

</html>