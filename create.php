<!--Description: The page that allows the user to creat a new post to insert into the database. -->
<?php
require 'authenticate.php';
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
            <h1><a href="index.php">Post a New Book</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create.php" class='active'>New Book</a></li>
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
        <input type="submit" name="command" value="Create" />
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