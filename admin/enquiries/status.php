<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: listing.php");
    exit;
}

if (
    !isset($_POST['id']) ||
    !isset($_POST['status']) ||
    !is_numeric($_POST['id']) ||
    !is_numeric($_POST['status'])
) {
    header("Location: listing.php");
    exit;
}

$id = (int) $_POST['id'];
$status = (int) $_POST['status'];

if ($status < 0 || $status > 3) {
    header("Location: listing.php");
    exit;
}

$sql = "UPDATE project_enquiries
        SET status = $status
        WHERE id = $id
        AND is_deleted = 0";

mysqli_query($conn, $sql);

header("Location: view.php?id=" . $id);
exit;