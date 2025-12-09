<?php
// ======================
// CONFIG DATABASE
// ======================
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "kapilar_db";


// ======================
// KONEKSI DATABASE
// ======================
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset agar aman dari simbol aneh
$conn->set_charset("utf8mb4");


// ======================
// OPTIONAL: AUTO START SESSION
// ======================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
