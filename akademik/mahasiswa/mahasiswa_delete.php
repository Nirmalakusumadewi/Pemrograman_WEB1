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

if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Hapus data mahasiswa berdasarkan NIM
    $delete_sql = "DELETE FROM mahasiswa WHERE nim = '$nim'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Data berhasil dihapus. <a href='index.php'>Kembali ke daftar</a>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "NIM tidak ditemukan.";
}

$conn->close();
?>