<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer/src/SMTP.php';


function sendSungmiEmail($recipient, $subject, $body, $attachment = null)
{
    $smtpHost      = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
    $smtpPort      = (int)(getenv('SMTP_PORT') ?: 587);
    $smtpUser      = getenv('SMTP_USER') ?: '';
    $smtpPass      = getenv('SMTP_PASS') ?: '';
    $smtpFromEmail = getenv('SMTP_FROM_EMAIL') ?: ($smtpUser ?: 'info@sungmi.co.in');
    $smtpFromName  = getenv('SMTP_FROM_NAME') ?: 'Sungmi India';

    if (empty($smtpUser) || empty($smtpPass)) {
        error_log('Sungmi Email Notice: SMTP_USER or SMTP_PASS environment variables are not set.');
        return false;
    }

    $mail = new PHPMailer(true);

    try {

        // SMTP
        $mail->isSMTP();
        $mail->Host       = $smtpHost;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtpUser;
        $mail->Password   = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtpPort;

        // Sender
        $mail->setFrom(
            $smtpFromEmail,
            $smtpFromName
        );

        // Dynamic recipient
        $mail->addAddress($recipient);

        // Email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Attachment
        if ($attachment && file_exists($attachment)) {
            $mail->addAttachment($attachment);
        }

        $mail->send();

        return true;

    } catch (Exception $e) {

        error_log('Sungmi Email Error: ' . $mail->ErrorInfo);

        return false;
    }
}