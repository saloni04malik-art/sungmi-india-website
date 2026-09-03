<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    $base_url = (strpos($_SERVER['REQUEST_URI'] ?? '', '/sungmi') !== false) ? '/sungmi' : '';
    header("Location: " . $base_url . "/admin/login.php");
    exit;
}


