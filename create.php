<?php
require_once 'db_connect.php'; // to connect to the database
if(isset($_POST['submit'])) {
    $title = $_POST['todoTitle']; // connect to the title of the todo task
    $description = $_POST['todoDescription']; // show the description of the todo task

    // check strings
    function check($string){
        $string  = htmlspecialchars($string);
        $string = strip_tags($string);
        $string = trim($string);
        $string = stripslashes($string);
        return $string;
    }

    // check for empty title
    if(empty($title)){
        $error  = true;
        $titleErrorMsg = "Title must not be empty!";
    }
    // check for empty description
    if(empty($description)){
        $error = true;
        $descriptionErrorMsg = "Description cannot be empty!";
    }

    // connect to database
    db();
    global $link;
    $query = "INSERT INTO tasks(todoTitle, todoDescription, date) VALUES ('$title', '$description', now() )";
    $insertTodo = mysqli_query($link, $query);
    if($insertTodo){
        echo "Task added!";
    }else{
        echo mysqli_error($link);
    }

}
?>

<html>
<head>
    <meta charset='utf-8'>
    <meta author='Bobby L'>
    <link rel="stylesheet" href="/style.css"
    <title>TODO List Application</title>
</head>
<body>
<h1>Create Todo List</h1>
<button type="submit"><a href="index.php">View all Todo</a></button>
<form method="post" action="create.php">
    <p>Task title: </p>
    <input name="todoTitle" type="text">
    <p>Task description: </p>
    <input name="todoDescription" type="text"><br>
    <input type="submit" name="submit" value="submit">
</form>
</body>
</html>
