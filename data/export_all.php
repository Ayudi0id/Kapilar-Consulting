<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "kapilar_db");

// Nama file Excel
$filename = "all_data_export_" . date("Y-m-d_H-i-s") . ".xls";

// Header supaya browser download sebagai Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");

// ========== SHEET 1: contact_messages ==========
$result1 = $conn->query("SELECT * FROM contact_messages");

echo "<table border='1'>";
echo "<tr><th colspan='10' style='background:#ccc;'>CONTACT MESSAGES</th></tr>";

if ($result1->num_rows > 0) {
    // Header kolom
    echo "<tr>";
    foreach ($result1->fetch_fields() as $field) {
        echo "<th>{$field->name}</th>";
    }
    echo "</tr>";

    // Data row
    $result1->data_seek(0);
    while ($row = $result1->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>".htmlspecialchars($value)."</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No data</td></tr>";
}
echo "</table><br><br>";


// ========== SHEET 2: cek_pt ==========
$result2 = $conn->query("SELECT * FROM cek_pt");

echo "<table border='1'>";
echo "<tr><th colspan='10' style='background:#ccc;'>CEK PT</th></tr>";

if ($result2->num_rows > 0) {
    // Header kolom
    echo "<tr>";
    foreach ($result2->fetch_fields() as $field) {
        echo "<th>{$field->name}</th>";
    }
    echo "</tr>";

    // Data row
    $result2->data_seek(0);
    while ($row = $result2->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>".htmlspecialchars($value)."</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No data</td></tr>";
}
echo "</table>";
?>
