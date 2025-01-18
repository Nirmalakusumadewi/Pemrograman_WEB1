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

// Query untuk mendapatkan data yang akan diedit
$sql = "SELECT * FROM perkuliahan WHERE nim = '$nim' AND kode_matakuliah = '$kode_matakuliah'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Data tidak ditemukan.");
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nidn = $_POST['nidn'];
    $nilai = $_POST['nilai'];

    // Update data di database
    $update_sql = "UPDATE perkuliahan SET nidn = '$nidn', nilai = '$nilai' WHERE nim = '$nim' AND kode_matakuliah = '$kode_matakuliah'";
    if ($conn->query($update_sql)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='../index.php';</script>";
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
    <title>Edit Data Perkuliahan</title>
</head>

<body>
    <h1>Edit Data Perkuliahan</h1>
    <form method="POST">
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" value="<?php echo $row['nim']; ?>" readonly><br><br>

        <label for="kode_matakuliah">Kode Matakuliah:</label>
        <input type="text" id="kode_matakuliah" name="kode_matakuliah" value="<?php echo $row['kode_matakuliah']; ?>"
            readonly><br><br>

        <label for="nidn">NIDN:</label>
        <input type="text" id="nidn" name="nidn" value="<?php echo $row['nidn']; ?>"><br><br>

        <label for="nilai">Nilai:</label>
        <input type="text" id="nilai" name="nilai" value="<?php echo $row['nilai']; ?>"><br><br>

        <button type="submit">Simpan</button>
        <a href="../index.php">Batal</a>
    </form>
</body>

</html>