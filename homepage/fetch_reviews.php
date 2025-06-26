<?php
require_once __DIR__ . '/../login/db_connect.php'; // adjust path as needed

$stmt = $pdo->query("
    SELECT r.rating, r.review, m.matatu_model, m.route 
    FROM reviews r
    JOIN matatu m ON r.reg_number = m.Reg_number
    ORDER BY r.review_date DESC
");

$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($reviews) {
    foreach ($reviews as $review) {
        echo "<div class='review-card'>";
        echo "<h3>" . htmlspecialchars($review['matatu_model']) . "</h3>";
        echo "<p><strong>Route:</strong> " . htmlspecialchars($review['route']) . "</p>";
        echo "<p><strong>Rating:</strong> " . intval($review['rating']) . "</p>";
        echo "<p><strong>Review:</strong> " . htmlspecialchars($review['review']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No reviews found.</p>";
}
?>
