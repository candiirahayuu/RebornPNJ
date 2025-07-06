<!-- ===================== BAGIAN UNTUK ADMIN ===================== -->
<?php
include 'koneksi.php';

// Cek apakah parameter 'kantin' ada di URL, jika tidak ada tampilkan pesan dan hentikan eksekusi
if (!isset($_GET['kantin'])) {
    echo "Kantin tidak ditemukan.";
    exit;
}
// Validasi dan ambil ID kantin dari parameter GET
$kantin_id = intval($_GET['kantin']);
// Query ke database untuk mengambil data kantin berdasarkan kantin_id yang diterima
$kantin_query = mysqli_query($koneksi, "SELECT * FROM kantin WHERE kantin_id = $kantin_id");
if (!$kantin_query || mysqli_num_rows($kantin_query) == 0) {
    echo "Kantin tidak ditemukan.";
    exit;
}

$kantin = mysqli_fetch_assoc($kantin_query);
// Query untuk mengambil semua menu yang terkait dengan kantin_id tersebut

$menu = mysqli_query($koneksi, "SELECT * FROM menu WHERE kantin_id = $kantin_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Kelola Menu - <?= htmlspecialchars($kantin['nama_kantin']) ?></title>
<style>
/* Reset and base */
* {
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    background-color: #f5f6fa;
    color: #333;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.sidebar {
    position: fixed;
    width: 220px;
    height: 100vh;
    background-color: #2c2c2c;
    color: white;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 8px rgba(0,0,0,0.15);
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

.sidebar a:hover,
.sidebar .active {
    background-color:hsl(54, 100.00%, 50.00%);
    color: #222222;
    font-weight: 700;
    border-left-color: #555555;
}

.main {
    margin-left: 220px;
    padding: 35px 40px 120px 40px; /* Add bottom padding for spacing from footer */
    background-color: #fff;
    flex-grow: 1;
    transition: margin-left 0.3s ease;
    box-sizing: border-box;
}

.info-kantin {
    display: flex;
    gap: 25px;
    align-items: center;
    margin-bottom: 40px;
    background-color: #f9f9f9;
    padding: 28px 35px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.07);
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

td {
    padding: 15px 20px;
    border: none;
    vertical-align: middle;
    color: #444;
    position: relative;
}

tbody tr td:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

tbody tr td:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

.status-tersedia {
    background-color: #28a745;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    text-align: center;
    width: 100px;
}

.status-habis {
    background-color: #6c757d;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    text-align: center;
    width: 100px;
}

.btn {
    padding: 8px 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    margin-right: 5px;
    transition: background 0.3s;
}

.edit-btn {
    background-color: #adb5bd;
    color: white;
}

.nonaktif-btn {
    background-color: #dc3545;
    color: white;
}

.aktif-btn {
    background-color: #007bff;
    color: white;
}

.tambah-btn {
    margin-top: 20px;
    background-color: #dc3545;
    color: white;
    border-radius: 10px;
    padding: 12px 20px;
    float: right;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s;
    /* Add margin-bottom for spacing from footer */
    margin-bottom: 40px;
}

.tambah-btn:hover {
    background-color: #c82333;
}

.footer {
    background-color: #dc3545;
    color: white;
    text-align: center;
    padding: 12px;
    font-size: 14px;
    clear: both;
    /* Fix footer to bottom */
    position: fixed;
    bottom: 0;
    width: calc(100% - 220px);
    margin-left: 220px;
    z-index: 100;
}

.menu-img {
    width: 100px;
    height: 120px;
    border-radius: 8px;
    object-fit: cover;
    margin-right: 12px;
    vertical-align: middle;
}

@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    .main {
        margin-left: 0;
        padding: 20px;
    }

    .footer {
        width: 100%;
        margin-left: 0;
        position: static;
    }

    table, .info-kantin {
        font-size: 14px;
    }

    .menu-img {
        width: 60px;
        height: 80px;
    }

    .tambah-btn {
        float: none;
        display: inline-block;
        margin-bottom: 30px;
    }
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>Kantin<span style="color:white;">Reborn</span></h2>
    <!-- Link ke halaman daftar pesanan dengan parameter kantin_id -->
    <a href="admin.php?kantin=<?= $kantin_id ?>">Daftar Pesanan</a>
    <!-- Link aktif saat ini untuk kelola menu -->
    <a href="#" class="active">Kelola Menu</a>
</div>

<div class="main">
    <div class="info-kantin">
        <!-- Gambar kantin-->
        <img src="img/<?= htmlspecialchars($kantin['gambar']) ?>" alt="<?= htmlspecialchars($kantin['nama_kantin']) ?>">
        <div>
            <!-- Nama kantin -->
            <h2><?= htmlspecialchars($kantin['nama_kantin']) ?></h2>
            <!-- Jam buka dan tutup kantin -->
            <small><?= htmlspecialchars($kantin['jam_buka']) ?> - <?= htmlspecialchars($kantin['jam_tutup']) ?> WIB</small><br>
            <!-- Estimasi waktu pelayanan -->
            <small><?= htmlspecialchars($kantin['estimasi_waktu']) ?> menit</small><br>
            <!-- Keterangan metode pembayaran -->
            <small>Bayar langsung saat ambil (COD)</small>
        </div>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <!-- Looping setiap data menu yang diambil dari database -->
            <?php while ($row = mysqli_fetch_assoc($menu)): ?>
            <tr>
                <!-- Tampilkan foto menu dan nama menu -->
                <td><img src="img/<?= htmlspecialchars($row['foto']) ?>" class="menu-img" alt="<?= htmlspecialchars($row['nama_menu']) ?>"> <?= htmlspecialchars($row['nama_menu']) ?></td>
                <!-- Format harga menu dalam Rupiah -->
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>
                    <!-- Tampilkan status ketersediaan menu -->
                    <?php if ($row['status_tersedia'] == 'T'): ?>
                        <div class="status-tersedia">Tersedia</div>
                    <?php else: ?>
                        <div class="status-habis">Habis</div>
                    <?php endif; ?>
                </td>
                <td>
                    <!-- Tombol untuk mengedit menu -->
                    <a href="proses_edit.php?id=<?= htmlspecialchars($row['id_menu']) ?>" class="btn edit-btn">Edit</a>
                    
                    <!-- Tombol untuk toggle status menu (aktif/nonaktif) -->
                    <?php if ($row['status_tersedia'] === 'T'): ?>
                        <button class="btn nonaktif-btn toggle-status-btn" 
                            data-id="<?= htmlspecialchars($row['id_menu']) ?>" 
                            data-aksi="nonaktifkan">Nonaktifkan</button>
                    <?php else: ?>
                        <button class="btn aktif-btn toggle-status-btn" 
                            data-id="<?= htmlspecialchars($row['id_menu']) ?>" 
                            data-aksi="aktifkan">Aktifkan</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    
    <!-- Tombol untuk membuka modal tambah menu baru -->
    <button class="tambah-btn" onclick="openTambahModal()">Tambah Menu</button>

    <!-- Modal Tambah Menu -->
    <div id="tambahModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center;">
        <div style="background:#fff; width:500px; max-width:95%; margin:80px auto; padding:30px; border-radius:10px; position:relative;">
            <h2>Tambah Menu</h2>
            <!-- Form tambah menu  -->
            <form id="tambahForm" enctype="multipart/form-data">
                <!-- Input hidden untuk mengirimkan id kantin ke server -->
                <input type="hidden" name="kantin_id" value="<?= $kantin_id ?>">
                
                <!-- Label dan input teks untuk nama menu -->
                <label>Nama Menu</label><br>
                <input type="text" name="nama_menu" style="width:100%; padding:8px;" required><br><br>
                
                <!-- Label dan input angka untuk harga menu -->
                <label>Harga</label><br>
                <input type="number" name="harga" style="width:100%; padding:8px;" required><br><br>
                
                <!-- Label dan input file untuk upload foto menu -->
                <label>Foto</label><br>
                <input type="file" name="foto" accept="image/*" required><br><br>
                
                <!-- Tombol batal yang memanggil fungsi javascript untuk menutup modal -->
                <button type="button" onclick="closeTambahModal()" style="background:gray;color:white;padding:8px 12px;border:none;">Batal</button>
                
                <!-- Tombol submit form untuk menyimpan data menu baru -->
                <button type="submit" style="background:red;color:white;padding:8px 12px;border:none;">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal Edit Menu -->
    <div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center;">
        <div style="background:#fff; width:500px; max-width:95%; margin:80px auto; padding:30px; border-radius:10px; position:relative;">
            <h2>Edit Menu</h2>
            <!-- Form edit menu, akan dikirim ke proses_edit.php via POST -->
            <form id="editForm" enctype="multipart/form-data">
                <!-- Menyimpan id menu yang diedit -->
                <input type="hidden" name="id_menu" id="edit-id">

                <!-- Input nama menu -->
                <label>Nama</label><br>
                <input type="text" name="nama_menu" id="edit-nama" style="width:100%; padding:8px;"><br><br>

                <!-- Input harga menu -->
                <label>Harga</label><br>
                <input type="text" name="harga" id="edit-harga" style="width:100%; padding:8px;"><br><br>

                <!-- untuk menampilkan gambar saat ini dari menu yang akan diedit -->
                <label>Gambar saat ini:</label><br>
                <!-- Preview gambar saat ini -->
                <img id="edit-preview" src="img/default.jpg" alt="Gambar Menu" width="100"><br><br>

                <!-- Label untuk input file gambar baru untuk mengganti gambar menu -->
                <label>Ganti Gambar:</label><br>
                <input type="file" name="foto" id="edit-gambar"><br><br>

                <!-- Tombol batal menutup modal edit -->
                <button type="button" onclick="closeEditModal()" style="background:gray;color:white;padding:8px 12px;border:none;">Batal</button>
                <!-- Tombol submit untuk mengirim data ke server -->
                <button type="submit" style="background:red;color:white;padding:8px 12px;border:none;">Simpan</button>
            </form>
        </div>
    </div>

</div>

<div class="footer">
    Hak cipta &copy; 2025 Dibuat oleh Kelompok 6
</div>

<script>
    // Pasang event click pada semua tombol toggle-status-btn
    function bindToggleButtons() {
    document.querySelectorAll('.toggle-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Ambil id dan aksi dari atribut data
            const id = this.getAttribute('data-id');
            const aksi = this.getAttribute('data-aksi');
            const row = this.closest('tr');

            // Konfirmasi aksi user
            if (!confirm(`Yakin ingin ${aksi} menu ini?`)) return;

            // Kirim request ke proses_status.php untuk update status
            fetch(`proses_status.php?id=${id}&aksi=${aksi}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update tampilan status dan tombol aksi di tabel
                        const statusCell = row.querySelector('td:nth-child(3)');
                        const aksiCell = row.querySelector('td:nth-child(4)');

                        if (data.status === 'Tersedia') {
                            statusCell.innerHTML = '<div class="status-tersedia">Tersedia</div>';
                            aksiCell.innerHTML = `
                                <a href="proses_edit.php?id=${id}" class="btn edit-btn">Edit</a>
                                <button class="btn nonaktif-btn toggle-status-btn" data-id="${id}" data-aksi="nonaktifkan">Nonaktifkan</button>
                            `;
                        } else {
                            statusCell.innerHTML = '<div class="status-habis">Habis</div>';
                            aksiCell.innerHTML = `
                                <a href="proses_edit.php?id=${id}" class="btn edit-btn">Edit</a>
                                <button class="btn aktif-btn toggle-status-btn" data-id="${id}" data-aksi="aktifkan">Aktifkan</button>
                            `;
                        }

                        // re-bind buttons after update
                        bindToggleButtons();
                        bindEditButtons();
                    } else {
                        alert('Gagal: ' + data.message);
                    }
                })
                .catch(err => {
                    alert('Terjadi kesalahan jaringan.');
                    console.error(err);
                });
        });
    });
}

function bindEditButtons() {
    // Pasang event click pada tombol edit-btn untuk buka modal edit
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const id = url.searchParams.get("id");
            openEditModal(id);
        });
    });
}

// Jalankan saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    bindToggleButtons();
    bindEditButtons();
});

// Tutup modal edit
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Buka modal edit dan isi form dengan data menu yang diambil via fetch
function openEditModal(id) {
    fetch(`get_menu.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert('Gagal mendapatkan data menu.');
            return;
        }

        // Isi form edit dengan data yang didapat
        document.getElementById('edit-id').value = data.id_menu;
        document.getElementById('edit-nama').value = data.nama_menu;
        document.getElementById('edit-harga').value = data.harga;
        if (data.foto) {
            document.getElementById('edit-preview').src = `img/${data.foto}`;
            document.getElementById('edit-preview').style.display = 'block';
        } else {
            document.getElementById('edit-preview').style.display = 'none';
        }
        // Tampilkan modal edit
        document.getElementById('editModal').style.display = 'flex';
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan jaringan.');
    });
}

// Event submit form edit, kirim data via fetch POST
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('proses_edit.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Menu berhasil diubah!');
            location.reload();
        } else {
            alert('Gagal menyimpan perubahan.');
        }
    })
    .catch(err => {
        alert('Terjadi kesalahan.');
        console.error(err);
    });
});

// Fungsi buka modal tambah menu
function openTambahModal() {
    document.getElementById('tambahModal').style.display = 'flex';
}

// Fungsi tutup modal tambah menu
function closeTambahModal() {
    document.getElementById('tambahModal').style.display = 'none';
}

// Event submit form tambah, kirim data via fetch POST
document.getElementById('tambahForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('proses_tambah_menu.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Menu berhasil ditambahkan!');
            location.reload();
        } else {
            alert('Gagal menambahkan menu: ' + data.message);
        }
    })
    .catch(err => {
        alert('Terjadi kesalahan.');
        console.error(err);
    });
});
</script>
</body>
</html>