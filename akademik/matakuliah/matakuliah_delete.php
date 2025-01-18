<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'akademik';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses hapus data berdasarkan kode_matakuliah
if (isset($_GET['kode_matakuliah'])) {
    $kode_matakuliah = $_GET['kode_matakuliah'];

    $sql = "DELETE FROM matakuliah WHERE kode_matakuliah = '$kode_matakuliah'";

    if ($conn->query($sql) === TRUE) {
        echo "Matakuliah berhasil dihapus!";
        header("Location: ../index.php"); // Redirect ke halaman utama
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Kode matakuliah tidak ditemukan!";
}
?>