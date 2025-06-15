<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['email'])) {
    $email = $_GET['email'];
    $code = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
    $_SESSION['verification_code'] = $code;
    $_SESSION['email'] = $email;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tednjiru3@gmail.com';
        $mail->Password   = 'qtpgtljwisabhcne';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('tednjiru3@gmail.com', 'MatBuzz Security');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = '🔐 Your MatBuzz Login Verification Code';
        $mail->Body    = "Your login verification code is: <b>$code</b>";
        $mail->AltBody = "Your login verification code is: $code";

        $mail->send();
        header("Location: Authentication.php");
        exit;
    } catch (Exception $e) {
        echo "❌ Failed to send verification email. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "❌ Invalid request or missing email.";
}
