<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];

    // Debugging untuk memeriksa data dari form
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Query untuk menambahkan data
    $sql = "INSERT INTO mahasiswa (nim, nama, tgl_lahir, jenis_kelamin, alamat)
            VALUES ('$nim', '$nama', '$tgl_lahir', '$jenis_kelamin', '$alamat')";

    // Eksekusi query
    if (mysqli_query($conn, $sql)) {
        echo "Data mahasiswa berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
        echo "Query: " . $sql;
    }
}
?>
<h2>Tambah Mahasiswa</h2>
<form method="POST">
    NIM: <input type="text" name="nim" required><br>
    Nama: <input type="text" name="nama" required><br>
    Tgl Lahir: <input type="date" name="tgl_lahir" required><br>
    Jenis Kelamin:
    <select name="jenis_kelamin" required>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select><br>
    Alamat: <textarea name="alamat" required></textarea><br>
    <button type="submit">Simpan</button>
</form>