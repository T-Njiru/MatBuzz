<?php
session_start();
$isPassenger = isset($_SESSION['role']) && $_SESSION['role'] === 'passenger';
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MatBuzz - Home</title>
    <link rel="stylesheet" href="home.css" />
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
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
        <a href="#featured">Home</a>
        <a href="#">All Reviews</a>
        <a href="#">Top Rated</a>
        <a href="../review/review.php">Submit Review</a>

        <div class="auth-buttons">
  <?php if ($isPassenger): ?>
    <a href="../profile/view.php">
      <img src="<?= htmlspecialchars($_SESSION['photo_url'] ?? 'default_profile.jpg') ?>" class="profile-pic" />
    </a>


  <?php else: ?>
    <a href="../login/login.html" class="login-btn">Login</a>
    <a href="../login/register.html" class="signup-btn">Sign Up</a>
  <?php endif; ?>
</div>

      </nav>
    </header>

    <div class="hero-section">
      <img src="pictures/hero1.jpg" alt="Welcome to MatBuzz" />
      <div class="hero-text">
        <h2>Welcome to MatBuzz</h2>
        <p>
          Discover honest reviews and ratings for matatus in Kenya. Empower your
          commute with real feedback from real people.
        </p>
      </div>
    </div>

    <form class="search-bar" method="GET" action="search.php">
  <input type="text" name="query" placeholder="Search Matatus by name or route..." required />
  <button type="submit">Search</button>
</form>


    <section id="featured" <section class="scroll-container" data-aos="fade-up">
      <h2 class="section-title">Featured Matatus</h2>
      <div class="slider">
        <div class="matatu-card">
          <img
            src="pictures/matatu3.jpeg"
            alt="Forward Travellers 005"
            class="matatu-image"
          />
          <h3>Forward Travellers 005</h3>
          <p><strong>Route:</strong> Nairobi - Rongai</p>
          <p><strong>Rating:</strong> 4 / 5</p>
          <p><strong>Review:</strong> Clean interior, good music.</p>
        </div>

        <div class="matatu-card">
          <img
            src="pictures/matatu1.jpeg"
            alt="Super Metro 302"
            class="matatu-image"
          />
          <h3>Super Metro 302</h3>
          <p><strong>Route:</strong> Nairobi - Umoja</p>
          <p><strong>Rating:</strong> 3 / 5</p>
          <p><strong>Review:</strong> Affordable but crowded.</p>
        </div>

        <div class="matatu-card">
          <img
            src="pictures/matatu2.jpeg"
            alt="Nazigi Sacco 222"
            class="matatu-image"
          />
          <h3>Nazigi Sacco 222</h3>
          <p><strong>Route:</strong> CBD - Githurai 45</p>
          <p><strong>Rating:</strong> 5 / 5</p>
          <p><strong>Review:</strong> Fast and respectful driver.</p>
        </div>

        <div class="matatu-card">
          <img
            src="pictures/matatu4.jpeg"
            alt="Zuri Express 909"
            class="matatu-image"
          />
          <h3>Zuri Express 909</h3>
          <p><strong>Route:</strong> Nairobi - Donholm</p>
          <p><strong>Rating:</strong> 4 / 5</p>
          <p><strong>Review:</strong> Smooth ride and polite crew.</p>
        </div>

        <div class="matatu-card">
          <img
            src="pictures/matatu5.jpeg"
            alt="Kaka Travellers 781"
            class="matatu-image"
          />
          <h3>Kaka Travellers 781</h3>
          <p><strong>Route:</strong> CBD - Kayole</p>
          <p><strong>Rating:</strong> 2 / 5</p>
          <p><strong>Review:</strong> Loud music and occasional delays.</p>
        </div>

        <div class="matatu-card">
          <img
            src="pictures/matatu7.jpeg"
            alt="KBS 110"
            class="matatu-image"
          />
          <h3>Kenya Bus Service 110</h3>
          <p><strong>Route:</strong> Nairobi - Ngong</p>
          <p><strong>Rating:</strong> 3 / 5</p>
          <p><strong>Review:</strong> Sometimes late</p>
        </div>

        
        <div class="matatu-card">
          <img
            src="pictures/matatu8.jpeg"
            alt="Buruburu Express 808"
            class="matatu-image"
          />
          <h3>Buruburu Express 808</h3>
          <p><strong>Route:</strong> Nairobi - Buruburu</p>
          <p><strong>Rating:</strong> 4 / 5</p>
          <p><strong>Review:</strong> Quiet, respectful passengers.</p>
        </div>

        
      </div>
    </section>

    <section class="testimonials" data-aos="fade-up">
      <h2>What People Are Saying</h2>
      <div class="testimonial-card" data-aos="fade-right">
        "I love using MatBuzz to decide which matatu to take!” — Joy M.
      </div>
      <div class="testimonial-card" data-aos="fade-left">
        “Great to leave honest reviews for my commute.” — Kevin K.
      </div>
      <div class="testimonial-card" data-aos="fade-up">
        “Easy to use and helpful.” — Sharon A.
      </div>
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
        <a href="#">About</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Contact</a>
        <a href="#">Help</a>
      </div>
      <p>© 2025 MatBuzz. All rights reserved.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
  </body>
</html>
