<?php
require_once __DIR__ . '/../login/db_connect.php';

// Fetch all matatu data
$stmt = $pdo->query("SELECT Reg_number, SACCO, route FROM matatu");
$matatus = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Structure data: route → sacco → matatus
$matatuData = [];
foreach ($matatus as $m) {
  $route = $m['route'];
  $sacco = $m['SACCO'];
  $reg   = $m['Reg_number'];

  if (!isset($matatuData[$route])) $matatuData[$route] = [];
  if (!isset($matatuData[$route][$sacco])) $matatuData[$route][$sacco] = [];
  $matatuData[$route][$sacco][] = $reg;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rate a Matatu - MatBuzz</title>
  <link rel="stylesheet" href="review.css" />
  <style>
    select, input[type="range"], button {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
    }
    label { font-weight: bold; }
  </style>
</head>
<body>

  <header class="header">
    <div class="logo-title">
      <img src="images/logo.png" alt="MatBuzz Logo" class="logo">
      <h1>Rate a Matatu</h1>
    </div>
    <a href="../homepage/home.html" class="back-home-btn">Back to Home</a>
  </header>

  <div class="review-wrapper">
    <div class="review-image">
      <img src="images/side1.jpg" alt="Review Matatu">
    </div>

    <div class="review-form-section">
      <h2>Quick Rating</h2>
      <form action="anon_review.php" method="POST">
        <label for="route">Route</label>
        <select id="route" name="route" required>
          <option value="">-- Select Route --</option>
          <?php foreach (array_keys($matatuData) as $route): ?>
            <option value="<?= htmlspecialchars($route) ?>"><?= htmlspecialchars($route) ?></option>
          <?php endforeach; ?>
        </select>

        <label for="sacco">SACCO</label>
        <select id="sacco" name="sacco" required disabled>
          <option value="">-- Select SACCO --</option>
        </select>

        <label for="matatu">Matatu (Reg Number)</label>
        <select id="matatu" name="matatu" required disabled>
          <option value="">-- Select Matatu --</option>
        </select>

        <label for="rating">Rating (1 - 5): <span id="ratingValue">3</span></label>
        <input type="range" id="rating" name="rating" min="1" max="5" value="3" oninput="updateRatingValue(this.value)">

        <button type="submit">Submit Rating</button>
      </form>
    </div>
  </div>

  <script>
    const matatuData = <?= json_encode($matatuData) ?>;

    const routeSelect = document.getElementById('route');
    const saccoSelect = document.getElementById('sacco');
    const matatuSelect = document.getElementById('matatu');

    routeSelect.addEventListener('change', function () {
      const selectedRoute = this.value;
      saccoSelect.innerHTML = '<option value="">-- Select SACCO --</option>';
      matatuSelect.innerHTML = '<option value="">-- Select Matatu --</option>';
      matatuSelect.disabled = true;

      if (matatuData[selectedRoute]) {
        Object.keys(matatuData[selectedRoute]).forEach(sacco => {
          const option = document.createElement('option');
          option.value = sacco;
          option.textContent = sacco;
          saccoSelect.appendChild(option);
        });
        saccoSelect.disabled = false;
      } else {
        saccoSelect.disabled = true;
      }
    });

    saccoSelect.addEventListener('change', function () {
      const selectedRoute = routeSelect.value;
      const selectedSacco = this.value;
      matatuSelect.innerHTML = '<option value="">-- Select Matatu --</option>';

      if (matatuData[selectedRoute] && matatuData[selectedRoute][selectedSacco]) {
        matatuData[selectedRoute][selectedSacco].forEach(reg => {
          const option = document.createElement('option');
          option.value = reg;
          option.textContent = reg;
          matatuSelect.appendChild(option);
        });
        matatuSelect.disabled = false;
      } else {
        matatuSelect.disabled = true;
      }
    });

    function updateRatingValue(val) {
      document.getElementById('ratingValue').textContent = val;
    }
  </script>

</body>
</html>
