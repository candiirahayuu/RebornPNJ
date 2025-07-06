<!-- ===================== BAGIAN UNTUK USER ===================== -->
<?php
session_start();
include 'koneksi.php';

// Ambil data pesanan dari session
$items = $_SESSION['items'] ?? [];

$pemesanan = $_SESSION['pemesanan'] ?? [];
$nomor_pesanan = $pemesanan['nomor_pesanan'] ?? null;
$items = $pemesanan['items'] ?? [];
$nama = $pemesanan['nama'] ?? '-';
$no_hp = $pemesanan['no_hp'] ?? '-';
$catatan = $pemesanan['catatan'] ?? '-';
$total = $pemesanan['total'] ?? 0;
$estimasi_waktu = $pemesanan['estimasi'] ?? '-';
$kantin_id = $pemesanan['kantin_id'] ?? null; 
$cara_pengambilan = $pemesanan['cara_pengambilan'] ?? '-';

// Ambil nama kantin dari database jika ID tersedia
$nama_kantin = '-';
if ($kantin_id !== null) {
    $query = mysqli_query($koneksi, "SELECT nama_kantin FROM kantin WHERE kantin_id = '$kantin_id'");
    if ($query && mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $nama_kantin = $row['nama_kantin'];
    }
}

// Ambil estimasi waktu dari database berdasarkan kantin_id dari item pertama
if (!empty($items)) {
    $kantin_id = $items[0]['kantin_id'];
    $query_kantin = mysqli_query($koneksi, "SELECT estimasi_waktu FROM kantin WHERE kantin_id = '$kantin_id'");
    $data_kantin = mysqli_fetch_assoc($query_kantin);
    $estimasi_waktu = $data_kantin['estimasi_waktu'];
} else {
    $estimasi_waktu = '-';
}

// Hapus item dari session agar tidak dikirim ulang saat refresh
unset($_SESSION['items']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan Berhasil</title>
  <style>
    body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    padding: 1rem;
    color: #333;
  }
  .modal-content {
    background: white;
    padding: 2rem 2.5rem;
    border-radius: 16px;
    box-shadow: 0 14px 30px rgba(0,0,0,0.12);
    max-width: 500px;
    width: 100%;
    text-align: center;
    border-top: 10px solid #e62c4b;
  }
  .checkmark {
    font-size: 4rem;
    color: #e62c4b;
    margin-bottom: 1rem;
  }
  h2 {
    font-weight: 700;
    font-size: 24px;
    margin-bottom: 0.5rem;
  }
  .highlight {
    font-weight: 600;
    color: #ff5722;
  }
  p {
    font-size: 16px;
    line-height: 1.5;
    margin: 0.25rem 0 1rem 0;
  }
  .download-btn {
    margin-top: 1.5rem;
    background: #28a745;
    color: white;
    padding: 0.65rem 1.6rem;
    font-size: 16px;
    border-radius: 8px;
    text-decoration: none;
    box-shadow: 0 6px 12px rgba(40,167,69,0.3);
    transition: background-color 0.3s ease;
    display: inline-block;
    cursor: pointer;
  }
  .download-btn:hover {
    background: #218838;
  }
  #backButton {
    position: absolute;
    top: 1rem;
    left: 1rem;
    background-color: #e62c4b;
    color: white;
    padding: 8px 18px;
    font-size: 14px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    display: none;
    text-decoration: none;
    z-index: 1000;
  }
  #backButton:hover {
    background-color: #ab132d;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <a id="backButton" href="index.php">← Kembali</a>
  
  <!-- sukses -->
  <div class="modal-content">
  <div class="checkmark">✔</div>
  <h2>Pesananmu Berhasil Dibuat!</h2>
  <p>Perkiraan pesanan akan <span class="highlight">siap dalam <?php echo $estimasi_waktu; ?> menit</span>.</p>
  <p>Jangan lupa untuk <span class="highlight">mengambilnya maksimal 25 menit</span> setelah pesanan siap, ya!</p>

  <!-- Canvas bukti pemesanan -->
  <canvas id="buktiCanvas" width="800" height="1000" style="display:none;"></canvas>
  <p style="margin-top: 25px; margin-bottom: 8px; font-style: italic; color: #d00000; font-size: 10px;">
    *Tunjukkan bukti ini kepada penjual saat mengambil pesanan (wajib)
  </p>
  <!-- Tombol download bukti -->
  <a id="downloadLink" class="download-btn" style="margin-top: 0;">⬇ Download Bukti Pemesanan</a>
  </div>

  <script>
    // Ambil elemen canvas dan context untuk menggambar
    const canvas = document.getElementById('buktiCanvas');
    const ctx = canvas.getContext('2d');
    const downloadLink = document.getElementById('downloadLink');
    const centerX = canvas.width / 2;

    // Data pesanan dari PHP ke JavaScript
    const data = <?php echo json_encode([
      'nomor_pesanan' => $nomor_pesanan,
      'nama' => $nama,
      'no_hp' => $no_hp,
      'catatan' => $catatan,
      'total' => $total,
      'estimasi' => $estimasi_waktu,
      'items' => $items,
      'nama_kantin' => $nama_kantin,
      'cara_pengambilan' => $cara_pengambilan
    ]); ?>;

    function drawStyledReceipt(data) {
    // Bersihkan canvas
    ctx.fillStyle = "#fff";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Border luar
    ctx.strokeStyle = "#ffcc00";
    ctx.lineWidth = 4;
    ctx.strokeRect(20, 20, canvas.width - 40, canvas.height - 40);

    // Header
    ctx.font = "bold 36px Arial";
    ctx.fillStyle = "#000";
    ctx.textAlign = "center";
    ctx.fillText("Bukti", centerX + -100, 80);
    ctx.fillStyle = "#ff0000";
    ctx.fillText("Pemesanan", centerX + 50, 80);

    // Info Nomor Pesanan dan Kantin
    ctx.font = "20px Arial";
    ctx.fillStyle = "#000";
    ctx.fillText("Nomor Pesanan: " + data.nomor_pesanan, centerX, 120);
    ctx.font = "18px Arial";
    ctx.fillText("Kantin: " + data.nama_kantin, centerX, 145);

    // Nama Lengkap
    ctx.textAlign = "left";
    ctx.font = "bold 22px Arial";
    ctx.fillText("Nama Lengkap", 80, 180);
    ctx.fillStyle = "#ccc";
    ctx.fillRect(80, 190, 640, 40);
    ctx.fillStyle = "#000";
    ctx.font = "18px Arial";
    ctx.fillText(data.nama, 90, 218);

    // Nomor Telepon
    ctx.font = "bold 22px Arial";
    ctx.fillText("Nomor Telepon", 80, 260);
    ctx.fillStyle = "#ccc";
    ctx.fillRect(80, 270, 640, 40);
    ctx.fillStyle = "#000";
    ctx.font = "18px Arial";
    ctx.fillText(data.no_hp, 90, 298);

    // Daftar Pesanan
    let y = 350;
    ctx.font = "bold 22px Arial";
    ctx.fillText("Detail Pesanan", 80, y);
    y += 30;

    data.items.forEach(item => {
      ctx.font = "bold 20px Arial";
      ctx.fillText(item.jumlah + "x " + item.nama_menu, 100, y);
      ctx.textAlign = "right";
      ctx.fillText("Rp " + parseInt(item.subtotal).toLocaleString(), 700, y);
      ctx.textAlign = "left";
      y += 30;
    });

    // Total Harga
    y += 20;
    ctx.fillStyle = "#fff4cc";
    ctx.fillRect(80, y, 640, 50);
    ctx.fillStyle = "#000";
    ctx.font = "bold 22px Arial";
    ctx.fillText("Total Harga", 100, y + 33);
    ctx.textAlign = "right";
    ctx.font = "bold 24px Arial";
    ctx.fillText("Rp " + data.total.toLocaleString(), 700, y + 33);
    ctx.textAlign = "left";

    // Estimasi
    y += 80;
    ctx.font = "16px Arial";
    ctx.fillStyle = "#555";
    ctx.fillText("Estimasi Waktu Selesai: " + data.estimasi + " menit", 80, y);

    // Cara Pengambilan
    y += 30;
    ctx.fillStyle = "#000";
    ctx.font = "bold 18px Arial";
    ctx.fillText("Cara Pengambilan: " + data.cara_pengambilan, 80, y);

    // Catatan (jika ada)
    if (data.catatan && data.catatan.trim() !== "") {
      y += 30;
      ctx.font = "italic 16px Arial";
      ctx.fillStyle = "#000";
      ctx.fillText("Catatan: " + data.catatan, 80, y);
    }

    // Footer
    ctx.font = "italic 14px Arial";
    ctx.fillText("Tunjukkan bukti ini saat mengambil pesanan.", 80, canvas.height - 80);
    ctx.font = "bold 16px Arial";
    ctx.fillText("Terima kasih telah memesan di Kantin Kami!", 220, canvas.height - 50);
  }

    // 🔙 Tombol kembali (tampil setelah download)
    const backButton = document.getElementById('backButton');

    // Download bukti sebagai gambar JPG
    downloadLink.addEventListener('click', function () {
      drawStyledReceipt(data);
      const image = canvas.toDataURL("image/jpeg");
      downloadLink.href = image;
      downloadLink.download = "bukti_pemesanan.jpg";

      // Tampilkan tombol kembali setelah download diklik
      backButton.style.display = 'inline-block';
    });

    drawStyledReceipt(data);
  </script>
</body>
</html>