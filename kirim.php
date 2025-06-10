<?php
include 'inc/config.php';
include 'inc/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    $folder = "uploads/";
    $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    if (in_array($ext, $allowed)) {
        $newName = time() . "_" . preg_replace('/\s+/', '_', $gambar);
        move_uploaded_file($tmp, $folder . $newName);

        // Simpan ke database
        $conn->query("INSERT INTO kendaraan (judul, harga, deskripsi, gambar) VALUES ('$judul', '$harga', '$deskripsi', '$newName')");

        echo "<script>alert('Iklan berhasil dikirim!');window.location='index.php';</script>";
    } else {
        echo "<div class='alert alert-danger text-center'>Format gambar tidak valid! Harus JPG / PNG.</div>";
    }
}
?>

<div class="container mt-5">
    <h2>Kirim Iklan Kendaraan</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Judul Kendaraan</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Gambar</label>
            <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png" required>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Iklan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include 'inc/footer.php'; ?>