<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Data Peminjaman Buku</h2>
<a href="insert.php">+ Tambah Peminjaman</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>NIM</th>
        <th>Nama Mahasiswa</th>
        <th>Judul Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $sql = "SELECT p.id_peminjaman, m.nim, m.nama, b.judul, p.tanggal_pinjam, p.tanggal_kembali
            FROM Peminjaman p
            JOIN Mahasiswa m ON p.nim = m.nim
            JOIN Buku b ON p.id_buku = b.id_buku
            ORDER BY p.id_peminjaman DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nim'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['tanggal_pinjam'] ?></td>
            <td><?= $row['tanggal_kembali'] ?: '-' ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_peminjaman'] ?>">Edit</a>
                <a href="hapus.php?id=<?= $row['id_peminjaman'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
    <?php
        endwhile;
    else:
    ?>
        <tr>
            <td colspan="7" style="text-align:center;">Tidak ada data peminjaman.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
