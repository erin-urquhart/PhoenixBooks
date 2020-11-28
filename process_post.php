<!--Description: .php file that processes create, delete, and edit requests -->
<?php
    require 'connect.php';
    //input sanitization
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    //if to check if Create Book was clicked
    if ($_POST['command'] == 'Create Book')     
    {
        $post_valid = isset($title) && isset($price) && isset($description) && isset($author) && isset($category) && !empty($category) && !empty($title) && !empty($price) && !empty($description);
        //if to check if book is valid before inserting it into database
        if ($post_valid)
        {
            $query = "INSERT INTO `books`(`title`, `price`, `category_id`,`description`,`author`) VALUES (:title, :price,:category,:description,:author)";
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

        $post_valid = isset($title) && isset($price) && isset($description) && isset($author) && isset($category) && !empty($category) && !empty($title) && !empty($price) && !empty($description);

        //checks for valid id
        if ($id_valid)
        {
            //checks for a valid post before updating 
            if($post_valid)
            {
                $query = "UPDATE books
                      SET title = :title, description = :description, price = :price, author = :author, category_id = :category
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

     if ($_POST['command'] == 'Create User')     
    {

        $username = filter_input(INPUT_POST, 'new_user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_type = filter_input(INPUT_POST, 'new_user_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'new_user_email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password1 = filter_input(INPUT_POST, 'new_user_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user_valid = isset($password1) && !empty($username) && !empty($user_type) && !empty($email) && !empty($password1);
        //if to check if user is valid before inserting it into database
        if ($user_valid)
        {
            $password = password_hash($password1, PASSWORD_DEFAULT);
            $query = "INSERT INTO `users`(`username`, `email`, `password`,`user_type`) VALUES (:username,:email,:password,:user_type)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username); 
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $password);
            $statement->bindValue(':user_type', $user_type);
            $statement->execute();
            $insert_id = $db->lastInsertId();
        }
    }

    //if to check if Update User was clicked
    if($_POST['command'] == 'Update User')
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id_valid = is_numeric($id);

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $user_type = filter_input(INPUT_POST, 'user_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user_valid = isset($username) && isset($user_type) && isset($email) && !empty($username) && !empty($user_type) && !empty($email);

        //checks for valid id
        if ($id_valid)
        {
            //checks for a valid post before updating 
            if($user_valid)
            {
                if (isset($_POST['change_password']) && !empty($_POST['change_password']))
                {
                    $password1 = filter_input(INPUT_POST, 'change_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $password = password_hash(password1, PASSWORD_DEFAULT);

                    $query = "UPDATE users
                      SET username = :username, password = :password, user_type = :user_type, email = :email
                      WHERE id = :id";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':id', $id, PDO::PARAM_INT);
                    $statement->bindValue(':username', $username); 
                    $statement->bindValue(':user_type', $user_type);
                    $statement->bindValue(':password', $password);
                    $statement->bindValue(':email', $email);
                    $statement->execute();
                }
                else
                {
                    $query = "UPDATE users
                        SET username = :username, user_type = :user_type, email = :email
                        WHERE id = :id";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':id', $id, PDO::PARAM_INT);
                    $statement->bindValue(':username', $username); 
                    $statement->bindValue(':user_type', $user_type);
                    $statement->bindValue(':email', $email);
                    $statement->execute();
                }
            }
        }
        else
        {
            //returns user to index if an error was found
            header("Location:index.php");
            exit();
        }
    }

    if($_POST['command'] == 'Delete User')
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id_valid = is_numeric($id);

        //checks for valid id
        if ($id_valid)
        {
            //deletes selected post from the table
            $query = "DELETE FROM users WHERE id = :id";
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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phoenix Books</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
                    The category must be at least one character.  
                </p>
                <a href="index.php">Return Home</a>
        <?php elseif ((isset($user_valid)) && ($user_valid == false)) :?>
        <h1>An error occured while processing your book post.</h1>
                <p>
                    Username, Email, and Password must all be at least one character.  
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
