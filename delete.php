<?php
// Include database connection file
require_once "db_connect.php";

$message = ''; // Initialize message variable to hold success or error messages

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];
    // Establish a connection to the database
    db();
    global $link;

    // Prepare a SQL query to delete the task with the given ID
    $query = "DELETE FROM tasks WHERE id = '$id'";
    $delete = mysqli_query($link, $query); // Execute the delete query

    // Check if the delete operation was successful
    if ($delete) {
        $message = 'Task successfully deleted!'; // Set success message
    } else {
        // Set error message if the delete operation fails, including the error from the database
        $message = 'Error deleting task: ' . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Delete Task</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external stylesheet -->
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Taskly</h1> <!-- Application title -->
            <p>Your Ultimate Task Management System</p> <!-- Application description -->
        </header>

        <div class="content">
            <?php if ($message): ?>
                <!-- Display success or error message based on the operation result -->
                <div class="success-message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Button to navigate back to the home page -->
            <button class="back-btn"><a href="index.php">Go Back to Home</a></button>
        </div>
    </div>
</body>

</html>