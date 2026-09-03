<?php

require '../includes/auth.php';
require '../includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die('Invalid application.');
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT cv_path
     FROM job_applications
     WHERE id = ?
     AND is_deleted = 0
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$row || empty($row['cv_path'])) {
    die('CV not found.');
}

/*
 * Database stores:
 * admin/uploads/cvs/filename.pdf
 */

$filePath = dirname(__DIR__, 2) . '/' . $row['cv_path'];

if (!file_exists($filePath)) {
    die('CV file does not exist.');
}

$extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

$mimeTypes = [
    'pdf'  => 'application/pdf',
    'doc'  => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
];

if (!isset($mimeTypes[$extension])) {
    die('Invalid CV file.');
}

header('Content-Type: ' . $mimeTypes[$extension]);
header('Content-Length: ' . filesize($filePath));
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('X-Content-Type-Options: nosniff');

readfile($filePath);
exit;