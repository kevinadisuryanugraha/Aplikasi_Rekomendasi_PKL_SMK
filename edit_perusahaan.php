<?php
// Koneksi ke database
include_once 'config.php';
include_once 'functions.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['perusahaan_id'])) {
    header("Location: index_perusahaan.php");
    exit();
}

$perusahaan_id = $_GET['perusahaan_id'];

// Ambil data perusahaan berdasarkan ID
$perusahaan = getPerusahaanById($perusahaan_id);

if (!$perusahaan) {
    echo "Perusahaan tidak ditemukan.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $perusahaan_id = $_POST['perusahaan_id'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $tentang_perusahaan = $_POST['tentang_perusahaan'];
    $lokasi_perusahaan = $_POST['lokasi_perusahaan'];
    $kontak_email = $_POST['kontak_email'];
    $kontak_telepon = $_POST['kontak_telepon'];

    // Update data perusahaan
    $result = updatePerusahaan($perusahaan_id, $nama_perusahaan, $tentang_perusahaan, $lokasi_perusahaan, $kontak_email, $kontak_telepon);

    if ($result) {
        header("Location: index_perusahaan.php");
        exit();
    } else {
        echo "Gagal mengupdate perusahaan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Perusahaan</title>
    <link rel="stylesheet" href="css/edit_perusahaan.css">
</head>

<body>
    <div class="container">
        <h1>Edit Perusahaan</h1>
        <form method="POST" action="">
            <input type="hidden" name="perusahaan_id" value="<?php echo $perusahaan['perusahaan_id']; ?>">
            <label for="nama_perusahaan">Nama Perusahaan</label>
            <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="<?php echo $perusahaan['nama_perusahaan']; ?>" required>

            <label for="tentang_perusahaan">Tentang Perusahaan</label>
            <input type="text" id="tentang_perusahaan" name="tentang_perusahaan" value="<?php echo $perusahaan['tentang_perusahaan']; ?>" required>

            <label for="lokasi_perusahaan">Lokasi Perusahaan</label>
            <input type="text" id="lokasi_perusahaan" name="lokasi_perusahaan" value="<?php echo $perusahaan['lokasi_perusahaan']; ?>" required>

            <label for="kontak_email">Kontak Email</label>
            <input type="email" id="kontak_email" name="kontak_email" value="<?php echo $perusahaan['kontak_email']; ?>" required>

            <label for="kontak_telepon">Kontak Telepon</label>
            <input type="tel" id="kontak_telepon" name="kontak_telepon" value="<?php echo $perusahaan['kontak_telepon']; ?>" required>

            <button type="submit">Update Perusahaan</button>
        </form>
        <a href="index_perusahaan.php" class="back-link">Kembali ke Daftar Perusahaan</a>
    </div>
</body>

</html>