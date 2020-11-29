<?php
 	require('connect.php');
 	include('login_functions.php');
?>

<!DOCTYPE html>
<html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phoenix Books</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container p-2 my-2 bg-light text-grey">
		<div>
			<h2>Login</h2>
		</div>
		<form method="post" action="sign_in.php">

			<?php echo display_error(); ?>

			<div class="container">
				<label>Username</label>
				<input type="text" name="username" >
			</div>
			<div class="container">
				<label>Password</label>
				<input type="password" name="password">
			</div>
			<div class="container">
				<button type="submit" class="btn" name="login_btn">Login</button>
			</div>
			<p>
				Not yet a member? <a href="register.php">Sign up</a>
			</p>
			<p>
				<a href="index.php">Return Home</a>
			</p>
		</form>
	</div>
</body>
</html>