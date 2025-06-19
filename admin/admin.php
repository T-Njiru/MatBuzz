<?php
require_once __DIR__ . '/../login/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate = trim($_POST['plate'] ?? '');
    $route = trim($_POST['route'] ?? '');
    $SACCO = trim($_POST['SACCO'] ?? '');
    $model = trim($_POST['model'] ?? '');

    if (empty($plate) || empty($route) || empty($model)) {
        echo json_encode(['success' => false, 'message' => '❌ All fields are required.']);
        exit;
    }

    $photoPath = '';
    if (isset($_FILES['Matatu_photo']) && $_FILES['Matatu_photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = basename($_FILES['Matatu_photo']['name']);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $uniqueName = uniqid('matatu_', true) . '.' . $extension;
        $destination = $uploadDir . $uniqueName;

        if (move_uploaded_file($_FILES['Matatu_photo']['tmp_name'], $destination)) {
            $photoPath = 'uploads/' . $uniqueName; // relative path to save in DB
        } else {
            echo json_encode(['success' => false, 'message' => '❌ Failed to upload image.']);
            exit;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO matatu (Reg_number, route, SACCO, matatu_model, matatu_photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$plate, $route, $SACCO, $model, $photoPath]);

        echo json_encode(['success' => true, 'message' => '✅ Matatu registered successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => '❌ Error: ' . $e->getMessage()]);
    }
    exit;
}
?>
