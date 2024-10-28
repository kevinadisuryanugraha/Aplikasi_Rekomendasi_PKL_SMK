<?php
// Koneksi ke database
include_once 'config.php';
include_once 'functions.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_perusahaan'])) {
    $user_id = $_SESSION['user_id'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $tentang_perusahaan = $_POST['tentang_perusahaan'];
    $lokasi_perusahaan = $_POST['lokasi_perusahaan'];
    $kontak_email = $_POST['kontak_email'];
    $kontak_telepon = $_POST['kontak_telepon'];

    $pesan = tambahPerusahaan($user_id, $nama_perusahaan, $tentang_perusahaan, $lokasi_perusahaan, $kontak_email, $kontak_telepon);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Perusahaan</title>
    <link rel="stylesheet" href="css/tambah_perusahaan.css">
</head>

<body>
    <div class="container">
        <h1>Tambah Perusahaan</h1>

        <form action="" method="POST">
            <input type="text" name="nama_perusahaan" placeholder="Nama Perusahaan" required>
            <textarea name="tentang_perusahaan" placeholder="Tentang Perusahaan" required></textarea>
            <input type="text" name="lokasi_perusahaan" placeholder="Lokasi Perusahaan" required>
            <input type="email" name="kontak_email" placeholder="Kontak Email" required>
            <input type="text" name="kontak_telepon" placeholder="Kontak Telepon" required>
            <button type="submit" name="tambah_perusahaan">Tambah Perusahaan</button>
        </form>

        <?php if (isset($pesan)) : ?>
            <p><?php echo $pesan; ?></p>
        <?php endif; ?>

        <a href="index_perusahaan.php">Kembali ke Daftar Lowongan</a>
    </div>
</body>

</html>