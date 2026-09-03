<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {

    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'saloni.infipre.intern@gmail.com';
    $mail->Password   = 'bkbl hebk fsoq pcki';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Email details
    $mail->setFrom(
        'saloni.infipre.intern@gmail.com',
        'Sungmi India'
    );

    $mail->addAddress(
        'saloni.infipre.intern@gmail.com'
    );

    $mail->Subject = 'Sungmi India - Email Test';

    $mail->Body = 'This is a test email from the Sungmi India website.';

    $mail->send();

    echo "Email sent successfully!";

} catch (Exception $e) {

    echo "Email could not be sent.";
    echo "<br>Error: " . htmlspecialchars($mail->ErrorInfo);
}