<?php

require '../includes/auth.php';
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: listing.php");
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id <= 0) {
    header("Location: listing.php");
    exit;
}

/*
 * Soft delete only.
 * The application remains in the database.
 */
$stmt = mysqli_prepare(
    $conn,
    "UPDATE job_applications
     SET is_deleted = 1
     WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: listing.php");
exit;