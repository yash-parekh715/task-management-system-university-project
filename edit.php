<?php
session_start();
// Include the database connection file
require_once 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Initialize variables for title, description, and message
$title = '';
$description = '';
$message = '';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the ID from the URL
    $id = $_GET['id'];
    // Establish a connection to the database
    db();
    global $link; // Make the database link accessible

    // Query to fetch the todo item by ID
    $query = "SELECT todoTitle, todoDescription FROM tasks WHERE id = '$id'";
    $result = mysqli_query($link, $query); // Execute the query

    // Check if a task was found
    if (mysqli_num_rows($result) == 1) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_array($result);
        if ($row) {
            // Sanitize output for security
            $title = htmlspecialchars($row['todoTitle']);
            $description = htmlspecialchars($row['todoDescription']);
        }
    } else {
        // Set message if no task is found
        $message = 'No task found!';
    }

    // Handle form submission for editing the task
    if (isset($_POST['submit'])) {
        // Get the updated title and description from the form
        $title = $_POST['title'];
        $description = $_POST['description'];
        db(); // Re-establish the database connection

        // Query to update the task in the database
        $query = "UPDATE tasks SET todoTitle = '$title', todoDescription = '$description' WHERE id = '$id'";
        $updateTask = mysqli_query($link, $query); // Execute the update query

        // Check if the update was successful
        if ($updateTask) {
            // Success message if the task was updated
            $message = "<p style='color: #3c763d;'>Task updated successfully!</p>";
        } else {
            // Error message if the update failed
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
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS stylesheet -->
    <style>
        /* Inline styles for body background and margin */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            /* Light grey background */
            margin: 0;
            padding: 0;
        }

        /* Container for the form and header */
        .container {
            max-width: 600px;
            /* Maximum width for the container */
            margin: 50px auto;
            /* Center the container */
            padding: 20px;
            /* Padding inside the container */
            background-color: #ffffff;
            /* White background for the container */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        .header {
            text-align: center;
            /* Center align header text */
            margin-bottom: 20px;
            /* Space below the header */
        }

        h1 {
            color: #4a90e2;
            /* Blue color for the title */
            margin: 0;
            /* Remove margin */
        }

        form {
            display: flex;
            /* Use flexbox for the form layout */
            flex-direction: column;
            /* Arrange items in a column */
            gap: 1rem;
            /* Space between form elements */
        }

        label {
            font-size: 0.9rem;
            /* Font size for labels */
            color: #555;
            /* Dark grey color for labels */
        }

        /* Styles for input and textarea fields */
        input[type="text"],
        textarea {
            padding: 0.8rem;
            /* Padding inside the fields */
            border: 1px solid #ddd;
            /* Light grey border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 1rem;
            /* Font size */
            outline: none;
            /* Remove outline on focus */
            transition: border 0.3s ease;
            /* Smooth border transition */
        }

        /* Change border color on focus */
        input[type="text"]:focus,
        textarea:focus {
            border-color: #4a90e2;
            /* Blue border on focus */
        }

        button {
            padding: 0.8rem;
            /* Padding inside the button */
            background-color: #4a90e2;
            /* Blue background for the button */
            color: #ffffff;
            /* White text */
            border: none;
            /* Remove border */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 1rem;
            /* Font size */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: background 0.3s ease;
            /* Smooth background transition */
        }

        /* Change background color on button hover */
        button:hover {
            background-color: #357ABD;
            /* Darker blue on hover */
        }

        .message {
            text-align: center;
            /* Center align messages */
            margin-top: 1rem;
            /* Space above the message */
        }

        /* Styles for the back button */
        .back-btn {
            display: block;
            /* Block-level element */
            margin: 20px auto 0;
            /* Center with margin */
            text-decoration: none;
            /* Remove underline from link */
            color: #ffffff;
            /* White text for the link */
            background-color: #4a90e2;
            /* Blue background */
            padding: 0.8rem;
            /* Padding for button */
            border-radius: 5px;
            /* Rounded corners */
            text-align: center;
            /* Center align text */
            transition: background 0.3s ease;
            /* Smooth background transition */
        }

        /* Change background color on back button hover */
        .back-btn:hover {
            background-color: #357ABD;
            /* Darker blue on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <h1>Edit Task</h1> <!-- Page title -->
        </header>

        <!-- Display any message (success or error) -->
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Form for editing the task -->
        <form action='edit.php?id=<?php echo $id; ?>' method='post'>
            <label for='title'>Task Title</label>
            <input type='text' name='title' value='<?php echo $title; ?>' placeholder='Edit title' required>

            <label for='description'>Task Description</label>
            <textarea name='description' placeholder='Edit description' required><?php echo $description; ?></textarea>

            <button type='submit' name='submit'>Save Changes</button> <!-- Submit button -->
        </form>

        <!-- Link to go back to the home page -->
        <a class="back-btn" href="index.php">Go Back to Home</a>
    </div>
</body>

</html>