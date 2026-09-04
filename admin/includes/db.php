<?php

$host     = getenv('MYSQLHOST') ?: 'localhost';
$user     = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$database = getenv('MYSQLDATABASE') ?: 'sungmi';
$port     = (int)(getenv('MYSQLPORT') ?: 3306);

$smtpHost       = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
$smtpPort       = (int)(getenv('SMTP_PORT') ?: 587);
$smtpUser       = getenv('SMTP_USER') ?: 'saloni04malik@gmail.com';
$smtpPass       = getenv('SMTP_PASS') ?: 'rhxd yyqw rrci mzxg';
$smtpFromEmail  = getenv('SMTP_FROM_EMAIL') ?: 'saloni04malik@gmail.com';
$smtpFromName   = getenv('SMTP_FROM_NAME') ?: 'Sungmi India';
$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database,
    $port
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
