<!--Description: .php file that processes create, delete, and edit requests -->
<?php
    require 'connect.php';
    //input sanitization
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    //if to check if Create Book was clicked
    if ($_POST['command'] == 'Create Book')     
    {
        $post_valid = isset($title) && isset($price) && isset($description) && isset($author) && !empty($title) && !empty($price) && !empty($description);
        //if to check if book is valid before inserting it into database
        if ($post_valid)
        {
            $query = "INSERT INTO `books`(`title`, `price`, `category`,`description`,`author`) VALUES (:title, :price,:category,:description,:author)";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title); 
            $statement->bindValue(':price', $price);
            $statement->bindValue(':category', $category);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':author', $author);
            $statement->execute();
            $insert_id = $db->lastInsertId();
        }
    }

    //if to check if Create Category was clicked
    if ($_POST['command'] == 'Create Category')     
    {
        $category_valid = isset($category) && !empty($category);

        if ($category_valid)
        {
            $query = "INSERT INTO `categories`(`category`) VALUES (:category)";
            $statement = $db->prepare($query);
            $statement->bindValue(':category', $category);
            $statement->execute();
            $insert_id = $db->lastInsertId();
        }
    }

    //if to check if Update was clicked
    if($_POST['command'] == 'Update')
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id_valid = is_numeric($id);

        $post_valid = isset($title) && isset($price) && isset($description) && isset($author) && !empty($title) && !empty($price) && !empty($description);

        //checks for valid id
        if ($id_valid)
        {
            //checks for a valid post before updating 
            if($post_valid)
            {
                $query = "UPDATE books
                      SET title = :title, description = :description, price = :price, author = :author, category = :category
                      WHERE id = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->bindValue(':title', $title); 
                $statement->bindValue(':description', $description);
                $statement->bindValue(':price', $price);
                $statement->bindValue(':author', $author);
                $statement->bindValue(':category', $category);
                $statement->execute();
            }
        }
        else
        {
            //returns user to index if an error was found
            header("Location:index.php");
            exit();
        }
    }

     //if to check if Delete was clicked
    if($_POST['command'] == 'Delete')
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id_valid = is_numeric($id);

        //checks for valid id
        if ($id_valid)
        {
            //deletes selected post from the table
            $query = "DELETE FROM books WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        }
        else
        {
            //returns user to index if error was found

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
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div>
        <!-- if the post is not valid, displays an error-->
        <?php if ((isset($post_valid)) && ($post_valid == false)): ?>
            <h1>An error occured while processing your book post.</h1>
                <p>
                    Both the title and description must be at least one character.  
                </p>
                <a href="index.php">Return Home</a>
        <?php elseif ((isset($category_valid)) && ($category_valid == false)): ?>
            <h1>An error occured while processing your book post.</h1>
                <p>
                    Both the title and description must be at least one character.  
                </p>
                <a href="index.php">Return Home</a>
        <?php else :?>
            <?=header("Location:index.php");?>
            <?= exit(); ?>
        <?php endif ?>

        <div id="footer">
          
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
