<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../analytics/login_admin.html");
    exit;
}

// Handle deletions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_passenger'])) {
        $stmt = $pdo->prepare("DELETE FROM passenger WHERE passenger_id = ?");
        $stmt->execute([$_POST['delete_passenger']]);
    }
    if (isset($_POST['delete_owner'])) {
        $stmt = $pdo->prepare("DELETE FROM owner WHERE owner_id = ?");
        $stmt->execute([$_POST['delete_owner']]);
    }
    if (isset($_POST['delete_matatu'])) {
        $stmt = $pdo->prepare("DELETE FROM matatu WHERE Reg_number = ?");
        $stmt->execute([$_POST['delete_matatu']]);
    }
    if (isset($_POST['delete_review'])) {
        $stmt = $pdo->prepare("DELETE FROM reviews WHERE review_id = ?");
        $stmt->execute([$_POST['delete_review']]);
    }
    header("Location: analytics.php");
    exit;
}

// Fetch data
$passengers = $pdo->query("SELECT passenger_id, name, email FROM passenger")->fetchAll();
$owners = $pdo->query("SELECT owner_id, name, email FROM owner")->fetchAll();
$matatus = $pdo->query("SELECT Reg_number, SACCO, route FROM matatu")->fetchAll();
$reviews = $pdo->query("SELECT review_id, reg_number, rating, review FROM reviews")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Analytics - MatBuzz</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        h1 { color: #004080; }
        .section { background: white; padding: 20px; margin-bottom: 30px; border-radius: 10px; }
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 10px; background: #f9f9f9; padding: 8px 12px; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; }
        form { margin: 0; }
        button { background: #d9534f; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        button:hover { background: #c9302c; }
    </style>
</head>
<body>

<h1>Admin Analytics</h1>

<div class="section">
    <h2>Passengers (<?= count($passengers) ?>)</h2>
    <ul>
        <?php foreach ($passengers as $p): ?>
            <li>
                <?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['email']) ?>)
                <form method="POST">
                    <button type="submit" name="delete_passenger" value="<?= $p['passenger_id'] ?>">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="section">
    <h2>Owners (<?= count($owners) ?>)</h2>
    <ul>
        <?php foreach ($owners as $o): ?>
            <li>
                <?= htmlspecialchars($o['name']) ?> (<?= htmlspecialchars($o['email']) ?>)
                <form method="POST">
                    <button type="submit" name="delete_owner" value="<?= $o['owner_id'] ?>">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="section">
    <h2>Matatus (<?= count($matatus) ?>)</h2>
    <ul>
        <?php foreach ($matatus as $m): ?>
            <li>
                <?= htmlspecialchars($m['Reg_number']) ?> - <?= htmlspecialchars($m['SACCO']) ?> (<?= htmlspecialchars($m['route']) ?>)
                <form method="POST">
                    <button type="submit" name="delete_matatu" value="<?= $m['Reg_number'] ?>">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="section">
    <h2>Reviews (<?= count($reviews) ?>)</h2>
    <ul>
        <?php foreach ($reviews as $r): ?>
            <li>
                <?= htmlspecialchars($r['reg_number']) ?>: <?= htmlspecialchars($r['review']) ?> (<?= htmlspecialchars($r['rating']) ?>/5)
                <form method="POST">
                    <button type="submit" name="delete_review" value="<?= $r['review_id'] ?>">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<a href="../homepage/home.php">⬅ Back to Home</a>

</body>
</html>
