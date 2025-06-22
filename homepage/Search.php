<?php
require_once __DIR__ . '/../login/db_connect.php';

$query = trim($_GET['query'] ?? '');

$results = [];

if ($query !== '') {
    $stmt = $pdo->prepare("SELECT * FROM matatu WHERE Reg_number LIKE ? OR route LIKE ? OR SACCO LIKE ?");
    $searchTerm = "%$query%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MatBuzz - Search Results</title>
  <link rel="stylesheet" href="home.css">
</head>
<body>
  <header class="main-header">
    <h1>Search Results for "<?= htmlspecialchars($query) ?>"</h1>
    <a href="home.html">← Back to Home</a>
  </header>

  <div class="slider">
    <?php if (count($results) > 0): ?>
      <?php foreach ($results as $m): ?>
        <a href="../Profile/Profile1.php?reg=<?= urlencode($m['Reg_number']) ?>" class="matatu-card-link">
          <div class="matatu-card">
        <div class="matatu-card">
          <img src="<?= htmlspecialchars($m['matatu_photo'] ?? 'pictures/default.jpg') ?>" class="matatu-image" />
          <h3><?= htmlspecialchars($m['SACCO'] . ' ' . $m['Reg_number']) ?></h3>
          <p><strong>Route:</strong> <?= htmlspecialchars($m['route']) ?></p>
          <p><strong>Model:</strong> <?= htmlspecialchars($m['matatu_model']) ?></p>
          <p><strong>Rating:</strong> 4 / 5</p>
          <p><strong>Review:</strong> Sample review here</p>
        </div>
      </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No results found for "<?= htmlspecialchars($query) ?>".</p>
    <?php endif; ?>
  </div>
</body>
</html>
