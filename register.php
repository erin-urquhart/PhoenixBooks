<?php
	require('connect.php');
	include('login_functions.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Phoenix Books</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
	<div id="wrapper">	
		<div id="header">
			<h2>Register</h2>
		</div>
		<form method="post" action="register.php">
			<?php echo display_error(); ?>
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username" value="<?php echo $username; ?>">
			</div>
			<div class="input-group">
				<label>Email</label>
				<input type="email" name="email" value="<?php echo $email; ?>">
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password_1">
			</div>
			<div class="input-group">
				<label>Confirm password</label>
				<input type="password" name="password_2">
			</div>
			<div class="input-group">
				<button type="submit" class="btn" name="register_btn">Register</button>
			</div>
			<p>
				Already a member? <a href="sign_in.php">Sign in</a>
				<a href="index.php">Return Home</a>
			</p>
		</form>
	</div>
</body>
</html>