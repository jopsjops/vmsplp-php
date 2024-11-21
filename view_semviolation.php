<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/plp.png">
    <title>View Tables</title>
</head>
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

    .sidebar ul li.tables a {
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

    /* Main content styling */
    .main {
        margin-left: 60px;
        padding: 20px;
        transition: margin-left 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center; /* Horizontally center */
        
        min-height: calc(100vh - 60px); /* Ensure full viewport height minus topbar */
    }


    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 16px;
        color: #333;
    }

    table thead {
        background-color: #059212;
        color: #fff;
    }

    table th,
    table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    table th {
        font-weight: bold;
        background-color: #059212;
        color: #fff;
    }

    table td {
        padding: 12px;
        text-align: left;
        color: #555;
    }

    .table-selection {
    margin-top: 20px;
    text-align: center;
}

.table-selection label {
    font-size: 18px;
    font-weight: bold;
    color: #059212;
    margin-right: 10px;
}

.table-selection select {
    width: 300px;
    height: 40px;
    padding: 5px 10px;
    font-size: 16px;
    border: 2px solid #059212;
    border-radius: 5px;
    outline: none;
    background-color: #f9f9f9;
    color: #333;
    transition: all 0.3s ease-in-out;
}

.table-selection select:focus {
    border-color: #046e0d;
    background-color: #eef8ee;
}

.table-selection button {
    margin-left: 10px;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background-color: #059212;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.table-selection button:hover {
    background-color: #046e0d;
}


    
</style>

<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <a href="dashboarddb.php">SSO.</a>
            </div>
            <div class="search">
            </div>
            <div class="user">
                <img src="img/plp.png" alt="Profile Image" id="profileImage">
                <div class="dropdown-content" id="dropdownContent">
                    <a href="admin_changepass.php" id="changePasswordButton"><i class='bx bx-lock'></i> Change
                        Password</a>
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
            <h1>VIEW TABLES</h1>
            <div class="table-selection">
                <form action="" method="post">
                    <label for="tableName">Select a table to view:</label>
                    <select id="tableName" name="tableName" required>
                        <?php
                        // Connect to MySQL
                        $servername = "d6q8diwwdmy5c9k9.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
                        $username = "roemju9ip7gqkgee8sot";
                        $password = "fsouojc1790ia6th";
                        $dbname = "jancl14mdl0z7ylv";
                        $conn = new mysqli($servername, $username, $password);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch tables
                        $sql = "SHOW TABLES FROM $dbname";
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

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tableName'])) {
                $selectedTable = $_POST['tableName'];
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM $selectedTable";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<thead><tr>";
                    $fields = $result->fetch_fields();
                    foreach ($fields as $field) {
                        echo "<th>" . htmlspecialchars($field->name) . "</th>";
                    }
                    echo "</tr></thead><tbody>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
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
        </div>
    </div>

    <script>
        document.getElementById("profileImage").onclick = function () {
            var dropdown = document.getElementById("dropdownContent");
            if (dropdown.style.display === "none" || dropdown.style.display === "") {
                dropdown.style.display = "block";
            } else {
                dropdown.style.display = "none";
            }
        }

        // Optionally close the dropdown if clicked outside
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
        }
    </script>
</body>

</html>