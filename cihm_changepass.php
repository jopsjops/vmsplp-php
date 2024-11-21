<?php
session_start();

// Database connection
$servername = "tj5iv8piornf713y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "vl9ieik1ttwerlmd"; // Your DB username
$password = "dxn55zzkhyp5ek1e";     // Your DB password
$dbname = "z6vet51amyrj9ci0"; // Your DB name
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Change password functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $username = 'cihm_dean';

    // Fetch current password for CIHM dean
    $stmt = $conn->prepare("SELECT password FROM dean_login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Verify the current password
    if ($row && password_verify($current_password, $row['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password
            $update_stmt = $conn->prepare("UPDATE dean_login SET password = ? WHERE username = ?");
            $update_stmt->bind_param("ss", $hashed_new_password, $username);
            if ($update_stmt->execute()) {
                echo "<script>alert('Password changed successfully!');</script>";
            } else {
                echo "<script>alert('Error updating password. Please try again.');</script>";
            }
            $update_stmt->close();
        } else {
            echo "<script>alert('New password and confirmation do not match.');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
}
$conn->close();
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
        color: #950c00;
    }

    .search {
        opacity: 0;
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

    .sidebar ul li.stud a {
        color: #fff;
        background: #950c00;
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

    .main {
        margin-left: 60px;
        padding: 20px;
        transition: margin-left 0.3s;
    }

    .sidebar:hover+.main {
        margin-left: 260px;
    }

    .container {
        margin-top: -100px;
        padding-top: 100px;
        /* Adjust this value as needed */
    }

    .form-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        margin: 100px auto 0;
        margin-top: 100px;
        position: relative;
    }


    h3 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    input[type="submit"] {
        background-color: #950c00;
        color: white;
        padding: 12px;
        width: 100%;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #841b00;
    }

    .message {
        text-align: center;
        color: #ff0000;
        margin-bottom: 15px;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/cihm.png">
    <title>Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Change Password - CIHM Dean</title>
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
                        <a href="index.php" id="logoutButton"><i class='bx bx-log-out'></i> Log Out</a>                </div>
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
    </div>
    <h2>Change Password - CIHM Dean</h2>
    <div class="form-container">
        <form action="cihm_changepass.php" method="POST">
            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" name="change_password" value="Change Password">
        </form>
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

        document.getElementById("logoutButton").onclick = function (event) {
            // Show confirmation alert
            var confirmLogout = confirm("Are you sure you want to log out?");

            // If the user clicks "Cancel", prevent the default action (i.e., logout)
            if (!confirmLogout) {
                event.preventDefault();
            }
        };
    </script>
</body>

</html>