<?php
session_start();
include "db.php";

$username = $_POST['username'];
$password = $_POST['password'];

if ($username) {
    $conn->query("UPDATE admin_users SET username='$username' WHERE id=1");
}

if ($password) {
    $passHash = MD5($password);
    $conn->query("UPDATE admin_users SET password='$passHash' WHERE id=1");
}

echo "OK";
