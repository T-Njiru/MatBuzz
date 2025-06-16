<?php
// Adjust this path if needed to reach db_connect.php
require_once __DIR__ . '/../login/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate = trim($_POST['plate'] ?? '');
    $route = trim($_POST['route'] ?? '');
    $model = trim($_POST['model'] ?? '');

    if (empty($plate) || empty($route) || empty($model)) {
        echo json_encode(['success' => false, 'message' => '❌ All fields are required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO matatu (Reg_number, route, matatu_model) VALUES (?, ?, ?)");
        $stmt->execute([$plate, $route, $model]);

        echo json_encode(['success' => true, 'message' => '✅ Matatu registered successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => '❌ Error: ' . $e->getMessage()]);
    }
    exit;
}
?>
