<?php
$host = "localhost";  // Nama host server
$user = "root";       // Username database (default XAMPP: root)
$pass = "";           // Password database (default XAMPP: kosongkan)
$db = "akademik";   // Nama database

$conn = mysqli_connect($host, $user, $pass, $db);

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>