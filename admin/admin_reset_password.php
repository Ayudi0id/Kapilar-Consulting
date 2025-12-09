<?php
session_start();
require "db.php";

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo "unauthorized";
    exit;
}

$id = intval($_POST['id'] ?? 0);
$new = trim($_POST['new_password'] ?? "");

if ($id <= 0 || $new === "") {
    echo "Data tidak valid.";
    exit;
}

if (strlen($new) < 6) {
    echo "Password minimal 6 karakter.";
    exit;
}

$hash = password_hash($new, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
$stmt->bind_param("si", $hash, $id);

echo ($stmt->execute()) ? "success" : "Gagal mereset password.";
