<?php include 'inc/config.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Website Otomotif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>

<body>
    <!-- inc/header.php -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">OtoDeal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center px-2">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kirim.php">Kirim Kendaraan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="detail.php">Detail</a>
                    </li>

                    <!-- Dropdown untuk admin -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="admin_login.php">Login</a></li>
                            <li><a class="dropdown-item" href="admin/dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="admin/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    include 'inc/config.php';


    $id = $_GET['id'];
    $query = $conn->query("SELECT * FROM kendaraan WHERE id = $id");
    $data = $query->fetch_assoc();
    ?>

    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">← Kembali</a>

        <div class="card">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="uploads/<?= $data['gambar'] ?>" class="img-fluid rounded-start" style="height: 100%; object-fit: cover;">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h3 class="card-title"><?= htmlspecialchars($data['judul']) ?></h3>
                        <h4 class="text-danger">Rp<?= number_format($data['harga'], 0, ',', '.') ?></h4>
                        <p class="card-text mt-3"><?= nl2br(htmlspecialchars($data['deskripsi'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'inc/footer.php'; ?>