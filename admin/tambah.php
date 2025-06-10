<?php include 'inc/header.php'; ?>
<?php include 'inc/config.php'; ?>

<div class="container mt-5">
    <h2>Tambah Iklan Kendaraan</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $judul = $_POST['judul'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];

        // Upload gambar
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = "uploads/";

        // Validasi tipe file gambar
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            // Ubah nama file agar aman & unik
            $gambar_baru = time() . "_" . preg_replace('/\s+/', '_', $gambar);

            // Pindahkan file ke folder uploads
            if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
                $sql = "INSERT INTO kendaraan (judul, harga, deskripsi, gambar)
                      VALUES ('$judul', '$harga', '$deskripsi', '$gambar_baru')";
                if ($conn->query($sql) === TRUE) {
                    echo '<div class="alert alert-success">Iklan berhasil ditambahkan!</div>';
                } else {
                    echo '<div class="alert alert-danger">Gagal menyimpan data ke database.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Upload gambar gagal.</div>';
            }
        } else {
            echo '<div class="alert alert-warning">Format gambar tidak valid. Hanya JPG, JPEG, PNG diperbolehkan.</div>';
        }
    }
    ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Judul Kendaraan</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Gambar</label>
            <input type="file" name="gambar" class="form-control" accept=".jpg, .jpeg, .png" required>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Iklan</button>
    </form>
</div>

<?php include 'inc/footer.php'; ?>