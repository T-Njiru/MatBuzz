<?php
// Optional: session_start(); if needed for logged-in state
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Reviews - MatBuzz</title>
  <link rel="stylesheet" href="all_reviews.css" />
</head>
<body>

  <header class="main-header">
    <div class="header-left">
      <img src="pictures/logo.png" alt="MatBuzz Logo" class="logo" />
      <div class="site-title">
        <h1>MatBuzz</h1>
        <p class="tagline">Rate & Review Matatus Across Kenya</p>
      </div>
    </div>

    <nav class="nav-links">
      <a href="home.php#featured">Home</a>
      <a href="#">Top Rated</a>
      <a href="review/review.php">Submit Review</a>
      <div class="auth-buttons">
        <a href="../login/login.html" class="login-btn">Login</a>
        <a href="../login/register.html" class="signup-btn">Sign Up</a>
      </div>
    </nav>
  </header>

  <main class="review-page">
    <h2>All Reviews</h2>

    <section class="filter-section">
      <input type="text" id="routeFilter" placeholder="Filter by Route" />
      <select id="ratingFilter">
        <option value="">Filter by Rating</option>
        <option value="5">5 - Excellent</option>
        <option value="4">4 - Good</option>
        <option value="3">3 - Average</option>
        <option value="2">2 - Poor</option>
        <option value="1">1 - Terrible</option>
      </select>
      <button id="applyFilters">Apply</button>
    </section>

    <section class="review-cards">
      <?php include 'fetch_reviews.php'; ?>
    </section>
  </main>

  <footer class="footer">
    <div class="footer-links">
      <a href="home.php">Home</a>
      <a href="privacy.html">Privacy Policy</a>
      <a href="contact.html">Contact</a>
      <a href="help.html">Help</a>
    </div>
    <p>© 2025 MatBuzz. All rights reserved.</p>
  </footer>

</body>
</html>
