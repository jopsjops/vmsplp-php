<?php
session_start();

include 'dbconnection.php';

$login_error = ""; // Initialize error message variable

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    // Prepare a statement to check if the user exists
    $stmt = $conn->prepare("SELECT id, username, password, college FROM dean_login WHERE username = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User found, verify password
        $user = $result->fetch_assoc();
        if (password_verify($input_password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['college'] = $user['college'];

            // Redirect based on user role
          // Show welcome alert, then redirect using JavaScript
            $redirectPage = ($user['college'] === 'ADMIN') ? 'dashboarddb.php' : strtolower($user['college']) . '_dean.php';

            echo "<script>
                alert('Welcome, " . addslashes($user['username']) . "!');
                window.location.href = '$redirectPage';
            </script>";

            exit();
        } else {
            // Incorrect password
            $login_error = "Invalid username or password.";
        }
    } else {
        // User not found
        $login_error = "Invalid username or password.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<style>
    /* Variables for consistent theming */
    :root {
        --primary-color: #1c824a;
        --secondary-color: #ffffff;
        --text-color: #333;
        --input-border-color: #ddd;
        --button-hover-color: #145b31;
        --font-family: 'Poppins', sans-serif;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: var(--font-family);
        background: url('img/plp_bg.png') no-repeat center center/cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        display: flex;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        width: 900px;
        height: 500px;
    }

    .login-section {
        flex: 1;
        padding: 40px;
        background-color: var(--secondary-color);
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        /* Added to anchor child absolute positioning */
    }

    .login-section h1 {
        font-size: 40px;
        margin-bottom: 20px;
        margin-left: 150px;
        color: var(--primary-color);
    }

    .login-section input {
        width: 420px;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid var(--input-border-color);
        border-radius: 5px;
        font-size: 14px;
        height: 30px;
    }

    .login-section button {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        border: none;
        padding: 12px;
        border-radius: 5px;
        width: 160px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-weight: bold;
        position: absolute;
        margin-left: -70px;
        /* Position the button absolutely within the login section */
        z-index: 4;
        /* Ensure button appears above images */
        top: 320px;
        /* Adjust top position as needed */
        left: 50%;
        /* Center horizontally */
        transform: translateX(-50%);
        /* Center the button */
    }

    .login-section button:hover {
        background-color: var(--button-hover-color);
    }

    .welcome-section {
        flex: 1.5;
        background-color: var(--primary-color);
        color: var(--secondary-color);
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
        margin-left: -90px;
        z-index: 3;
    }

    .welcome-section h1 {
        margin-bottom: 15px;
        font-size: 24px;
        font-weight: px;
    }

    .welcome-section p {
        line-height: 1.5;
        font-size: 14px;
    }
    

    .illustrations {
        position: relative;
        display: flex;
        justify-content: center;
        z-index: 1;
    }

    .illustrations img {
        position: relative;
        bottom: -33px;
        z-index: 1;
        /* Adjust the vertical position as needed */
    }

    .illustrations img:first-child {
        left: -100px;
        /* Position the first image on the left */
        height: 290px;
        /* Adjust size as needed */
        margin-top: -67px;
    }

    .illustrations img:last-child {
        right: 40px;
        /* Position the second image on the right */
        height: 290px;
        /* Adjust size as needed */
        margin-top: -67px;
        margin-left: -40px;
    }

    /* Accessibility */
    .visually-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }

    
</style>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLP Violation Monitoring System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
</head>

<body>
    <main class="container">
        <!-- Login Section -->
        <section class="login-section">
            <h1>LOGIN</h1>
            <form method="post" action="">
                <label for="username" class="visually-hidden">Username</label>
                <input type="text" id="username" placeholder="username" name="username" required>
                <label for="password" class="visually-hidden">Password</label>
                <div class="password-container">
                    <input type="password" id="password" placeholder="Password" name="password" required>
                    <i class="fas fa-eye-slash" id="toggle-password" onclick="togglePassword()"></i>
                </div>

                <button type="submit">LOGIN</button>
                <?php if (!empty($login_error)): ?>
                    <p>
                        <?php echo $login_error; ?>
                    </p>
                <?php endif; ?>
            </form>
            <div class="illustrations">
                <img src="img/boy.png" alt="Student 1">
                <img src="img/girl.png" alt="Student 2">
            </div>
        </section>

        <!-- Welcome Section -->
        <section class="welcome-section">
            <h1>Welcome to PLP Violation Monitoring System</h1>
            <p>Welcome to the homepage of the Pamantasan ng Lungsod ng Pasig's Violation Monitoring System...</p>
        </section>
    </main>

    <script>
        // JavaScript to toggle the password visibility
        function togglePassword() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.getElementById("toggle-password");

    if (passwordField.type === "text") {
        passwordField.type = "password"; // Hide the password
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash"); // Show slashed eye
    } else {
        passwordField.type = "text"; // Show the password
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye"); // Show regular eye
    }
}

    </script>
</body>

</html>