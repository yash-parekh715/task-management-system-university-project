<?php
session_start();
// Include database connection file
require_once "db_connect.php";
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Initialize variables for task details and message
$title = '';
$description = '';
$date = '';
$message = '';

// Check if ID is set in the URL to identify the todo item
if (isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];
    // Establish a connection to the database
    db();
    global $link;

    // Query to fetch the todo item by ID
    $query = "SELECT todoTitle, todoDescription, date FROM tasks WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    // Check if the result contains a row indicating the todo item exists
    if ($result && mysqli_num_rows($result) == 1) {
        // Fetch the row of the todo item
        $row = mysqli_fetch_array($result);
        if ($row) {
            // Sanitize output to prevent XSS and store in variables
            $title = htmlspecialchars($row['todoTitle']);
            $description = htmlspecialchars($row['todoDescription']);
            $date = htmlspecialchars($row['date']);
        }
    } else {
        // Set an error message if no todo item is found
        $message = 'No todo found with this ID.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Todo Details</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Taskly</h1>
            <p>Your Ultimate Task Management System</p>
        </header>

        <div class="content">
            <?php if ($message): ?>
                <!-- Display error message if no todo item is found -->
                <div class="error-message">
                    <?php echo $message; ?>
                </div>
            <?php else: ?>
                <!-- Display todo item details -->
                <h2><?php echo $title; ?></h2>
                <h3>Description</h3>
                <p><?php echo $description; ?></p>
                <small><?php echo $date; ?></small>
            <?php endif; ?>

            <!-- Button to navigate back to the home page -->
            <button class="back-btn"><a href="index.php">Go Back to Home</a></button>
        </div>
    </div>
</body>

</html>