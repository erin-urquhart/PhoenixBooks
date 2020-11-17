<!--Description: Shows the selected book post on its own. -->
<?php
  require 'connect.php';
  include 'login_functions.php';
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $id_valid = is_numeric($id);

  // If id is valid, sql to grab the book post with the id, else redirected back to main page.
  if ($id_valid)
  {
    $query = "SELECT books.id, books.title, books.author, books.price, books.description ,categories.category
    FROM books
    LEFT JOIN categories
    ON books.category_id = categories.id
    WHERE books.id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
  }
  else
  {
    header("Location:index.php");
    exit();
  }

$book_post = $statement->fetch();

?> 

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$book_post['title']?></title>
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
            <h1><a href="index.php">Phoenix Books - <?= $book_post['title'] ?></a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
        <?php if (isset($_SESSION['user'])) :?>
          <?php if ($_SESSION['user']['user_type'] == 'admin') :?>
            <li><a href="create_book.php" >New Post</a></li>
          <?php endif ?>
        <?php endif ?>
</ul> <!-- END div id="menu" -->
  <div id="all_books">
    <div class="book_post">
      <h2><a><?=$book_post['title']?></a>
        <?php if (isset($_SESSION['user'])) :?>
          <?php if ($_SESSION['user']['user_type'] == 'admin') :?>
            <small>
              <a href="edit.php?id=<?= $book_post['id']?>">edit</a>
            </small>
          <?php endif ?>
        <?php endif ?>
      </h2>
      <p>
        <small>Price: $<?=$book_post['price']?></small>
      </p>
      <p>
        <small>Author: <?=$book_post['author']?></small>
      </p>
      <p>
        <small>Category: <?=$book_post['category']?></small>
      </p>
      <div class='book_content'>
        <?= $book_post['description']?>
      </div>
    </div>
  </div>
        <div id="footer">
            PhoenixBooks 2020 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>