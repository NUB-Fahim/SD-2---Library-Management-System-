<?php
$conn = new mysqli("localhost", "root", "", "nub_library_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {

    echo ($user['role'] === 'admin') ? "admin" : "user";
  } else {
    echo "Invalid password!";
  }
} else {
  echo "User not found!";
}

$stmt->close();
$conn->close();
?>
