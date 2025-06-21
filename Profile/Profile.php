<?php
require_once __DIR__ . '/../login/db_connect.php';

// ✅ Set Reg_number manually for testing
$reg = 'KAA 123A';

// 🔍 Fetch matatu by Reg_number
$stmt = $pdo->prepare("SELECT * FROM matatu WHERE Reg_number = ?");
$stmt->execute([$reg]);
$matatu = $stmt->fetch(PDO::FETCH_ASSOC);

if ($matatu):
    $drivers = explode(',', $matatu['Driver_list']);
    $conductors = explode(',', $matatu['Conductor_list']);
    $routes = explode(',', $matatu['route']);
    $photo = $matatu['matatu_photo'] ? 'uploads/' . $matatu['matatu_photo'] : 'placeholder.jpg';
?>

<div class="profile-header">
  <img src="<?= htmlspecialchars($photo) ?>" alt="Matatu Photo" />
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
  <strong>AVERAGE RATING:</strong> ★★★★☆
</div>

<div class="review-box">
  <strong>JOHN DOE:</strong> ★★★★★<br>
  Vehicle is well driven and maintained
</div>

<?php else: ?>
<p>No matatu found with Reg_number: <?= htmlspecialchars($reg) ?></p>
<?php endif; ?>
