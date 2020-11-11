<!--Description: The page that brings up the post selected for editing. -->
<?php
  require 'authenticate.php';
  require 'connect.php';
  $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $id_valid = is_numeric($id);

 // If id is valid, sql to grab the book with the id, else redirected back to main page.
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
    <title>Phoenix Books - Edit Book</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Phoenix Books - Edit Book</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create.php" >New Book</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_books">
  <form action="process_post.php" method="post">
    <fieldset>
      <legend>Edit Book</legend>
      <p>
        <label for="title">Title</label>
        <input name="title" id="title" value="<?= $book_post['title']?>"/>
      </p>
      <p>
        <label for="price">Price</label>
        <input name="price" id="price" value="<?= $book_post['price']?>"/>
      </p>
      <p>
        <label for="author">Author</label>
        <input name="author" id="author" value="<?= $book_post['author']?>"/>
      </p>
      <p>
        <label for="Description">Description</label>
        <textarea name="description" id="description"><?= $book_post['description']?></textarea>
      </p>
      <p>
        <label for="category">Category</label>
        <select name="category" id="category">
          <option value="History">History</option>
          <option value="Horror">Horror</option>
          <option value="Folklore">Folklore</option>
          <option value="Young Adult">Young Adult</option>
          <option value="Biography">Biography</option>
          <option value="Occult and Magic">Occult and Magic</option>
          <option value="Poetry">Poetry</option>
        </select>
      </p>
      <p>
        <input type="hidden" name="id" value="<?= $book_post['id']?>" />
        <input type="submit" name="command" value="Update" />
        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this book?')" />
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
