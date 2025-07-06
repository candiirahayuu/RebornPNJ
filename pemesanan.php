<!-- ===================== BAGIAN UNTUK USER ===================== -->
<?php 
session_start();
include 'koneksi.php';

// Ambil data menu saat pertama kali masuk (POST dari detail_kantin)
if (isset($_POST['id_menu']) && isset($_POST['jumlah'])) {
    $id_menus = $_POST['id_menu'];
    $jumlahs = $_POST['jumlah'];
    $items = [];
    $total = 0;

    // Loop tiap menu yang dipesan
    for ($i = 0; $i < count($id_menus); $i++) {
        $id = $id_menus[$i];
        $qty = (int)$jumlahs[$i];

        if ($qty > 0) { // hanya proses jika jumlah > 0
            // Query ambil data menu dan nama kantin terkait
            $query = mysqli_query($koneksi, "SELECT m.*, k.nama_kantin FROM menu m JOIN kantin k ON m.kantin_id = k.kantin_id WHERE m.id_menu = '$id'");
            $menu = mysqli_fetch_assoc($query);

            // Hitung subtotal harga menu (harga * jumlah)
            $subtotal = $menu['harga'] * $qty;
            $total += $subtotal; // tambahkan ke total keseluruhan

            // Simpan detail menu ke array items
            $items[] = [
                'id_menu'   => $menu['id_menu'],
                'nama_menu' => $menu['nama_menu'],
                'harga'     => $menu['harga'],
                'jumlah'    => $qty,
                'subtotal'  => $subtotal,
                'kantin_id' => $menu['kantin_id'],
                'kantin_nama' => $menu['nama_kantin'],
                'foto'      => $menu['foto']
            ];
        }
    }

    // Simpan data pesanan dan total ke session agar bisa dipakai halaman lain
    $_SESSION['items'] = $items;
    $_SESSION['total'] = $total;

} else {
    // Ambil ulang dari session kalau form dikirim ulang
    $items = $_SESSION['items'] ?? [];
    $total = $_SESSION['total'] ?? 0;
}

// Proses penyimpanan ke database setelah form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama']) && isset($_POST['no_hp']) && isset($_POST['cara_pengambilan'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $catatan = $_POST['catatan'] ?? '';
    $cara_pengambilan = $_POST['cara_pengambilan']; // tambahan
    $total = $_SESSION['total'] ?? 0;

    // Validasi sederhana agar cara_pengambilan harus makan_di_tempat atau bungkus
    if (!in_array($cara_pengambilan, ['makan_di_tempat', 'bungkus'])) {
        die("Pilihan cara pengambilan tidak valid.");
    }

    // Simpan pesanan ke database jika valid
    if (!empty($_SESSION['items'])) {
        $nomor_pesanan = uniqid('PNJ'); // nomor pesanan unik dan sama utk semua menu

        // Loop tiap item pesanan, simpan ke tabel pesanan
        foreach ($_SESSION['items'] as $item) {
          $kantin_id = $item['kantin_id'];
          $menu_id = $item['id_menu'];
          $menu_nama = $item['nama_menu'];
          $jumlah = $item['jumlah']; 
          $subtotal = $item['subtotal'];

           // Query insert data pesanan ke database
          $insert = mysqli_query($koneksi, "INSERT INTO pesanan 
              (nomor_pesanan, kantin_id, menu_id, nama_pemesan, no_hp, catatan, daftar_menu, subtotal, jumlah_menu, cara_pengambilan) 
              VALUES 
              ('$nomor_pesanan', '$kantin_id', '$menu_id', '$nama', '$no_hp', '$catatan', '$menu_nama', '$subtotal', '$jumlah', '$cara_pengambilan')");

          if (!$insert) {
              echo "Error: " . mysqli_error($koneksi);
          }
      }

        // Simpan data pemesanan ke session untuk ditampilkan di halaman berhasil
        $_SESSION['pemesanan'] = [
            'nomor_pesanan' => $nomor_pesanan,
            'nama'    => $nama,
            'no_hp'   => $no_hp,
            'catatan' => $catatan,
            'total'   => $total,
            'items'   => $_SESSION['items'],
            'kantin_id' => $items[0]['kantin_id'],
            'cara_pengambilan' => $cara_pengambilan
        ];

        // Redirect ke halaman berhasil.php setelah proses selesai
        header("Location: berhasil.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Konfirmasi Pesanan</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      background: #fff;
      color: #111;
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

    .highlight {
      color: red;
    }

    h2 {
      text-align: center;
      margin: 2rem 0 2rem;
      font-size: 32px;
      font-weight: 700;
    }

    table {
      width: 90%;
      margin: 0 auto;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px;
      text-align: left;
      vertical-align: middle;
    }

    th {
      background-color: #ffd700;
      font-weight: 600;
    }

    tr:not(:last-child) {
      border-bottom: 1px solid #ccc;
    }

    .produk-info {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .produk-info img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }

    .total-tag {
      background: #f2d97d;
      padding: 0.6rem 1rem;
      border-radius: 6px;
      font-weight: bold;
      float: right;
      margin: 1rem 5% 2rem 2rem;
    }

    .clearfix::after {
      content: "";
      display: table;
      clear: both;
    }

.cara-pengambilan-group {
  display: flex;
  gap: 12px;
  margin-top: 6px;
}

.radio-card {
  flex: 1;
  border: 2px solid #ddd;
  border-radius: 10px;
  padding: 8px 12px;
  cursor: pointer;
  font-weight: 600;
  font-size: 0.9rem;
  color: #444;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  user-select: none;
  background-color: #fafafa;
}

.radio-card:hover {
  border-color: #e03e2f;
  background-color: #ffe6e3;
  color: #b52a1f;
}

.radio-card input[type="radio"] {
  display: none;
}

.radio-card input[type="radio"]:checked + .radio-label {
  color: #fff;
  background-color: #e03e2f;
  padding: 6px 12px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(224, 62, 47, 0.7);
}

.radio-label {
  cursor: pointer;
  display: block;
  width: 100%;
  text-align: center;
  border-radius: 10px;
  padding: 6px 10px;
  transition: background-color 0.3s ease, color 0.3s ease;
  user-select: none;
  font-size: 0.9rem;
}
    .note-section {
      width: 90%;
      margin: 0 auto 2rem;
    }

    .note-section h3 {
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 0.2rem;
      margin-top: 0.5rem;
    }

    .note-section small {
      display: block;
      color: #555;
      margin-bottom: 0.5rem;
    }

    .note-container {
      display: flex;
      align-items: flex-start;
      margin-top: 6px;
      border: none;
      border-radius: 8px;
      padding: 0.8rem 1rem;
      gap: 0.8rem;
      background-color: #f3f3f3;
    }

    .note-container img {
      width: 20px;
      height: 20px;
      margin-top: 4px;
    }

    .note-container textarea {
      width: 100%;
      border: none;
      resize: none;
      outline: none;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      background-color: #f3f3f3;
    }

    .form-section {
      width: 90%;
      margin: 0 auto 2rem;
      border: 2px solid #ffc107;
      border-radius: 8px;
      padding: 2rem;
      background: #fff;
    }

    .form-section h2 {
      margin-top: 0;
    }

    .form-section h3 {
      font-size: 16px;
      font-weight: 600;
      text-align: left;
      margin-bottom: 0.4rem;
      margin-top: 1rem;
    }

    .form-section p {
      text-align: center;
      font-size: 13px;
      color: #333;
      margin-bottom: 1.5rem;
    }

    .form-section span {
      color: red;
      font-weight: 600;
    }

    .form-section input {
      width: 100%;
      padding: 12px;
      margin-bottom: 1.2rem;
      border: none;
      background-color: #f3f3f3;
      border-radius: 6px;
      font-size: 14px;
    }

    .btn-container {
      width: 90%;
      margin: 1rem auto 2rem;
      display: flex;
      justify-content: flex-end;
    }

    .btn-submit {
      padding: 0.8rem 2.5rem;
      background: red;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
    }

    .footer {
      background: red;
      color: white;
      text-align: center;
      padding: 1rem;
      font-size: 13px;
    }

    .popup-overlay {
      position: fixed;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.4);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      font-family: 'Poppins', sans-serif;
    }

    .popup-box {
      background-color: white;
      border-radius: 24px;
      padding: 2rem 2.5rem;
      width: 90%;
      max-width: 500px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .popup-box h2 {
      margin-top: 10px;
      font-size: 28px;
      margin-bottom: 1rem;
      font-weight: 700;
    }

    .red-text {
      color: #f43f5e;
      font-weight: 700;
    }

    .black-text {
      color: #111;
      font-weight: 700;
    }

    .desc {
      color: #333;
      font-size: 16px;
      line-height: 1.6;
      font-weight: 500;
      margin-bottom: 2rem;
    }

    .popup-actions {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-belum {
      background-color: #facc15;
      color: #111;
      border: none;
      font-weight: 700;
      font-size: 16px;
      padding: 10px 20px;
      border-radius: 12px;
      cursor: pointer;
      flex: 1;
      max-width: 200px;
    }

    .btn-yakin {
      background-color: #ef4444;
      color: #fff;
      border: none;
      font-weight: 700;
      font-size: 16px;
      padding: 10px 20px;
      border-radius: 12px;
      cursor: pointer;
      flex: 1;
      max-width: 200px;
    }

    .btn-kembali {
      position: absolute;
      top: 80px;
      left: 20px;
      margin-bottom: 1rem;
      background-color: #eeeeee;
      color: #333;
      padding: 10px 16px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      border-radius: 8px;
      border: #eeeeee;
      transition: background 0.3s ease;
      z-index: 1000;
      transition: all 0.2s ease-in-out;
    }
    .btn-kembali:hover {
      background-color: #ccc;
      color: red;
      transform: translateX(-3px);
    }

  </style>
</head>
<body>

  <header><span style="color:white">Kantin</span><span class="highlight">Reborn</span></header>

<button type="button" class="btn-kembali" onclick="history.back()">← Kembali</button>

  <h2>Pemesanan</h2>
  
  <table>
    <tr>
      <th>Menu</th>
      <th>Harga</th>
      <th>Jumlah</th>
      <th>Subtotal</th>
    </tr>
    <?php foreach ($items as $item): ?>
    <tr>
      <td>
        <div class="produk-info">
          <!-- Tampilkan gambar menu, src dinamis berdasarkan data -->
          <img src="img/<?php echo $item['foto']; ?>" alt="">
          <!-- Tampilkan nama menu -->
          <?php echo $item['nama_menu']; ?>
        </div>
      </td>
      <!-- Format harga -->
      <td>Rp<?php echo number_format($item['harga']); ?></td>
      <!-- Tampilkan jumlah pesanan -->
      <td><?php echo $item['jumlah']; ?></td>
      <!-- Hitung subtotal dan format tampilannya -->
      <td>Rp<?php echo number_format($item['subtotal']); ?></td>
    </tr>
    <?php endforeach; ?>
  </table>

  <!-- Total keseluruhan pesanan -->
  <div class="total-tag">Total: Rp<?php echo number_format($total); ?></div>
  <div class="clearfix"></div>

  <!-- Formulir pemesanan -->
  <form action="pemesanan.php" id="form-pesanan" class="form-section" method="post">
    <h2>Formulir <span>Pemesanan</span></h2>
    <p>Isi dulu formulirnya, biar penjual tahu siapa yang pesan dan bisa langsung siapin pesanan kamu.</p>

    <h3>Nama Lengkap:</h3>
    <!-- Input nama wajib diisi -->
    <input type="text" name="nama" placeholder="Untuk identifikasi saat pengambilan" required>

    <h3>Nomor Telepon:</h3>
    <!-- Input nomor telepon dengan validasi pattern untuk nomor Indonesia dengan kode +62 -->
    <input type="tel" id="no_hp" name="no_hp" placeholder="+62xxxx" required
            pattern="^\+62[0-9]{9,13}$"
            title="Masukkan nomor aktif diawali dengan +62, contoh: +6281234567890">
    <span id="error-nohp" style="color: red; font-size: 13px; display: none;"></span>

    <h3>Pilih Cara Pengambilan:</h3>
    <div class="cara-pengambilan-group">
      <label class="radio-card">
        <input type="radio" name="cara_pengambilan" value="makan_di_tempat" required>
        <span class="radio-label">🍽️ Makan di Tempat</span>
      </label>
      <label class="radio-card">
        <input type="radio" name="cara_pengambilan" value="bungkus" required>
        <span class="radio-label">🥡 Bungkus</span>
      </label>
    </div>

    <h3>Catatan</h3>
    <small>Opsional</small>
    <div class="note-container">
      <!-- Ikon catatan -->
      <img src="img/Form_fill.png" alt="Form Icon">
      <!-- Textarea catatan tambahan yang boleh kosong -->
      <textarea name="catatan" rows="3" placeholder="Misalnya: jangan terlalu pedas, bungkus terpisah, dll."></textarea>
    </div>

    <!-- Input hidden untuk menyimpan total harga agar dikirim ke server -->
    <input type="hidden" name="total" value="<?php echo $total; ?>">
  </form>
  
  
  <!-- Tombol submit di luar form tapi terhubung dengan form via atribut form -->
  <div class="btn-container">
    <button class="btn-submit" type="submit" form="form-pesanan">Kirim</button>
  </div>

  <!-- Footer sederhana -->
  <div class="footer">Hak cipta © 2025 Dibuat oleh Kelompok 6</div>

  <!-- Pop-up Konfirmasi -->
  <div id="popup-konfirmasi" class="popup-overlay" style="display: none;">
    <div class="popup-box">
      <h2><span class="red-text">Yakin</span> <span class="black-text">dengan</span> <span class="red-text">pesananmu</span><span class="black-text">?</span></h2>
      <p class="desc">
        Pastikan semua data dan pilihan sudah benar, ya.<br>
        <strong>Pemesanan yang sudah dikirim tidak bisa dibatalkan.</strong>
      </p>
      <div class="popup-actions">
        <!-- Tombol batal, menutup popup -->
        <button id="btn-belum" class="btn-belum">Belum Yakin</button>
        <!-- Tombol yakin, lanjut submit -->
        <button id="btn-yakin" class="btn-yakin">Yakin</button>
      </div>
    </div>
  </div>

<script>
  // Ambil elemen input no_hp dan tombol submit, popup dan tombol popup
  const noHpInput = document.getElementById('no_hp');
  const btnSubmit = document.querySelector('.btn-submit');
  const popup = document.getElementById('popup-konfirmasi');
  const btnBelum = document.getElementById('btn-belum');
  const btnYakin = document.getElementById('btn-yakin');
  const form = document.getElementById('form-pesanan');

  // Fungsi cek nomor telepon valid sesuai regex +62 dan 9-13 digit setelahnya
  function cekValidNoHp() {
    const regex = /^\+62[0-9]{9,13}$/;
    return regex.test(noHpInput.value.trim());
  }
  
  // Event listener klik tombol submit utama
btnSubmit.addEventListener('click', function (e) {
  e.preventDefault();
  const nama = form.nama.value.trim();
  const noHp = form.no_hp.value.trim();
  const errorSpan = document.getElementById('error-nohp');

  errorSpan.style.display = 'none';
  errorSpan.textContent = '';

  // Tambahan validasi pilihan cara_pengambilan
  const caraPengambilan = form.querySelector('input[name="cara_pengambilan"]:checked');

  if (!nama || !noHp) {
    errorSpan.textContent = "Nama dan nomor telepon wajib diisi!";
    errorSpan.style.display = 'block';
    noHpInput.focus();
  } else if (!cekValidNoHp()) {
    errorSpan.textContent = "Nomor telepon tidak valid! Harus diawali +62 dan berisi 9–13 digit angka.";
    errorSpan.style.display = 'block';
    noHpInput.focus();
  } else if (!caraPengambilan) {  // Cek radio button belum dipilih
    errorSpan.textContent = "Harap pilih cara pengambilan (makan di tempat atau bungkus)!";
    errorSpan.style.display = 'block';
  } else {
    popup.style.display = 'flex';
  }
});


// Menambahkan event listener untuk menangani event 'submit' pada form
form.addEventListener('submit', function(e) {
  const errorSpan = document.getElementById('error-nohp');
  errorSpan.style.display = 'none';
  errorSpan.textContent = '';

    // Melakukan validasi nomor HP dengan memanggil fungsi cekValidNoHp()
  if (!cekValidNoHp()) {
    e.preventDefault();
    errorSpan.textContent = "Nomor telepon tidak valid!";
    errorSpan.style.display = 'block';
    // Mengarahkan fokus ke input nomor HP agar pengguna bisa langsung memperbaikinya
    noHpInput.focus();
  }
});

  // Tombol "Belum Yakin" akan menutup popup konfirmasi
  btnBelum.addEventListener('click', function () {
    popup.style.display = 'none';
  });

  // Tombol "Yakin" akan submit form
  btnYakin.addEventListener('click', function () {
    // Ambil nilai textarea catatan dan masukkan ke input hidden sebelum submit
    const catatanTextarea = document.querySelector('textarea[name="catatan"]');
    const catatanHidden = document.getElementById('catatan-hidden');
    if (catatanTextarea && catatanHidden) {
      catatanHidden.value = catatanTextarea.value;
    }

    form.submit(); // kirim form
  });
</script>
</body>
</html>