<?php
// dashboard_summary.php
include "db.php";

$contact = $conn->query("SELECT COUNT(*) AS total FROM kontak_masuk");
$cekpt   = $conn->query("SELECT COUNT(*) AS total FROM permohonan_cek_pt");
$admin   = $conn->query("SELECT COUNT(*) AS total FROM admin_users");

$c = $contact ? intval($contact->fetch_assoc()['total']) : 0;
$k = $cekpt ? intval($cekpt->fetch_assoc()['total']) : 0;
$a = $admin ? intval($admin->fetch_assoc()['total']) : 0;

header('Content-Type: application/json');
echo json_encode(["contact" => $c, "cekpt" => $k, "admin" => $a]);
