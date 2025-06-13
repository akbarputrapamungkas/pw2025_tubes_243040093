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
        if (move_uploaded_file($tmp, $folder . $newName)) {
            $conn->query("INSERT INTO kendaraan (judul, harga, deskripsi, gambar) VALUES ('$judul', '$harga', '$deskripsi', '$newName')");
            echo "<div class='alert alert-success text-center mt-4'>✅ Iklan berhasil dikirim! Anda akan diarahkan...</div>";
            echo "<script>setTimeout(() => window.location='index.php', 2000);</script>";
        } else {
            echo "<div class='alert alert-danger text-center mt-4'>❌ Gagal mengunggah gambar!</div>";
        }
    } else {
        echo "<div class='alert alert-warning text-center mt-4'>⚠️ Format gambar tidak valid! Harus JPG / JPEG / PNG.</div>";
    }
}
?>

<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Kirim Iklan Kendaraan</h4>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul Kendaraan</label>
                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Honda Brio RS 2022" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" placeholder="Contoh: 165000000" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tuliskan detail kendaraan, kondisi, kilometer, dll." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png" required>
                    <small class="text-muted">Hanya file JPG, JPEG, atau PNG. Ukuran disarankan maksimal 2MB.</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-success">📤 Kirim Iklan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>