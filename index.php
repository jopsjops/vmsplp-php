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

            // ✅ Log to audit_trail
            $log_stmt = $conn->prepare("INSERT INTO audit_trail (username, action, message, event_type) VALUES (?, ?, ?, ?)");
            $action = "login";
            $message = "User logged in.";
            $event_type = "Authentication";
            $log_stmt->bind_param("ssss", $user['username'], $action, $message, $event_type);
            $log_stmt->execute();
            $log_stmt->close();

            // Redirect based on user role
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
<html>
<head>
	<title>VMS.</title>
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/plp.png" type="image/png">
</head>
<style>
	* {
		padding: 0;
		margin: 0;
		box-sizing: border-box;
	}

	body {
		font-family: 'Poppins', sans-serif;
		overflow: hidden;
	}

	.wave {
		position: fixed;
		bottom: 0;
		left: 0;
		height: 100%;
		z-index: -1;
	}

	.container {
		width: 100vw;
		height: 100vh;
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		grid-gap: 7rem;
		padding: 0 2rem;
	}

	.img {
		display: flex;
		justify-content: flex-end;
		align-items: center;
	}

	.login-content {
		display: flex;
		justify-content: flex-start;
		align-items: center;
		text-align: center;
	}

	.img img {
		width: 500px;
	}

	form {
		width: 360px;
	}

	.login-content img {
		height: 100px;
	}

	.login-content h2 {
		margin: 15px 0;
		color: #333;
		text-transform: uppercase;
		font-size: 2.9rem;
	}

	.login-content .input-div {
		position: relative;
		display: grid;
		grid-template-columns: 7% 93%;
		margin: 25px 0;
		padding: 5px 0;
		border-bottom: 2px solid #d9d9d9;
	}

	.login-content .input-div.one {
		margin-top: 0;
	}

	.i {
		color: #d9d9d9;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.i i {
		transition: .3s;
	}

	.input-div>div {
		position: relative;
		height: 45px;
	}

	.input-div>div>h5 {
		position: absolute;
		left: 10px;
		top: 50%;
		transform: translateY(-50%);
		color: #999;
		font-size: 18px;
		transition: .3s;
	}

	.input-div:before,
	.input-div:after {
		content: '';
		position: absolute;
		bottom: -2px;
		width: 0%;
		height: 2px;
		background-color: #0f9845;
		transition: .4s;
	}

	.input-div:before {
		right: 50%;
	}

	.input-div:after {
		left: 50%;
	}

	.input-div.focus:before,
	.input-div.focus:after {
		width: 50%;
	}

	.input-div.focus>div>h5 {
		top: -5px;
		font-size: 15px;
	}

	.input-div.focus>.i>i {
		color: #0f9845;
	}

	.input-div>div>input {
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		border: none;
		outline: none;
		background: none;
		padding: 0.5rem 0.7rem;
		font-size: 1.2rem;
		color: #555;
		font-family: 'poppins', sans-serif;
	}

	.input-div.pass {
		margin-bottom: 4px;
	}

	a {
		display: block;
		text-align: right;
		text-decoration: none;
		color: #999;
		font-size: 0.9rem;
		transition: .3s;
	}

	a:hover {
		color: #0f9845;
	}

	.btn {
		display: block;
		width: 100%;
		height: 50px;
		border-radius: 25px;
		outline: none;
		border: none;
		background-image: linear-gradient(to right, #32be8f, #0f9845, #32be8f);
		background-size: 200%;
		font-size: 1.2rem;
		color: #fff;
		font-family: 'Poppins', sans-serif;
		text-transform: uppercase;
		margin: 1rem 0;
		cursor: pointer;
		transition: .5s;
	}

	.btn:hover {
		background-position: right;
	}


	/* Tooltip styling */
	.toggle-password[data-tooltip]::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 120%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 5px 8px;
    border-radius: 4px;
    font-size: 12px;
    opacity: 0;
    white-space: nowrap;
    pointer-events: none;
    transition: opacity 0.2s ease-in-out;
    z-index: 10;
}

.toggle-password:hover::after {
    opacity: 1;
}


</style>

<body>
	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			<form action="" method="POST">
				<img src="img/plp.png">
				<h2 class="title">Welcome!</h2>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" class="input" id="username" name="username" autocomplete="off">
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" class="input" id="password" name="password">
					</div>
                    <i class="fa-regular fa-eye toggle-password" id="togglePassword"
					data-tooltip="Show Password"
					style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
				</div>
				<input type="submit" class="btn" value="Login">
			</form>
		</div>
	</div>

	<script>
		const inputs = document.querySelectorAll(".input");


		function addcl() {
			let parent = this.parentNode.parentNode;
			parent.classList.add("focus");
		}

		function remcl() {
			let parent = this.parentNode.parentNode;
			if (this.value == "") {
				parent.classList.remove("focus");
			}
		}


		inputs.forEach(input => {
			input.addEventListener("focus", addcl);
			input.addEventListener("blur", remcl);
		});


        
        document.addEventListener('DOMContentLoaded', function () {
			const passwordInput = document.getElementById('password');
			const toggleIcon = document.getElementById('togglePassword');

			// Hide the icon initially
			toggleIcon.style.display = 'none';

			// Listen for input changes
			passwordInput.addEventListener('input', function () {
				if (passwordInput.value.length > 0) {
					toggleIcon.style.display = 'block';
					toggleIcon.setAttribute('data-tooltip', passwordInput.type === 'password' ? 'Show Password' : 'Hide Password');
				} else {
					toggleIcon.style.display = 'none';
					passwordInput.type = 'password'; // reset to hidden if cleared
					toggleIcon.classList.remove('fa-eye-slash');
					toggleIcon.classList.add('fa-eye');
					toggleIcon.setAttribute('data-tooltip', 'Show Password');
				}
			});

			// Toggle password visibility and update tooltip
			toggleIcon.addEventListener('click', function () {
				const isPassword = passwordInput.type === 'password';
				passwordInput.type = isPassword ? 'text' : 'password';

				toggleIcon.classList.toggle('fa-eye');
				toggleIcon.classList.toggle('fa-eye-slash');

				toggleIcon.setAttribute('data-tooltip', isPassword ? 'Hide Password' : 'Show Password');
			});
		});

    </script>
    <?php if (!empty($login_error)) : ?>
        <script>
            alert("<?php echo $login_error; ?>");
        </script>
    <?php endif; ?>
</body>

</html>