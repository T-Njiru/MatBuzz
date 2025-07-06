<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
    header("Location: ../login/login.html");
    exit;
}

$name = $_SESSION['name'] ?? '';
$photo_url = $_SESSION['photo_url'] ?? '';
$isPassenger = isset($_SESSION['role']) && $_SESSION['role'] === 'passenger';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MatBuzz - Home</title>
  <link rel="stylesheet" href="home.css">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background: #f4f4f4; display: flex; }
    .sidebar {
      width: 230px;
      background: #004080;
      color: white;
      height: 100vh;
      padding: 20px;
      position: fixed;
    }
    .sidebar a {
      display: block;
      color: white;
      padding: 10px 0;
      text-decoration: none;
      font-weight: bold;
    }
    .sidebar a:hover {
      background: #0066cc;
      padding-left: 10px;
    }
    .profile-pic {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid white;
      margin-bottom: 15px;
    }
    .main-content {
      margin-left: 230px;
      flex: 1;
      padding: 0px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <?php if (!empty($photo_url)): ?>
    <img src="../login/<?= htmlspecialchars($photo_url) ?>" alt="Profile Picture" class="profile-pic" />
  <?php endif; ?>
  <strong><?= htmlspecialchars($name) ?></strong>
  <a href="home.php">🏠 Home</a>
  <a href="../homepage/my_reviews.php">📋 My Reviews</a>
  <a href="../Profile/profile_edit.php">✏️ Edit Info</a>
  <a href="../admin/admin1.php">🚌 Register as Owner</a>
  <a href="../homepage/top_rated.php">⭐ Top Rated</a>
  <a href="../review/review.php">✍️ Submit Review</a>
  <a href="../login/logout.php">🚪 Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">

  <header class="main-header">
    <div class="header-left">
      <img src="pictures/logo.png" alt="MatBuzz Logo" class="logo" />
      <div class="site-title">
        <h1>MatBuzz</h1>
        <p class="tagline">Rate & Review Matatus Across Kenya</p>
      </div>
    </div>
  </header>

  <div class="hero-section">
    <img src="pictures/hero1.jpg" alt="Welcome to MatBuzz">
    <div class="hero-text">
      <h2>Welcome to MatBuzz</h2>
      <p>Discover honest reviews and ratings for matatus in Kenya. Empower your commute with real feedback from real people.</p>
    </div>
  </div>

  <form class="search-bar" method="GET" action="search.php">
    <input type="text" name="query" placeholder="Search Matatus by name or route..." required>
    <button type="submit">Search</button>
  </form>

  <section id="featured" class="scroll-container" data-aos="fade-up">
    <h2 class="section-title">Featured Matatus</h2>
    <div class="slider">

      <a href="../Profile/Profile1.php?reg=KDA005A" class="matatu-card">
        <img src="pictures/matatu3.jpeg" alt="Forward Travellers 005" class="matatu-image">
        <h3>Forward Travellers 005</h3>
        <p><strong>Route:</strong> Nairobi - Rongai</p>
        <p><strong>Rating:</strong> 4 / 5</p>
        <p><strong>Review:</strong> Clean interior, good music.</p>
      </a>

      <a href="../Profile/Profile1.php?reg=KDA302B" class="matatu-card">
        <img src="pictures/matatu1.jpeg" alt="Super Metro 302" class="matatu-image">
        <h3>Super Metro 302</h3>
        <p><strong>Route:</strong> Nairobi - Umoja</p>
        <p><strong>Rating:</strong> 3 / 5</p>
        <p><strong>Review:</strong> Affordable but crowded.</p>
      </a>

      <a href="../Profile/Profile1.php?reg=KDC222C" class="matatu-card">
        <img src="pictures/matatu2.jpeg" alt="Nazigi Sacco 222" class="matatu-image">
        <h3>Nazigi Sacco 222</h3>
        <p><strong>Route:</strong> CBD - Githurai 45</p>
        <p><strong>Rating:</strong> 5 / 5</p>
        <p><strong>Review:</strong> Fast and respectful driver.</p>
      </a>

      <a href="../Profile/Profile1.php?reg=KDE909D" class="matatu-card">
        <img src="pictures/matatu4.jpeg" alt="Zuri Express 909" class="matatu-image">
        <h3>Zuri Express 909</h3>
        <p><strong>Route:</strong> Nairobi - Donholm</p>
        <p><strong>Rating:</strong> 4 / 5</p>
        <p><strong>Review:</strong> Smooth ride and polite crew.</p>
      </a>

    </div>
  </section>

  <section class="testimonials" data-aos="fade-up">
    <h2>What People Are Saying</h2>
    <div class="testimonial-card" data-aos="fade-right">"I love using MatBuzz to decide which matatu to take!” — Joy M.</div>
    <div class="testimonial-card" data-aos="fade-left">“Great to leave honest reviews for my commute.” — Kevin K.</div>
    <div class="testimonial-card" data-aos="fade-up">“Easy to use and helpful.” — Sharon A.</div>
  </section>

  <section class="why-matbuzz" data-aos="fade-up">
    <h2>Why Use MatBuzz?</h2>
    <div class="features">
      <div class="feature">
        <h4>Honest Reviews</h4>
        <p>Genuine feedback from real passengers to guide your journey.</p>
      </div>
      <div class="feature">
        <h4>Reliable Ratings</h4>
        <p>Get clarity before you hop on board.</p>
      </div>
      <div class="feature">
        <h4>Know Before You Go</h4>
        <p>Stay informed about your daily routes and options.</p>
      </div>
      <div class="feature">
        <h4>Community Driven</h4>
        <p>Built for commuters, by commuters.</p>
      </div>
    </div>
  </section>

  <section class="news-section" data-aos="fade-up">
    <h2>Matatu News & Notices</h2>
    <ul>
      <li>⚠️ New traffic regulations starting July 1st.</li>
      <li>📢 SACCO registration open till June 30.</li>
      <li>🛠️ Super Metro 302 under maintenance.</li>
    </ul>
  </section>

  <footer class="footer">
    <div class="footer-links">
      <a href="#about">About</a>
      <a href="privacy.html">Privacy Policy</a>
      <a href="contact.html">Contact</a>
      <a href="help.html">Help</a>
    </div>
    <p>© 2025 MatBuzz. All rights reserved.</p>
  </footer>

</div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
