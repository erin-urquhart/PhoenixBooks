<!--Description: The page that allows the user to create a new book to insert into the database. -->
<?php
require 'connect.php';
include 'login_functions.php';

if (isset($_SESSION['user']))
  {
    if ($_SESSION['user']['user_type'] == 'admin')
    {
        $query = "SELECT *
                    FROM categories";
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
            <h1><a href="index.php">Post a New Book</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create_book.php" class='active'>New Book</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_blogs">
  <form action="process_post.php" method="post">
    <fieldset>
      <legend>New Book</legend>
      <p>
        <label for="title">Title</label>
        <input name="title" id="title" />
      </p>
      <p>
        <label for="price">Price</label>
        <input name="price" name="price">
      </p>
      <p>
        <label for="author">Author</label>
        <input name="author" name="author">
      </p>
      <p>
        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>
      </p>
      <p>
        <label for="category">Category</label>
        <select name="category" id="category">
        <?php while($row = $statement->fetch()): ?>
          <option value="<?=$row['id']?>"><?= $row['category']?></option>
        <?php endwhile ?> 
        </select>
      </p>
      <p>
        <input type="submit" name="command" value="Create Book" />
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