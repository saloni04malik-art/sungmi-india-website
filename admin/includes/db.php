<?php

$conn = mysqli_connect("localhost", "root", "", "sungmi");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}