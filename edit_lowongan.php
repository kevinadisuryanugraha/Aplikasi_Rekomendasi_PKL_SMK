<?php
// Koneksi ke database
include_once 'config.php';
include_once 'functions.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['lowongan_id'])) {
    header("Location: index_perusahaan.php");
    exit();
}

$lowongan_id = $_GET['lowongan_id'];

$lowongan = getLowonganById($lowongan_id);

if (!$lowongan) {
    echo "Lowongan tidak ditemukan.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $skill_yang_dibutuhkan = $_POST['skill_yang_dibutuhkan'];
    $jurusan = $_POST['jurusan'];
    $jenjang_kontrak = $_POST['jenjang_kontrak'];
    $status = $_POST['status'];

    $result = updateLowongan($lowongan_id, $skill_yang_dibutuhkan, $jurusan, $jenjang_kontrak, $status);

    if ($result) {
        header("Location: index_perusahaan.php");
        exit();
    } else {
        echo "Gagal mengupdate lowongan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lowongan PKL</title>
    <link rel="stylesheet" href="css/edit_lowongan.css">
</head>

<body>
    <div class="container">
        <h1>Edit Lowongan PKL</h1>

        <form action="edit_lowongan.php?lowongan_id=<?php echo $lowongan_id; ?>" method="POST">
            <label for="skill_yang_dibutuhkan">Skill yang Dibutuhkan:</label>
            <input type="text" name="skill_yang_dibutuhkan" id="skill_yang_dibutuhkan" value="<?php echo htmlspecialchars($lowongan['skill_yang_dibutuhkan']); ?>" required>

            <label for="jurusan">Jurusan:</label>
            <input type="text" name="jurusan" id="jurusan" value="<?php echo htmlspecialchars($lowongan['jurusan']); ?>" required>

            <label for="jenjang_kontrak">Jenjang Kontrak:</label>
            <select name="jenjang_kontrak" id="jenjang_kontrak" required>
                <option value="3 Bulan" <?php if ($lowongan['jenjang_kontrak'] == '3 Bulan') echo 'selected'; ?>>3 Bulan</option>
                <option value="6 Bulan" <?php if ($lowongan['jenjang_kontrak'] == '6 Bulan') echo 'selected'; ?>>6 Bulan</option>
                <option value="1 Tahun" <?php if ($lowongan['jenjang_kontrak'] == '1 Tahun') echo 'selected'; ?>>1 Tahun</option>
            </select>

            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="tersedia" <?php if ($lowongan['status'] == 'tersedia') echo 'selected'; ?>>Tersedia</option>
                <option value="ditutup" <?php if ($lowongan['status'] == 'ditutup') echo 'selected'; ?>>Ditutup</option>
            </select>

            <button type="submit">Simpan Perubahan</button>
        </form>

        <a href="index_perusahaan.php" class="back-link">Kembali</a>
    </div>
</body>

</html>