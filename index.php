<!-- ===================== BAGIAN UNTUK USER ===================== -->
<?php
include 'koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kantin Reborn PNJ</title>

  <!-- Pemanggilan Bootstrap dan ikon Bootstrap untuk styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <!-- Navbar navigasi utama -->
  <nav class="navbar navbar-expand-lg">
    <div class="navbar-custom">
      <a class="navbar-brand fw-bold text-white" href="#">
        Kantin<span class="text-danger">Reborn</span>
      </a>
    </div>
    <!-- Tombol toggle navbar untuk tampilan mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Daftar navigasi -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <!-- Navigasi antar bagian halaman -->
        <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#kategori">Kategori</a></li>
        <li class="nav-item"><a class="nav-link" href="#favorit">Favorit</a></li>
        <li class="nav-item"><a class="nav-link" href="#alur-pemesanan">Step</a></li>
        <li class="nav-item"><a class="nav-link" href="#toko">Toko</a></li>
        <li class="nav-item"><a class="nav-link" href="#ulasan">Ulasan</a></li>
        <li class="nav-item"><a class="nav-link" href="#lokasi">Lokasi</a></li>
      </ul>
    </div>
  </nav>  

  <!-- Hero Section / Header utama  -->
  <section id="home" class="hero d-flex align-items-center py-5 px-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1 class="display-5 fw-bold">Pesan <span class="text-danger">Makanan</span> Lebih Mudah di Kantin <span class="text-danger">Reborn</span> PNJ</h1>
          <p class="mt-3 text-muted">Pilih menu favorit, isi formulir pemesanan, dan ambil makanan tanpa antre. Buat waktu makanmu lebih efisien, langsung dari perangkatmu!</p>
          <div class="mt-3">
            <span class="badge bg-danger py-2 px-3 fw-semibold">Senin–Jumat, pukul 07.00–15.00</span>
          </div>
        </div>

        <!-- Gambar ilustrasi -->
        <div class="col-md-6 text-center mt-4 mt-md-0">
          <div class="hero-images d-flex justify-content-center align-items-center">
            <img src="img/Kantin1.jpg" alt="kantin1" class="kantin1">
            <img src="img/Kantin2.jpg" alt="kantin2" class="kantin2">
          </div>
        </div>
    </div>
  </section>

  <!-- Kategori Menu Section -->
  <section id="kategori" class="section text-center py-5 bg-white">
  <div class="container">
    <h2 class="fw-bold">Pilihan <span class="text-danger">Kategori</span> Menu</h2>
    <p class="text-muted">Pilih kategori sesuai selera kamu untuk mulai memesan</p>
    
    <!-- Kartu kategori menu -->
    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
      <a href="makanan.php" class="kategori-link text-decoration-none text-dark">
        <div class="kategori-item">
        <img src="img/KAT MAKANAN.png" alt="Makanan"> </div>
      </a>
      <a href="minuman.php" class="kategori-link text-decoration-none text-dark">
        <div class="kategori-item">
          <img src="img/KAT MINUMAN.png" alt="Minuman">
        </div>
      </a>
      <a href="cemilan.php" class="kategori-link text-decoration-none text-dark">
        <div class="kategori-item">
        <img src="img/KAT CAMILAN.png" alt="Camilan">
      </div>
      </a>
    </div>
  </div>
  </section>
  
  <!--Menu Favorit-->  
  <section id="favorit" class=" section menu-favorit text-center my-5">
    <h2><strong>Menu <span class="text-danger">Favorit</span></strong></h2>
    <p>Lihat pilihan yang paling sering dipesan dan disukai banyak orang</p>
  
    <!-- Tiga menu favorit dengan posisi ranking -->
    <div class="d-flex justify-content-center align-items-end gap-4 flex-wrap mt-4 favorit-top3">
      <!-- No 2 - Es Teh -->
      <div class="favorit-card second">
        <div class="image-wrapper">
          <img src="img/favorit-esteh.png" alt="Es Teh">
        </div>
      </div>
    
      <!-- No 1 - Ayam Penyet -->
      <div class="favorit-card first">
        <div class="image-wrapper">
          <img src="img/favorit-ayam.png" alt="Ayam Penyet">
        </div>
      </div>
    
      <!-- No 3 - Rice Bowl -->
      <div class="favorit-card third">
        <div class="image-wrapper">
          <img src="img/favorit-ricebowl.png" alt="Rice Bowl">
        </div>
      </div>
    </div>    
  </section>

  <!-- Alur Pemesanan -->
  <section id="alur-pemesanan" class="section alur-pemesanan">
    <!-- Gambar alur proses pemesanan -->
    <img src="img/Section.png" alt="Alur Pemesanan Kantin Reborn" />
  </section>

  <!-- Pilih Toko -->
  <section id="toko" class="section text-center my-5">
    <h2><strong>Pilih <span class="text-danger">Toko</span></strong></h2>
    <p>Pilih kios atau tenant tempat kamu ingin memesan makanan</p>

    <div id="carouselToko" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- Slide toko pertama -->
        <div class="carousel-item active">
          <div class="d-flex justify-content-center gap-4 flex-wrap">
            <a href="detail_kantin.php?kantin_id=1" class="toko-card text-decoration-none text-dark">
              <img src="img/Fresh & Tasty.png" alt="Fresh & Tasty">
              <h5>Fresh & Tasty</h5>
            </a>
            <a href="detail_kantin.php?kantin_id=2" class="toko-card text-decoration-none text-dark">
              <img src="img/Rice Bowl.png" alt="Rice Bowl">
              <h5>Teras Warung Kuy</h5>
            </a>
            <a href="detail_kantin.php?kantin_id=3" class="toko-card text-decoration-none text-dark">
              <img src="img/Seafood Reborn PNJ.png" alt="Seafood Reborn PNJ">
              <h5>Seafood Reborn PNJ</h5>
            </a>
            <a href="detail_kantin.php?kantin_id=4" class="toko-card text-decoration-none text-dark">
              <img src="img/Penyetan HK.png" alt="Penyetan HK">
              <h5>Penyetan HK</h5>
            </a>
          </div>
        </div>

        <!-- Slide toko kedua -->
        <div class="carousel-item">
          <div class="d-flex justify-content-center gap-4 flex-wrap">
            <a href="detail_kantin.php?kantin_id=5" class="toko-card text-decoration-none text-dark">
              <img src="img/Mie Yamin.png" alt="Mie Yamin">
              <h5>Mie Yamin 20 PNJ</h5>
            </a>
            <a href="detail_kantin.php?kantin_id=6" class="toko-card text-decoration-none text-dark">
              <img src="img/Aneka Soto.png" alt="Soto">
              <h5>Aneka Soto dan Sop</h5>
            </a>
            <a href="detail_kantin.php?kantin_id=7" class="toko-card text-decoration-none text-dark">
              <img src="img/Dhans Japanese Food.png" alt="Dhans Japanese Food">
              <h5>Dhans Japanese Food</h5>
            </a>
            <a href="detail_kantin.php?kantin_id=8" class="toko-card text-decoration-none text-dark">
              <img src="img/SILANDI.png" alt="Silandi">
              <h5>Silandi</h5>
            </a>
          </div>
        </div>

        <!-- Slide toko ketiga -->
        <div class="carousel-item">
          <div class="d-flex justify-content-center gap-4 flex-wrap">
            <a href="detail_kantin.php?kantin_id=9" class="toko-card text-decoration-none text-dark">
              <img src="img/Kedai Ayam Crispy.png" alt="Kedai Ayam Crispy">
              <h5>Kedai Ayam Crispy</h5>
            </a>
            <a href="detail_kantin.php?kantin_id=10" class="toko-card text-decoration-none text-dark">
              <img src="img/My Drink.png" alt="My Drink">
              <h5>My Drink</h5>
            </a>
            <a href="detail_kantin.php?kantin_id=11" class="toko-card text-decoration-none text-dark">
              <img src="img/Nasi Goreng Arifin.png" alt="Nasi Goreng Arifin">
              <h5>Nasi Goreng Arifin</h5>
            </a>
          </div>
        </div>
      </div>

      <!-- Navigasi panah -->
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselToko" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselToko" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
        <span class="visually-hidden">Next</span>
      </button>

      <!-- Titik indikator -->
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselToko" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselToko" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselToko" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
    </div>
  </section>

  <!-- Form Tulis Ulasan -->
  <section id="ulasan" class="section ulasan-section">
    <h2><strong>Tulis <span class="text-danger">Ulasan</span> Kamu</strong></h2>
    <p>Yuk, share kesan dan pesanmu!</p>
  
    <!-- Form pengiriman ulasan -->
    <form class="ulasan-form" action="proses_ulasan.php" method="POST">
      <label for="nama">Nama:</label>
      <input type="text" id="nama" name="nama" required placeholder="Isi nama kamu di sini!"/>

      <label for="ulasan">Ulasan:</label>
      <textarea id="ulasan" name="komentar" rows="3" required  placeholder="Tulis ulasanmu dan ceritakan pengalamanmu di sini!"></textarea>

      <label for="rating">Rating:</label>
      <select id="rating" name="rating" required>
        <option value="">Pilih rating</option>
        <option value="5">5 - Sangat baik</option>
        <option value="4">4 - Baik</option>
        <option value="3">3 - Cukup</option>
        <option value="2">2 - Kurang</option>
        <option value="1">1 - Buruk</option>
      </select>

      <button type="submit">Kirim Ulasan</button>
    </form>

    <!-- Judul bagian ulasan pengunjung -->
    <h2 class="judul-ulasan">
      <span class="merah">Ulasan</span> <span class="hitam">Pengunjung</span>
    </h2>      
  
    <!-- Tabel ulasan -->
    <table class="ulasan-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Komentar</th>
          <th>Rating</th>
          <th>Tanggal</th>
        </tr>
      </thead>
      <tbody>
      <!-- Baris ulasan akan muncul di sini -->
      <?php
      include 'koneksi.php';
      $sql = "SELECT * FROM ulasan_pengunjung ORDER BY tanggal DESC";
      $result = mysqli_query($koneksi, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
          echo "<td>" . htmlspecialchars($row['komentar']) . "</td>";
          echo "<td>" . $row['rating'] . "/5</td>";
          echo "<td>" . $row['tanggal'] . "</td>";
          echo "</tr>";
      }
      ?>
      </tbody>
    </table>
  </section>

  <!-- Lokasi Kantin -->
  <section id="lokasi">
    <div class="lokasi-wrapper">
      <div class="lokasi-map" id="map"></div>
      <div class="lokasi-info">
        <h2>Kantin <span>Reborn</span> PNJ</h2>
        <p>
          Kantin Reborn terletak di area strategis dalam kampus Politeknik Negeri Jakarta (PNJ), yang beralamat di:<br><br>
          Kampus PNJ<br>
          Jl. Prof. DR. G.A. Siwabessy, Kukusan, Beji,<br>
          Depok, Jawa Barat 16425
        </p>
        <ul>
          <li>Dekat Bank Mini (Unit Kegiatan Mahasiswa)</li>
          <li>Sebelah Gedung Administrasi Bisnis (AB)</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    Hak cipta © 2025 Dibuat oleh Kelompok 6
  </footer>

  <!-- Script untuk Bootstrap dan Google Maps -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function initMap() {
      const kantinReborn = { lat: -6.370520291600104, lng: 106.82359549350429 };
      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 18,
        center: kantinReborn,
      });
      new google.maps.Marker({
        position: kantinReborn,
        map: map,
        title: "Kantin Reborn PNJ",
        animation: google.maps.Animation.BOUNCE,
      });
    }

  function escapeHtml(text) {
  return text
    ? text.replace(/&/g, "&amp;")
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;")
          .replace(/"/g, "&quot;")
          .replace(/'/g, "&#039;")
    : "";
  }
  </script>

  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_ahD9XE7cQ_-2QxCz0NUs8mpnRSgnI2Q&callback=initMap">
  </script>
</body>
</html>