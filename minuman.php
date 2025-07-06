<!-- ===================== BAGIAN UNTUK USER ===================== -->
<?php
include 'koneksi.php';

// Ambil semua toko dari kategori "Minuman"
$query = "SELECT k.kantin_id, k.nama_kantin, k.jam_buka, k.jam_tutup, k.nama_kantin, k.harga_min, 
            k.harga_max, 
            k.gambar
          FROM kantin k
          JOIN kategori_kantin kk ON k.kantin_id = kk.kantin_id
          JOIN kategori kat ON kk.kategori_id = kat.kategori_id
          WHERE kat.nama_kategori = 'Minuman'";

$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kategori Minuman - Kantin Reborn</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #fff;
    }

    header {
      font-family: 'Segoe UI', sans-serif;
      background-color: #4e4542;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
      padding: 16px 24px;
      display: flex;
      align-items: center;
      color: white;
      font-weight: bold;
      font-size: 22px;
    }

    header .brand {
      color: white;
    }

    header .brand span {
      color: red;
    }

    .category-bar {
      display: flex;
      align-items: center;
      padding: 20px 24px;
    }

    .category-bar img {
      width: 40px;
      margin-right: 10px;
    }

    .category-bar .back {
      margin-right: 20px;
      text-decoration: none;
      font-size: 20px;
      color: #000;
    }

    .container {
      max-width: 900px;
      margin: auto;
      padding: 20px;
    }

    .kantin-item {
      display: flex;
      gap: 20px;
      align-items: flex-start;
      background-color: #fff;
      border-radius: 12px;
      padding: 10px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
      margin-bottom: 20px;
      transition: box-shadow 0.3s;
    }

    .kantin-item:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .kantin-item img {
      width: 160px;
      height: 120px;
      object-fit: cover;
      border-radius: 12px;
    }

    .kantin-info h3 {
      font-size: 20px;
      margin-bottom: 6px;
      margin-top: 0;
      color: #333;
    }

    .kantin-info {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .badge {
      align-self: flex-start;
      background-color: red;
      color: white;
      font-size: 12px;
      padding: 4px 10px;
      border-radius: 12px;
      margin-bottom: 8px;
    }

    .info-line {
      display: flex;
      align-items: center;
      font-size: 14px;
      color: #444;
      margin-bottom: 6px;
    }

    .kantin-info p {
      margin: 0;
      font-size: 14px;
      color: #666;
    }

    .info-line img {
      width: 16px;
      height: 16px;
      margin-right: 6px;
    }

    footer {
      background-color: red;
      color: white;
      text-align: center;
      padding: 12px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>
<body>

  <header>
    <div class="brand">Kantin<span>Reborn</span></div>
  </header>

  <div class="category-bar">
    <!-- Tombol kembali ke halaman kategori utama -->
    <a href="index.php#kategori" class="back">←</a>
    <img src="img/minuman.png" alt="Minuman">
    <h2>Minuman</h2>
  </div>

<div class="container">
  <!-- Cek apakah hasil query ada dan ada data -->
  <?php if ($result && $result->num_rows > 0): ?>
    <!-- Loop untuk menampilkan setiap kantin yang menjual minuman -->
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="kantin-item">
        <!-- Link ke halaman detail kantin dengan parameter kantin_id dan sumber halaman -->
        <a href="detail_kantin.php?kantin_id=<?= $row['kantin_id'] ?>&from=minuman.php" style="display: flex; gap: 20px; align-items: center; text-decoration: none; color: inherit;">
        <img src="img/<?= htmlspecialchars($row['gambar'] ?? 'placeholder.jpg') ?>" alt="<?= htmlspecialchars($row['nama_kantin'] ?? 'Nama tidak tersedia') ?>">
        <div class="kantin-info">
          <!-- Nama kantin -->
          <h3><?= htmlspecialchars($row["nama_kantin"] ?? 'Nama tidak tersedia') ?></h3>
          <!-- Label kategori minuman -->
          <div class="badge">Minuman</div>
          <div class="info-line">
            <!-- Ikon harga -->
            <img src="img/icon-tag.png" alt="Harga">
            <!-- Tampilkan rentang harga jika tersedia -->
            <?php if (isset($row["harga_min"]) && isset($row["harga_max"])): ?>
              Rp<?= number_format($row["harga_min"], 0, ',', '.') ?>–Rp<?= number_format($row["harga_max"], 0, ',', '.') ?>
            <?php else: ?>
              Harga tidak tersedia
            <?php endif; ?>
          </div>
          <!-- Jam buka dan tutup kantin -->
          <p>Jam buka: <?= htmlspecialchars($row["jam_buka"] ?? '-') ?> - <?= htmlspecialchars($row["jam_tutup"] ?? '-') ?></p>
        </div>
        </a>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Tidak ada toko yang menjual minuman.</p>
  <?php endif; ?>
</div>


  <footer>
    Hak cipta © 2025 Dibuat oleh Kelompok 6
  </footer>

</body>
</html>
