<?php
// Mengimpor file koneksi database
include 'koneksi.php';

// Inisialisasi respons default
$response = ['success' => false];

// Mengambil parameter dengan aman
$id = isset($_GET['id']) ? intval($_GET['id']) : null; // Mengambil ID menu
$aksi = $_GET['aksi'] ?? null; // Mengambil aksi (aktifkan/nonaktifkan)

// Memeriksa apakah ID dan aksi ada
if ($id && $aksi) {
    // Menentukan status berdasarkan aksi
    if ($aksi === 'aktifkan') {
        $status = 'T'; // Tersedia
    } elseif ($aksi === 'nonaktifkan') {
        $status = 'H'; // Habis
    } else {
        // Jika aksi tidak valid
        $response['message'] = 'Aksi tidak valid';
        echo json_encode($response);
        exit; // Menghentikan eksekusi
    }

    // Query untuk memperbarui status menu
    $query = "UPDATE menu SET status_tersedia='$status' WHERE id_menu=$id";
    $result = mysqli_query($koneksi, $query); // Menjalankan query

    // Memeriksa hasil dari query
    if ($result) {
        $response['success'] = true; // Menandakan sukses
        $response['status'] = ($status === 'T') ? 'Tersedia' : 'Habis'; // Menentukan status baru
    } else {
        // Jika gagal memperbarui, ambil pesan kesalahan
        $response['message'] = 'Gagal update: ' . mysqli_error($koneksi);
    }
} else {
    // Jika parameter tidak lengkap
    $response['message'] = 'Parameter tidak lengkap';
}

// Mengembalikan respons dalam format JSON
echo json_encode($response);
