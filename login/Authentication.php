<?php
session_start();

$feedback = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userCode = $_POST['code'] ?? '';
    $actualCode = $_SESSION['verification_code'] ?? null;

    if ($userCode === $actualCode) {
        $feedback = "✅ Verification successful! Welcome.";
         header('Location: /MatBuzz/admin/admin.html');
        // Proceed with login or account activation logic here
    } else {
        $feedback = "❌ Incorrect verification code. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Enter Verification Code</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="auth-container">
    <h1>MatBuzz</h1>
    <h2>Email Verification</h2>
    <p>Please enter the 5-digit code sent to: <b><?= htmlspecialchars($_SESSION['email'] ?? '') ?></b></p>

    <form method="POST">
      <label for="code">Verification Code</label>
      <input type="text" id="code" name="code" pattern="\d{5}" required placeholder="Enter 5-digit code" />

      <button type="submit">Verify</button>
    </form>
  

    <p class="status-message"><?= $feedback ?></p>
  </div>
</body>
</html>
