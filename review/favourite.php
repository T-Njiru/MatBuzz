<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $_SESSION['role'] === 'passenger') {
    $passenger_id = $_SESSION['user_id'];
    $reg_number = $_POST['reg_number'] ?? '';

    if ($reg_number) {
        $check = $pdo->prepare("SELECT * FROM favourites WHERE passenger_id = ? AND reg_number = ?");
        $check->execute([$passenger_id, $reg_number]);

        if ($check->rowCount() === 0) {
            $stmt = $pdo->prepare("INSERT INTO favourites (passenger_id, reg_number) VALUES (?, ?)");
            $stmt->execute([$passenger_id, $reg_number]);
            echo "✅ Matatu added to favourites!";
        } else {
            echo "⚠️ Already in favourites.";
        }
    } else {
        echo "❌ Invalid matatu.";
    }
} else {
    echo "❌ Unauthorized request.";
}
?>
