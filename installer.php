<?php
// 1. Koneksi ke database mysql
$hostname = "localhost";
$username = "root";
$password = "";

$db = new mysqli($hostname, $username, $password);

// cek kondisi
if ($db->connect_error) {
    die("Koneksi gagal" . $db->connect_error);
} else {
    echo "Koneksi berhasil" . "<br>";
}

// 2. buat database jika belum ada
$sql_buat_db = "CREATE DATABASE IF NOT EXISTS db_rekomendasi_pkl";
$eksekusi_buat_db = $db->query($sql_buat_db);

if ($eksekusi_buat_db) {
    echo "database 'db_rekomendasi_pkl' berhasil dibuat atau sudah ada" . "<br>";
} else {
    die("Gagal membuat database: " . $db->error);
}

// 3. pilih database
$sql_masuk_db = "USE db_rekomendasi_pkl";
$eksekusi_masuk_db = $db->query($sql_masuk_db);

if ($eksekusi_masuk_db) {
    echo "Berhasil masuk ke database db_rekomendasi_pkl";
} else {
    die("Gagal masuk database: " . $db->error);
}

// 4. Buat tabel 'users' jika belum ada
$sql_buat_tabel_users = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    nomor_telepon VARCHAR(50) NOT NULL,
    role ENUM('siswa', 'perusahaan') NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$eksekusi_buat_tabel_users = $db->query($sql_buat_tabel_users);

if ($eksekusi_buat_tabel_users) {
    echo "Berhasil membuat tabel users";
} else {
    die("Gagal Membuat tabel users: " . $db->error);
}

// 5. Buat tabel 'perusahaan' jika belum ada
$sql_buat_tabel_perusahaan = "CREATE TABLE IF NOT EXISTS perusahaan (
    perusahaan_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama_perusahaan VARCHAR(255) NOT NULL,
    tentang_perusahaan TEXT,
    lokasi_perusahaan VARCHAR(255),
    kontak_email VARCHAR(100) NOT NULL,
    kontak_telepon VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
)";
$eksekusi_buat_tabel_perusahaan = $db->query($sql_buat_tabel_perusahaan);

if ($eksekusi_buat_tabel_perusahaan) {
    echo "Berhasil membuat tabel Perusahaan";
} else {
    die("Gagal Membuat tabel Perusahaan: " . $db->error);
}

// 6. Buat tabel 'lowongan PKL' jika belum ada
$sql_buat_tabel_lowongan_pkl = "CREATE TABLE IF NOT EXISTS lowongan_pkl (
    lowongan_id INT AUTO_INCREMENT PRIMARY KEY,
    perusahaan_id INT NOT NULL,
    skill_yang_dibutuhkan TEXT NOT NULL,
    jurusan VARCHAR(255) NOT NULL,
    jenjang_kontrak ENUM('3 bulan', '6 bulan', '1 tahun') NOT NULL,
    status ENUM('tersedia', 'penuh', 'ditutup') DEFAULT 'tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (perusahaan_id) REFERENCES perusahaan(perusahaan_id) ON DELETE CASCADE
)";

$eksekusi_buat_tabel_lowongan_pkl = $db->query($sql_buat_tabel_lowongan_pkl);

if ($eksekusi_buat_tabel_lowongan_pkl) {
    echo "Berhasil membuat tabel lowongan PKL";
} else {
    die("Gagal Membuat tabel lowongan PKL: " . $db->error);
}
