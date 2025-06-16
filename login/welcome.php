<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendWelcomeEmail($email, $name) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tednjiru3@gmail.com';
        $mail->Password   = 'qtpgtljwisabhcne';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('tednjiru3@gmail.com', 'MatBuzz Team');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Welcome to MatBuzz!';
        $mail->Body    = "Hi <b>$name</b>,<br><br>Thanks for signing up with MatBuzz!";
        $mail->AltBody = "Hi $name,\n\nThanks for signing up with MatBuzz!";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}

