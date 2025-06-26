<?php
require_once 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($email) || empty($password) || empty($role)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $table = ($role === 'owner') ? 'Owner' : 'Passenger';
    $idField = ($role === 'owner') ? 'owner_id' : 'passenger_id';

    $stmt = $pdo->prepare("SELECT * FROM $table WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user[$idField];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = strtolower($table);
        $_SESSION['email'] = $user['email'];

        // ✅ Profile picture setup with full relative path
       if ($role === 'passenger') {
    $_SESSION['photo_url'] = !empty($user['photo_url']) ? $user['photo_url'] : 'uploads/default_profile.jpg';
}


        if ($role === 'owner') {
            header("Location: Verification.php?email=" . urlencode($email));
            exit;
        }

        header("Location: /MatBuzz/homepage/home.php");
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    exit;
}
?>
