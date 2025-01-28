<?php
include 'functions.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$lowongan_pkl = getAllLowonganPKL();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lowongan PKL</title>
    <link rel="stylesheet" href="css/index_siswa.css">
</head>

<body>
    <!-- Halaman Selamat Datang -->
    <div class="welcome-section">
        <h1>Selamat Datang di Aplikasi Lowongan PKL!</h1>
        <p>Kami senang Anda bergabung. Temukan berbagai lowongan PKL yang sesuai dengan skill Anda.</p>
    </div>

    <!-- Daftar Lowongan PKL -->
    <div class="container" id="daftar-lowongan">
        <h1>Daftar Lowongan PKL</h1>
        <table>
            <thead>
                <tr>
                    <th>Nama Perusahaan</th>
                    <th>Skill yang Dibutuhkan</th>
                    <th>Jurusan</th>
                    <th>Jenjang Kontrak</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lowongan_pkl as $lowongan): ?>
                    <tr>
                        <td><?php echo $lowongan['nama_perusahaan']; ?></td>
                        <td><?php echo $lowongan['skill_yang_dibutuhkan']; ?></td>
                        <td><?php echo $lowongan['jurusan']; ?></td>
                        <td><?php echo $lowongan['jenjang_kontrak']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($lowongan['created_at'])); ?></td>
                        <td><?php echo $lowongan['status'] == 'tersedia' ? 'Tersedia' : 'Ditutup'; ?></td>
                        <td>
                            <a href="detail_lowongan.php?lowongan_id=<?php echo $lowongan['lowongan_id']; ?>">Lihat Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>

</html>