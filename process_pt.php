<?php
// ======= CONFIG DATABASE =======
$host = "localhost";
$user = "root";
$pass = ""; //ganti jadi password baru
$db   = "kapilar_db"; // ganti sesuai database kamu

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ======= AMBIL DATA DARI FORM =======
$nama_pt       = $_POST['nama_pt'];
$nama_pemohon  = $_POST['nama_pemohon'];
$email         = $_POST['email'];
$hp            = $_POST['hp'];
$pertanyaan    = $_POST['pertanyaan'];

// ======= QUERY INSERT =======
$sql = "INSERT INTO cek_pt (nama_pt, nama_pemohon, email, hp, pertanyaan)
        VALUES ('$nama_pt', '$nama_pemohon', '$email', '$hp', '$pertanyaan')";

if ($conn->query($sql) === TRUE) {
    echo "
    <script>
      alert('Data berhasil dikirim! Kami akan menghubungi Anda via email.');
      window.location.href='cek-pt.html';
    </script>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
