<?php
require '../inc/config.php';
$result = mysqli_query($conn, "SELECT * FROM kendaraan ORDER BY id DESC");
include '../inc/header.php';
?>
<div class="container">
    <h2>Data Kendaraan</h2>
    <a href="tambah.php" class="btn btn-primary mb-3">Tambah Kendaraan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Merk</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['merk']; ?></td>
                    <td><?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><img src="../uploads/<?= $row['gambar']; ?>" width="80"></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin?');" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../inc/footer.php'; ?>