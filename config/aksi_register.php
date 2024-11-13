<?php
session_start();
include 'koneksi.php'; // Ensure this includes your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user data into the database
    $sql = "INSERT INTO user (username, password, email, nama_lengkap, alamat) VALUES ('$username', '$hashedPassword', '$email', '$nama_lengkap', '$alamat')";
    
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Registrasi berhasil!'); location.href='../login.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); location.href='../register.php';</script>";
    }
} else {
    echo "<script>alert('Akses tidak valid!'); location.href='../register.php';</script>";
}
?>
