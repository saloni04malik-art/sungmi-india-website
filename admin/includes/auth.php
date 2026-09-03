<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
/*This file simply checks:

Is an admin logged in?

If not → send them to login*/
