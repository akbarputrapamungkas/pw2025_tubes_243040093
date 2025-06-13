<?php
session_start();
require 'inc/config.php';

// Cek jika sudah login
if (isset($_SESSION['login'])) {
    if ($_SESSION['username'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];

            if ($row['username'] === 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login dan Cari Kendaraan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #f8f9fa;
        }

        .card-login {
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-vehicle {
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card-vehicle:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .section-title {
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>

    <!-- LOGIN SECTION -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-login">
                    <div class="card-header bg-primary text-white text-center fs-5">Login</div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center">Username atau Password salah!</div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3 text-end">
                                <a href="registrasi.php" class="text-decoration-none">Belum punya akun?</a>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VEHICLE SEARCH SECTION -->
    <div class="container mt-5 py-4">
        <h3 class="section-title">Cari Kendaraan</h3>

        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Masukkan nama kendaraan..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button class="btn btn-outline-primary" type="submit">Cari</button>
            </div>
        </form>

        <div class="row">
            <?php
            $keyword = isset($_GET['search']) ? $_GET['search'] : '';
            $sql = "SELECT * FROM kendaraan WHERE judul LIKE '%$keyword%' ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card card-vehicle h-100">
                            <img src="uploads/<?= $row['gambar'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= $row['judul'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                                <p class="text-muted mb-1">Rp<?= number_format($row['harga'], 0, ',', '.') ?></p>
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

</body>

</html>