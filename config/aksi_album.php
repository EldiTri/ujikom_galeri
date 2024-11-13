<?php
session_start();
require_once("koneksi.php");

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Anda belum login!'); location.href='../index.php';</script>";
    exit;
}

if (isset($_POST['tambah'])) {
    $namaalbum = $_POST['nama_album'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal_dibuat'];
    $userid = $_SESSION['userid'];

    $query = "INSERT INTO album (nama_album, deskripsi, tanggal_dibuat, id_user) 
              VALUES ('$namaalbum', '$deskripsi', '$tanggal', '$userid')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil disimpan'); location.href='../admin/album.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); location.href='../admin/album.php';</script>";
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['albumid'];
    $nama_album = $_POST['namaalbum'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal_dibuat'];

    $query = "UPDATE album SET nama_album='$nama_album', deskripsi='$deskripsi', tanggal_dibuat='$tanggal' WHERE id_album='$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil diperbarui'); location.href='../admin/album.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); location.href='../admin/album.php';</script>";
    }
}

if (isset($_POST['hapus'])) {
    $albumid = $_POST['albumid'];

    $query = "DELETE FROM album WHERE id_album='$albumid'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil dihapus'); location.href='../admin/album.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); location.href='../admin/album.php';</script>";
    }
}
?>
