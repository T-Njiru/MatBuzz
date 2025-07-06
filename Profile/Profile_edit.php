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

// Fetch user details
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
  <meta charset="UTF-8" />
  <title>Edit Profile - MatBuzz</title>
  <link rel="stylesheet" href="../homepage/home.css" />
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 0; }
    .container { max-width: 600px; margin: 100px auto 40px; background: white; padding: 20px; border-radius: 10px; }
    .profile-pic { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; display: block; margin: auto; }
    h2 { text-align: center; margin-top: 10px; }
    form { margin-top: 30px; }
    label { font-weight: bold; display: block; margin-top: 15px; }
    input[type="text"], input[type="email"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      margin-top: 20px;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      display: block;
      width: 100%;
    }
    button:hover {
      background-color: #0056b3;
    }
    .back-btn {
      display: block;
      margin: 20px auto 0;
      text-align: center;
      background: #007bff;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      width: fit-content;
    }
  </style>
</head>
<body>

<header class="main-header">
  <div class="header-left">
    <img src="../homepage/pictures/logo.png" alt="MatBuzz Logo" class="logo" />
    <div class="site-title">
      <h1>MatBuzz</h1>
      <p class="tagline">Edit your profile information</p>
    </div>
  </div>
  <nav class="nav-links">
    <a href="../homepage/home.php">Home</a>
    <a href="../review/review.php">Submit Review</a>
  </nav>
</header>

<div class="container">
  <?php if ($photo_url): ?>
    <img src="../login/<?= htmlspecialchars($photo_url) ?>" alt="Profile Picture" class="profile-pic" />
  <?php endif; ?>
  <h2><?= htmlspecialchars($name) ?></h2>

  <form method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <button type="submit">Update Info</button>
  </form>

  <a href="../homepage/home.php" class="back-btn">⬅ Back to Home</a>
</div>

</body>
</html>
