<!-- ===================== BAGIAN UNTUK ADMIN ===================== -->
<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data id_pesanan, status, dan kantin_id dari POST, lalu filter inputnya
    $id_pesanan = intval($_POST['id_pesanan']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $kantin_id = intval($_POST['kantin_id']);

    // Siapkan query untuk update status pesanan sesuai id_pesanan yang dikirim
    $query = "UPDATE pesanan SET status = '$status' WHERE id_pesanan = $id_pesanan";

    // Jalankan query update
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil update, redirect ke halaman admin dengan parameter kantin agar tetap di halaman yang sesuai
        header("Location: admin.php?kantin=" . $kantin_id);
        exit;
    } else {
        // Jika query gagal, tampilkan pesan error dari mysqli
        echo "Gagal memperbarui status: " . mysqli_error($koneksi);
    }
} else {
    // Jika request bukan POST, tampilkan pesan bahwa metode tidak diperbolehkan
    echo "Metode tidak diperbolehkan.";
}
?>