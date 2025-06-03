<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM Peminjaman WHERE id_peminjaman = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $sql = "UPDATE Peminjaman SET 
            nim='$nim', 
            id_buku='$id_buku', 
            tanggal_pinjam='$tanggal_pinjam', 
            tanggal_kembali='$tanggal_kembali' 
            WHERE id_peminjaman=$id";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Gagal mengubah data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Peminjaman</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Edit Data Peminjaman</h2>

<form method="POST">
    <label>NIM:</label><br>
    <select name="nim">
        <?php
        $mhs = $conn->query("SELECT nim, nama FROM Mahasiswa");
        while ($row = $mhs->fetch_assoc()) {
            $selected = ($row['nim'] == $data['nim']) ? 'selected' : '';
            echo "<option value='{$row['nim']}' $selected>{$row['nim']} - {$row['nama']}</option>";
        }
        ?>
    </select><br><br>

    <label>Buku:</label><br>
    <select name="id_buku">
        <?php
        $buku = $conn->query("SELECT id_buku, judul FROM Buku");
        while ($row = $buku->fetch_assoc()) {
            $selected = ($row['id_buku'] == $data['id_buku']) ? 'selected' : '';
            echo "<option value='{$row['id_buku']}' $selected>{$row['judul']}</option>";
        }
        ?>
    </select><br><br>

    <label>Tanggal Pinjam:</label><br>
    <input type="date" name="tanggal_pinjam" value="<?= $data['tanggal_pinjam'] ?>"><br><br>

    <label>Tanggal Kembali:</label><br>
    <input type="date" name="tanggal_kembali" value="<?= $data['tanggal_kembali'] ?>"><br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="index.php">← Kembali</a>
</body>
</html>
