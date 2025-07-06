<?php
// Menyertakan file koneksi ke database
include 'koneksi.php';

// Set header response sebagai JSON agar klien dapat memproses JSON dengan benar
header('Content-Type: application/json');

// Inisialisasi respons default dengan status gagal
$response = [
    'success' => false,    // Status keberhasilan operasi
    'message' => '',       // Pesan error atau sukses
    'menu' => null         // Data menu yang baru ditambahkan (jika sukses)
];

// Proses hanya jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil dan validasi input dari form POST
    $kantin_id = intval($_POST['kantin_id']); // Konversi ke integer
    // Mengamankan input nama_menu dari SQL Injection dengan mysqli_real_escape_string
    $nama_menu = isset($_POST['nama_menu']) ? mysqli_real_escape_string($koneksi, $_POST['nama_menu']) : '';
    $harga = intval($_POST['harga']); // Harga sebagai integer

    // Validasi input, pastikan tidak ada field kosong dan harga serta kantin_id valid (>0)
    if (empty($nama_menu) || $harga <= 0 || $kantin_id <= 0) {
        $response['message'] = 'Nama menu, harga, dan kantin ID harus diisi dengan benar';
        // Kirim response JSON dan hentikan script
        echo json_encode($response);
        exit;
    }

    // Validasi file foto harus ada dan tidak ada error saat upload
    if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != 0) {
        $response['message'] = 'Foto wajib diunggah';
        echo json_encode($response);
        exit;
    }

    // Ambil ekstensi file foto dan ubah ke huruf kecil
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    // Daftar ekstensi file yang valid
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    // Cek apakah ekstensi foto valid
    if (!in_array($ext, $allowed_extensions)) {
        $response['message'] = 'Ekstensi file foto tidak valid. Hanya diperbolehkan: ' . implode(', ', $allowed_extensions);
        echo json_encode($response);
        exit;
    }

    // Buat nama file unik untuk foto agar tidak terjadi duplikasi
    $filename = uniqid('', true) . '.' . $ext;
    $target_path = 'img/' . $filename; // Lokasi tujuan upload

    // Pindahkan file foto ke folder tujuan
    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target_path)) {
        $response['message'] = 'Gagal mengupload foto';
        echo json_encode($response);
        exit;
    }

    // Query untuk memasukkan data menu ke database
    $query = "INSERT INTO menu (kantin_id, nama_menu, harga, foto, status_tersedia)
              VALUES ($kantin_id, '$nama_menu', $harga, '$filename', 'Tersedia')";

    // Eksekusi query dan cek hasilnya
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil insert, ambil ID menu yang baru
        $id_menu = mysqli_insert_id($koneksi);
        // Query ambil data menu lengkap berdasarkan ID tersebut
        $result = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = $id_menu");
        // Ambil data menu dalam bentuk associative array
        $menu = mysqli_fetch_assoc($result);

        // Update response sukses dan sertakan data menu
        $response['success'] = true;
        $response['menu'] = $menu;
        $response['message'] = 'Menu berhasil ditambahkan';
    } else {
        // Jika gagal, hapus foto yang sudah terupload agar tidak menumpuk file sampah
        if (file_exists($target_path)) {
            unlink($target_path);
        }
        // Set pesan error dengan alasan kegagalan query
        $response['message'] = 'Gagal menyimpan ke database: ' . mysqli_error($koneksi);
    }
} else {
    // Jika bukan metode POST, berikan pesan error
    $response['message'] = 'Metode request tidak didukung';
}

// Kirim response dalam format JSON ke client
echo json_encode($response);
?>

