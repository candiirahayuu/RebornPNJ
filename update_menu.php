<!-- ===================== BAGIAN UNTUK ADMIN ===================== -->
<?php
include 'koneksi.php';

// Ambil data dari form POST
$id = $_POST['id_menu'];
$nama = $_POST['nama_menu'];
$harga = $_POST['harga'];

// Cek apakah user upload gambar baru
if ($_FILES['gambar_menu']['name']) {
    $gambar_name = time() . '_' . $_FILES['gambar_menu']['name'];
    $gambar_tmp = $_FILES['gambar_menu']['tmp_name'];
    move_uploaded_file($gambar_tmp, 'uploads/' . $gambar_name);

    // Update termasuk gambar
    $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', gambar_menu='$gambar_name' WHERE id_menu=$id";
} else {
    // Update tanpa ubah gambar
    $query = "UPDATE menu SET nama_menu='$nama', harga='$harga' WHERE id_menu=$id";
}

// Eksekusi query update
mysqli_query($koneksi, $query);
// Redirect ke halaman index setelah update selesai
header('Location: index.php'); 
?>