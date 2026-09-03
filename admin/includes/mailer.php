<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';


function sendSungmiEmail($recipient, $subject, $body, $attachment = null)
{
    $mail = new PHPMailer(true);

    try {

        // SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'saloni.infipre.intern@gmail.com';
        $mail->Password   = 'bkbl hebk fsoq pcki';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender
        $mail->setFrom(
            'saloni.infipre.intern@gmail.com',
            'Sungmi India'
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