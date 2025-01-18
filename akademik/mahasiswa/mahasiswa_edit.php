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
    // Debug: tampilkan NIM yang diterima
    echo "NIM yang diterima: " . $nim . "<br>";

    // Ambil data mahasiswa berdasarkan NIM
    $sql = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $mahasiswa = $result->fetch_assoc();
    } else {
        echo "Data mahasiswa tidak ditemukan.";
        exit;  // Jika tidak ditemukan data, berhenti eksekusi
    }
}

if (isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    // Update data mahasiswa
    $update_sql = "UPDATE mahasiswa SET nama = '$nama', alamat = '$alamat' WHERE nim = '$nim'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Data berhasil diperbarui. <a href='index.php'>Kembali ke daftar</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
</head>

<body>
    <h1>Edit Data Mahasiswa</h1>
    <?php if (isset($mahasiswa)): ?>
        <form method="POST">
            <label for="nim">NIM:</label><br>
            <input type="text" name="nim" value="<?php echo $mahasiswa['nim']; ?>" readonly><br><br>

            <label for="nama">Nama:</label><br>
            <input type="text" name="nama" value="<?php echo $mahasiswa['nama']; ?>"><br><br>

            <label for="alamat">Alamat:</label><br>
            <textarea name="alamat"><?php echo $mahasiswa['alamat']; ?></textarea><br><br>

            <button type="submit" name="submit">Simpan Perubahan</button>
        </form>
    <?php else: ?>
        <p>Data mahasiswa tidak ditemukan.</p>
    <?php endif; ?>
</body>

</html>

<?php
$conn->close();
?>