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


$sql = "UPDATE clients
        SET is_deleted = 1
        WHERE id = ? AND is_deleted = 0";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);


header("Location: listing.php");
exit;