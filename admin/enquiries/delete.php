<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: listing.php");
    exit;
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: listing.php");
    exit;
}

$id = (int) $_POST['id'];

$sql = "UPDATE project_enquiries
        SET is_deleted = 1
        WHERE id = $id";

mysqli_query($conn, $sql);

header("Location: listing.php");
exit;