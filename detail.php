<?php include 'inc/config.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Kendaraan | OtoDeal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        body {
            padding-top: 80px;
            background-color: #f9f9f9;
        }

        .detail-card {
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-img-left {
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .btn-back {
            transition: 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0d6efd;
            color: #fff;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">OtoDeal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center px-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kirim.php">Kirim Kendaraan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="detail.php">Detail</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="admin_login.php">Login Admin</a></li>
                            <li><a class="dropdown-item" href="admin/dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="admin/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mb-5">
        <?php
        $id = $_GET['id'];
        $query = $conn->query("SELECT * FROM kendaraan WHERE id = $id");
        $data = $query->fetch_assoc();
        ?>

        <a href="index.php" class="btn btn-outline-secondary mb-4 btn-back">← Kembali</a>

        <div class="card detail-card">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="uploads/<?= htmlspecialchars($data['gambar']) ?>" class="img-fluid card-img-left" alt="Foto Kendaraan">
                </div>
                <div class="col-md-6 p-4">
                    <div class="card-body">
                        <h3 class="card-title fw-bold"><?= htmlspecialchars($data['judul']) ?></h3>
                        <h4 class="text-danger mt-2 mb-4">Rp<?= number_format($data['harga'], 0, ',', '.') ?></h4>
                        <p class="card-text"><?= nl2br(htmlspecialchars($data['deskripsi'])) ?></p>
                        <hr>
                        <p class="card-text"><small class="text-muted">
                                Diperbarui pada <?= date('d M Y', strtotime($data['tgl_isi'] ?? date('Y-m-d'))) ?>
                            </small></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        &copy; <?= date("Y") ?> Otomotif - All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>