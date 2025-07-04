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
  <title>Admin Verification - MatBuzz</title>
  <link rel="stylesheet" href="login_admin.css" />

</head>
<body>
  <div class="auth-container">
    <h1>Admin Verification</h1>
    <h2>Enter the code sent to your email</h2>

    <?php if (!empty($error)): ?>
      <p class="status-message" style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
      <label for="code">Verification Code:</label>
      <input type="text" id="code" name="code" required />
      <button type="submit">Verify</button>
    </form>

    <div class="redirect">
      <a href="login_admin.php">← Back to login</a>
    </div>
  </div>
</body>
</html>
