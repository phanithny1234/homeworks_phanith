<?php
// Accessing POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $email = $_POST['email'];
  echo "Username: " . htmlspecialchars($username);
  echo "Email: " . htmlspecialchars($email);
}
?>