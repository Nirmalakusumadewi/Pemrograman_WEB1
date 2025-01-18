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

    // Ambil data dosen berdasarkan NIDN
    $sql = "SELECT * FROM dosen WHERE nidn = '$nidn'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $dosen = $result->fetch_assoc();
    } else {
        echo "Data dosen tidak ditemukan.";
        exit;  // Jika tidak ditemukan data, berhenti eksekusi
    }
}

if (isset($_POST['submit'])) {
    $nidn = $_POST['nidn'];
    $nama_dosen = $_POST['nama_dosen'];

    // Update data dosen
    $update_sql = "UPDATE dosen SET nama_dosen = '$nama_dosen' WHERE nidn = '$nidn'";
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
    <title>Edit Data Dosen</title>
</head>

<body>
    <h1>Edit Data Dosen</h1>
    <?php if (isset($dosen)): ?>
        <form method="POST">
            <label for="nidn">NIDN:</label><br>
            <input type="text" name="nidn" value="<?php echo $dosen['nidn']; ?>" readonly><br><br>

            <label for="nama_dosen">Nama Dosen:</label><br>
            <input type="text" name="nama_dosen" value="<?php echo $dosen['nama_dosen']; ?>"><br><br>

            <button type="submit" name="submit">Simpan Perubahan</button>
        </form>
    <?php else: ?>
        <p>Data dosen tidak ditemukan.</p>
    <?php endif; ?>
</body>

</html>

<?php
$conn->close();
?>