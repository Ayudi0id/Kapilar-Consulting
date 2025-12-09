<?php
header("Content-Type: application/json");

$secret = "Thisisatest1";

if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    http_response_code(403);
    echo json_encode(["error" => "Invalid API key"]);
    exit;
}

$conn = new mysqli("localhost", "root", "", "kapilar_db");
if ($conn->connect_error) die(json_encode(["error" => "DB error"]));

$result1 = $conn->query("SELECT * FROM kontak_masuk ORDER BY id DESC");
$contact = [];
while ($row = $result1->fetch_assoc()) $contact[] = $row;

$result2 = $conn->query("SELECT * FROM permohonan_cek_pt ORDER BY id DESC");
$cekpt = [];
while ($row = $result2->fetch_assoc()) $cekpt[] = $row;

echo json_encode([
    "kontak_masuk" => $contact,
    "permohonan_cek_pt" => $cekpt
], JSON_PRETTY_PRINT);
?>
