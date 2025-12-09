<?php
$conn = new mysqli("localhost", "root", "", "kapilar_db");

$filename = "export_" . date("Y-m-d_H-i-s") . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");


// ===================== kontak_masuk =====================
$result1 = $conn->query("SELECT * FROM kontak_masuk");

echo "<table border='1'>";
echo "<tr><th colspan='10' style='background:#ccc;'>KONTAK MASUK</th></tr>";
echo "<tr>";
foreach ($result1->fetch_fields() as $f) echo "<th>{$f->name}</th>";
echo "</tr>";

$result1->data_seek(0);
while ($row = $result1->fetch_assoc()) {
    echo "<tr>";
    foreach ($row as $val) echo "<td>".htmlspecialchars($val)."</td>";
    echo "</tr>";
}
echo "</table><br><br>";


// ===================== permohonan_cek_pt =====================
$result2 = $conn->query("SELECT * FROM permohonan_cek_pt");

echo "<table border='1'>";
echo "<tr><th colspan='10' style='background:#ccc;'>PERMOHONAN CEK PT</th></tr>";
echo "<tr>";
foreach ($result2->fetch_fields() as $f) echo "<th>{$f->name}</th>";
echo "</tr>";

$result2->data_seek(0);
while ($row = $result2->fetch_assoc()) {
    echo "<tr>";
    foreach ($row as $val) echo "<td>".htmlspecialchars($val)."</td>";
    echo "</tr>";
}
echo "</table>";
?>
