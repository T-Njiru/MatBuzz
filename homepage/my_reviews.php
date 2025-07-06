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
  <meta charset="UTF-8" />
  <title>Your Profile - MatBuzz</title>
  <link rel="stylesheet" href="../homepage/home.css" />
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; padding: 0; }
    .container { max-width: 800px; margin: 100px auto 40px; background: white; padding: 20px; border-radius: 10px; }
    .profile-pic { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; display: block; margin: auto; }
    h2 { text-align: center; margin-top: 10px; }
    .reviews { margin-top: 30px; }
    .review-card { background: #f1f1f1; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
    .review-card strong { display: block; margin-bottom: 5px; }
    .owner-response {
      background: #e7f3ff;
      border-left: 4px solid #004080;
      padding: 10px;
      margin-top: 10px;
      font-style: italic;
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
    .delete-btn {
      background: #d9534f;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<header class="main-header">
  <div class="header-left">
    <img src="../homepage/pictures/logo.png" alt="MatBuzz Logo" class="logo" />
    <div class="site-title">
      <h1>MatBuzz</h1>
      <p class="tagline">All your reviews in one place!</p>
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

  <div class="reviews">
    <?php if (count($reviews) > 0): ?>
      <?php foreach ($reviews as $review): ?>
        <div class="review-card">
          <strong><?= htmlspecialchars($review['reg_number']) ?> (<?= htmlspecialchars($review['route']) ?>)</strong>
          <p><?= nl2br(htmlspecialchars($review['review'])) ?></p>
          <p>Rating: <?= $review['rating'] ?>/5</p>
          <small>Reviewed on <?= date("F j, Y", strtotime($review['review_date'])) ?></small>

          <?php if (!empty($review['owner_response'])): ?>
            <div class="owner-response">
              <strong>Owner Response:</strong><br>
              <?= nl2br(htmlspecialchars($review['owner_response'])) ?>
            </div>
          <?php else: ?>
            <div class="owner-response" style="background:#f9f9f9; border-color:#ccc;">No response yet.</div>
          <?php endif; ?>

          <form action="../review/delete_review.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
            <input type="hidden" name="reg_number" value="<?= htmlspecialchars($review['reg_number']) ?>">
            <input type="hidden" name="review_date" value="<?= htmlspecialchars($review['review_date']) ?>">
            <button type="submit" class="delete-btn">Delete Review</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No reviews yet.</p>
    <?php endif; ?>
  </div>

  <a href="../homepage/home.php" class="back-btn">⬅ Back to Home</a>
</div>
</body>
</html>
