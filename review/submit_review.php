<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure passenger is logged in
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
        die("Unauthorized access.");
    }

    $reg_number = trim($_POST['matatu']);  // Should now be the actual Reg_number
    $review = trim($_POST['review']);
    $rating = intval($_POST['rating']);
    $passenger_id = $_SESSION['user_id'];  // This is the passenger_id stored during login

    // Basic validation
    if (empty($reg_number) || empty($review) || $rating < 1 || $rating > 5) {
        die("Invalid input.");
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO reviews (reg_number, review, rating, passenger_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$reg_number, $review, $rating, $passenger_id]);

        echo "✅ Review submitted successfully!";
    } catch (PDOException $e) {
        echo "❌ Error submitting review: " . $e->getMessage();
    }
}
?>
