<?php
include_once 'config.php';
include_once 'functions.php';

$lowongan_id = $_GET['lowongan_id'];

$lowongan = getLowonganById($lowongan_id);
if (!$lowongan) {
    die("Lowongan tidak ditemukan.");
}

$perusahaan = getPerusahaanByLowonganId($lowongan_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan</title>
    <link rel="stylesheet" href="css/detail_lowongan.css">
</head>

<body>
    <div class="container">
        <h1>Detail Lowongan</h1>

        <!-- Informasi Perusahaan -->
        <?php if ($perusahaan): ?>
            <section class="company-info">
                <h2>Informasi Perusahaan</h2>
                <p><strong>Nama Perusahaan:</strong> <?php echo $perusahaan['nama_perusahaan']; ?></p>
                <p><strong>Tentang Perusahaan:</strong> <?php echo $perusahaan['tentang_perusahaan']; ?></p>
                <p><strong>Lokasi Perusahaan:</strong> <?php echo $perusahaan['lokasi_perusahaan']; ?></p>
                <p><strong>Email Kontak:</strong> <?php echo $perusahaan['kontak_email']; ?></p>
                <p><strong>Telepon Kontak:</strong> <?php echo $perusahaan['kontak_telepon']; ?></p>
            </section>
        <?php else: ?>
            <p>Informasi perusahaan tidak tersedia.</p>
        <?php endif; ?>

        <!-- Informasi Lowongan PKL -->
        <section class="job-info">
            <h2>Informasi Lowongan PKL</h2>
            <p><strong>Skill yang Dibutuhkan:</strong> <?php echo $lowongan['skill_yang_dibutuhkan']; ?></p>
            <p><strong>Jurusan:</strong> <?php echo $lowongan['jurusan']; ?></p>
            <p><strong>Jenjang Kontrak:</strong> <?php echo $lowongan['jenjang_kontrak']; ?></p>
            <p><strong>Status:</strong> <?php echo $lowongan['status'] == 'tersedia' ? 'Tersedia' : 'Ditutup'; ?></p>
        </section>

        <a href="index_siswa.php" class="back-button">Kembali ke Dashboard</a>
    </div>
</body>

</html>