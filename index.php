<!--Description: Main page of the site. Shows the last 5 blog posts from the database. -->
<?php
  
  require 'connect.php';
  include 'login_functions.php';

  $orderby = "title";
  $order = "ASC";

  if(!empty($_POST["orderby"])) {
    $orderby = $_POST["orderby"];
  }

  if(!empty($_POST["order"])) {
    $order = $_POST["order"];
  }

  $query = "SELECT books.id, books.title, books.author, books.price, books.description ,categories.category
    FROM books
    LEFT JOIN categories
    ON books.category_id = categories.id
    ORDER BY " . $orderby . " " . $order;
  $statement = $db->prepare($query);
  $statement->execute();
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
          <h1><a href="index.php">Phoenix Books</a></h1>
          <h2>Browse the books we have!</h2>
          <?php if (!isset($_SESSION['user'])) : ?>
            <h3><small id="signin"><a href="sign_in.php">Sign in</a></small></h3>
            <h3><small><a href="register.php">Register</a></small></h3>
          <?php endif ?>
      </div> <!-- END div id="header" -->
      <?php if (isset($_SESSION['user'])) :?>
        <form action="index.php" method="post">
        <select name="orderby" id="orderby">
          <option value="title">Title</option>
          <option value="author">Author</option>
          <option value="price">Price</option>
        </select>
        <select name="order" id="order">
          <option value="ASC">Ascending</option>
          <option value="DESC">Descending</option>
        </select>
        <p>Currently sorted by: <?=$order?>, <?=$orderby?></p>
        <input type="submit" name="sort" id="sort"/>
      </form>
      <?php endif ?>    
<ul id="menu">
    <li><a href="index.php" class='active'>Home</a></li>
    <?php if (isset($_SESSION['user'])) :?>
      <?php if ($_SESSION['user']['user_type'] == 'admin') :?>
        <li><a href="create_book.php" >New Book</a></li>
        <li><a href="create_category.php" >New Category</a></li>
      <?php endif ?>
    <?php endif ?>
</ul> <!-- END div id="menu" -->
<div id="all_books">
  <!--while loop to display the books -->
  <?php while ($row = $statement->fetch()): ?>
      <div class="book_post">
        <h2><a href="show.php?id=<?=$row['id']?>"><?= $row['title'] ?></a></h2>
      <p>
        <small>
          Price: $<?= $row['price']?>
        </small>
      </p>
       <p>
        <small>
          Author: <?= $row['author']?>
        </small>
      </p>
      <p>
        <small>
          Category: <?= $row['category']?>
        </small>
      </p>
      </div>
      <div class='book_content'>
        <!--if to truncate posts over 200 characters -->
        <?php if (strlen($row['description']) > 200): ?>
          <?= mb_strimwidth($row['description'], 0, 200, " ...");?>       
          <a href="show.php?id=<?= $row['id'] ?>">Read more</a>
          <?php else : ?>
            <?= $row['description'] ?>     
        <?php endif ?>
      </div>
  <?php endwhile ?>
</div>
      <div id="footer">
          PhoenixBooks 2020 - No Rights Reserved
      </div> <!-- END div id="footer" -->
  </div> <!-- END div id="wrapper" -->
</body>
</html>