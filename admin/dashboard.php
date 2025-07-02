<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
  header("Location: ../login/login.html");
  exit;
}

$owner_id = $_SESSION['user_id'];

if (!isset($_GET['reg'])) {
  echo "<p style='color:red;'>No matatu selected.</p>";
  exit;
}

$reg = $_GET['reg'];

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_matatu'])) {
    // Delete associated reviews
    $pdo->prepare("DELETE FROM reviews WHERE reg_number = ?")->execute([$reg]);
    // Delete from favourites
    $pdo->prepare("DELETE FROM favourites WHERE Reg_number = ?")->execute([$reg]);
    // Delete matatu
    $pdo->prepare("DELETE FROM matatu WHERE Reg_number = ? AND owner_id = ?")->execute([$reg, $owner_id]);

    header("Location: ../admin/owner_homepage.php");
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['route'])) {
    $route = trim($_POST['route']);
    $model = trim($_POST['model']);
    $drivers = trim($_POST['Driver_list']);
    $conductors = trim($_POST['Conductor_list']);

    $stmt = $pdo->prepare("UPDATE matatu SET route = ?, matatu_model = ?, Driver_list = ?, Conductor_list = ? WHERE Reg_number = ? AND owner_id = ?");
    $stmt->execute([$route, $model, $drivers, $conductors, $reg, $owner_id]);
    $message = "✅ Matatu updated.";
} elseif (isset($_POST['review_id'], $_POST['owner_response'])) {
    $stmt = $pdo->prepare("UPDATE reviews SET owner_response = ? WHERE review_id = ?");
    $stmt->execute([trim($_POST['owner_response']), $_POST['review_id']]);
}

// Fetch matatu
$stmt = $pdo->prepare("SELECT * FROM matatu WHERE Reg_number = ? AND owner_id = ?");
$stmt->execute([$reg, $owner_id]);
$matatu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$matatu) {
  echo "<p style='color:red;'>Matatu not found or not yours.</p>";
  exit;
}

// Fetch reviews
$reviewStmt = $pdo->prepare("SELECT r.*, p.name AS passenger_name FROM reviews r JOIN passenger p ON r.passenger_id = p.passenger_id WHERE r.reg_number = ? ORDER BY r.review_date DESC");
$reviewStmt->execute([$reg]);
$reviews = $reviewStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit <?= htmlspecialchars($reg) ?> - MatBuzz</title>
  <link rel="stylesheet" href="admin.css">
  <style>
    .container { max-width: 800px; margin: 40px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #fff; }
    .review { margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-left: 4px solid #007bff; }
    .reply { background: #e9f7e9; margin-top: 10px; padding: 10px; border-left: 4px solid green; }
    textarea { width: 100%; }
    .delete-btn {
      background: #d9534f;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 15px;
    }
    .delete-btn:hover {
      background-color: #c9302c;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Matatu: <?= htmlspecialchars($reg) ?></h1>
    <?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>

    <form method="POST">
      <label>Route:
        <input type="text" name="route" value="<?= htmlspecialchars($matatu['route']) ?>" required>
      </label><br><br>
      <label>Model:
        <input type="text" name="model" value="<?= htmlspecialchars($matatu['matatu_model']) ?>" required>
      </label><br><br>
      <label>Drivers:
        <input type="text" name="Driver_list" value="<?= htmlspecialchars($matatu['Driver_list']) ?>" required>
      </label><br><br>
      <label>Conductors:
        <input type="text" name="Conductor_list" value="<?= htmlspecialchars($matatu['Conductor_list']) ?>" required>
      </label><br><br>
      <button type="submit">Update</button>
    </form>

    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this matatu? This action cannot be undone.');">
      <input type="hidden" name="delete_matatu" value="1">
      <button type="submit" class="delete-btn">🗑️ Delete Matatu</button>
    </form>

    <h2>Reviews</h2>
    <?php if (empty($reviews)): ?>
      <p>No reviews yet.</p>
    <?php else: ?>
      <?php foreach ($reviews as $r): ?>
        <div class="review">
          <p><strong><?= htmlspecialchars($r['passenger_name']) ?></strong> (<?= htmlspecialchars($r['review_date']) ?>):</p>
          <p>Rating: <?= htmlspecialchars($r['rating']) ?>/5</p>
          <p><?= nl2br(htmlspecialchars($r['review'])) ?></p>

          <?php if (!empty($r['owner_response'])): ?>
            <div class="reply"><strong>Your Response:</strong><br><?= nl2br(htmlspecialchars($r['owner_response'])) ?></div>
          <?php else: ?>
            <form method="POST" style="margin-top:10px;">
              <input type="hidden" name="review_id" value="<?= $r['review_id'] ?>">
              <textarea name="owner_response" rows="2" placeholder="Write your reply..." required></textarea>
              <button type="submit" style="margin-top:5px;">Send Reply</button>
            </form>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
