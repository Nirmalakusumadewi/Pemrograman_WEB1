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

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $sks = $_POST['sks'];

    $sql = "UPDATE matakuliah SET nama_matakuliah = '$nama_matakuliah', sks = '$sks' WHERE kode_matakuliah = '$kode_matakuliah'";

    if ($conn->query($sql) === TRUE) {
        echo "Data matakuliah berhasil diupdate!";
        header("Location: ../index.php"); // Redirect ke halaman utama
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Ambil data matakuliah berdasarkan kode_matakuliah
if (isset($_GET['kode_matakuliah'])) {
    $kode_matakuliah = $_GET['kode_matakuliah'];
    $sql = "SELECT * FROM matakuliah WHERE kode_matakuliah = '$kode_matakuliah'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Matakuliah tidak ditemukan!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Matakuliah</title>
</head>

<body>
    <h1>Edit Matakuliah</h1>
    <form action="matakuliah_edit.php" method="POST">
        <input type="hidden" name="kode_matakuliah" value="<?php echo $data['kode_matakuliah']; ?>">
        <label for="nama_matakuliah">Nama Matakuliah:</label><br>
        <input type="text" id="nama_matakuliah" name="nama_matakuliah" value="<?php echo $data['nama_matakuliah']; ?>"
            required><br><br>
        <label for="sks">SKS:</label><br>
        <input type="number" id="sks" name="sks" value="<?php echo $data['sks']; ?>" required><br><br>
        <button type="submit">Update</button>
    </form>
</body>

</html>