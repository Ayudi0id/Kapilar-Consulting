<?php
$conn = new mysqli("localhost", "root", "", "kapilar_db");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$nama_pt      = $_POST['nama_pt'];
$nama_pemohon = $_POST['nama_pemohon'];
$email        = $_POST['email'];
$hp           = $_POST['hp'];
$pertanyaan   = $_POST['pertanyaan'];

$sql = "INSERT INTO permohonan_cek_pt (nama_pt, nama_pemohon, email, no_hp, pertanyaan)
        VALUES ('$nama_pt', '$nama_pemohon', '$email', '$hp', '$pertanyaan')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Data berhasil dikirim! Kami akan menghubungi Anda via email.');
            window.history.go(-1);
          </script>";
} else {
    echo 'Error: ' . $conn->error;
}

$conn->close();
?>
