<?php
require_once 'db_connect.php';

$title = '';
$description = '';
$message = '';

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    db();
    global $link;

    // Query to fetch the todo item by ID
    $query = "SELECT todoTitle, todoDescription FROM tasks WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        if ($row) {
            $title = htmlspecialchars($row['todoTitle']);
            $description = htmlspecialchars($row['todoDescription']);
        }
    } else {
        $message = 'No task found!';
    }

    // Handle form submission for editing the task
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        db();

        // Update the task in the database
        $query = "UPDATE tasks SET todoTitle = '$title', todoDescription = '$description' WHERE id = '$id'";
        $updateTask = mysqli_query($link, $query);

        // Check if the update was successful
        if ($updateTask) {
            $message = "<p style='color: #3c763d;'>Task updated successfully!</p>";
        } else {
            $message = "<p style='color: #a94442;'>" . mysqli_error($link) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task - Taskly</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #4a90e2;
            margin: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-size: 0.9rem;
            color: #555;
        }

        input[type="text"],
        textarea {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #4a90e2;
        }

        button {
            padding: 0.8rem;
            background-color: #4a90e2;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #357ABD;
        }

        .message {
            text-align: center;
            margin-top: 1rem;
        }

        .back-btn {
            display: block;
            margin: 20px auto 0;
            text-decoration: none;
            color: #ffffff;
            background-color: #4a90e2;
            padding: 0.8rem;
            border-radius: 5px;
            text-align: center;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background-color: #357ABD;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Edit Task</h1>
        </header>

        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action='edit.php?id=<?php echo $id; ?>' method='post'>
            <label for='title'>Task Title</label>
            <input type='text' name='title' value='<?php echo $title; ?>' placeholder='Edit title' required>

            <label for='description'>Task Description</label>
            <textarea name='description' placeholder='Edit description' required><?php echo $description; ?></textarea>

            <button type='submit' name='submit'>Save Changes</button>
        </form>

        <a class="back-btn" href="index.php">Go Back to Home</a>
    </div>
</body>

</html>