<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
    header("Location: ../login/login.html");
    exit;
}

$passenger_id = $_SESSION['user_id'];
$photo_url = $_SESSION['photo_url'] ?? '';
$name = $_SESSION['name'] ?? '';

// Fetch current passenger info
$stmt = $pdo->prepare("SELECT name, email FROM passenger WHERE passenger_id = ?");
$stmt->execute([$passenger_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = trim($_POST['name'] ?? '');
    $newEmail = trim($_POST['email'] ?? '');

    if (!empty($newName) && !empty($newEmail)) {
        $updateStmt = $pdo->prepare("UPDATE passenger SET name = ?, email = ? WHERE passenger_id = ?");
        $updateStmt->execute([$newName, $newEmail, $passenger_id]);
        $_SESSION['name'] = $newName;
        header("Location: view.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile - MatBuzz</title>
  <link rel="stylesheet" href="../homepage/home.css">
  <style>
    body { display: flex; margin: 0; font-family: 'Segoe UI', sans-serif; }
    .sidebar {
      width: 220px;
      background-color: #004080;
      color: white;
      height: 100vh;
      padding: 2rem 1rem;
      position: fixed;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 0.5rem;
      border-radius: 6px;
    }
    .sidebar a:hover {
      background-color: #007bff;
    }
    .main-content {
      margin-left: 220px;
      padding: 2rem;
      width: calc(100% - 220px);
    }
    .profile-pic {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #ffaa00;
      margin-bottom: 1rem;
    }
    form {
      max-width: 500px;
      background: #f1f1f1;
      padding: 20px;
      border-radius: 8px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="email"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <?php if ($photo_url): ?>
      <img src="../login/<?= htmlspecialchars($photo_url) ?>" alt="Profile Picture" class="profile-pic" />
    <?php endif; ?>
    <strong><?= htmlspecialchars($name) ?></strong>
    <a href="../home.php">🏠 Home</a>
    <a href="view.php">📋 My Reviews</a>
    <a href="profile_edit.php">✏️ Edit Info</a>
    <a href="../admin/admin1.php">🚌 Register as Owner</a>
    <a href="../login/logout.php">🚪 Logout</a>
  </div>

  <div class="main-content">
    <h1>Edit My Info</h1>
    <form method="POST">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

      <button type="submit">Update Info</button>
    </form>
  </div>
</body>
</html>
