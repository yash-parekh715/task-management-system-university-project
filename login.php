<?php
session_start(); // Start the session
require_once('db_connect.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['email']);
  $password = trim($_POST['password']);
  $errors = [];

  // Validate email
  if (empty($username) || !filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  }

  // Validate password
  if (empty($password)) {
    $errors[] = "Password cannot be empty.";
  }

  if (empty($errors)) {
    // Check if the email exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      // Verify the password
      if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        // Redirect to the task management page
        header("Location: index.php");
        exit();
      } else {
        $errors[] = "Invalid password.";
      }
    } else {
      $errors[] = "No account found with that email.";
    }

    $stmt->close();
  }
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css"> <!-- Link to the external CSS file -->
</head>

<body>
  <div class="container">
    <header class="header">
      <h1>Login</h1>
      <p>Welcome back! Please log in to your account.</p>
    </header>
    <form method="post" action="login.php" class="task-form">
      <label for="email">Email:</label>
      <input type="text" name="email" class="input" required>
      <label for="password">Password:</label>
      <input type="password" name="password" class="input" required>
      <button type="submit" class="btn-primary">Login</button>
    </form>
    <?php if (!empty($errors)): ?>
      <div class="error-message">
        <?php foreach ($errors as $error): ?>
          <p><?php echo $error; ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <p>Don't have an account? <a href="register.php" class="view-btn">Register</a></p>
  </div>
</body>

</html>