<?php
$conn = new mysqli("localhost", "root", "", "nub_library_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];  
$admin_pin = $_POST['admin_pin'];

if ($role == 'admin' && $admin_pin != '1234') {
  echo "Invalid admin PIN.";
  exit;
}

$stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $full_name, $email, $password, $role);

if ($stmt->execute()) {
  echo "success";
} else {
  echo "Something went wrong!";
}

$stmt->close();
$conn->close();
?>
