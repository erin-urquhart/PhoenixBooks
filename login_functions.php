<?php 
session_start();

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	global $db, $errors, $username, $email;
	$file = 'register.txt';
	// receive all input values from the form
	$username    =  filter_input(INPUT_POST,'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$email       =  filter_input(INPUT_POST,'email',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password_1  =  filter_input(INPUT_POST,'password_1',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password_2  =  filter_input(INPUT_POST,'password_2',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	$query = "SELECT *
              FROM users
              WHERE username=:username";
	    $statement = $db->prepare($query);
	    $statement->bindValue(':username', $username);
	    $statement->execute();
		$count = $statement->rowCount();
	file_put_contents($file, $count);
	if ($count > 0) {
		array_push($errors, "The username entered is already in use");

	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database


		if (isset($_POST['user_type'])) {
			$user_type = ($_POST['user_type']);
			$query = "INSERT INTO `users` (`username`, `email`,`user_type`, `password`) 
					  VALUES(:username, :email, :user_type,:password)";
			$statement = $db->prepare($query);
            $statement->bindValue(':username', $username); 
            $statement->bindValue(':email', $email);
            $statement->bindValue(':user_type', $user_type);
            $statement->bindValue(':password', $password);
            $statement->execute();
            $insert_id = $db->lastInsertId();
			$_SESSION['success']  = "New user successfully created!!";
			header('location: index.php');
			exit();
		}else{
			$query = "INSERT INTO `users` (`username`, `email`,`user_type`, `password`) 
					  VALUES(:username,:email,'user',:password)";
			$statement = $db->prepare($query);
            $statement->bindValue(':username', $username); 
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $password);
	        $statement->execute();
            $insert_id = $db->lastInsertId();
           
			// get id of the created user
			$logged_in_user_id =  $db->lastInsertId();
			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";header('location: index.php');	
				exit();			
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	 $query = "SELECT *
              FROM users
              WHERE id = :id";
		    $statement = $db->prepare($query);
		    $statement->bindValue(':id', $id, PDO::PARAM_INT);
		    $statement->execute();
		    return $statement->fetch(PDO::FETCH_ASSOC);
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: sign_in.php");
	}

//call login if login button is clicked
if (isset($_POST['login_btn'])) {
	login();
}

function login(){
	global $db, $username, $errors;

	$username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	// check for form errors
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {
		$query = "SELECT *
              FROM users
              WHERE username=:username";
	    $statement = $db->prepare($query);
	    $statement->bindValue(':username', $username);
	    $statement->execute();
		
		$count = $statement->rowCount();
		$login_user = $statement->fetch(PDO::FETCH_ASSOC);
		if ($count == 1) { // user found
			// check if user is admin or user
			if (!password_verify($password, $login_user['password'])){
				array_push($errors, "Incorrect username or password");
			}	
		} else {
			array_push($errors, "Incorrect username or password");
		}
		//login if no errors
		if (count($errors) == 0) {
			if ($login_user['user_type'] == 'admin') {
				$_SESSION['user'] = $login_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: index.php');		  
			} else {
				$_SESSION['user'] = $login_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: index.php');
			}
		}
	}
}

?>