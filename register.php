<?php
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
  if (empty($password) || strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters long.";
  }

  if (empty($errors)) {
    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $errors[] = "Email already registered.";
    } else {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

      $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $username, $hashedPassword);

      if ($stmt->execute()) {
        // Registration successful, redirect to login page
        header("Location: login.php");
        exit(); // Important: Call exit after header to stop further execution
      } else {
        $errors[] = "Error: " . $stmt->error;
      }
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
  <title>Register</title>
  <link rel="stylesheet" href="styles.css"> <!-- Link to the external CSS file -->
</head>

<body>
  <div class="container">
    <header class="header">
      <h1>Register</h1>
      <p>Create your account</p>
    </header>
    <form method="post" action="register.php" class="task-form">
      <label for="email">Email:</label>
      <input type="text" name="email" class="input" required>
      <label for="password">Password:</label>
      <input type="password" name="password" class="input" required>
      <button type="submit" class="btn-primary">Register</button>
    </form>
    <?php if (!empty($errors)): ?>
      <div class="error-message">
        <?php foreach ($errors as $error): ?>
          <p><?php echo $error; ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <p>Already have an account? <a href="login.php" class="view-btn">Login</a></p>
  </div>
</body>

</html>