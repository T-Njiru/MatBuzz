<?php

file_put_contents("debug.txt", print_r($_POST, true));

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; 

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $email = $_GET['email'] ?? '';

    if (!empty($email)) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tednjiru3@gmail.com';           // Your Gmail
            $mail->Password   = 'qtpgtljwisabhcne';              // App Password (no spaces)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('tednjiru3@gmail.com', 'Ted');
            $mail->addAddress($email); 

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = 'Hi! This is a test email sent to <b>' . htmlspecialchars($email) . '</b>';
            $mail->AltBody = 'Hi! This is a test email sent to ' . $email;

            $mail->send();
            echo "✅ Verification email sent to $email.";
        } catch (Exception $e) {
            echo "❌ Failed to send email. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "⚠️ No email was provided.";
    }
} else {
    echo "❌ Invalid request.";
}
