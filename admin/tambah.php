<?php include '../inc/config.php'; ?>
<?php include '../inc/header.php'; ?>

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Kendaraan</li>
        </ol>
    </nav>

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Tambah Iklan Kendaraan</h4>
        </div>
        <div class="card-body">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $judul = $_POST['judul'];
                $harga = $_POST['harga'];
                $deskripsi = $_POST['deskripsi'];

                // Upload gambar
                $gambar = $_FILES['gambar']['name'];
                $tmp = $_FILES['gambar']['tmp_name'];
                $folder = "../uploads/";

                // Validasi tipe file gambar
                $allowed = ['jpg', 'jpeg', 'png'];
                $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed)) {
                    $gambar_baru = time() . "_" . preg_replace('/\s+/', '_', $gambar);

                    if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
                        $sql = "INSERT INTO kendaraan (judul, harga, deskripsi, gambar)
                                VALUES ('$judul', '$harga', '$deskripsi', '$gambar_baru')";
                        if ($conn->query($sql) === TRUE) {
                            echo '<div class="alert alert-success">✅ Iklan berhasil ditambahkan!</div>';
                        } else {
                            echo '<div class="alert alert-danger">❌ Gagal menyimpan data ke database.</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger">⚠️ Upload gambar gagal.</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning">⚠️ Format gambar tidak valid. Hanya JPG, JPEG, PNG diperbolehkan.</div>';
                }
            }
            ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul Kendaraan</label>
                    <input type="text" name="judul" class="form-control" placeholder="Contoh: Toyota Avanza 2020" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-control" placeholder="Contoh: 120000000" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Kendaraan</label>
                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Tulis deskripsi lengkap kendaraan..." required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept=".jpg, .jpeg, .png" required>
                    <small class="text-muted">Format gambar harus .jpg, .jpeg, atau .png</small>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">➕ Tambah Iklan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>