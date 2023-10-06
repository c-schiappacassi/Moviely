<?php session_start();?>
<?php
include("conexion.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload file

$mail = new PHPMailer(true);

try {
    // Common SMTP settings
    $mail->isSMTP();
    $mail->SMTPSecure = 'tls';
    $mail->Port = 465;

    // Gmail settings
    $gmailEnabled = true; // Set to true if using Gmail

    if ($gmailEnabled) {
        $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'movielyreviews@gmail.com'; // Your Gmail address
        $mail->Password = 'MOVIELY_moviely'; // Your Gmail password or App Password
    }

    // Common email settings
    $mail->setFrom('movielyreviews@gmail.com', 'Moviely-Reviews');
    $mail->addAddress('tripa.xjp@gmail.com', 'Kensho');
    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = 'This is a test email sent from a webpage using PHPMailer.';

    $mail->send();
    echo 'Email sent successfully!';
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
