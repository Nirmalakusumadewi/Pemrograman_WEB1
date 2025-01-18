<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nidn = $_POST['nidn'];
    $nama_dosen = $_POST['nama_dosen'];


    $sql = "INSERT INTO dosen (nidn, nama_dosen)
            VALUES ('$nidn', '$nama_dosen')";

    if (mysqli_query($conn, $sql)) {
        echo "Data dosen berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<h2>Tambah Dosen</h2>
<form method="POST">
    NIDN: <input type="text" name="nidn" required><br>
    Nama Dosen: <input type="text" name="nama_dosen" required><br>

    <button type="submit">Simpan</button>
</form>