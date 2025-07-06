<!-- ===================== BAGIAN UNTUK USER ===================== -->
<?php
include 'koneksi.php';

// Periksa apakah permintaan berasal dari metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form input
    $nama = $_POST['nama'];
    $komentar = $_POST['komentar'];
    $rating = $_POST['rating'];

    // Query untuk memasukkan data ulasan ke dalam tabel ulasan_pengunjung
    $query = "INSERT INTO ulasan_pengunjung (nama, komentar, rating) VALUES ('$nama', '$komentar', '$rating')";

    // Jalankan query dan cek apakah berhasil
    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php"); // kembali ke halaman utama
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>