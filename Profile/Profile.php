<?php
require_once __DIR__ . '/../login/db_connect.php';

$reg = $_GET['reg'] ?? '';
$matatu = null;
$photo = 'placeholder.jpg';

if ($reg) {
    $stmt = $pdo->prepare("SELECT * FROM matatu WHERE Reg_number = ?");
    $stmt->execute([$reg]);
    $matatu = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!empty($matatu)) {
    $drivers = explode(',', $matatu['Driver_list']);
    $conductors = explode(',', $matatu['Conductor_list']);
    $routes = explode(',', $matatu['route']);
    $filename = $matatu['matatu_photo'];
    $fullPath = realpath(__DIR__ . '/../') . '/' . $filename;
    $photo = '../' . $filename;

    if (!empty($filename) && file_exists($fullPath)) {
        $photo = '../' . $filename;
    }

    // Fetch reviews for this matatu
    $reviewStmt = $pdo->prepare("SELECT r.*, p.name AS passenger_name FROM reviews r JOIN passenger p ON r.passenger_id = p.passenger_id WHERE r.reg_number = ? ORDER BY r.review_date DESC");
    $reviewStmt->execute([$reg]);
    $reviews = $reviewStmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate average rating
    $avgRating = 0;
    if (count($reviews) > 0) {
        $total = array_sum(array_column($reviews, 'rating'));
        $avgRating = round($total / count($reviews), 1);
    }

?>
<div class="profile-header">
  <img src="<?= htmlspecialchars($photo) ?>" alt="Matatu Photo" style="max-width: 300px;" />
  <div>
    <div class="info-box"><strong>MATATU OWNER:</strong> John DoE</div>
    <div class="info-box"><strong>MATATU SACCO:</strong> <?= htmlspecialchars($matatu['SACCO']) ?></div>
  </div>
</div>

<div class="lists">
  <div class="list-box">
    <strong>DRIVER LIST:</strong><br>
    <?php foreach ($drivers as $i => $driver): ?>
      <?= ($i+1) . '. ' . htmlspecialchars(trim($driver)) ?><br>
    <?php endforeach; ?>
  </div>

  <div class="list-box">
    <strong>CONDUCTOR LIST:</strong><br>
    <?php foreach ($conductors as $i => $conductor): ?>
      <?= ($i+1) . '. ' . htmlspecialchars(trim($conductor)) ?><br>
    <?php endforeach; ?>
  </div>

  <div class="list-box">
    <strong>ROUTE LIST:</strong><br>
    <?php foreach ($routes as $i => $route): ?>
      <?= ($i+1) . '. ' . htmlspecialchars(trim($route)) ?><br>
    <?php endforeach; ?>
  </div>
</div>

<div class="rating">
  <strong>AVERAGE RATING:</strong> <?= str_repeat("★", floor($avgRating)) ?><?= ($avgRating - floor($avgRating)) >= 0.5 ? "½" : "" ?> (<?= $avgRating ?>/5)
</div>

<?php if (count($reviews) > 0): ?>
  <?php foreach ($reviews as $review): ?>
    <div class="review-box">
      <strong><?= htmlspecialchars($review['passenger_name']) ?>:</strong>
      <?= str_repeat("★", $review['rating']) ?><?= str_repeat("☆", 5 - $review['rating']) ?><br>
      <?= htmlspecialchars($review['review']) ?><br>
      <small><em><?= date("F j, Y H:i", strtotime($review['review_date'])) ?></em></small>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="review-box">
    <em>No reviews yet for this matatu.</em>
  </div>
<?php endif; ?>

<?php
} else {
    echo "<p>⚠️ Matatu not found with Reg_number: " . htmlspecialchars($reg) . "</p>";
}
?>
