<?php
$host = "localhost";
$user = "root";
$pass = "";//ganti password baru
$db   = "kapilar_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data sesuai name="" di HTML
$nama     = $_POST['nama'];
$email    = $_POST['email'];
$telepon  = $_POST['telepon'];
$pesan    = $_POST['pesan'];

$sql = "INSERT INTO contact_messages (name, email, phone, message)
        VALUES ('$nama', '$email', '$telepon', '$pesan')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Pesan berhasil dikirim!');
            window.location.href='contact.html';
          </script>";
} else {
    echo 'Error: ' . $conn->error;
}

$conn->close();
?>
