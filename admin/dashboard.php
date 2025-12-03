<?php
session_start();
include "db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        table { border-collapse: collapse; margin-bottom: 40px; width: 100%; }
        th, td { border: 1px solid #333; padding: 8px; }
        th { background: #eee; }
        .export-btn {
            background: green;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .export-btn:hover {
            background: #0a7f0a;
        }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>
    <a href="logout.php">Logout</a>

    <br><br>

<a href="../data/export_all.php" target="_blank">
    <button>Export All</button>
</a>


    <hr>

    <!-- ================= CONTACT_MESSAGES ================= -->
    <h2>Table: contact_messages</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Pesan</th>
            <th>Created At</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['message']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
        }
        ?>
    </table>


    <!-- ================= CEK_PT ================= -->
    <h2>Table: cek_pt</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama PT</th>
            <th>Nama Pemohon</th>
            <th>Email</th>
            <th>HP</th>
            <th>Pertanyaan</th>
            <th>Created At</th>
        </tr>

        <?php
        $result2 = $conn->query("SELECT * FROM cek_pt ORDER BY id DESC");
        while ($row2 = $result2->fetch_assoc()) {
            echo "<tr>
                    <td>{$row2['id']}</td>
                    <td>{$row2['nama_pt']}</td>
                    <td>{$row2['nama_pemohon']}</td>
                    <td>{$row2['email']}</td>
                    <td>{$row2['hp']}</td>
                    <td>{$row2['pertanyaan']}</td>
                    <td>{$row2['created_at']}</td>
                  </tr>";
        }
        ?>
    </table>

</body>
</html>
