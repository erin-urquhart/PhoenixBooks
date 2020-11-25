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
<html>
<head>
    <meta charset="utf-8">
    <title>Phoenix Books</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
      <div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
        <h3>
          <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
          ?>
        </h3>
      </div>
    <?php endif ?>

      <div class="profile_info">
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
        <div id="header">
            <h1><a href="index.php">View/Moderate Users</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create_book.php" >New Book</a></li>
    <li><a href="create_category.php" >New Category</a></li>
    <li><a href="moderate_users.php" class='active' >Create/Delete Users</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_books">
  <form action="process_post.php" method="post">
    <fieldset>
      <p>
        <label for="new_user">Create New User</label>
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
<table id= "users">
  <tr>
    <th>Username</th>
    <th>User Type</th>
    <th>Email</th>
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