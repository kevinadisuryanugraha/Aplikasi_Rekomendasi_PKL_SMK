<?php
// Koneksi ke database
include_once 'config.php';
include_once 'functions.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $perusahaan_id = $_POST['perusahaan_id']; // Mengambil perusahaan_id dari form
    $skill_yang_dibutuhkan = $_POST['skill_yang_dibutuhkan'];
    $jurusan = $_POST['jurusan'];
    $jenjang_kontrak = $_POST['jenjang_kontrak'];
    $status = $_POST['status'];

    $pesan = tambahLowonganPkl($perusahaan_id, $skill_yang_dibutuhkan, $jurusan, $jenjang_kontrak, $status);
}

// Mendapatkan perusahaan yang dimiliki oleh pengguna
$perusahaan = getPerusahaanByUserId($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lowongan PKL</title>
    <link rel="stylesheet" href="css/tambah_lowongan.css">
</head>

<body>
    <h1>Tambah Lowongan PKL</h1>

    <form action="" method="POST">
        <label for="perusahaan_id"> Perusahaan:</label>
        <select name="perusahaan_id" required>
            <?php foreach ($perusahaan as $item) : ?>
                <option value="<?php echo $item['perusahaan_id']; ?>"><?php echo $item['nama_perusahaan']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="Jurusan">Jurusan:</label>
        <input type="text" name="jurusan" placeholder="Jurusan" required>

        <label for="skill_yang_dibutuhkan">Skill yang dibutuhkan:</label>
        <input type="text" name="skill_yang_dibutuhkan" placeholder="Skill yang Dibutuhkan" required>

        <label for="jenjang_kontrak">Jenjang Kontrak:</label>
        <select name="jenjang_kontrak" required>
            <option value="3 bulan">3 Bulan</option>
            <option value="6 bulan">6 Bulan</option>
            <option value="1 tahun">1 Tahun</option>
        </select>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Tersedia">Tersedia</option>
            <option value="Tidak Tersedia">Tidak Tersedia</option>
        </select>
        <button type="submit">Tambah Lowongan</button>
    </form>

    <?php if (isset($pesan)) : ?>
        <p><?php echo $pesan; ?></p>
    <?php endif; ?>

    <a href="index_perusahaan.php">Kembali ke Daftar Lowongan</a>
</body>

</html>