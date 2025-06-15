<?php
require_once 'db_connect.php'; // makes $pdo available

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Check both tables: Passenger and Owner
    $tables = ['Passenger' => 'passenger_id', 'Owner' => 'owner_id'];
    $found = false;

    foreach ($tables as $table => $idField) {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            $found = true;
            session_start();
            $_SESSION['user_id'] = $user[$idField];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = strtolower($table); // passenger or owner

            echo json_encode(['success' => true, 'message' => 'Login successful', 'role' => strtolower($table)]);
            exit;
        }
    }

    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    exit;
}
?>
