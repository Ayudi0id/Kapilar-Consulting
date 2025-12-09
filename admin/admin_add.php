<?php
session_start();
require "db.php";

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo "unauthorized";
    exit;
}

$username = trim($_POST['username'] ?? "");
$password = trim($_POST['password'] ?? "");
$role     = trim($_POST['role'] ?? "admin");

if ($username === "" || $password === "") {
    echo "Semua field wajib diisi.";
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

$stmt = $conn->prepare("SELECT id FROM admin_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Username sudah digunakan.";
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash, role) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $hash, $role);

echo ($stmt->execute()) ? "success" : "Gagal menambah admin.";
