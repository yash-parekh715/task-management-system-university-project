<?php
// Include the database connection file
require_once("db_connect.php");
?>
<html>

<head>
    <meta charset='utf-8'> <!-- Specify the character set for the document -->
    <meta author='Bobby L'> <!-- Author metadata for the document -->
    <title>Task Management System</title> <!-- Title displayed in the browser tab -->
    <link rel="stylesheet" href="index.css"> <!-- Link to the external CSS file for styling -->
</head>

<body>
    <div class="container"> <!-- Main container for the entire page content -->
        <header class="header"> <!-- Header section containing the title and description -->
            <h2>Taskly</h2> <!-- Main heading for the application -->
            <p>Your Ultimate Task Management System</p> <!-- Subheading or description of the application -->
        </header>

        <div class="task-header"> <!-- Header for the task list -->
            <h3>Task List</h3> <!-- Subheading for the task list -->
            <a href="create.php" class="add-task">+ Add Task</a> <!-- Link to create a new task -->
        </div>

        <?php
        // Establish a connection to the database
        db();
        global $link;

        // Query to select all tasks from the database
        $query = "SELECT id, todoTitle, todoDescription, date FROM tasks";
        $result = mysqli_query($link, $query); // Execute the query

        // Check if there are any tasks in the result
        if (mysqli_num_rows($result) >= 1) {
            echo "<ul class='task-list'>"; // Start an unordered list for tasks
            while ($row = mysqli_fetch_array($result)) { // Fetch each row from the result
                $id = $row['id']; // Get the task ID
                $title = $row['todoTitle']; // Get the task title
                $date = $row['date']; // Get the creation date of the task

                // Output each task as a list item with links for detail, edit, and delete
                echo "
                    <li class='task-item'> <!-- List item for each task -->
                        <div>
                            <a href='detail.php?id=$id' class='task-title'>$title</a> <!-- Link to task details -->
                            <p class='task-date'>Created on: $date</p> <!-- Display task creation date -->
                        </div>
                        <div class='task-buttons'> <!-- Buttons for editing and deleting the task -->
                            <a href='edit.php?id=$id' class='edit-button'>Edit</a> <!-- Link to edit task -->
                            <a href='delete.php?id=$id' class='delete-button'>Delete</a> <!-- Link to delete task -->
                        </div>
                    </li>
                ";
            }
            echo "</ul>"; // End the unordered list
        } else {
            // If no tasks are found, display a message
            echo "<p class='no-tasks'>No tasks found! Click on '+ Add Task' to get started.</p>";
        }
        ?>
    </div>
</body>

</html>