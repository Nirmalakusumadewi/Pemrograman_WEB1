<?php
// Start session
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: index.php'); // Jika belum login, redirect ke halaman login
    exit;
}

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'akademik';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data mahasiswa, dosen, matakuliah, dan perkuliahan
$sql_mahasiswa = "SELECT * FROM mahasiswa";
$sql_dosen = "SELECT * FROM dosen";
$sql_matakuliah = "SELECT * FROM matakuliah";
$sql_perkuliahan = "
    SELECT 
        perkuliahan.nim,
        mahasiswa.nama AS nama_mahasiswa,
        perkuliahan.kode_matakuliah,
        matakuliah.nama_matakuliah,
        perkuliahan.nidn,
        dosen.nama_dosen,
        perkuliahan.nilai
    FROM perkuliahan
    JOIN mahasiswa ON perkuliahan.nim = mahasiswa.nim
    JOIN matakuliah ON perkuliahan.kode_matakuliah = matakuliah.kode_matakuliah
    JOIN dosen ON perkuliahan.nidn = dosen.nidn";

$result_mahasiswa = $conn->query($sql_mahasiswa);
$result_dosen = $conn->query($sql_dosen);
$result_matakuliah = $conn->query($sql_matakuliah);
$result_perkuliahan = $conn->query($sql_perkuliahan);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Aplikasi Akademik</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div>
        <h1>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Gunakan menu di bawah untuk mengelola data akademik:</p>
    </div>
    <!-- Tampilkan Menu -->
    <!-- Tambahkan tabel daftar mahasiswa, dosen, matakuliah, dan perkuliahan seperti sebelumnya -->
</body>

</html>