<?php
$conn = new mysqli("localhost", "root", "", "kapilar_db");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$nama     = $_POST['nama'];
$email    = $_POST['email'];
$telepon  = $_POST['telepon'];
$pesan    = $_POST['pesan'];

$sql = "INSERT INTO kontak_masuk (nama_pengirim, email, no_hp, pesan)
        VALUES ('$nama', '$email', '$telepon', '$pesan')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Pesan berhasil dikirim!');
            window.history.go(-1);
          </script>";
} else {
    echo 'Error: ' . $conn->error;
}

$conn->close();
?>
