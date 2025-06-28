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
    SELECT r.review, r.rating, r.review_date, r.reg_number, m.route
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
  <meta charset="UTF-8" />
  <title>Your Profile - MatBuzz</title>
  <link rel="stylesheet" href="view.css" />
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; background: #f9f9f9; }
    .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
    .profile-pic { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; display: block; margin: auto; }
    h2 { text-align: center; margin-top: 10px; }
    .reviews { margin-top: 30px; }
    .review-card { background: #f1f1f1; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
    .review-card strong { display: block; margin-bottom: 5px; }
    .register-driver { text-align: center; margin-top: 30px; }
    .register-driver a { color: #007bff; text-decoration: none; font-weight: bold; }
    .logout-btn { display: block; margin: 40px auto 0; padding: 10px 20px; background: #d9534f; color: white; border: none; border-radius: 5px; cursor: pointer; text-align: center; text-decoration: none; width: fit-content; }
  </style>
</head>
<body>
  <div class="container">
    <?php if ($photo_url): ?>
      <img src="../login/<?= htmlspecialchars($photo_url) ?>" alt="Profile Picture" class="profile-pic" />
    <?php endif; ?>
    <h2><?= htmlspecialchars($name) ?>'s Reviews</h2>

    <div class="reviews">
      <?php if (count($reviews) > 0): ?>
        <?php foreach ($reviews as $review): ?>
          <div class="review-card">
            <strong><?= htmlspecialchars($review['reg_number']) ?> (<?= htmlspecialchars($review['route']) ?>)</strong>
            <p><?= htmlspecialchars($review['review']) ?></p>
            <p>Rating: <?= $review['rating'] ?>/5</p>
            <small>Reviewed on <?= date("F j, Y", strtotime($review['review_date'])) ?></small>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No reviews yet.</p>
      <?php endif; ?>
    </div>

    <div class="register-driver">
      <p><a href="../login/register.html">Register as a driver?</a></p>
    </div>

    <a href="../login/logout.php" class="logout-btn">Logout</a>
  </div>
</body>
</html>
