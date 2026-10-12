<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Path ko define karna taaki error na aaye
$path = __DIR__ . '/PHPMailer/';

if (!file_exists($path . 'PHPMailer.php')) {
    die("Error: PHPMailer folder nahi mila! Please check: " . $path);
}

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vekariyashya@gmail.com'; 
        $mail->Password   = 'usxp aliw'; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL ke liye best
        $mail->Port       = 465;

        $mail->setFrom('vekariyashriya@gmail.com', 'FilmFlix');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
