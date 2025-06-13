<?php
require 'inc/config.php'; // Pastikan file koneksi database sudah ada
function registrasi($data)
{
global $conn;

$username = strtolower(stripslashes($data['username']));
$password = mysqli_real_escape_string($conn, $data['password']);
$password2 = mysqli_real_escape_string($conn, $data['password2']);

// cek username sudah ada atau belum
$result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
if (mysqli_fetch_assoc($result)) {
echo "<script>
    alert('Username sudah terdaftar!');
</script>";
return false;
}

// cek konfirmasi password
if ($password !== $password2) {
echo "<script>
    alert('Konfirmasi password tidak sesuai!');
</script>";
return false;
}

// enkripsi password
$password = password_hash($password, PASSWORD_DEFAULT);

// tambahkan user baru ke database
$query = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
if (mysqli_query($conn, $query)) {
return mysqli_affected_rows($conn);
} else {
echo "Query error: " . mysqli_error($conn);
return false;
}
}