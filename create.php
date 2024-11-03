<?php
require_once 'db_connect.php'; // to connect to the database
$successMessage = ''; // Initialize success message variable

if (isset($_POST['submit'])) {
    $title = $_POST['todoTitle']; // connect to the title of the todo task
    $description = $_POST['todoDescription']; // show the description of the todo task

    // check strings, perform sanitation
    function check($string)
    {
        $string = htmlspecialchars($string);
        $string = strip_tags($string);
        $string = trim($string);
        $string = stripslashes($string);
        return $string;
    }

    // check for empty title
    if (empty($title)) {
        $error = true;
        $titleErrorMsg = "Title must not be empty!";
    }
    // check for empty description
    if (empty($description)) {
        $error = true;
        $descriptionErrorMsg = "Description cannot be empty!";
    }

    // connect to database
    db();
    global $link;
    $query = "INSERT INTO tasks(todoTitle, todoDescription, date) VALUES ('$title', '$description', now() )";
    $insertTodo = mysqli_query($link, $query);
    // as the id primary key part of the table is set to autoincrement, we need not update it
    if ($insertTodo) {
        $successMessage = "Task added!"; // Set success message
    } else {
        echo mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Task Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Taskly</h1>
            <p>Your Ultimate Task Management System</p>
        </header>

        <div class="content">
            <button class="view-btn"><a href="index.php">View All Todos</a></button>
            <form method="post" action="create.php" class="task-form">
                <label for="todoTitle">Task Title:</label>
                <input name="todoTitle" type="text" class="input" placeholder="Enter task title">

                <label for="todoDescription">Task Description:</label>
                <textarea name="todoDescription" class="input" placeholder="Enter task description"></textarea>

                <button type="submit" name="submit" class="btn-primary">Add Task</button>
            </form>

            <?php if ($successMessage): ?>
                <div class="success-message">
                    <?php echo $successMessage; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>