<?php
include 'inc/config.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website Otomotif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">OtoDeal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center px-2">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="kirim.php">Kirim Kendaraan</a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="admin_logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container mt-5 pt-5">
        <h2 class="mb-4">Cari Kendaraan</h2>

        <!-- Form Pencarian -->
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Masukkan nama kendaraan..."
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <div class="row">
            <?php
            $keyword = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
            $sql = "SELECT * FROM kendaraan WHERE judul LIKE '%$keyword%' ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="Gambar Kendaraan"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                                <p class="card-text text-muted">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
                                <p class="card-text"><?= htmlspecialchars(substr($row['deskripsi'], 0, 80)) ?>...</p>
                                <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <p class="text-muted">Tidak ada kendaraan ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'inc/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>