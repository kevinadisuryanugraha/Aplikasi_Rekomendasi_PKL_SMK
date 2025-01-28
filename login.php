<?php
include 'functions.php';

// Inisialisasi variabel error
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input apakah tidak kosong
    if (!empty($email) && !empty($password)) {
        // Panggil fungsi loginUser() dari functions.php
        $error = loginUser($email, $password);
    } else {
        $error = "Email dan password harus diisi.";
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
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p style="text-align: center;">
            Jika belum mempunyai akun silahkan <a href="register.php">Register disini!</a>
        </p>
    </div>

</body>

</html>