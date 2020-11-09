<!--Description: Main page of the site. Shows the last 5 blog posts from the database. -->
<?php
  require 'connect.php';

  //sql to pull last 5 blog posts from the database
  $query = "SELECT *
            FROM books
            ORDER BY title";
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
      <div id="header">
          <h1><a href="index.php">Phoenix Books</a></h1>
          <h2>Browse the books we have!</h2>
          <h3><small id="signin"><a href="sign_in.php">Sign in</a></small></h3>
          <h3><small><a href="register.php">Register</a></small></h3>
      </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" class='active'>Home</a></li>
    <li><a href="create.php" >New Book</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_books">
  <!--while loop to display the 5 blog posts -->
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