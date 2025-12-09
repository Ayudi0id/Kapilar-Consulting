<?php
include "db.php";

$type = $_GET['type'] ?? '';

switch ($type) {

    case "contact":
        $query = "SELECT id, nama_pengirim, email, no_hp, pesan, tanggal_dibuat, is_read
                  FROM kontak_masuk 
                  ORDER BY id DESC";
        break;

    case "cekpt":
        $query = "SELECT id, nama_pt, nama_pemohon, email, no_hp, pertanyaan, tanggal_dibuat, is_read
                  FROM permohonan_cek_pt 
                  ORDER BY id DESC";
        break;

    default:
        echo json_encode([]);
        exit;
}

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
