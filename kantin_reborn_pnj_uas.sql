-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jul 2025 pada 07.05
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantin_reborn_pnj_uas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kantin`
--

CREATE TABLE `kantin` (
  `kantin_id` int(11) NOT NULL,
  `nama_kantin` varchar(100) NOT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `harga_min` int(11) NOT NULL,
  `harga_max` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `estimasi_waktu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kantin`
--

INSERT INTO `kantin` (`kantin_id`, `nama_kantin`, `jam_buka`, `jam_tutup`, `harga_min`, `harga_max`, `gambar`, `estimasi_waktu`) VALUES
(1, 'Fresh & Tasty', '09:00:00', '15:00:00', 4000, 8000, 'minuman-es.jpg', 10),
(2, 'Teras Warung Kuy', '09:00:00', '15:00:00', 13000, 15000, 'Rice Bowl.jpg', 15),
(3, 'Seafood Reborn PNJ', '09:00:00', '15:00:00', 10000, 15000, 'seafood-reborn.jpg', 15),
(4, 'Penyetan HK', '09:00:00', '15:00:00', 10000, 15000, 'penyetanHK.jpg', 20),
(5, 'Mie Yamin 20 PNJ', '09:00:00', '15:00:00', 10000, 13000, 'mieyamin.jpg', 15),
(6, 'Aneka Soto & Sop', '09:00:00', '15:00:00', 12000, 20000, 'soto.jpg', 15),
(7, 'Dhans Japanese Food', '09:00:00', '15:00:00', 10000, 20000, 'japanesse.jpg', 15),
(8, 'Silandi', '09:00:00', '15:00:00', 10000, 20000, 'silandi.jpg', 15),
(9, 'Kedai Ayam Crispy', '09:00:00', '15:00:00', 3000, 15000, 'crispy.jpg', 15),
(10, 'My Drink', '09:00:00', '15:00:00', 5000, 10000, 'jus.jpg', 10),
(11, 'Nasi Goreng Arifin', '09:00:00', '15:00:00', 7000, 13000, 'nasigoreng.jpg', 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Camilan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_kantin`
--

CREATE TABLE `kategori_kantin` (
  `kantin_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_kantin`
--

INSERT INTO `kategori_kantin` (`kantin_id`, `kategori_id`) VALUES
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(9, 3),
(10, 2),
(11, 1),
(11, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `kantin_id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status_tersedia` varchar(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `kantin_id`, `nama_menu`, `harga`, `foto`, `status_tersedia`) VALUES
(0, 8, 'Paket Nasi Telor + Tahu/Tempe', 12000.00, 'Paket Nasi Telor Tahu Tempe.jpg', 'T'),
(1, 1, 'Teh Tawar (Panas/Dingin)', 4000.00, '1750126625_1748391109_TEH TAWAR.jpg', 'T'),
(2, 1, 'Teh Manis (Panas/Dingin)', 5000.00, '1748393521_TEH MANIS.jpg', 'T'),
(3, 1, 'Teh Kekinian (Strawberry)', 8000.00, '1748392837_TEH KEKINIAN STRAWBERRY.jpg', 'T'),
(4, 1, 'Teh Kekinian (Teh Tarik – Max Tea)', 8000.00, 'TEH TARIK.jpg', 'H'),
(5, 1, 'Kopi Liong (Tanpa Gula/Gula)', 5000.00, 'KOPI LIONG.jpg', 'T'),
(6, 1, 'Kopi Kapal Api (Tanpa Gula/Gula)', 5000.00, 'KOPI KAPAL API.jpg', 'T'),
(7, 1, 'Kopi Kapal Api Susu', 5000.00, 'KOPI KAPAL API SUSU.jpg', 'T'),
(8, 1, 'Good Day (Mocachino)', 5000.00, 'Good Day Mocacinno.jpg', 'T'),
(9, 1, 'Latte (Matcha)', 5000.00, 'lattematcha.jpg', 'T'),
(10, 1, 'Latte (Matcha)', 8000.00, 'lattematcha.jpg', 'T'),
(11, 1, 'Pop Ice (Melon)', 5000.00, 'popicemelon.jpg', 'T'),
(12, 1, 'Pop Ice (Permen Karet)', 5000.00, 'popicepermenkaret.jpg', 'T'),
(13, 1, 'Nutrisari (Jeruk Peras)', 5000.00, 'nutrisarijerukperas.jpg', 'T'),
(14, 1, 'Nutrisari (Jeruk Nipis)', 5000.00, 'nutrisarijeruknipis.jpg', 'T'),
(15, 1, 'Nutrisari (Sweet Orange)', 5000.00, 'nutrisarisweetorange.jpg', 'T'),
(16, 1, 'Kuwut (Melon)', 8000.00, 'kuwutmelon.jpg', 'T'),
(17, 1, 'Yakult (Soda Jeruk)', 8000.00, 'yakultsodajeruk.jpg', 'T'),
(18, 1, 'Mocktail (Rainbow)', 8000.00, 'moctailrainbow.png', 'T'),
(19, 1, 'Squash (Melon)', 5000.00, 'squashmelon.jpg', 'T'),
(20, 1, 'Squash (Melon)', 8000.00, 'squashmelon.jpg', 'T'),
(21, 1, 'Mojito (Sirup)', 8000.00, 'mojito.jpg', 'T'),
(22, 1, 'Soda Gembira', 8000.00, 'sodagembira.jpg', 'T'),
(23, 1, 'Chocolatos Coklat', 6000.00, 'chocolatoscoklat.jpg', 'T'),
(24, 1, 'Chocolatos Matcha', 6000.00, 'chocolatosmatcha.jpg', 'T'),
(160, 1, 'Ovaltine', 6000.00, 'ovaltine.jpg', 'T'),
(161, 1, 'Hilo Hazelnut', 6000.00, 'Hilo Hazelnut.jpg', 'T'),
(163, 2, 'Rice Bowl Ayam Pop (Cranchy Wings)', 15000.00, 'Rice Bowl Ayam Pop (Cranchy Wings).jpg', 'T'),
(164, 2, 'Rice Bowl Ayam Pop (Teriyaki)', 13000.00, 'Rice Bowl Ayam Pop (Teriyaki).jpg', 'T'),
(165, 2, 'Rice Bowl Ayam Pop (BBQ)', 13000.00, 'Rice Bowl Ayam Pop (BBQ).jpg', 'T'),
(166, 2, 'Rice Bowl Ayam Pop (Black Papper)', 13000.00, 'Rice Bowl Ayam Pop (Black Papper).jpg', 'T'),
(167, 2, 'Rice Bowl Ayam Pop (Korean)', 13000.00, 'Rice Bowl Ayam Pop (Korean).jpg', 'T'),
(168, 2, 'Rice Bowl Ayam Pop (Sambal Matah)', 14000.00, 'Rice Bowl Ayam Pop (Sambal Matah).jpg', 'T'),
(169, 2, 'Rice Bowl Ayam Pop (Cheese)', 15000.00, 'Rice Bowl Ayam Pop (Cheese).jpg', 'T'),
(170, 3, 'Steak Ayam + Nasi', 15000.00, 'Steak Ayam + Nasi.jpeg', 'T'),
(171, 3, 'Steak Ayam Bakar + Nasi', 15000.00, 'Steak Ayam Bakar + Nasi.png', 'T'),
(172, 3, 'Steak Udang + Nasi', 15000.00, 'Steak Udang + Nasi.jpeg', 'T'),
(173, 3, 'Steak Cumi + Nasi', 15000.00, 'Steak Cumi + Nasi.jpg', 'T'),
(174, 3, 'Bebek Madura + Nasi', 15000.00, 'Bebek Madura + Nasi.jpeg', 'T'),
(175, 3, 'Aneka Ikan Crispy + Nasi (Lele)', 13000.00, 'Aneka Ikan Crispy + Nasi (Lele).jpg', 'T'),
(176, 3, 'Nasi Kepal', 10000.00, 'Nasi Kepal.jpeg', 'T'),
(177, 3, 'Tomyum + Nasi', 10000.00, 'Tomyum + Nasi.jpg', 'T'),
(178, 4, 'Ayam Penyet', 15000.00, 'Ayam Penyet.jpg', 'T'),
(179, 4, 'Ayam Bakar', 15000.00, 'Ayam Bakar.jpg', 'T'),
(180, 4, 'Ayam Geprek', 15000.00, 'Ayam Geprek.jpg', 'T'),
(181, 4, 'Ayam Rica', 15000.00, 'Ayam Rica.jpg', 'T'),
(182, 4, 'Ati Ampela', 10000.00, 'Ati Ampela.jpg', 'T'),
(183, 5, 'Mie Rempah Pedas Manis', 12000.00, 'Mie Rempah Pedas Manis.jpg', 'T'),
(184, 5, 'Mie Rempah Pedas Asin', 12000.00, 'Mie Rempah Pedas Asin.jpg', 'T'),
(185, 5, 'Mie Yamin Toping Pangsit/Ceker', 13000.00, 'Mie Yamin Toping Pangsit Ceker.jpg', 'T'),
(186, 5, 'Mie Ayam Toping Pangsit/Ceker', 13000.00, 'Mie Ayam Toping Pangsit Ceker.jpg', 'T'),
(188, 5, 'Pangsit Goreng Chili Oil', 10000.00, 'Pangsit Goreng Chili Oil.jpg', 'T'),
(189, 5, 'Pangsit Rebus Chili Oil', 10000.00, 'Pangsit Rebus Chili Oil.jpg', 'T'),
(190, 6, 'Soto Mie + Nasi', 15000.00, 'Soto Mie + Nasi.jpeg', 'T'),
(191, 6, 'Soto Babat + Nasi', 15000.00, 'Soto Babat + Nasi.jpg', 'T'),
(192, 6, 'Soto Campur + Nasi', 15000.00, 'Soto Campur + Nasi.jpg', 'T'),
(193, 6, 'Soto Daging + Nasi', 13000.00, 'Soto Daging + Nasi.jpg', 'T'),
(194, 6, 'Soto Betawi + Nasi', 13000.00, 'Soto Betawi + Nasi.jpg', 'T'),
(195, 6, 'Soto Ayam + Nasi', 12000.00, 'Soto Ayam + Nasi.jpg', 'T'),
(196, 6, 'Sop Iga + Nasi', 20000.00, 'Sop Iga + Nasi.jpeg', 'T'),
(197, 6, 'Sop Daging + Nasi', 13000.00, 'Sop Daging + Nasi.jpg', 'T'),
(198, 6, 'Sop Kimlo + Nasi', 13000.00, 'Sop Kimlo + Nasi.jpg', 'T'),
(199, 6, 'Sop Ayam + Nasi', 12000.00, 'Sop Ayam + Nasi..jpg', 'T'),
(200, 6, 'Sop Telur Puyuh + Nasi', 12000.00, 'Sop Telur Puyuh + Nasi.jpg', 'T'),
(201, 7, 'Chicken Gordon Blue + Salad + Nasi', 20000.00, 'Chicken Gordon Blue + Salad + Nasi.jpg', 'T'),
(202, 7, 'Chicken Katsu + Salad + Nasi', 13000.00, 'Chicken Katsu + Salad + Nasi.jpg', 'T'),
(203, 7, 'Chicken Teriyaki + Salad + Nasi', 15000.00, 'Chicken Teriyaki + Salad + Nasi.jpg', 'T'),
(205, 7, 'Cumi + Salad + Nasi', 15000.00, 'Cumi.jpg', 'T'),
(206, 7, 'Ebi Furai + Salad + Nasi', 15000.00, 'Ebi Furai + Salad + Nasi.jpg', 'T'),
(207, 7, 'Chicken Karaage + Salad + Nasi', 15000.00, 'Chicken Karaage + Salad + Nasi.jpg', 'T'),
(208, 7, 'Chiby Bento + Salad + Nasi', 15000.00, 'Chiby Bento + Salad + Nasi.jpeg', 'T'),
(209, 7, 'Tuna + Salad + Nasi', 15000.00, 'Tuna + Salad + Nasi.jpg', 'T'),
(210, 7, 'Kentang Goreng', 10000.00, 'Kentang Goreng.jpg', 'T'),
(211, 8, 'Paket Nasi Telor', 10000.00, 'Paket Nasi Telor.jpg', 'T'),
(213, 8, 'Paket Nasi Ayam', 13000.00, 'Paket Nasi Ayam.jpg', 'T'),
(214, 8, 'Paket Nasi Ayam + Tahu/Tempe', 15000.00, 'Paket Nasi Ayam Tahu Tempe.jpg', 'T'),
(215, 8, 'Paket Nasi Ikan', 18000.00, 'Paket Nasi Ikan.jpg', 'T'),
(216, 8, 'Paket Nasi Ikan + Tahu/Tempe', 20000.00, 'Paket Nasi Ikan Tahu Tempe.jpeg', 'T'),
(217, 9, 'Gyoza Dimsum', 3000.00, 'Gyoza Dimsum.jpg', 'T'),
(218, 9, 'Corndog Sosis', 5000.00, 'Corndog Sosis.jpg', 'T'),
(219, 9, 'Baso Aci', 14000.00, 'Baso Aci.jpg', 'T'),
(220, 9, 'Kebab Mini Daging Sapi', 7000.00, 'Kebab Mini Daging Sapi.jpg', 'T'),
(221, 9, 'Krispy Balado', 11000.00, 'Krispy Balado.jpg', 'T'),
(222, 9, 'Krispy Jagung Manis', 11000.00, 'Krispy Jagung Manis.jpg', 'T'),
(223, 9, 'Krispy Jagung Bakar', 11000.00, 'Krispy Jagung Bakar.jpg', 'T'),
(224, 9, 'Krispy Barbeque', 11000.00, 'Krispy Barbeque.jpg', 'T'),
(225, 9, 'Krispy Korean', 11000.00, 'Krispy Korean.jpg', 'T'),
(226, 9, 'Krispy Cheese', 11000.00, 'Krispy Cheese.jpg', 'T'),
(227, 9, 'Kulit Ayam + Nasi', 14000.00, 'Kulit Ayam + Nasi.jpeg', 'T'),
(228, 10, 'Jus Alpukat', 10000.00, 'Jus Alpukat.jpg', 'T'),
(229, 10, 'Jus Mangga', 10000.00, 'JusMangga.jpg', 'T'),
(230, 10, 'Jus Strawberry', 10000.00, 'Jus Strawberry.jpg', 'T'),
(231, 10, 'Jus Jambu Merah', 10000.00, 'Jus Jambu Merah.jpg', 'T'),
(232, 10, 'Jus Apel', 10000.00, 'Jus Apel.jpg', 'T'),
(233, 10, 'Jus Melon', 10000.00, 'Jus Melon.jpg', 'T'),
(234, 11, 'Nasi Goreng', 10000.00, 'Nasi Goreng.jpg', 'T'),
(235, 11, 'Mie Goreng', 12000.00, 'Mie Goreng.jpg', 'T'),
(236, 11, 'Kwetiau Goreng', 12000.00, 'Kwetiau Goreng.jpg', 'T'),
(237, 11, 'Nasi Gila', 13000.00, 'Nasi Gila.jpg', 'T'),
(238, 11, 'Martabak Mie', 13000.00, 'Martabak Mie.jpg', 'T'),
(239, 11, 'Roti Bakar Keju', 8000.00, 'Roti Bakar Keju.jpg', 'T'),
(240, 11, 'Roti Bakar Selai', 7000.00, 'Roti Bakar Selai.jpg', 'T');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nomor_pesanan` varchar(50) DEFAULT NULL,
  `kantin_id` int(11) NOT NULL,
  `nama_pemesan` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `menu_id` int(11) NOT NULL,
  `daftar_menu` text DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `waktu_pemesanan` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Belum Diambil','Sudah Diambil','Tidak Diambil') NOT NULL DEFAULT 'Belum Diambil',
  `jumlah_menu` int(11) NOT NULL DEFAULT 1,
  `cara_pengambilan` enum('makan_di_tempat','bungkus') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `nomor_pesanan`, `kantin_id`, `nama_pemesan`, `no_hp`, `catatan`, `menu_id`, `daftar_menu`, `subtotal`, `waktu_pemesanan`, `status`, `jumlah_menu`, `cara_pengambilan`) VALUES
(1, 'PNJ68403f24b0367', 4, 'adinda', '+62498394893', '', 180, 'Ayam Geprek', 15000.00, '2025-06-04 12:42:12', 'Belum Diambil', 1, 'makan_di_tempat'),
(2, 'PNJ6840719adc07d', 1, 'RADEN RORO JASMINE AZZAHRA RAUDHAH', '+6289506131374', '', 2, 'Teh Manis (Panas/Dingin)', 10000.00, '2025-06-04 16:17:30', 'Tidak Diambil', 2, 'bungkus'),
(3, 'PNJ6840719adc07d', 1, 'RADEN RORO JASMINE AZZAHRA RAUDHAH', '+6289506131374', '', 4, 'Teh Kekinian (Teh Tarik – Max Tea)', 8000.00, '2025-06-04 16:17:30', 'Sudah Diambil', 1, 'bungkus'),
(4, 'PNJ684fb530431e9', 1, 'SOL.4CE', '+6289506131374', '', 1, 'Teh Tawar (Panas/Dingin)', 8000.00, '2025-06-16 06:09:52', 'Sudah Diambil', 2, 'makan_di_tempat'),
(5, 'PNJ684fb56d8d9ad', 1, 'candi', '+6289506131374', '', 2, 'Teh Manis (Panas/Dingin)', 10000.00, '2025-06-16 06:10:53', 'Sudah Diambil', 2, 'makan_di_tempat'),
(6, 'PNJ6850e075efc84', 7, 'rt', '+6289506131345', '', 205, 'Cumi + Salad + Nasi', 30000.00, '2025-06-17 03:26:45', 'Belum Diambil', 2, 'bungkus'),
(7, 'PNJ6850e8f503c40', 1, 'ADINDA AZHSYARA', '+6289506131374', 'es ya', 1, 'Teh Tawar (Panas/Dingin)', 20000.00, '2025-06-17 04:03:01', 'Sudah Diambil', 5, 'bungkus'),
(8, 'PNJ686a0165e4589', 2, 'Rahayu', '+62498394893', 'Nasinya dikit aja ya', 168, 'Rice Bowl Ayam Pop (Sambal Matah)', 14000.00, '2025-07-06 04:53:57', 'Belum Diambil', 1, 'bungkus'),
(9, 'PNJ686a0165e4589', 2, 'Rahayu', '+62498394893', 'Nasinya dikit aja ya', 169, 'Rice Bowl Ayam Pop (Cheese)', 30000.00, '2025-07-06 04:53:58', 'Belum Diambil', 2, 'bungkus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan_pengunjung`
--

CREATE TABLE `ulasan_pengunjung` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `komentar` text NOT NULL,
  `rating` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan_pengunjung`
--

INSERT INTO `ulasan_pengunjung` (`id`, `nama`, `komentar`, `rating`, `tanggal`) VALUES
(15, 'fika aneke ', 'makanannya enak-enak bangettt!!!!', 5, '2025-05-20 05:44:35'),
(16, 'adinda', 'ayam penyet the best!', 5, '2025-05-21 02:23:47'),
(17, 'candi', 'jelek', 5, '2025-06-17 02:19:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kantin`
--
ALTER TABLE `kantin`
  ADD PRIMARY KEY (`kantin_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indeks untuk tabel `kategori_kantin`
--
ALTER TABLE `kategori_kantin`
  ADD PRIMARY KEY (`kantin_id`,`kategori_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `kantin_id` (`kantin_id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `ulasan_pengunjung`
--
ALTER TABLE `ulasan_pengunjung`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kantin`
--
ALTER TABLE `kantin`
  MODIFY `kantin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `ulasan_pengunjung`
--
ALTER TABLE `ulasan_pengunjung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kategori_kantin`
--
ALTER TABLE `kategori_kantin`
  ADD CONSTRAINT `kategori_kantin_ibfk_1` FOREIGN KEY (`kantin_id`) REFERENCES `kantin` (`kantin_id`),
  ADD CONSTRAINT `kategori_kantin_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`);

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`kantin_id`) REFERENCES `kantin` (`kantin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
