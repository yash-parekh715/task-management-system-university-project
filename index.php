<?php
session_start(); // Start the session to manage user authentication

// Include the database connection file
require_once("db_connect.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Establish a connection to the database
$link = db(); // Call the db() function to get the database connection

?>
<!DOCTYPE html>
<html lang="en"> <!-- Specify the language of the document -->
<head>
    <meta charset='utf-8'> <!-- Specify the character set for the document -->
    <meta name='author' content='Bobby L'> <!-- Author metadata for the document -->
    <title>Task Management System</title> <!-- Title displayed in the browser tab -->
    <link rel="stylesheet" href="index.css"> <!-- Link to the external CSS file for styling -->
</head>
<body>
    <div class="container"> <!-- Main container for the entire page content -->
        <header class="header"> <!-- Header section containing the title and description -->
            <h2>Taskly</h2> <!-- Main heading for the application -->
            <p>Your Ultimate Task Management System</p> <!-- Subheading or description of the application -->
            <a href="logout.php" class="logout-button">Logout</a> <!-- Link to logout -->
        </header>

        <div class="task-header"> <!-- Header for the task list -->
            <h3>Task List</h3> <!-- Subheading for the task list -->
            <a href="create.php" class="add-task">+ Add Task</a> <!-- Link to create a new task -->
        </div>

        <?php
        // Query to select all tasks from the database
        $query = "SELECT id, todoTitle, todoDescription, date FROM tasks";
        $result = mysqli_query($link, $query); // Execute the query

        // Check if there are any tasks in the result
        if (mysqli_num_rows($result) > 0) {
            echo "<ul class='task-list'>"; // Start an unordered list for tasks
            while ($row = mysqli_fetch_assoc($result)) { // Fetch each row from the result
                $id = htmlspecialchars($row['id']); // Get the task ID
                $title = htmlspecialchars($row['todoTitle']); // Get the task title
                $date = htmlspecialchars($row['date']); // Get the creation date of the task

                // Output each task as a list item with links for detail, edit, and delete
                echo "
                    <li class='task-item'> <!-- List item for each task -->
                        <div>
                            <a href='detail.php?id=$id' class='task-title'>$title</a> <!-- Link to task details -->
                            <p class='task-date'>Created on: $date</p> <!-- Display task creation date -->
                        </div>
                        <div class='task-buttons'> <!-- Buttons for editing and deleting the task -->
                            <a href='edit.php?id=$id' class='edit-button'>Edit</a> <!-- Link to edit task -->
                            <a href='delete.php?id=$id' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this task?\");'>Delete</a> <!-- Link to delete task with confirmation -->
                        </div>
                    </li>
                ";
            }
            echo "</ul>"; // End the unordered list
        } else {
            // If no tasks are found, display a message
            echo "<p class='no-tasks'>No tasks found! Click on '+ Add Task' to get started.</p>";
        }

        // Close the database connection
        mysqli_close($link);
        ?>
    </div>
</body>
</html>