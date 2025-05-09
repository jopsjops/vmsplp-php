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
            margin-top: 180px;
            padding: 10px;
            text-align: center;
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
                <li class="studentpage">
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
                <li class="tables">
                    <a href="view_semviolation.php">
                        <i class='bx bx-table'></i>
                        <div>View Tables</div>
                    </a>
                </li>
                <li class="active">
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
            <h1>STUDENT MANUAL</h1>
            <div class="main-content">
                
        </div>
    </div>
</body>
</html>
