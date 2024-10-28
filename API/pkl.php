<?php

require_once "helper.php";
require_once "../functions.php";

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        // Mendapatkan semua pengguna
        if (isset($_GET['all_users'])) {
            $users = getAllUsers();
            $response = [
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $users
            ];
            echo response($response, 200);
        }
        // Mendapatkan perusahaan berdasarkan ID
        elseif (isset($_GET['perusahaan_id'])) {
            $perusahaan_id = $_GET['perusahaan_id'];
            $company = getPerusahaanById($perusahaan_id);
            if ($company) {
                $response = [
                    'status' => true,
                    'message' => 'Perusahaan ditemukan',
                    'data' => $company
                ];
                echo response($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Perusahaan tidak ditemukan'
                ];
                echo response($response, 404);
            }
        }
        // Mendapatkan semua lowongan atau lowongan berdasarkan ID
        elseif (isset($_GET['lowongan_id']) && !empty($_GET['lowongan_id'])) {
            $lowongan_id = $_GET['lowongan_id'];
            $detail_lowongan = getLowonganById($lowongan_id);

            if ($detail_lowongan) {
                $response = [
                    'status' => true,
                    'message' => 'Data ditemukan',
                    'data' => $detail_lowongan
                ];
                echo response($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ];
                echo response($response, 404);
            }
        } else {
            $list_lowongan = getAllLowonganPKL();
            $response = [
                'status' => true,
                'message' => 'Sukses',
                'data' => $list_lowongan
            ];
            echo response($response, 200);
        }
        break;

    case 'POST':
        // Menambahkan pengguna baru
        if (isset($_POST['nama_lengkap'], $_POST['email'], $_POST['nomor_telepon'], $_POST['role'])) {
            $result = tambahUser($_POST['nama_lengkap'], $_POST['email'], $_POST['nomor_telepon'], $_POST['role']);
            if ($result) {
                $response = [
                    'status' => true,
                    'message' => 'Pengguna berhasil ditambahkan'
                ];
                echo response($response, 201);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menambahkan pengguna'
                ];
                echo response($response, 500);
            }
        }
        // Menambahkan perusahaan baru
        elseif (isset($_POST['user_id'], $_POST['nama_perusahaan'], $_POST['tentang_perusahaan'], $_POST['lokasi_perusahaan'], $_POST['kontak_email'], $_POST['kontak_telepon'])) {
            $result = tambahPerusahaan($_POST['user_id'], $_POST['nama_perusahaan'], $_POST['tentang_perusahaan'], $_POST['lokasi_perusahaan'], $_POST['kontak_email'], $_POST['kontak_telepon']);
            if ($result) {
                $response = [
                    'status' => true,
                    'message' => 'Perusahaan berhasil ditambahkan'
                ];
                echo response($response, 201);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menambahkan perusahaan'
                ];
                echo response($response, 500);
            }
        }
        // Menambahkan lowongan baru
        elseif (!empty($_POST['skill_yang_dibutuhkan']) && !empty($_POST['perusahaan_id']) && !empty($_POST['jurusan']) && !empty($_POST['jenjang_kontrak']) && isset($_POST['status'])) {
            $result = tambahLowonganPkl($_POST['perusahaan_id'], $_POST['skill_yang_dibutuhkan'], $_POST['jurusan'], $_POST['jenjang_kontrak'], $_POST['status']);
            if ($result) {
                $response = [
                    'status' => true,
                    'message' => 'Lowongan berhasil ditambahkan'
                ];
                echo response($response, 201);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menambahkan lowongan'
                ];
                echo response($response, 500);
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Semua kolom harus diisi'
            ];
            echo response($response, 400);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        // Memperbarui lowongan
        if (!empty($_PUT['lowongan_id']) && !empty($_PUT['skill_yang_dibutuhkan'])) {
            $result = updateLowongan($_PUT['lowongan_id'], $_PUT['skill_yang_dibutuhkan'], $_PUT['jurusan'], $_PUT['jenjang_kontrak'], $_PUT['status']);
            if ($result) {
                $response = [
                    'status' => true,
                    'message' => 'Lowongan berhasil diperbarui'
                ];
                echo response($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal memperbarui lowongan'
                ];
                echo response($response, 500);
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Semua kolom harus diisi untuk memperbarui'
            ];
            echo response($response, 400);
        }
        break;

    case 'DELETE':
        // Menghapus lowongan
        if (isset($_GET['lowongan_id'])) {
            $lowongan_id = $_GET['lowongan_id'];
            $result = deleteLowongan($lowongan_id);
            if ($result) {
                $response = [
                    'status' => true,
                    'message' => 'Lowongan berhasil dihapus'
                ];
                echo response($response, 200);
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Gagal menghapus lowongan'
                ];
                echo response($response, 500);
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'ID lowongan diperlukan'
            ];
            echo response($response, 400);
        }
        break;

    default:
        // Metode tidak diizinkan
        $response = [
            'status' => false,
            'message' => 'Metode tidak diizinkan'
        ];
        echo response($response, 405);
        break;
}
