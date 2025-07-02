<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
  header("Location: ../login/login.html");
  exit;
}

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
$passenger_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Submit Review - MatBuzz</title>
  <link rel="stylesheet" href="review.css" />
  <style>
    select, textarea, input[type="range"], button {
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
      <h1>Submit a Review</h1>
    </div>
    <a href="../homepage/home.php" class="back-home-btn">Back to Home</a>
  </header>

  <div class="review-wrapper">
    <div class="review-image">
      <img src="images/side1.jpg" alt="Review Matatu">
    </div>

    <div class="review-form-section">
      <h2>Share Your Experience</h2>
      <form action="submit_review.php" method="POST">
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

        <button type="button" id="fav-btn" disabled>♥ Favourite This Matatu</button>

        <label for="review">Your Review</label>
        <textarea id="review" name="review" rows="4" required></textarea>

        <label for="rating">Rating (1 - 5): <span id="ratingValue">3</span></label>
        <input type="range" id="rating" name="rating" min="1" max="5" value="3" oninput="updateRatingValue(this.value)">

        <button type="submit">Submit Review</button>
      </form>
    </div>
  </div>

  <script>
    const matatuData = <?= json_encode($matatuData) ?>;

    const routeSelect = document.getElementById('route');
    const saccoSelect = document.getElementById('sacco');
    const matatuSelect = document.getElementById('matatu');
    const favBtn = document.getElementById('fav-btn');

    routeSelect.addEventListener('change', function () {
      const selectedRoute = this.value;
      saccoSelect.innerHTML = '<option value="">-- Select SACCO --</option>';
      matatuSelect.innerHTML = '<option value="">-- Select Matatu --</option>';
      matatuSelect.disabled = true;
      favBtn.disabled = true;

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
      favBtn.disabled = true;

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

    matatuSelect.addEventListener('change', () => {
      favBtn.disabled = matatuSelect.value === '';
    });

    favBtn.addEventListener('click', () => {
      const regNumber = matatuSelect.value;
      if (!regNumber) return;

      fetch('favourite.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `reg_number=${encodeURIComponent(regNumber)}`
      })
      .then(res => res.text())
      .then(alert);
    });

    function updateRatingValue(val) {
      document.getElementById('ratingValue').textContent = val;
    }
  </script>

</body>
</html>
