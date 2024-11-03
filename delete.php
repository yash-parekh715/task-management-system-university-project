<?php
require_once "db_connect.php";

$message = ''; // Initialize message variable

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    db();
    global $link;
    $query = "DELETE FROM tasks WHERE id = '$id'";
    $delete = mysqli_query($link, $query);

    if ($delete) {
        $message = 'Task successfully deleted!'; // Set success message
    } else {
        $message = 'Error deleting task: ' . mysqli_error($link); // Set error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Delete Task</title>
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
                <div class="success-message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <button class="back-btn"><a href="index.php">Go Back to Home</a></button>
        </div>
    </div>
</body>

</html>