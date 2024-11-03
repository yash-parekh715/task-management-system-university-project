<?php
require_once "db_connect.php";

$title = '';
$description = '';
$date = '';
$message = '';

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    db();
    global $link;

    // Query to fetch the todo item by ID
    $query = "SELECT todoTitle, todoDescription, date FROM tasks WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    // Check if the result contains a row
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        if ($row) {
            $title = htmlspecialchars($row['todoTitle']);
            $description = htmlspecialchars($row['todoDescription']);
            $date = htmlspecialchars($row['date']);
        }
    } else {
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
                <div class="error-message">
                    <?php echo $message; ?>
                </div>
            <?php else: ?>
                <h2><?php echo $title; ?></h2>
                <h3>Description</h3>
                <p><?php echo $description; ?></p>
                <small><?php echo $date; ?></small>
            <?php endif; ?>

            <button class="back-btn"><a href="index.php">Go Back to Home</a></button>
        </div>
    </div>
</body>

</html>