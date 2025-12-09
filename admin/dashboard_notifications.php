<?php
// dashboard_notifications.php
include "db.php";

$contact_q = $conn->query("SELECT COUNT(*) AS total FROM kontak_masuk WHERE is_read = 0");
$cekpt_q   = $conn->query("SELECT COUNT(*) AS total FROM permohonan_cek_pt WHERE is_read = 0");

$contact = $contact_q ? intval($contact_q->fetch_assoc()['total']) : 0;
$cekpt   = $cekpt_q ? intval($cekpt_q->fetch_assoc()['total']) : 0;

header('Content-Type: application/json');
echo json_encode(["contact" => $contact, "cekpt" => $cekpt]);
