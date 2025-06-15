<?php
require 'users.php'; // Load fake users

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (isset($users[$username]) && $users[$username] === $password) {
    echo "Welcome, " . htmlspecialchars($username) . "!";
} else {
    echo "Invalid username or password.";
}
?>
