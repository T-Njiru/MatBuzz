<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
  header("Location: ../login/login.html");
  exit;
}

$owner_id = $_SESSION['user_id'];

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $route = trim($_POST['route']);
    $model = trim($_POST['model']);
    $drivers = trim($_POST['Driver_list']);
    $conductors = trim($_POST['Conductor_list']);

    $stmt = $pdo->prepare("UPDATE matatu SET route = ?, matatu_model = ?, Driver_list = ?, Conductor_list = ? WHERE Reg_number = ? AND owner_id = ?");
    $stmt->execute([$route, $model, $drivers, $conductors, $id, $owner_id]);
    $message = "✅ Matatu updated.";
}

// Fetch matatus belonging to this owner
$stmt = $pdo->prepare("SELECT * FROM matatu WHERE owner_id = ?");
$stmt->execute([$owner_id]);
$matatus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Matatus - MatBuzz</title>
  <link rel="stylesheet" href="admin.css">
  <style>
    .top-button {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 20px;
    }
    .top-button a {
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .top-button a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="admin-container">
    <div class="top-button">
      <a href="../admin/admin1.php">+ Register New Matatu</a>
    </div>

    <h1>Your Registered Matatus</h1>
    <?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>
    
    <?php foreach ($matatus as $matatu): ?>
      <form method="POST" class="matatu-edit-form">
        <input type="hidden" name="update_id" value="<?= htmlspecialchars($matatu['Reg_number']) ?>">

        <p><strong>Plate:</strong> <?= htmlspecialchars($matatu['Reg_number']) ?></p>
        
        <label>Route:
          <input type="text" name="route" value="<?= htmlspecialchars($matatu['route']) ?>" required>
        </label>

        <label>Model:
          <input type="text" name="model" value="<?= htmlspecialchars($matatu['matatu_model']) ?>" required>
        </label>

        <label>Drivers:
          <input type="text" name="Driver_list" value="<?= htmlspecialchars($matatu['Driver_list']) ?>" required>
        </label>

        <label>Conductors:
          <input type="text" name="Conductor_list" value="<?= htmlspecialchars($matatu['Conductor_list']) ?>" required>
        </label>

        <button type="submit">Update</button>
      </form>
      <hr>
    <?php endforeach; ?>
  </div>
</body>
</html>
