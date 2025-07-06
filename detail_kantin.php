<!-- ===================== BAGIAN UNTUK USER ===================== -->
<?php
session_start();
include 'koneksi.php';
// Mengecek apakah parameter kantin_id ada di URL
if (!isset($_GET['kantin_id'])) {
  echo "Kantin tidak ditemukan.";
  exit;
}
$kantin_id = mysqli_real_escape_string($koneksi, $_GET['kantin_id']);
// Mengambil detail kantin berdasarkan kantin_id
$query = mysqli_query($koneksi, "SELECT * FROM kantin WHERE kantin_id = '$kantin_id'");
$data = mysqli_fetch_array($query);
// Mengambil semua menu yang terkait dengan kantin_id dan hanya yang tersedia
$menuQuery = mysqli_query($koneksi, "SELECT * FROM menu WHERE kantin_id = '$kantin_id' AND status_tersedia = 'T'");

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo $data['nama_kantin']; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
    }
    header {
      font-family: 'Segoe UI', sans-serif;
      background-color: #4e4542;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
      padding: 16px 24px;
      color: white;
      font-size: 1.5rem;
      font-weight: bold;
    }
    .btn-back {
      display: inline-block;
      margin-bottom: 1rem;
      background-color: #eeeeee;
      color: #333;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: all 0.2s ease-in-out;
    }
    .btn-back:hover {
      background-color: #ccc;
      color: red;
      transform: translateX(-3px);
    }
    .highlight {
      color: red;
    }
    .container {
      padding: 2rem;
    }
  .kantin-title {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #222;
  }

  .info-box {
    flex: 1;
  }

  .info-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .info-list li {
    margin-bottom: 8px;
    font-size: 15px;
    color: #444;
  }

  .info-list li span {
    font-weight: 600;
    color: #000;
    display: inline-block;
    min-width: 140px;
  }

  .kantin-info {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
    margin-bottom: 2rem;
  }

  .kantin-info img {
    width: 260px;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  }

  .kantin-info h2 {
    margin-top: 0;
    font-size: 24px;
    color: #222;
  }

  .kantin-info p {
    font-size: 15px;
    margin: 6px 0;
    color: #444;
  }

  .menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    row-gap: 5rem;      /* jarak atas-bawah antar card */
    column-gap: 1.5rem;   /* jarak kanan-kiri antar card */
    margin-top: 2rem;
  }

  .menu-card {
    background-color: #fff;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    transition: transform 0.2s ease;
  }

  .menu-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    align-items : center;
  }
  

  .menu-card h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
  }

  .menu-card p {
    margin: 2px 5px;
    font-size: 14px;
    color: #444;
  }

  .jumlah-group {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    gap: 8px;
    margin-top: 0.75rem;
  }

  .jumlah-group button {
    background-color: red;
    color: white;
    border: none;
    padding: 6px 10px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.2s;
  }

  .jumlah-group button:hover {
    background-color: #c40000;
  }

  .jumlah-group input {
    width: 40px;
    height: 32px;
    text-align: center;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background: #fff;
  }

  .btn-order {
    background-color: red;
    color: white;
    border: none;
    padding: 1rem 2rem;
    font-size: 1rem;
    margin-top: 4rem;
    cursor: pointer;
    border-radius: 8px;
  }
  
  footer {
    background-color: red;
    color: white;
    text-align: center;
    padding: 1rem;
    margin-top: 3rem;
  }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <span class="highlight">Kantin</span>Reborn
  </header>

  <div class="container">
  <?php
  $back = isset($_GET['from']) ? $_GET['from'] : 'index.php#toko';
  ?>
  <a href="<?= htmlspecialchars($back) ?>" class="btn-back">&larr; Kembali</a>
  
  <!-- Informasi detail tentang kantin -->
  <div class="kantin-info">
    <img src="img/<?php echo $data['gambar']; ?>" alt="gambar kantin">
    <div class="info-box">
      <h2 class="kantin-title"><?php echo $data['nama_kantin']; ?></h2>
      <ul class="info-list">
        <li><span>📍 Lokasi:</span> Dekat Bank Mini PNJ</li>
        <li><span>⏰ Jam:</span> <?php echo $data['jam_buka']; ?> - <?php echo $data['jam_tutup']; ?></li>
        <li><span>💸 Harga:</span> Rp<?php echo number_format($data['harga_min']); ?> - Rp<?php echo number_format($data['harga_max']); ?></li>
        <li><span>💳 COD:</span> Bayar saat ambil</li>
        <li><span>⏱️ Estimasi Waktu Siap:</span> <?php echo $data['estimasi_waktu']; ?> menit</li>
      </ul>
    </div>
  </div>

<!-- Form pemesanan -->
<form action="pemesanan.php" method="post">
<div class="menu-grid"> 
  <?php
  // Menampilkan daftar menu dari kantin terkait yang statusnya tersedia
  while ($menu = mysqli_fetch_assoc($menuQuery)) {
  ?>
    <div class="menu-card">
      <img src="img/<?php echo $menu['foto']; ?>" alt="">
      <h5><?php echo $menu['nama_menu']; ?></h5>
      <p>Rp<?php echo number_format($menu['harga']); ?></p>

      <!-- Input jumlah & ID menu -->
      <input type="hidden" name="id_menu[]" value="<?php echo $menu['id_menu']; ?>">
      <div class="jumlah-group">
        <button type="button" onclick="decrease(this)">-</button>
        <input type="number" name="jumlah[]" value="0" min="0" readonly>
        <button type="button" onclick="increase(this)">+</button>
      </div>
    </div>
  <?php } ?>
  </div>

  <!-- Hidden input untuk mengingat kantin_id -->
<input type="hidden" name="kantin_id" value="<?= $kantin_id ?>">

  <!-- Tombol untuk mengirim form pemesanan -->
  <button type="button" class="btn-order" onclick="cekPesanan()">Buat Pesanan</button>
  </form>
  </div>

  <!-- Footer -->
  <footer>
    Hak cipta © 2025 Dibuat oleh Kelompok 6
  </footer>

  <!-- Script JavaScript untuk validasi jumlah dan fungsi tombol -->
  <script>
    function cekPesanan() {
      const jumlahInputs = document.querySelectorAll('input[name="jumlah[]"]');
      let totalPesanan = 0;

      // Hitung total pesanan dari semua input jumlah
      jumlahInputs.forEach(input => {
        totalPesanan += parseInt(input.value);
      });

      // Tampilkan alert jika belum ada pesanan
      if (totalPesanan === 0) {
        alert("Silakan pilih minimal 1 menu sebelum membuat pesanan.");
      } else {
        document.querySelector('form').submit(); // Kirim form
      }
    }

    // Fungsi untuk menambah jumlah
    function increase(btn) {
      const input = btn.previousElementSibling;
      let currentValue = parseInt(input.value);

      if (currentValue < 5) { // Batas maksimal jumlah = 5
        input.value = currentValue + 1;
      } else {
        alert("Maksimal pemesanan menu ini adalah 5.");
      }
    }

    // Fungsi untuk mengurangi jumlah
    function decrease(btn) {
      const input = btn.nextElementSibling;
      if (parseInt(input.value) > 0) {
        input.value = parseInt(input.value) - 1;
      }
    }
  </script>
</body>
</html>