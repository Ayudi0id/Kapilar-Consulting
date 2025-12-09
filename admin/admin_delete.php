<?php
session_start();
require "db.php";

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo "unauthorized";
    exit;
}

$id = intval($_POST['id'] ?? 0);
$me = intval($_SESSION['admin_id'] ?? 0);

if ($id <= 0) {
    echo "ID tidak valid.";
    exit;
}

if ($id === $me) {
    echo "error:self";
    exit;
}

$result = $conn->query("SELECT COUNT(*) AS c FROM admin_users");
$count = intval($result->fetch_assoc()['c']);

if ($count <= 1) {
    echo "error:last";
    exit;
}

$stmt = $conn->prepare("DELETE FROM admin_users WHERE id = ?");
$stmt->bind_param("i", $id);

echo ($stmt->execute()) ? "success" : "Gagal menghapus admin.";
