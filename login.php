<?php
session_start();

if (isset($_SESSION['user'])) {
    header('location: dashboard.php');
}

$error_message = '';

if ($_POST) {
    include('database/connection.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform the query using prepared statements to prevent SQL injection
    $sql = 'SELECT * FROM users WHERE email = :username';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the entered password against the stored hash
        if (password_verify($password, $user['password'])) {
            // Passwords match, login successful

            // Capture data of currently logged-in user
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = 'Please make sure that the username and password are correct.';
        }
    } else {
        $error_message = 'User not found. Please check the username.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>IMS Login - Inventory Management System</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style>
		body#loginBody{
	background: url('images/back_img.jpg') no-repeat center center fixed;
	background-size: cover;
}
	</style>
</head>
<body id="loginBody" >
<?php if(!empty($error_message)) {?>
<div id="errorMessage">
<strong>Error:</strong><p> <?= $error_message?>
</p>
</div>
<?php } ?>
	<div class="container">
		<div class="loginHeader">
			<h1>IMS</h1>
			<p>Inventory Management System</p>
		</div>
		<div class="loginBody">
			<form action="login.php" method="POST">
				<div class="loginInputsContainer">
					<label for="">Username</label>
					<input placeholder="username" name="username" type="text" />
				</div>
				<div class="loginInputsContainer">
					<label for="">Password</label>
					<input placeholder="password" name="password" type="password" />
				</div>
				<div class="loginButtonContainer">
					<button>login</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>