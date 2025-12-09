<?php
// set_read.php
include "db.php";

$type = $_GET['type'] ?? '';
$id   = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($type === 'contact') {
    if ($id > 0) {
        $stmt = $conn->prepare("UPDATE kontak_masuk SET is_read = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } else {
        // mark all read
        $conn->query("UPDATE kontak_masuk SET is_read = 1");
    }
}

if ($type === 'cekpt') {
    if ($id > 0) {
        $stmt = $conn->prepare("UPDATE permohonan_cek_pt SET is_read = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } else {
        $conn->query("UPDATE permohonan_cek_pt SET is_read = 1");
    }
}

echo json_encode(["success" => true]);
