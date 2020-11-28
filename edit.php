<!--Description: The page that brings up the book selected for editing. -->
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
        $query_book = "SELECT *
                  FROM books
                  WHERE id = :id";
        $statement_book = $db->prepare($query_book);
        $statement_book->bindValue(':id', $id, PDO::PARAM_INT);
        $statement_book->execute();

        $query_category = "SELECT *
                FROM categories";
        $statement_category = $db->prepare($query_category);
        $statement_category->execute();
        $book_post = $statement_book->fetch();
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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phoenix Books - Edit Book</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
<body>
    <div class="container">
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
    <li><a href="moderate_users.php" >Create/Delete Users</a></li>
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
          <?php while($row = $statement_category->fetch()): ?>
            <option value="<?=$row['id']?>"><?= $row['category']?></option>
          <?php endwhile ?> 
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
</body>
</html>
