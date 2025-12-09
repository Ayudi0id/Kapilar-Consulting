<?php
include "db.php";

$cm = $conn->query("SELECT COUNT(*) FROM kontak_masuk WHERE is_read = 0")->fetch_row()[0];
$cp = $conn->query("SELECT COUNT(*) FROM permohonan_cek_pt WHERE is_read = 0")->fetch_row()[0];

echo json_encode([
    "contact" => $cm,
    "cekpt" => $cp
]);
