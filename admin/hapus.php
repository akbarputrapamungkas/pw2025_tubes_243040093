<?php
include '../inc/config.php';

$id = $_GET['id'];

// Ambil nama file gambar untuk dihapus dari folder
$get = $conn->query("SELECT gambar FROM kendaraan WHERE id=$id");
$row = $get->fetch_assoc();
$gambar = $row['gambar'];

// Hapus file gambar dari folder
if (file_exists("../uploads/$gambar")) {
    unlink("../uploads/$gambar");
}

// Hapus data dari database
$conn->query("DELETE FROM kendaraan WHERE id=$id");

echo "<script>alert('Data berhasil dihapus!');window.location='dashboard.php';</script>";
