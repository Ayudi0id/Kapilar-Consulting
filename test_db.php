<?php
$conn = new mysqli("localhost", "root", "", "kapilar_db");

if ($conn->connect_error) {
    die("Gagal konek: " . $conn->connect_error);
} else {
    echo "KONEKSI BERHASIL!";
}
?>
