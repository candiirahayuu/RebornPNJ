<!-- ===================== BAGIAN UNTUK ADMIN ===================== -->

<?php
include 'koneksi.php';

// Cek apakah parameter 'kantin'
if (!isset($_GET['kantin'])) {
    echo "Kantin tidak ditemukan.";
    exit;
}

// Ambil dan amankan ID kantin
$kantin_id = intval($_GET['kantin']);

// Ambil data kantin berdasarkan ID
$kantin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kantin WHERE kantin_id = $kantin_id"));
if (!$kantin) {
    echo "Kantin tidak ditemukan.";
    exit;
}

// Ambil data pesanan berdasarkan ID kantin, urutkan dari yang terbaru
$pesanan = mysqli_query($koneksi, "
    SELECT * 
    FROM pesanan
    WHERE kantin_id = $kantin_id
    ORDER BY id_pesanan DESC
");

if (!$pesanan) {
    echo "Query error: " . mysqli_error($koneksi);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin - <?= htmlspecialchars($kantin['nama_kantin']) ?></title>
<style>
    /* Reset and base */
    * {
        box-sizing: border-box;
    }
    body {
        margin:0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f6fa;
        color: #333;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        width: 220px;
        height: 100vh;
        background-color: #2c2c2c;
        color: white;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
        z-index: 999;
    }
    .sidebar h2 {
        margin: 0;
        padding: 22px 20px;
        font-size: 24px;
        background-color: #1f1f1f;
        color: #ff4444;
        text-align: center;
        font-weight: 700;
        letter-spacing: 1.5px;
        border-bottom: 3px solid #ff4444;
        user-select: none;
    }
    .sidebar a {
        display: block;
        padding: 14px 25px;
        color: white;
        text-decoration: none;
        font-weight: 600;
        letter-spacing: 0.03em;
        transition: background-color 0.3s, color 0.3s;
        border-left: 4px solid transparent;
    }
    /* Remove red color from active and hover, use grey shades */
    .sidebar a:hover,
    .sidebar .active {
        background-color:hsl(54, 100.00%, 50.00%);
        color: #222222;
        font-weight: 700;
        border-left-color: #555555;
    }

    /* Main content */
    .main {
        margin-left: 220px;
        padding: 35px 40px;
        background-color: #fff;
        min-height: 100vh;
        transition: margin-left 0.3s ease;
    }

    /* Info Kantin */
    .info-kantin {
        display: flex;
        align-items: center;
        gap: 25px;
        background-color: #f9f9f9;
        padding: 28px 35px;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.07);
        user-select: none;
        transition: box-shadow 0.3s ease;
    }
    .info-kantin:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    .info-kantin img {
        width: 140px;
        height: 140px;
        border-radius: 15px;
        object-fit: cover;
        border: 2px solid #ddd;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .info-kantin img:hover {
        transform: scale(1.07);
    }
    .info-kantin h2 {
        font-size: 28px;
        margin: 0;
        font-weight: 700;
        color: #333;
    }
    .info-kantin small {
        color: #666;
        font-size: 15px;
        font-weight: 600;
        display: block;
        margin-top: 4px;
        letter-spacing: 0.03em;
    }

    /* Table styles */
    .table-container {
        overflow-x: auto;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        border-radius: 15px;
        background-color: white;
        padding: 16px 24px;
    }
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 14px;
        font-size: 15px;
        min-width: 600px;
    }

    /* Table header with black text */
    thead tr {
        background: transparent;
    }
    th {
        color: #000000; /* Black text for header */
        font-weight: 700;
        padding: 14px 20px;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 3px solid #ff4444;
        user-select: none;
    }
    
    /* Table body rows */
    tbody tr {
        background-color: #fafafa;
        box-shadow: 0 3px 8px -4px rgba(0,0,0,0.1);
        border-radius: 12px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        cursor: default;
    }
    tbody tr:hover {
        background-color: #fff8e1;
        box-shadow: 0 12px 25px rgba(255, 204, 0, 0.25);
    }

    /* Reset td border for smooth rounded rows */
    td {
        padding: 15px 20px;
        border: none;
        vertical-align: middle;
        color: #444;
        position: relative;
    }
    /* Rounded edges for first and last td of rows */
    tbody tr td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    tbody tr td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Red highlight for 'Tidak Diambil' */
    tbody tr.tidak-diambil {
    background-color:rgb(255, 113, 113); /* Latar belakang merah muda */
    color: #c1272d; /* Warna teks merah */
    font-weight: 700; /* Tebal */
    }

    /* Select styling */
    select {
        padding: 8px 14px;
        border-radius: 8px;
        border: 2px solid #ccc;
        font-size: 14px;
        font-weight: 600;
        background-color: white;
        color: #333;
        cursor: pointer;
        outline: none;
        appearance: none;
        background-image:
            linear-gradient(45deg, transparent 50%, #666 50%),
            linear-gradient(135deg, #666 50%, transparent 50%),
            linear-gradient(to right, #ccc, #ccc);
        background-position:
            calc(100% - 20px) calc(1em + 2px),
            calc(100% - 15px) calc(1em + 2px),
            calc(100% - 25px) 0.5em;
        background-size: 5px 5px,5px 5px,1px 1.5em;
        background-repeat: no-repeat;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    select:focus {
        border-color: #ffcc00;
        box-shadow: 0 0 8px 2px #ffcc00aa;
    }

    /* Status option colors */
    option[value="Belum Diambil"] { color:#333; font-weight:600; }
    option[value="Sudah Diambil"] { color:green; font-weight:600; }
    option[value="Tidak Diambil"] { color:#c1272d; font-weight:600; }

    /* Footer */
    .footer {
        background-color: #ff4444;
        color: white;
        text-align: center;
        padding: 14px 20px;
        font-weight: 600;
        font-size: 14px;
        user-select: none;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.15);
        position: fixed;
        bottom: 0;
        width: calc(100% - 220px);
        margin-left: 220px;
        transition: width 0.3s ease, margin-left 0.3s ease;
        z-index: 50;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
        }
        .main {
            margin-left: 0;
            padding: 25px 20px 80px;
        }
        .footer {
            position: static;
            width: 100%;
            margin-left: 0;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        table {
            min-width: 0;
            font-size: 14px;
        }
        tbody tr {
            box-shadow: none;
            border-radius: 0;
            margin-bottom: 12px;
            display: block;
            background-color: #fff;
            padding: 12px 18px;
        }
        tbody tr.tidak-diambil td {
            color: #c1272d;
        }
        tbody tr:hover {
            background-color: #fff8e1;
            box-shadow: none;
        }
        tbody tr td {
            display: block;
            padding: 6px 0;
            border: none;
            text-align: right;
            position: relative;
        }
        tbody tr td::before {
            content: attr(data-label);
            float: left;
            font-weight: 700;
            color: #ff4444;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        tbody tr td:last-child {
            border-radius: 0;
        }
    }
</style>
</head>
<body>

<div class="sidebar" aria-label="Sidebar Navigasi">
    <!-- Menampilkan nama kantin di sidebar -->
    <h2>Kantin<span style="color:white;">Reborn</span></h2>
    <a href="admin.php?kantin=<?= $kantin_id ?>" class="<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : '' ?>">Daftar Pesanan</a>
    <a href="kelola_menu.php?kantin=<?= $kantin_id ?>" class="<?= basename($_SERVER['PHP_SELF']) == 'kelola_menu.php' ? 'active' : '' ?>">Kelola Menu</a>
</div>

<div class="main">
    <!-- Tampilkan gambar dan informasi kantin -->
    <div class="info-kantin" aria-label="Informasi Kantin">
        <img src="img/<?= htmlspecialchars($kantin['gambar']) ?>" alt="<?= htmlspecialchars($kantin['nama_kantin']) ?>" />
        <div>
            <h2><?= htmlspecialchars($kantin['nama_kantin']) ?></h2>
            <small><?= htmlspecialchars($kantin['jam_buka']) ?> - <?= htmlspecialchars($kantin['jam_tutup']) ?> WIB</small>
            <small>Estimasi waktu: <?= htmlspecialchars($kantin['estimasi_waktu']) ?> menit</small>
            <small>Bayar langsung saat ambil (COD)</small>
        </div>
    </div>

    <div class="table-container" role="region" aria-label="Daftar Pesanan">
        <table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Cara Pengambilan</th> 
            <th>Catatan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($pesanan)) {
        if ($row['status'] === "Sudah Diambil") {
            continue;
        }
        // Bersihkan nilai status dan beri kelas jika status 'Tidak Diambil'
        $status_dibersihkan = strtolower(trim($row['status']));
        $tdClass = ($status_dibersihkan === 'tidak diambil') ? 'tidak-diambil' : '';
        ?>
        <tr class="<?= $tdClass ?>">
            <td data-label="No"><?= $no ?></td>
            <td data-label="Nama"><?= htmlspecialchars($row['nama_pemesan']) ?></td>
            <td data-label="Menu"><?= htmlspecialchars($row['daftar_menu']) ?></td>
            <td data-label="Jumlah"><?= htmlspecialchars($row['jumlah_menu']) ?></td> <!-- Menampilkan jumlah menu -->
            <td data-label="Cara Pengambilan"><?= htmlspecialchars($row['cara_pengambilan']) ?></td>
            <td data-label="Catatan"><?= nl2br(htmlspecialchars($row['catatan'])) ?></td>
            <td data-label="Status">
                <form method="post" action="proses_status_menu.php" style="margin:0;">
                    <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($row['id_pesanan']) ?>">
                    <input type="hidden" name="kantin_id" value="<?= htmlspecialchars($kantin_id) ?>">
                    <select name="status" onchange="this.form.submit()" aria-label="Ubah status pesanan">
                        <option value="Belum Diambil" <?= $row['status'] === "Belum Diambil" ? "selected" : "" ?>>Belum Diambil 🕒</option>
                        <option value="Sudah Diambil" <?= $row['status'] === "Sudah Diambil" ? "selected" : "" ?>>Sudah Diambil ✅</option>
                        <option value="Tidak Diambil" <?= $row['status'] === "Tidak Diambil" ? "selected" : "" ?>>Tidak Diambil ❌</option>
                    </select>
                </form>
            </td>
        </tr>
        <?php
        $no++;
    }
    ?>
    </tbody>
</table>
    </div>
</div>

<div class="footer" role="contentinfo">
    Hak cipta &copy; 2025 Dibuat oleh Kelompok 6
</div>

</body>
</html>
