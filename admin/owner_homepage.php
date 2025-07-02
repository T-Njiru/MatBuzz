<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

// Check if owner is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: ../login/login.html");
    exit;
}

$owner_id = $_SESSION['user_id'];

// Fetch matatus for this owner
$sql = "SELECT Reg_number, matatu_photo FROM matatu WHERE owner_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$owner_id]);
$matatus = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner Homepage - MatBuzz</title>
  <link rel="stylesheet" href="../homepage/home.css">
  <style>
    .matatu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      padding: 20px;
    }
    .matatu-card {
      border: 1px solid #ccc;
      border-radius: 10px;
      padding: 10px;
      text-align: center;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .matatu-card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 10px;
    }
    .nav-links {
      text-align: right;
      padding: 10px 20px;
      background: #004080;
    }
    .nav-links a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header class="main-header">
    <div class="header-left">
      <img src="../homepage/pictures/logo.png" alt="MatBuzz Logo" class="logo" />
      <div class="site-title">
        <h1>MatBuzz</h1>
        <p class="tagline">Your Matatus in One Place</p>
      </div>
    </div>

    <!-- 🧭 Added Navbar with link to registration.php -->
    <nav class="nav-links">
      <a href="../admin/admin.html">+ Register New Matatu</a>
    </nav>
  </header>

  <h2 style="text-align:center; margin-top: 30px;">Your Registered Vehicles</h2>

  <div class="matatu-grid">
    <?php foreach ($matatus as $matatu): ?>
      <?php
        $imagePath = $matatu['matatu_photo'];
        if (!str_starts_with($imagePath, 'uploads/')) {
            $imagePath = 'homepage/pictures/' . basename($imagePath);
        }
      ?>
      <a href="../admin/dashboard.php?reg=<?= urlencode($matatu['Reg_number']) ?>">
        <div class="matatu-card">
          <img src="../<?= htmlspecialchars($imagePath) ?>" alt="Matatu Photo">
          <p><strong><?= htmlspecialchars($matatu['Reg_number']) ?></strong></p>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</body>
</html>
