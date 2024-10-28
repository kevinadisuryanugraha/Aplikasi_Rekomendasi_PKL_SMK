<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_rekomendasi_pkl";

$db = new mysqli($hostname, $username, $password, $database);

if ($db->connect_error) {
    die("koneksi gagal: " . $db->connect_error);
} else {
    // echo "koneksi berhasil";
}
