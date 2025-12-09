<?php
session_start();
require "db.php";

header("Content-Type: application/json");

// Wajib login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode([]);
    exit;
}

$stmt = $conn->prepare("SELECT id, username, role, created_at FROM admin_users ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();

$out = [];
while ($r = $result->fetch_assoc()) {
    $out[] = $r;
}

echo json_encode($out);
