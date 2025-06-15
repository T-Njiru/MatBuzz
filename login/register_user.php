<?php
require_once 'db_connect.php'; // Make sure this connects properly

// Get form inputs
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$sacco = $_POST['sacco'] ?? null;
$role = $_POST['role'] ?? 'commuter';
$profilePic = $_FILES['profile_pic'] ?? null;

// Validate input
if (!$name || !$email || !$password || ($role === 'owner' && !$sacco)) {
    exit("❌ Missing required fields.");
}

// Hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Handle profile picture upload
$photo_url = null;
if ($profilePic && $profilePic['error'] === 0) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileExt = pathinfo($profilePic['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . "." . $fileExt;
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($profilePic['tmp_name'], $targetPath)) {
        $photo_url = $targetPath;
    } else {
        exit("❌ Failed to upload profile picture.");
    }
}

try {
    if ($role === 'commuter') {
        $stmt = $pdo->prepare("INSERT INTO Passenger (name, email, password_hash, photo_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $passwordHash, $photo_url]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO Owner (name, email, password_hash, photo_url, sacco) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $passwordHash, $photo_url, $sacco]);
    }

    // Redirect to email verification
    header('Location: welcome.php?email=' . urlencode($email));
    exit();

} catch (Exception $e) {
    exit("❌ Registration failed: " . $e->getMessage());
}
