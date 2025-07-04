<?php
session_start();
require_once __DIR__ . '/../login/db_connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check email and password
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && hash_equals($admin['password_hash'], hash('sha256', $password))) {
        // Password correct - generate verification code
        $code = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        $_SESSION['admin_email'] = $email;
        $_SESSION['admin_verification_code'] = $code;

        // Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tednjiru3@gmail.com';
            $mail->Password   = 'qtpgtljwisabhcne';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('tednjiru3@gmail.com', 'MatBuzz Admin Login');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your Admin Login Code';
            $mail->Body    = "<b>Your admin verification code is: $code</b>";

            $mail->send();

            header("Location: admin_verification.php");
            exit;
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!-- admin_login.php -->
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Admin Login - MatBuzz</title>
<link rel="stylesheet" href="login_admin.css" />
</head>
<body>
<h1>Admin Login</h1>
<div class="auth-container">
    <h1>Admin Login</h1>
    <h2>Enter your credentials to receive a verification code</h2>

    <?php if (!empty($error)): ?>
      <p class="status-message" style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <button type="submit">Send Verification Code</button>
    </form>

</body>
</html>
