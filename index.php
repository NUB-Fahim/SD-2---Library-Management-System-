<?php
// Start session to check if user is already logged in
session_start();

// If user is already logged in, redirect to their respective dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: user_dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NUB Library Management System</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body data-page="index">

  <div class="main-container">
    <div class="info-box">
      <h1>📚 NUB Library Management System</h1>
      <h2>Northern University Bangladesh</h2>
      <p>Our digital library system helps students and faculty easily access, borrow, and manage books.
      A smart step toward a paperless academic environment, promoting reading and research anytime, anywhere.</p>
    </div>

    <div class="form-container">
      <!-- Login Form -->
      <div class="form-box" id="login-box">
        <h3>Login</h3>
        <form id="loginForm" action="login.php" method="POST">
          <input type="email" name="email" placeholder="Email" required />
          <input type="password" name="password" placeholder="Password" required />
          <button type="submit">Login</button>
          <a href="#" class="forgot">Forgot Password?</a>
          <p class="switch-form">Don't have an account? <span onclick="toggleForms()">Sign Up</span></p>
        </form>
      </div>

      <!-- Sign Up Form -->
      <div class="form-box" id="signup-box" style="display: none;">
        <h3>Sign Up</h3>
        <form id="signupForm" action="signup.php" method="POST">
          <input type="text" name="fullname" placeholder="Full Name" required />
          <input type="email" name="email" placeholder="Email" required />
          <input type="password" name="password" placeholder="Password" required />

          <select id="roleSelect" name="role" required>
            <option value="">Select Role</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>

          <input type="password" id="adminPin" name="admin_pin" placeholder="Admin Security PIN" style="display: none;" />

          <button type="submit">Create Account</button>
          <p class="switch-form">Already have an account? <span onclick="toggleForms()">Login</span></p>
        </form>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>