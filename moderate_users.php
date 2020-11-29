<?php
require 'connect.php';
include 'login_functions.php';

if (isset($_SESSION['user']))
  {
    if ($_SESSION['user']['user_type'] == 'admin')
    {
        $query = "SELECT *
                    FROM users";
        $statement = $db->prepare($query);
        $statement->execute();
    }
    else
    {
      header("Location:index.php");
      exit();
    }
  }

?> 

<!DOCTYPE html>
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
  <div class="container">
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="alert alert-success alert-dismissible fade show" >
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Success!</strong> <?php echo $_SESSION['success'];  ?>
        <?php  unset($_SESSION['success']); ?>
      </div>
    <?php endif ?>
    <div>
      <?php  if (isset($_SESSION['user'])) : ?>
        <strong><?php echo $_SESSION['user']['username']; ?></strong>
        <small>
          <i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
          <br>
          <a href="index.php?logout='1'" style="color: red;">logout</a>
        </small>
      <?php endif ?>
    </div>
      <div class="jumbotron text-center" style="margin-bottom:0">
          <h1><a href="index.php">View/Moderate Users</a></h1>
      </div>
<nav class="navbar navbar-expand-sm bg-light justify-content-center">          
  <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="create_book.php" >New Book</a></li>
    <li class="nav-item"><a class="nav-link" href="create_category.php" >New Category</a></li>
    <li class="nav-item"><a class="nav-link" href="moderate_users.php" >Create/Delete Users</a></li>
  </ul>
</nav> 
<div class="container p-2 my-2 bg-light text-grey">
  <form action="process_post.php" method="post">
    <fieldset>
      <p>
        <label for="new_user">Create New User:</label>
        <input name="new_user_name" id="new_user_name" placeholder="Username" />
        <input name="new_user_email" type="new_user_email" placeholder="Email"/>
        <input name="new_user_password" id="new_user_password" placeholder="Password" />
        <select name="new_user_type">
          <option value="admin">Admin</option>
          <option value="user">User</option>
        </select>
      </p>
      <p>
        <input type="submit" name="command" value="Create User" />
      </p>
    </fieldset>
  </form>
<table class="table table-striped">
  <tr>
    <th>Username</th>
    <th>User Type</th>
    <th>Email</th>
    <th></th>
  </tr>
  <?php while ($row = $statement->fetch()): ?>
  <tr>
    <td><?= $row['username']?></td>
    <td><?= $row['user_type']?></td>
    <td><?= $row['email']?></td>
    <td><a href="edit_user.php?id=<?=$row['id']?>">Edit</a></td>
  </tr>
  <?php endwhile ?>
</table>
</div>
        <div id="footer">
            PhoenixBooks 2020 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>