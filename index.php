<?php
require_once("db_connect.php");
?>
<html>

<head>
    <meta charset='utf-8'>
    <meta author='Bobby L'>
    <title>Task Management System</title>
    <link rel="stylesheet" href="index.css"> <!-- Link to the external CSS file -->
</head>

<body>
    <div class="container">
        <header class="header">
            <h2>Taskly</h2>
            <p>Your Ultimate Task Management System</p>
            <header>

                <div class="task-header">
                    <h3>Task List</h3>
                    <a href="create.php" class="add-task">+ Add Task</a>
                </div>

                <?php
                db();
                global $link;
                $query = "SELECT id, todoTitle, todoDescription, date FROM tasks";
                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) >= 1) {
                    echo "<ul class='task-list'>";
                    while ($row = mysqli_fetch_array($result)) {
                        $id = $row['id'];
                        $title = $row['todoTitle'];
                        $date = $row['date'];
                        echo "
                    <li class='task-item'>
                        <div>
                            <a href='detail.php?id=$id' class='task-title'>$title</a>
                            <p class='task-date'>Created on: $date</p>
                        </div>
                        <div class='task-buttons'>
                            <a href='edit.php?id=$id' class='edit-button'>Edit</a>
                            <a href='delete.php?id=$id' class='delete-button'>Delete</a>
                        </div>
                    </li>
                ";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='no-tasks'>No tasks found! Click on '+ Add Task' to get started.</p>";
                }
                ?>
    </div>
</body>

</html>