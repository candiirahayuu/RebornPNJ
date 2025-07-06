<?php
// Menyertakan file koneksi ke database
include 'koneksi.php';

// Set header response sebagai JSON agar klien dapat memproses JSON dengan benar
header('Content-Type: application/json');

// Inisialisasi respons default dengan status gagal
$response = ['success' => false]; // Status keberhasilan operasi

// Cek apakah data POST yang wajib tersedia sudah ada (id_menu, nama_menu, harga)
if (isset($_POST['id_menu'], $_POST['nama_menu'], $_POST['harga'])) {
    // Ambil dan filter data input untuk keamanan
    $id = intval($_POST['id_menu']); // ID menu yang akan diperbarui
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_menu']); // Nama menu yang baru
    $harga = intval($_POST['harga']); // Harga menu yang baru
    $fotoUpdate = ''; // Variabel untuk menyimpan bagian foto jika ada

    // Cek jika ada file gambar baru
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotoName = time() . '_' . basename($_FILES['foto']['name']); // Buat nama file unik
        $targetPath = 'img/' . $fotoName; // Lokasi tujuan upload

        // Pindahkan file dari temporary ke folder tujuan
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
            $fotoUpdate = ", foto = '$fotoName'"; // Siapkan bagian query untuk foto
        } else {
            // Jika gagal upload foto, set pesan error dan kirim response
            $response['message'] = 'Gagal mengunggah gambar.';
            echo json_encode($response);
            exit;
        }
    }

    // Buat dan jalankan query update data menu (nama, harga, dan jika ada foto)
    $query = mysqli_query($koneksi, "UPDATE menu SET nama_menu='$nama', harga=$harga $fotoUpdate WHERE id_menu=$id");

    // Cek apakah query berhasil
    if ($query) {
        // Jika query berhasil, set success true
        $response['success'] = true;
    } else {
        // Jika query gagal, isi pesan error dengan info dari mysqli
        $response['message'] = 'Query gagal: ' . mysqli_error($koneksi);
    }
} else {
    // Jika data POST kurang lengkap, set pesan error
    $response['message'] = 'Data tidak lengkap';
}

// Kirim response dalam format JSON ke client
echo json_encode($response);
?>
