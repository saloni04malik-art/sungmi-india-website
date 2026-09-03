<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {

    $smtpHost      = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
    $smtpPort      = (int)(getenv('SMTP_PORT') ?: 587);
    $smtpUser      = getenv('SMTP_USER') ?: '';
    $smtpPass      = getenv('SMTP_PASS') ?: '';
    $smtpFromEmail = getenv('SMTP_FROM_EMAIL') ?: ($smtpUser ?: 'info@sungmi.co.in');

    if (empty($smtpUser) || empty($smtpPass)) {
        die("SMTP_USER and SMTP_PASS environment variables are required to run this test.");
    }

    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUser;
    $mail->Password   = $smtpPass;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $smtpPort;

    // Email details
    $mail->setFrom(
        $smtpFromEmail,
        'Sungmi India'
    );

    $mail->addAddress(
        $smtpUser
    );

    $mail->Subject = 'Sungmi India - Email Test';

    $mail->Body = 'This is a test email from the Sungmi India website.';

    $mail->send();

    echo "Email sent successfully!";

} catch (Exception $e) {

    echo "Email could not be sent.";
    echo "<br>Error: " . htmlspecialchars($mail->ErrorInfo);
}