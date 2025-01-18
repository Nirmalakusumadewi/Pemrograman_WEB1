<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $sks = $_POST['sks'];

    $sql = "INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, sks)
            VALUES ('$kode_matakuliah', '$nama_matakuliah', '$sks')";

    if (mysqli_query($conn, $sql)) {
        echo "Data matakuliah berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<h2>Tambah Matakuliah</h2>
<form method="POST">
    Kode Matakuliah: <input type="text" name="kode_matakuliah" required><br>
    Nama Matakuliah: <input type="text" name="nama_matakuliah" required><br>
    SKS: <input type="number" name="sks" required><br>
    <button type="submit">Simpan</button>
</form>