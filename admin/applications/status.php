<?php

require '../includes/auth.php';
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: listing.php");
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$status = isset($_POST['status']) ? (int) $_POST['status'] : -1;

$allowed_statuses = [0, 1, 2, 3, 4];

if ($id <= 0 || !in_array($status, $allowed_statuses, true)) {
    header("Location: listing.php");
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "UPDATE job_applications
     SET status = ?
     WHERE id = ?
       AND is_deleted = 0"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $status,
    $id
);

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: listing.php");
exit;