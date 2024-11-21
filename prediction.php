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
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'poppins', sans-serif;
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

        .dropdown-content {
            transform: translateY(55px);
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
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

        .dropdown-content ul{
            display: flex;
            flex-direction: column;
        }

        .user img {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .user:hover{
            cursor: pointer;
        }

        /* sidebar */
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

        .sidebar ul li.pred a {
            color: #059212;
            background: #fff;
        }

        .sidebar ul li a:hover {
            color: #059212;
            background: #f5f5f5;
        }

        .sidebar ul li span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .main {
            margin-left: 60px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .sidebar:hover ~ .main {
            margin-left: 260px; /* Sidebar expanded */
        }

        /* main content*/
        .main-content {
            margin-left: 0px; /* Sidebar width */
            padding: 20px;
            overflow-y: auto;
        }

        header {
            background: #fff;
            color:#059212;
            padding-top: 80px;
            min-height: 70px;
            border-bottom: #fff 3px solid;
            text-align: center;
        }

        header h1 {
            margin-top: -20px;
            margin-bottom: 20px;
            color: #059212;
        }

        button {
            background: #059212;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: block;
            margin: 20px auto; /* Centers the button horizontally */
        }

        button:hover {
            background: #046c1e;
        }

        #prediction-result {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #059212;
            color: white;
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
            </div>
            <div class="user">
                <img src="img/plp.png" alt="Profile Image" id="profileImage">
                <div class="dropdown-content" id="dropdownContent">
                    <a href="cas_changepass.php" id="changePasswordButton"><i class='bx bx-lock'></i> Change
                        Password</a>
                        <a href="index.php" id="logoutButton"><i class='bx bx-log-out'></i> Log Out</a>                </div>
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
            <div class="main-content">
                <header>
                    <h1>STUDENT VIOLATION PREDICTION</h1>
                </header>
                <main>
                <form method="POST" action="">
                <button type="submit" name="run_python">Run Prediction</button>
            </form>

            <div id="prediction-result">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['run_python'])) {
                    // Run the Python script
                    $command = escapeshellcmd('python C:\\xampp\\htdocs\\capstone_updated\\capstone\\logistic_regre.py');

                    $output = shell_exec($command);

                    // Display the Python script output
                    echo "<pre>$output</pre>";
                }
                ?>
            </div>

                    <div id="table-container">
                        <!-- Table will be displayed here -->
                    </div>
                </main>
            </div>
        </div>
        <script>

            document.getElementById("profileImage").onclick = function() {
                var dropdown = document.getElementById("dropdownContent");
                dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
            };

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
            };

            document.getElementById("logoutButton").onclick = function(event) {
                var confirmLogout = confirm("Are you sure you want to log out?");
                if (!confirmLogout) {
                    event.preventDefault();
                }
            };
        </script>
    </div>
</body>
</html>