<?php
include_once 'config.php';
include_once 'functions.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

// Ambil semua lowongan PKL
$lowongan_pkl = getAllLowonganPKL();

// Mengambil perusahaan yang dimiliki oleh user saat ini
$company = getCompanyByUser($_SESSION['user_id']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perusahaan</title>
    <link rel="stylesheet" href="css/index_perusahaan.css">
</head>

<body>
    <div class="container">
        <h1>Dashboard Perusahaan</h1>

        <!-- Informasi Perusahaan -->
        <?php if ($company): ?>
            <section class="company-info">
                <h2>Informasi Perusahaan Anda</h2>
                <p><strong>Nama Perusahaan:</strong> <?php echo $company['nama_perusahaan']; ?></p>
                <p><strong>Tentang Perusahaan:</strong> <?php echo $company['tentang_perusahaan']; ?></p>
                <p><strong>Lokasi Perusahaan:</strong> <?php echo $company['lokasi_perusahaan']; ?></p>
                <p><strong>Kontak Email:</strong> <?php echo $company['kontak_email']; ?></p>
                <p><strong>Kontak Telepon:</strong> <?php echo $company['kontak_telepon']; ?></p>
                <a href="edit_perusahaan.php?perusahaan_id=<?php echo $company['perusahaan_id']; ?>">Edit Perusahaan</a>
            </section>
        <?php else: ?>
            <p>Anda belum menambahkan perusahaan.</p>
            <a href="tambah_perusahaan.php">Tambah Perusahaan</a>
        <?php endif; ?>

        <!-- Daftar Lowongan PKL -->
        <h1>Daftar Lowongan PKL</h1>
        <table>
            <thead>
                <tr>
                    <th>Nama Perusahaan</th>
                    <th>Skill yang Dibutuhkan</th>
                    <th>Jenjang Kontrak</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lowongan_pkl as $lowongan): ?>
                    <tr>
                        <td><?php echo $lowongan['nama_perusahaan'] ?></td>
                        <td><?php echo $lowongan['skill_yang_dibutuhkan']; ?></td>
                        <td><?php echo $lowongan['jenjang_kontrak']; ?></td>
                        <td><?php echo $lowongan['status'] == 'tersedia' ? 'Tersedia' : 'Ditutup'; ?></td>
                        <td>
                            <form action="edit_lowongan.php" method="GET" style="display:inline;">
                                <input type="hidden" name="lowongan_id" value="<?php echo $lowongan['lowongan_id']; ?>">
                                <button type="submit">Edit</button>
                            </form>
                            <form action="delete_lowongan.php" method="POST" style="display:inline;">
                                <input type="hidden" name="lowongan_id" value="<?php echo $lowongan['lowongan_id']; ?>">
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?');">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="tambah_lowongan.php">Tambah Lowongan PKL</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>


</html>