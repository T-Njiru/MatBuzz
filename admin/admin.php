<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php'; 

// Ensure user is logged in as an owner
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    echo json_encode(['success' => false, 'message' => '❌ Unauthorized access.']);
    exit;
}

$owner_id = $_SESSION['user_id']; // Pull owner_id from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plate = trim($_POST['plate'] ?? '');
    $route = trim($_POST['route'] ?? '');
    $SACCO = trim($_POST['SACCO'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $drivers = trim($_POST['Driver_list'] ?? '');
    $conductors = trim($_POST['Conductor_list'] ?? '');

    // ✅ Check required fields
    if (
        empty($plate) || empty($route) || empty($SACCO) ||
        empty($model) || empty($drivers) || empty($conductors)
    ) {
        echo json_encode(['success' => false, 'message' => '❌ All fields are required.']);
        exit;
    }

    // ✅ Handle photo upload
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
            $photoPath = 'uploads/' . $uniqueName;
        } else {
            echo json_encode(['success' => false, 'message' => '❌ Failed to upload image.']);
            exit;
        }
    }

    // ✅ Insert into database with owner_id
    try {
        $stmt = $pdo->prepare("INSERT INTO matatu 
            (Reg_number, route, SACCO, matatu_model, Driver_list, Conductor_list, matatu_photo, owner_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $plate,
            $route,
            $SACCO,
            $model,
            $drivers,
            $conductors,
            $photoPath,
            $owner_id
        ]);

        echo json_encode(['success' => true, 'message' => '✅ Matatu registered successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => '❌ Error: ' . $e->getMessage()]);
    }

    exit;
}
?>
