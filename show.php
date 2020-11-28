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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?=$book_post['title']?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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