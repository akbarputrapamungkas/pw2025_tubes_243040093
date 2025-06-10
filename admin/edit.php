<?php
include '../inc/config.php';
include '../inc/header.php';

$id = $_GET['id'];
$query = $conn->query("SELECT * FROM kendaraan WHERE id = $id");
$data = $query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    // Cek apakah ada file baru diupload
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = "../uploads/";
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $gambar_baru = time() . "_" . preg_replace('/\s+/', '_', $gambar);
            if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
                // Update dengan gambar baru
                $conn->query("UPDATE kendaraan SET judul='$judul', harga='$harga', deskripsi='$deskripsi', gambar='$gambar_baru' WHERE id=$id");
            }
        }
    } else {
        // Update tanpa mengganti gambar
        $conn->query("UPDATE kendaraan SET judul='$judul', harga='$harga', deskripsi='$deskripsi' WHERE id=$id");
    }

    echo "<script>alert('Data berhasil diperbarui!');window.location='dashboard.php';</script>";
}
?>

<div class="container mt-5">
    <h2>Edit Kendaraan</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required><?= $data['deskripsi'] ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ganti Gambar (opsional)</label><br>
            <img src="../uploads/<?= $data['gambar'] ?>" width="150" class="img-thumbnail mb-2"><br>
            <input type="file" name="gambar" class="form-control" accept=".jpg, .jpeg, .png">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../inc/footer.php'; ?>