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

<!-- STYLE TAMBAHAN -->
<style>
    .edit-card {
        border-radius: 12px;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
        padding: 30px;
        background-color: #ffffff;
    }

    .form-title {
        border-left: 5px solid #0d6efd;
        padding-left: 12px;
        font-weight: 600;
        font-size: 24px;
        margin-bottom: 30px;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="edit-card">
                <div class="form-title">Edit Data Kendaraan</div>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul Kendaraan</label>
                        <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Gambar Saat Ini</label><br>
                            <img src="../uploads/<?= $data['gambar'] ?>" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ganti Gambar (Opsional)</label>
                            <input type="file" name="gambar" class="form-control" accept=".jpg, .jpeg, .png">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>