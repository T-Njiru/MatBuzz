<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
  header("Location: ../login/login.html");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Submit Review - MatBuzz</title>
  <link rel="stylesheet" href="review.css" />
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
        <label for="matatu-name">Matatu Plate No. (Reg Number)</label>
        <input type="text" id="matatu-name" name="matatu" required>

        <label for="review">Your Review</label>
        <textarea id="review" name="review" rows="4" required></textarea>

        <label for="rating">Rating (1 - 5): <span id="ratingValue">3</span></label>
        <input type="range" id="rating" name="rating" min="1" max="5" value="3" oninput="updateRatingValue(this.value)">

        <button type="submit">Submit Review</button>
      </form>
    </div>
  </div>

  <script>
    function updateRatingValue(val) {
      document.getElementById('ratingValue').textContent = val;
    }
  </script>

</body>
</html>
