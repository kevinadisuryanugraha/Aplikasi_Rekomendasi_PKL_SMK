<?php
include 'functions.php';

// Inisialisasi variabel error
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $role = $_POST['role'];

    // Validasi input apakah tidak kosong
    if (!empty($nama_lengkap) && !empty($email) && !empty($nomor_telepon) && !empty($role)) {
        // Panggil fungsi registerUser() dari functions.php
        $error = tambahUser($nama_lengkap, $email, $nomor_telepon, $role);
    } else {
        $error = "Semua field harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aplikasi PKL</title>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>

    <div class="register-container">
        <h2>Register Aplikasi PKL</h2>

        <!-- Tampilkan pesan error jika ada -->
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="tel" id="nomor_telepon" name="nomor_telepon" required>

            <label for="role">Peran</label>
            <select id="role" name="role" required>
                <option value="siswa">Siswa</option>
                <option value="perusahaan">Perusahaan</option>
            </select>

            <button type="submit">Register</button>
        </form>
    </div>

</body>

</html>