<?php
session_start();

if (!isset($_SESSION['admin_email'], $_SESSION['admin_verification_code'])) {
    echo "⚠️ No verification process initiated.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userCode = trim($_POST['code'] ?? '');
    $actualCode = $_SESSION['admin_verification_code'];

    if ($userCode === $actualCode) {
        // ✅ Verification successful
        $_SESSION['role'] = 'admin';
        $_SESSION['user_id'] = $_SESSION['admin_email'];  // optional, if you want to track user ID
        unset($_SESSION['admin_verification_code']);      // clear the code
        header("Location: ../analytics/analytics.php");
        exit;
    } else {
        $error = "❌ Incorrect verification code. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Verification</title>
</head>
<body>
  <h1>Verify Admin Login</h1>
  <?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="POST">
    <label>Verification Code: <input type="text" name="code" required></label><br>
    <button type="submit">Verify</button>
  </form>
</body>
</html>
