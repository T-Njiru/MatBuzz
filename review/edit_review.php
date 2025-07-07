<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
    header("Location: ../login/login.html");
    exit;
}

$passenger_id = $_SESSION['user_id'];
$reg_number = $_GET['reg_number'] ?? '';
$review_date = $_GET['review_date'] ?? '';

if (!$reg_number || !$review_date) {
    exit('Missing data.');
}

// Fetch existing review
$stmt = $pdo->prepare("SELECT review, rating FROM reviews WHERE passenger_id = ? AND reg_number = ? AND review_date = ?");
$stmt->execute([$passenger_id, $reg_number, $review_date]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$review) {
    exit('Review not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newReview = trim($_POST['review']);
    $newRating = (int) $_POST['rating'];

    $updateStmt = $pdo->prepare("UPDATE reviews SET review = ?, rating = ? WHERE passenger_id = ? AND reg_number = ? AND review_date = ?");
    $updateStmt->execute([$newReview, $newRating, $passenger_id, $reg_number, $review_date]);

    header("Location: ../homepage/my_reviews.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Review</title>
  <style>
    body { font-family: Arial; margin: 2rem; }
    form { background: #f9f9f9; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; }
    textarea, input[type="number"] { width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #ccc; border-radius: 6px; }
    button { margin-top: 15px; background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; }
    button:hover { background: #0056b3; }
  </style>
</head>
<body>

<h2>Edit Your Review</h2>
<form method="POST">
  <label>Review:</label>
  <textarea name="review" rows="5" required><?= htmlspecialchars($review['review']) ?></textarea>

  <label>Rating (1 to 5):</label>
  <input type="number" name="rating" min="1" max="5" value="<?= $review['rating'] ?>" required />

  <button type="submit">Save Changes</button>
</form>

</body>
</html>
