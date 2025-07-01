<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
    header("Location: ../login/login.html");
    exit;
}

$name = $_SESSION['name'] ?? '';
$photo_url = $_SESSION['photo_url'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Passenger Profile - MatBuzz</title>
  <link rel="stylesheet" href="view.css" />
  <style>
    body { display: flex; margin: 0; font-family: Arial, sans-serif; background: #f4f4f4; }
    .sidebar {
      width: 220px;
      background: #004080;
      color: white;
      height: 100vh;
      padding: 20px;
    }
    .sidebar h2 { font-size: 1.2rem; margin-bottom: 1rem; }
    .sidebar a {
      display: block;
      color: white;
      padding: 10px 0;
      text-decoration: none;
      font-weight: bold;
    }
    .sidebar a:hover {
      background: #0066cc;
      padding-left: 10px;
    }
    .main-content {
      flex: 1;
      padding: 30px;
    }
    .profile-pic {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid white;
      display: block;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <?php if ($photo_url): ?>
      <img src="../login/<?= htmlspecialchars($photo_url) ?>" alt="Profile Picture" class="profile-pic" />
    <?php endif; ?>
    <strong><?= htmlspecialchars($name) ?></strong>
    <a href="../homepage/home.php">🏠 Home</a>
    <a href="Profile_reviews.php">📋 My Reviews</a>
    <a href="profile_edit.php">✏️ Edit Info</a>
    <a href="../admin/admin1.php">🚌 Register as Owner</a>
    <a href="../login/logout.php">🚪 Logout</a>
  </div>


<div class="main-content">
  <h1>Welcome, <?= htmlspecialchars($name) ?> 👋</h1>
  <p>Use the menu on the left to view reviews, update your profile, or register as a matatu owner.</p>
</div>

</body>
</html>
