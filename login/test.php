<?php
require __DIR__ . '/../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tednjiru3@gmail.com';    
    $mail->Password   = 'qtpg tljw isab hcne ';       
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Recipients
    $mail->setFrom('tednjiru3@gmail.com', 'Ted');
    $mail->addAddress('ted.njiru@strathmore.edu', 'Recipient');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Hello from PHPMailer';
    $mail->Body    = 'This is a <b>test email</b> using PHPMailer.';
    $mail->AltBody = 'This is a test email using PHPMailer.';

    $mail->send();
    echo 'Message has been sent.';
} catch (Exception $e) {
    echo "Message could not be sent. Error: {$mail->ErrorInfo}";
}
