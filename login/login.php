<?php
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($email) || empty($password) || empty($role)) {
        die("All fields are required.");
    }

    $table = ($role === 'owner') ? 'Owner' : 'Passenger';
    $idField = ($role === 'owner') ? 'owner_id' : 'passenger_id';

    $stmt = $pdo->prepare("SELECT * FROM $table WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        // Save session data
        $_SESSION['user_id'] = $user[$idField];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = strtolower($table);
        $_SESSION['email'] = $user['email'];

        // Handle profile picture
        if (strtolower($table) === 'passenger') {
            if (!empty($user['photo_url'])) {
                $_SESSION['photo_url'] = $user['photo_url']; // should be 'uploads/filename.jpg'
            } else {
                $_SESSION['photo_url'] = 'uploads/default_profile.jpg';
            }
        }

        if ($role === 'owner') {
            header("Location: Verification.php?email=" . urlencode($email));
            exit;
        } else {
            header("Location: /MatBuzz/homepage/home.php");
            exit;
        }
    }

    die("Invalid email or password.");
}
?>
