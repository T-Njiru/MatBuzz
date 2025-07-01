<?php
require_once __DIR__ . '/../login/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reg_number = $_POST['matatu'] ?? '';
    $rating = $_POST['rating'] ?? '';

    if ($reg_number && $rating >= 1 && $rating <= 5) {
        $stmt = $pdo->prepare("INSERT INTO reviews (passenger_id, reg_number, review, rating, review_date) VALUES (NULL, ?, NULL, ?, NOW())");
        $stmt->execute([$reg_number, $rating]);

        echo "<script>alert('Thank you for your rating!'); window.location.href='../homepage/home.html';</script>";
    } else {
        echo "<script>alert('Invalid input.'); history.back();</script>";
    }
}
?>
