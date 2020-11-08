<!--Description: Shows the selected blog post on its own. -->
<?php
  require 'authenticate.php';
  require 'connect.php';
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $id_valid = is_numeric($id);

  // If id is valid, sql to grab the blog post with the id, else redirected back to main page.
  if ($id_valid)
  {
    $query = "SELECT *
              FROM books
              WHERE id = :id";
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
        <div id="header">
            <h1><a href="index.php">Phoenix Books - <?= $book_post['title'] ?></a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create.php" >New Post</a></li>
</ul> <!-- END div id="menu" -->
  <div id="all_books">
    <div class="book_post">
      <h2><a><?=$book_post['title']?></a>
        <small>
          <a href="edit.php?id=<?= $book_post['id']?>">edit</a>
        </small>
      </h2>
      <p>
        <small>Price: $<?=$book_post['price']?></small>
      </p>
      <p>
        <small>Author: <?=$book_post['author']?></small>
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