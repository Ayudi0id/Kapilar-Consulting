<?php
header("Content-Type: application/json");

// ================= TOKEN KEAMANAN =================
$secret = "Thisisatest1"; // ganti sesuai keinginanmu

if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    http_response_code(403); 
    echo json_encode(["error" => "Invalid or missing API key"]);
    exit;
}

// ================= KONEKSI DATABASE =================
$conn = new mysqli("localhost", "root", "", "kapilar_db");

if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection error"]);
    exit;
}

// ================= CONTACT_MESSAGES =================
$result1 = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
$contact = [];
while ($row = $result1->fetch_assoc()) {
    $contact[] = $row;
}

// ================= CEK_PT =================
$result2 = $conn->query("SELECT * FROM cek_pt ORDER BY id DESC");
$cekpt = [];
while ($row2 = $result2->fetch_assoc()) {
    $cekpt[] = $row2;
}

// ================= OUTPUT JSON =================
echo json_encode([
    "contact_messages" => $contact,
    "cek_pt"           => $cekpt
], JSON_PRETTY_PRINT);

?>
