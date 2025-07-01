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

// Prepare the query using PDO
$stmt = $pdo->prepare("
    SELECT r.review, r.rating, r.review_date, r.reg_number, r.owner_response, m.route
    FROM reviews r
    JOIN matatu m ON r.reg_number = m.Reg_number
    WHERE r.passenger_id = ?
    ORDER BY r.review_date DESC
");
$stmt->execute([$passenger_id]);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Passenger Profile - MatBuzz</title>
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
    .review-card {
      background: #f1f1f1;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .review-card strong { display: block; margin-bottom: 5px; }
    .review-card .response { background: #fff; padding: 10px; border-left: 4px solid #ffaa00; margin-top: 10px; border-radius: 4px; }
  </style>
</head>
<body>
  <div class="sidebar">
    <?php if ($photo_url): ?>
      <img src="../login/<?= htmlspecialchars($photo_url) ?>" alt="Profile Picture" class="profile-pic" />
    <?php endif; ?>
    <strong><?= htmlspecialchars($name) ?></strong>
    <a href="../homepage/home.php">🏠 Home</a>
    <a href="view.php">📋 My Reviews</a>
    <a href="profile_edit.php">✏️ Edit Info</a>
    <a href="../admin/admin1.php">🚌 Register as Owner</a>
    <a href="../login/logout.php">🚪 Logout</a>
  </div>

  <div class="main-content">
    <h1>My Reviews</h1>
    <?php if (count($reviews) > 0): ?>
      <?php foreach ($reviews as $review): ?>
        <div class="review-card">
          <strong><?= htmlspecialchars($review['reg_number']) ?> (<?= htmlspecialchars($review['route']) ?>)</strong>
          <p><?= htmlspecialchars($review['review']) ?></p>
          <p>Rating: <?= $review['rating'] ?>/5</p>
          <small>Reviewed on <?= date("F j, Y", strtotime($review['review_date'])) ?></small>
          <?php if (!empty($review['owner_response'])): ?>
            <div class="response">
              <strong>Owner Response:</strong>
              <p><?= nl2br(htmlspecialchars($review['owner_response'])) ?></p>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No reviews yet.</p>
    <?php endif; ?>
  </div>
</body>
</html>
