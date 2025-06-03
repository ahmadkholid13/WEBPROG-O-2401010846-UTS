<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID peminjaman tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);

// Ambil data peminjaman untuk ditampilkan di konfirmasi
$sql = "SELECT p.id_peminjaman, m.nim, m.nama, b.judul, p.tanggal_pinjam, p.tanggal_kembali
        FROM Peminjaman p
        JOIN Mahasiswa m ON p.nim = m.nim
        JOIN Buku b ON p.id_buku = b.id_buku
        WHERE p.id_peminjaman = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Data tidak ditemukan.";
    exit;
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Hapus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Konfirmasi Hapus Data</h2>
<p>Apakah kamu yakin ingin menghapus data peminjaman berikut?</p>

<table border="1" cellpadding="8">
    <tr><th>NIM</th><td><?= $data['nim'] ?></td></tr>
    <tr><th>Nama Mahasiswa</th><td><?= $data['nama'] ?></td></tr>
    <tr><th>Judul Buku</th><td><?= $data['judul'] ?></td></tr>
    <tr><th>Tanggal Pinjam</th><td><?= $data['tanggal_pinjam'] ?></td></tr>
    <tr><th>Tanggal Kembali</th><td><?= $data['tanggal_kembali'] ?: '-' ?></td></tr>
</table>

<br>
<form method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    <button type="submit" name="hapus">Ya, Hapus</button>
    <a href="index.php">Batal</a>
</form>

</body>
</html>

<?php
// Eksekusi penghapusan jika tombol "hapus" ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    $id = intval($_POST['id']);
    $hapus = $conn->query("DELETE FROM Peminjaman WHERE id_peminjaman = $id");

    if ($hapus) {
        header("Location: index.php");
        exit;
    } else {
        echo "<p style='color:red;'>Gagal menghapus data: " . $conn->error . "</p>";
    }
}
?>
