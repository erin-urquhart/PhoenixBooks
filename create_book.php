<!--Description: The page that allows the user to create a new book to insert into the database. -->
<?php
require 'connect.php';
include 'login_functions.php';

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['user_type'] == 'admin') {
        $query = "SELECT *
                    FROM categories";
        $statement = $db->prepare($query);
        $statement->execute();
    } else {
        header("Location:index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Phoenix Books</title>
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
	integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	crossorigin="anonymous">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
	integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	crossorigin="anonymous"></script>
<script
	src="https://cdn.tiny.cloud/1/o8nfv5d1yn1qoux0h4h665xs71e1jw91aqfynp7spj0saj92/tinymce/5/tinymce.min.js"
	referrerpolicy="origin"></script>
</head>


<body>
	<script>
        tinymce.init({
        selector: 'textarea',
        plugin: 'a_tinymce_plugin',
        a_plugin_option: true,
        a_configuration_option: 400,
        force_br_newlines : true,
      force_p_newlines : false,
      forced_root_block : ''
      });
      </script>
	<div class="container">
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="alert alert-success alert-dismissible fade show">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Success!</strong> <?php echo $_SESSION['success'];  ?>
        <?php  unset($_SESSION['success']); ?>
      </div>
    <?php endif ?>
    <div class="container">
      <?php if (isset($_SESSION['user'])) : ?>
        <strong><?php echo $_SESSION['user']['username']; ?></strong> <small>
				<i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
				<br> <a href="index.php?logout='1'" style="color: red;">logout</a>
			</small>
      <?php endif ?>  
    </div>
		<div class="jumbotron text-center" style="margin-bottom: 0">
			<h1>
				<a href="index.php">Post a New Book</a>
			</h1>
		</div>
		<nav class="navbar navbar-expand-sm bg-light justify-content-center">
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
				<li class="nav-item"><a class="nav-link" href="create_book.php">New
						Book</a></li>
				<li class="nav-item"><a class="nav-link" href="create_category.php">New
						Category</a></li>
				<li class="nav-item"><a class="nav-link" href="moderate_users.php">Create/Delete
						Users</a></li>
			</ul>
		</nav>
		<div
			class="d-flex justify-content-center align-items-center container p-2 my-2 bg-light text-grey">
			<div class="row">
				<form action="process_post.php" enctype="multipart/form-data"
					method="post">
					<div class="form-group">
						<legend>New Book</legend>
						<label for="title">Title</label> <input name="title" id="title" />
					</div>
					<div class="form-group">
						<label for="price">Price</label> <input name="price" name="price">
					</div>
					<div class="form-group">
						<label for="author">Author</label> <input name="author"
							name="author">
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea name="description" id="description"></textarea>
					</div>
					<div class="form-group">
						<label for="category">Category</label> <select name="category"
							id="category">
        <?php while($row = $statement->fetch()): ?>
          <option value="<?=$row['id']?>"><?= $row['category']?></option>
        <?php endwhile ?> 
        </select>
					</div>
					<div class="form-group">
						<label for='image'>Image (Optional)</label> <input type='file'
							name='image' id='image'>
					</div>
					<p>
						<input type="submit" name="command" value="Create Book" />
					</p>
				</form>
			</div>
		</div>
		<div id="footer">PhoenixBooks 2020 - No Rights Reserved</div>
		<!-- END div id="footer" -->

</body>
</html>