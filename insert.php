<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $sql = "INSERT INTO Peminjaman (nim, id_buku, tanggal_pinjam, tanggal_kembali)
            VALUES ('$nim', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali')";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan: " . $conn->error;
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2>Tambah Data Peminjaman</h2>
<form method="POST">
    <label>NIM:</label><br>
    <select name="nim">
        <?php
        $mhs = $conn->query("SELECT nim, nama FROM Mahasiswa");
        while ($row = $mhs->fetch_assoc()) {
            echo "<option value='{$row['nim']}'>{$row['nim']} - {$row['nama']}</option>";
        }
        ?>
    </select><br><br>

    <label>Buku:</label><br>
    <select name="id_buku">
        <?php
        $buku = $conn->query("SELECT id_buku, judul FROM Buku");
        while ($row = $buku->fetch_assoc()) {
            echo "<option value='{$row['id_buku']}'>{$row['judul']}</option>";
        }
        ?>
    </select><br><br>

    <label>Tanggal Pinjam:</label><br>
    <input type="date" name="tanggal_pinjam"><br><br>

    <label>Tanggal Kembali:</label><br>
    <input type="date" name="tanggal_kembali"><br><br>

    <button type="submit">Simpan</button>
</form>
<br>
<a href="index.php">← Kembali</a>
