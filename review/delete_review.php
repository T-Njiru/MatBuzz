<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'passenger') {
    header("Location: ../login/login.html");
    exit;
}

$passenger_id = $_SESSION['user_id'];
$reg = $_POST['reg_number'] ?? '';
$date = $_POST['review_date'] ?? '';

if ($reg && $date) {
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE passenger_id = ? AND reg_number = ? AND review_date = ?");
    $stmt->execute([$passenger_id, $reg, $date]);
    header("Location: ../homepage/my_reviews.php"); 
    exit;
} else {
    echo "Invalid request.";
}
