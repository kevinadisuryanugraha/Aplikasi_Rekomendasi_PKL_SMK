<?php
include 'functions.php';

// Inisialisasi variabel error
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];

    // Validasi input apakah tidak kosong
    if (!empty($nama_lengkap) && !empty($email)) {
        // Panggil fungsi loginUser() dari functions.php
        $error = loginUser($nama_lengkap, $email);
    } else {
        $error = "Nama lengkap dan email harus diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi PKL</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>

    <div class="login-container">
        <h2>Login Aplikasi PKL</h2>

        <!-- Tampilkan pesan error jika ada -->
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Login</button>
        </form>

        <p style="text-align: center;">
            Jika belum mempunyai akun silahkan <a href="register.php">Register disini!</a>
        </p>
    </div>

</body>

</html>