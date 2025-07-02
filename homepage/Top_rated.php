<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
  header("Location: ../login/login.html");
  exit;
}

$passenger_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
  SELECT m.Reg_number, m.SACCO, m.route, m.matatu_photo,
         AVG(r.rating) AS avg_rating
  FROM matatu m
  JOIN favourites f ON m.Reg_number = f.Reg_number
  LEFT JOIN reviews r ON m.Reg_number = r.reg_number
  WHERE f.passenger_id = ?
  GROUP BY m.Reg_number
  ORDER BY avg_rating IS NULL, avg_rating DESC
");
$stmt->execute([$passenger_id]);
$favs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Top Rated Favourites - MatBuzz</title>
  <link rel="stylesheet" href="../homepage/home.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .navbar {
      background-color: #004080;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.6rem 1.5rem;
      color: white;
    }

    .logo {
      height: 40px;
      width: auto;
      margin-right: 10px;
    }

    .nav-button {
      background-color: #ffaa00;
      padding: 8px 16px;
      color: black;
      text-decoration: none;
      font-weight: bold;
      border-radius: 6px;
    }

    .nav-button:hover {
      background-color: #ffc107;
    }

    .container {
      max-width: 1000px;
      margin: 2rem auto;
      padding: 1rem;
    }

    .matatu-card {
      background: white;
      padding: 1rem;
      margin-bottom: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .matatu-card img {
      width: 140px;
      height: 90px;
      object-fit: cover;
      border-radius: 6px;
    }

    .matatu-info {
      flex: 1;
    }

    .rating-stars {
      font-size: 1.2rem;
      color: gold;
      margin-top: 0.3rem;
      margin-bottom: 0.3rem;
    }

    h2 {
      text-align: center;
      margin-bottom: 1rem;
    }

    a {
      color: #004080;
      font-weight: bold;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div style="display: flex; align-items: center;">
      <img src="pictures/logo.png" alt="MatBuzz Logo" class="logo" />
      <span style="font-size: 1.2rem; font-weight: bold;">MatBuzz</span>
    </div>
    <a href="../homepage/home.php" class="nav-button">Home</a>
  </div>

  <div class="container">
    <h2>Your Favourite Matatus</h2>

    <?php if (count($favs) > 0): ?>
      <?php foreach ($favs as $matatu): ?>
        <div class="matatu-card">
          <img src="../<?= htmlspecialchars($matatu['matatu_photo']) ?>" alt="Matatu Photo">
          <div class="matatu-info">
            <div><strong><?= htmlspecialchars($matatu['Reg_number']) ?></strong> - <?= htmlspecialchars($matatu['SACCO']) ?> (<?= htmlspecialchars($matatu['route']) ?>)</div>
            <div class="rating-stars">
              <?php 
                $avg = $matatu['avg_rating']; 
                echo $avg ? str_repeat('★', floor($avg)) . (($avg - floor($avg)) >= 0.5 ? '½' : '') . " ({$avg}/5)" : 'No rating yet';
              ?>
            </div>
            <a href="../Profile/Profile1.php?reg=<?= urlencode($matatu['Reg_number']) ?>">View Profile</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center;">You haven’t favourited any matatus yet.</p>
    <?php endif; ?>
  </div>
</body>
</html>
