<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nidn = $_POST['nidn'];
    $nilai = $_POST['nilai'];

    $sql = "INSERT INTO perkuliahan (nim, kode_matakuliah, nidn, nilai)
            VALUES ('$nim', '$kode_matakuliah', '$nidn', '$nilai')";

    if (mysqli_query($conn, $sql)) {
        echo "Data perkuliahan berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<h2>Tambah Perkuliahan</h2>
<form method="POST">
    NIM: <input type="text" name="nim" required><br>
    Kode Matakuliah: <input type="text" name="kode_matakuliah" required><br>
    NIDN: <input type="text" name="nidn" required><br>
    Nilai: <input type="text" name="nilai" required><br>
    <button type="submit">Simpan</button>
</form>