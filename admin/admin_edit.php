<?php
session_start();
require "db.php";

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo "unauthorized";
    exit;
}

$id       = intval($_POST['id'] ?? 0);
$username = trim($_POST['username'] ?? "");
$role     = trim($_POST['role'] ?? "admin");

if ($id <= 0 || $username === "") {
    echo "Data tidak valid.";
    exit;
}

if (strlen($username) > 50) {
    echo "Username maksimal 50 karakter.";
    exit;
}

if (!in_array($role, ["admin", "superadmin"])) {
    echo "Role tidak valid.";
    exit;
}

$stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ? AND id <> ?");
$stmt->bind_param("si", $username, $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Username sudah dipakai.";
    exit;
}

$stmt = $conn->prepare("UPDATE admin_users SET username = ?, role = ? WHERE id = ?");
$stmt->bind_param("ssi", $username, $role, $id);

echo ($stmt->execute()) ? "success" : "Gagal mengedit admin.";
