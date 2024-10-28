<?php
include_once 'config.php';

// Fungsi untuk menambahkan user baru
function tambahUser($nama_lengkap, $email, $nomor_telepon, $role)
{
    global $db;
    $sql = "INSERT INTO users (nama_lengkap, email, nomor_telepon, role) 
            VALUES ('$nama_lengkap', '$email', '$nomor_telepon', '$role')";
    if ($db->query($sql)) {
        header("Location: login.php");
        exit();
    } else {
        return "Gagal menambahkan user: " . $db->error;
    }
}

// Fungsi login di functions.php
function loginUser($nama_lengkap, $email)
{
    global $db;

    $query = "SELECT * FROM users WHERE nama_lengkap = '$nama_lengkap' AND email = '$email'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role']; // Menyimpan role di session

        // Arahkan ke halaman utama setelah login berhasil
        if ($user['role'] == 'siswa') {
            header("Location: index_siswa.php");
        } elseif ($user['role'] == 'perusahaan') {
            header("Location: index_perusahaan.php");
        }
        exit();
    } else {
        return "Email atau nomor telepon salah.";
    }
}

// Fungsi untuk mendapatkan semua data user
function getAllUsers()
{
    global $db;
    $sql = "SELECT * FROM users";
    $result = $db->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Fungsi untuk menambahkan perusahaan
function tambahPerusahaan($user_id, $nama_perusahaan, $tentang_perusahaan, $lokasi_perusahaan, $kontak_email, $kontak_telepon)
{
    global $db;
    $sql = "INSERT INTO perusahaan (user_id, nama_perusahaan, tentang_perusahaan, lokasi_perusahaan, kontak_email, kontak_telepon) 
            VALUES ('$user_id', '$nama_perusahaan', '$tentang_perusahaan', '$lokasi_perusahaan', '$kontak_email', '$kontak_telepon')";
    if ($db->query($sql)) {
        return "Perusahaan berhasil ditambahkan.";
    } else {
        return "Gagal menambahkan perusahaan: " . $db->error;
    }
}

// Fungsi untuk mendapatkan semua perusahaan yang dimiliki user
function getPerusahaanByUserId($user_id)
{
    global $db;
    $sql = "SELECT * FROM perusahaan WHERE user_id = '$user_id'";
    $result = $db->query($sql);
    $perusahaan = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $perusahaan[] = $row;
        }
    }
    return $perusahaan;
}

// Fungsi untuk mendapatkan data perusahaan berdasarkan ID
function getPerusahaanById($perusahaan_id)
{
    global $db;
    $sql = "SELECT * FROM perusahaan WHERE perusahaan_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $perusahaan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

// Fungsi untuk mengupdate data perusahaan
function updatePerusahaan($perusahaan_id, $nama_perusahaan, $tentang_perusahaan, $lokasi_perusahaan, $kontak_email, $kontak_telepon)
{
    global $db;
    $sql = "UPDATE perusahaan SET 
                nama_perusahaan = ?, 
                tentang_perusahaan = ?, 
                lokasi_perusahaan = ?, 
                kontak_email = ?, 
                kontak_telepon = ? 
            WHERE perusahaan_id = ?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssssi", $nama_perusahaan, $tentang_perusahaan, $lokasi_perusahaan, $kontak_email, $kontak_telepon, $perusahaan_id);

    return $stmt->execute();
}

function getCompanyByUser($user_id)
{
    global $db;
    $query = "SELECT * FROM perusahaan WHERE user_id = ? LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function tambahLowonganPkl($perusahaan_id, $skill_yang_dibutuhkan, $jurusan, $jenjang_kontrak, $status)
{
    global $db;

    // Query untuk menambahkan lowongan PKL dengan field yang baru
    $sql = "INSERT INTO lowongan_pkl (perusahaan_id, skill_yang_dibutuhkan, jurusan, jenjang_kontrak, status) 
            VALUES ('$perusahaan_id', '$skill_yang_dibutuhkan', '$jurusan', '$jenjang_kontrak', '$status')";

    if ($db->query($sql)) {
        return "Lowongan PKL berhasil ditambahkan.";
    } else {
        return "Gagal menambahkan lowongan PKL: " . $db->error;
    }
}


function getAllLowonganPKL()
{
    global $db;
    // Tambahkan kolom 'created_at' pada query
    $sql = "SELECT l.lowongan_id, p.nama_perusahaan, l.skill_yang_dibutuhkan, l.jenjang_kontrak, l.status, l.created_at 
    FROM lowongan_pkl l 
    JOIN perusahaan p ON l.perusahaan_id = p.perusahaan_id";
    $result = $db->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}



function getLowonganById($lowongan_id)
{
    global $db;
    $sql = "SELECT * FROM lowongan_pkl WHERE lowongan_id = '$lowongan_id'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function getPerusahaanByLowonganId($lowongan_id)
{
    global $db;
    $sql = "SELECT p.nama_perusahaan, p.tentang_perusahaan, p.lokasi_perusahaan, p.kontak_email, p.kontak_telepon 
            FROM perusahaan p 
            JOIN lowongan_pkl l ON p.perusahaan_id = l.perusahaan_id 
            WHERE l.lowongan_id = '$lowongan_id'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


function updateLowongan($lowongan_id, $skill_yang_dibutuhkan, $jurusan, $jenjang_kontrak, $status)
{
    global $db;
    // Menggunakan query UPDATE untuk mengubah data lowongan
    $sql = "UPDATE lowongan_pkl 
            SET skill_yang_dibutuhkan = '$skill_yang_dibutuhkan', 
                jurusan = '$jurusan', 
                jenjang_kontrak = '$jenjang_kontrak', 
                status = '$status' 
            WHERE lowongan_id = '$lowongan_id'";

    return $db->query($sql);
} {
    global $db;
    $sql = "SELECT l.lowongan_id, p.nama_perusahaan, l.skill_yang_dibutuhkan, l.jenjang_kontrak, l.status 
        FROM lowongan_pkl l 
        JOIN perusahaan p ON l.perusahaan_id = p.perusahaan_id";

    return $db->query($sql);
}


function getLowonganByPerusahaanId($perusahaan_id)
{
    global $db; // Pastikan ini menggunakan $db, bukan $conn
    $stmt = $db->prepare("SELECT * FROM lowongan_pkl WHERE perusahaan_id = ?");
    $stmt->bind_param("i", $perusahaan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


function deleteLowongan($lowongan_id)
{
    global $db;
    $sql = "DELETE FROM lowongan_pkl WHERE lowongan_id = '$lowongan_id'";

    return $db->query($sql);
}
