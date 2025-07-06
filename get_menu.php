<?php
include 'koneksi.php';

// Cek apakah parameter 'id' sudah diberikan melalui metode GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Menjalankan query untuk mengambil data menu berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = $id");
    
    // Jika query berhasil dan data ditemukan
    if ($query && mysqli_num_rows($query) > 0) {
        // Mengembalikan data menu dalam format JSON
        echo json_encode(mysqli_fetch_assoc($query));
    } else {
        echo json_encode(['error' => 'Menu tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID tidak diberikan']);
}
?>