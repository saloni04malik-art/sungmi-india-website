<?php

require 'includes/mailer.php';

$result = sendSungmiEmail(
    'Sungmi India - Mailer Test',
    '<h2>Email Test Successful</h2><p>PHPMailer is working correctly.</p>'
);

if ($result) {
    echo "Email sent successfully!";
} else {
    echo "Email could not be sent.";
}