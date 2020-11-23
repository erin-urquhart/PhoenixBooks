<!--Description: Main page of the site. Shows the last 5 books from the database. -->
<?php
  
  require 'connect.php';
  include 'login_functions.php';

  $orderby = "title";
  $order = "ASC";
  $category = `IS NOT NULL`;

  $query_category = "SELECT *
                    FROM categories";
  $statement_category = $db->prepare($query_category);
  $statement_category->execute();

  if(!empty($_POST["orderby"])) {
    $orderby = $_POST["orderby"];
  }

  if(!empty($_POST["order"])) {
    $order = $_POST["order"];
  }


  if(!empty($_POST["category"])) {
    $category = $_POST["category"];
  }

  $query_book = "SELECT books.id, books.title, books.author, books.price, books.description ,categories.category
    FROM books
    LEFT JOIN categories
    ON books.category_id = categories.id
    WHERE books.category_id = :category OR :category IS NULL
    ORDER BY " . $orderby . " " . $order;
  $statement_book = $db->prepare($query_book);
  if ($category == "ALL") {
    $statement_book->bindValue(':category', NULL);
  }
  else {
    $statement_book->bindValue(':category', $category);  
  }
  $statement_book->execute();

    ob_start();                  
    var_dump( $_POST );           
    $contents = ob_get_contents(); 
    ob_end_clean();               
    file_put_contents("duck.txt", $contents);

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
        <p>Sort by:</p>
        <form action="index.php" method="post">
        <select name="orderby" id="orderby">
          <option value="title" <?php echo (isset($_POST['orderby']) && $_POST['orderby'] == 'title') ? 'selected="selected"' : ''; ?>>Title</option>
          <option value="author" <?php echo (isset($_POST['orderby']) && $_POST['orderby'] == 'author') ? 'selected="selected"' : ''; ?>>Author</option>
          <option value="price" <?php echo (isset($_POST['orderby']) && $_POST['orderby'] == 'price') ? 'selected="selected"' : ''; ?>>Price</option>
        </select>
        <select name="order" id="order">
          <option value="ASC" <?php echo (isset($_POST['order']) && $_POST['order'] == 'ASC') ? 'selected="selected"' : ''; ?>>Ascending</option>
          <option value="DESC" <?php echo (isset($_POST['order']) && $_POST['order'] == 'DESC') ? 'selected="selected"' : ''; ?>>Descending</option>
        </select>
        <div id="categorysearch">
            <label for="category">Category:</label>
            <select name="category" id="category">
              <option value="ALL">All</option>
            <?php while($row_category = $statement_category->fetch()): ?>
              <option value="<?=$row_category['id']?>" <?php echo (isset($_POST['category']) && $_POST['category'] == $row_category['id']) ? 'selected="selected"' : ''; ?>><?= $row_category['category']?></option>
            <?php endwhile ?> 
            </select>
            <input type="submit" name="id" id="id" value="Search" />
            <input type="reset" name="id" id="id" value="Reset"/>
        </div>  
        </form> 
      <?php endif ?> 
<ul id="menu">
    <li><a href="index.php" class='active'>Home</a></li>
    <?php if (isset($_SESSION['user'])) :?>
      <?php if ($_SESSION['user']['user_type'] == 'admin') :?>
        <li><a href="create_book.php" >New Book</a></li>
        <li><a href="create_category.php" >New Category</a></li>
        <li><a href="create_category.php" >Create/Delete Users</a></li>
      <?php endif ?>
    <?php endif ?>
</ul> <!-- END div id="menu" -->
<div id="all_books">
  <!--while loop to display the books -->
  <?php while ($row_book = $statement_book->fetch()): ?>
      <div class="book_post">
        <h2><a href="show.php?id=<?=$row_book['id']?>"><?= $row_book['title'] ?></a></h2>
      <p>
        <small>
          Price: $<?= $row_book['price']?>
        </small>
      </p>
       <p>
        <small>
          Author: <?= $row_book['author']?>
        </small>
      </p>
      <p>
        <small>
          Category: <?= $row_book['category']?>
        </small>
      </p>
      </div>
      <div class='book_content'>
        <!--if to truncate posts over 200 characters -->
        <?php if (strlen($row_book['description']) > 200): ?>
          <?= mb_strimwidth($row_book['description'], 0, 200, " ...");?>       
          <a href="show.php?id=<?= $row_book['id'] ?>">Read more</a>
          <?php else : ?>
            <?= $row_book['description'] ?>     
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