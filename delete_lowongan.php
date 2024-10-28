<?php
include_once 'config.php';
include_once 'functions.php';


session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['lowongan_id'])) {
    $lowongan_id = $_POST['lowongan_id'];

    if (deleteLowongan($lowongan_id)) {
        header("Location: index_perusahaan.php?success=Lowongan berhasil dihapus");
        exit();
    } else {
        echo "Gagal menghapus lowongan.";
    }
} else {
    header("Location: index_perusahaan.php");
    exit();
}
