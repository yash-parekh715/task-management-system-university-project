<?php
// Include the database connection file
require_once 'db_connect.php';

$successMessage = ''; // Initialize a variable to hold the success message

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve the title and description of the todo task from the form
    $title = $_POST['todoTitle'];
    $description = $_POST['todoDescription'];

    // Function to sanitize input strings
    function check($string)
    {
        $string = htmlspecialchars($string); // Convert special characters to HTML entities
        $string = strip_tags($string); // Remove HTML and PHP tags
        $string = trim($string); // Remove whitespace from the beginning and end
        $string = stripslashes($string); // Remove backslashes from the string
        return $string; // Return the sanitized string
    }

    // Check if the title is empty
    if (empty($title)) {
        $error = true; // Set error flag
        $titleErrorMsg = "Title must not be empty!"; // Set error message for title
    }
    // Check if the description is empty
    if (empty($description)) {
        $error = true; // Set error flag
        $descriptionErrorMsg = "Description cannot be empty!"; // Set error message for description
    }

    // Establish a connection to the database
    db();
    global $link;
    // Prepare the SQL query to insert the new task into the database
    $query = "INSERT INTO tasks(todoTitle, todoDescription, date) VALUES ('$title', '$description', now())";
    $insertTodo = mysqli_query($link, $query); // Execute the insert query

    // Since the id is a primary key with auto-increment, we do not need to set it manually
    if ($insertTodo) {
        $successMessage = "Task added!"; // Set success message if the insert is successful
    } else {
        echo mysqli_error($link); // Output error message if the insert fails
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Task Management System</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external stylesheet -->
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Taskly</h1> <!-- Application title -->
            <p>Your Ultimate Task Management System</p> <!-- Application description -->
        </header>

        <div class="content">
            <!-- Button to navigate to the page that views all todos -->
            <button class="view-btn"><a href="index.php">View All Todos</a></button>
            <!-- Form for adding a new task -->
            <form method="post" action="create.php" class="task-form">
                <label for="todoTitle">Task Title:</label> <!-- Label for the title input -->
                <input name="todoTitle" type="text" class="input" placeholder="Enter task title">
                <!-- Input field for title -->

                <label for="todoDescription">Task Description:</label> <!-- Label for the description textarea -->
                <textarea name="todoDescription" class="input" placeholder="Enter task description"></textarea>
                <!-- Textarea for description -->

                <button type="submit" name="submit" class="btn-primary">Add Task</button>
                <!-- Submit button to add the task -->
            </form>

            <?php if ($successMessage): ?>
                <!-- Display success message if the task was added -->
                <div class="success-message">
                    <?php echo $successMessage; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>