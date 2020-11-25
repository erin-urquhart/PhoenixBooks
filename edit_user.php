<?php
  require 'connect.php';
  include 'login_functions.php';
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $id_valid = is_numeric($id);

 // If id is valid, sql to grab the book with the id, and categories, else redirected back to main page.
  if (isset($_SESSION['user']))
  {
    if ($_SESSION['user']['user_type'] == 'admin')
    {
      if ($id_valid)
      {
        $query = "SELECT *
                  FROM users
                  WHERE id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $user = $statement->fetch();
      }
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
    <title>Phoenix Books - Edit Book</title>
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
            <h1><a href="index.php">Phoenix Books - Edit Book</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
      <li><a href="index.php" >Home</a></li>
    <li><a href="create_book.php" >New Book</a></li>
    <li><a href="create_category.php" >New Category</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_books">
  <form action="process_post.php" method="post">
    <fieldset>
      <legend>Edit User</legend>
      <p>
        <label for="username">Username</label>
        <input name="username" id="username" value="<?= $user['username']?>"/>
      </p>
      <p>
        <label for="change_password">Change Password</label>
        <input name="change_password" id="change_password"/>
      </p>
      <p>
        <label for="user_type">User Type</label>
        <select name="user_type" id="user_type">
            <option value="admin" <?php echo (isset($user['user_type']) && $user['user_type'] == 'admin') ? 'selected="selected"' : ''; ?>>Admin</option>
            <option value="user" <?php echo (isset($user['user_type']) && $user['user_type'] == 'user') ? 'selected="selected"' : ''; ?>>User</option>
        </select>
      </p>
      <p>
        <input type="hidden" name="id" value="<?= $user['id']?>" />
        <input type="submit" name="command" value="Update User" />
        <input type="submit" name="command" value="Delete User" onclick="return confirm('Are you sure you wish to delete this user?')" />
      </p>
    </fieldset>
  </form>
</div>
        <div id="footer">
            PhoenixBooks 2020 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
