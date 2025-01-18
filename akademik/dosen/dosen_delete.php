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

if (isset($_GET['nidn'])) {
    $nidn = $_GET['nidn'];

    // Hapus data dosen berdasarkan NIDN
    $delete_sql = "DELETE FROM dosen WHERE nidn = '$nidn'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Data berhasil dihapus. <a href='index.php'>Kembali ke daftar</a>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "NIDN tidak ditemukan.";
}

$conn->close();
?>