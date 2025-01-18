<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'akademik';

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil parameter dari URL
$nim = $_GET['nim'];
$kode_matakuliah = $_GET['kode_matakuliah'];

// Query untuk menghapus data
$sql = "DELETE FROM perkuliahan WHERE nim = '$nim' AND kode_matakuliah = '$kode_matakuliah'";
if ($conn->query($sql)) {
    echo "<script>alert('Data berhasil dihapus!'); window.location.href='../index.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>