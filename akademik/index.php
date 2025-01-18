<?php
// Start session
session_start();

// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'akademik';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa login
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header('Location: ' . $_SERVER['PHP_SELF']); // Reload halaman
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}

// Jika user belum login, tampilkan halaman login
if (!isset($_SESSION['username'])):
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Aplikasi Akademik</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .login-container {
                background: #ffffff;
                padding: 30px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                text-align: center;
                width: 100%;
                max-width: 400px;
            }

            .login-container h1 {
                margin-bottom: 20px;
            }

            .login-container input[type="text"],
            .login-container input[type="password"] {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            .login-container button {
                width: 100%;
                padding: 10px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
            }

            .login-container button:hover {
                background-color: #0056b3;
            }

            .error {
                color: red;
                margin-top: 10px;
            }
        </style>
    </head>

    <body>
        <div class="login-container">
            <h1>Login</h1>
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
        </div>
    </body>

    </html>
    <?php
    exit;
endif;

// Ambil data mahasiswa, dosen, matakuliah, dan perkuliahan dengan join
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
    JOIN dosen ON perkuliahan.nidn = dosen.nidn
";

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
    <title>Aplikasi Akademik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
        }

        .menu a {
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .menu a:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <h1>Aplikasi Akademik</h1>

    <!-- Menu untuk menambah data -->
    <div class="menu">
        <a href="mahasiswa/mahasiswa_add.php">Tambah Mahasiswa</a>
        <a href="dosen/dosen_add.php">Tambah Dosen</a>
        <a href="matakuliah/matakuliah_add.php">Tambah Matakuliah</a>
        <a href="perkuliahan/perkuliahan_add.php">Tambah Perkuliahan</a>
        <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </div>

    <h3>Selamat datang, <?php echo $_SESSION['username']; ?>!</h3>

    <!-- Tampilkan data mahasiswa, dosen, matakuliah, dan perkuliahan -->
    <h2>Daftar Mahasiswa</h2>
    <table>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result_mahasiswa->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['nim']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td>
                    <a href="mahasiswa/mahasiswa_edit.php?nim=<?php echo $row['nim']; ?>">Edit</a> |
                    <a href="mahasiswa/mahasiswa_delete.php?nim=<?php echo $row['nim']; ?> "
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Daftar Dosen</h2>
    <table>
        <tr>
            <th>NIDN</th>
            <th>Nama Dosen</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result_dosen->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['nidn']; ?></td>
                <td><?php echo $row['nama_dosen']; ?></td>
                <td>
                    <a href="dosen/dosen_edit.php?nidn=<?php echo $row['nidn']; ?>">Edit</a> |
                    <a href="dosen/dosen_delete.php?nidn=<?php echo $row['nidn']; ?>"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Daftar Matakuliah</h2>
    <table>
        <tr>
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>SKS</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result_matakuliah->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['kode_matakuliah']; ?></td>
                <td><?php echo $row['nama_matakuliah']; ?></td>
                <td><?php echo $row['sks']; ?></td>
                <td>
                    <a href="matakuliah/matakuliah_edit.php?kode_matakuliah=<?php echo $row['kode_matakuliah']; ?>">Edit</a>
                    |
                    <a href="matakuliah/matakuliah_delete.php?kode_matakuliah=<?php echo $row['kode_matakuliah']; ?>"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Daftar Perkuliahan</h2>
    <table>
        <tr>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>NIDN</th>
            <th>Nama Dosen</th>
            <th>Nilai</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result_perkuliahan->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['nim']; ?></td>
                <td><?php echo $row['nama_mahasiswa']; ?></td>
                <td><?php echo $row['kode_matakuliah']; ?></td>
                <td><?php echo $row['nama_matakuliah']; ?></td>
                <td><?php echo $row['nidn']; ?></td>
                <td><?php echo $row['nama_dosen']; ?></td>
                <td><?php echo $row['nilai']; ?></td>
                <td>
                    <a
                        href="perkuliahan/perkuliahan_edit.php?nim=<?php echo $row['nim']; ?>&kode_matakuliah=<?php echo $row['kode_matakuliah']; ?>">Edit</a>
                    |
                    <a href="perkuliahan/perkuliahan_delete.php?nim=<?php echo $row['nim']; ?>&kode_matakuliah=<?php echo $row['kode_matakuliah']; ?>"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>