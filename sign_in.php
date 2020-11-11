<?php
 	require('connect.php');
 	include('login_functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Phoenix Books</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<h2>Login</h2>
		</div>
		<form method="post" action="sign_in.php">

			<?php echo display_error(); ?>

			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username" >
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password">
			</div>
			<div class="input-group">
				<button type="submit" class="btn" name="login_btn">Login</button>
			</div>
			<p>
				Not yet a member? <a href="register.php">Sign up</a>
			</p>
		</form>
	</div>
</body>
</html>