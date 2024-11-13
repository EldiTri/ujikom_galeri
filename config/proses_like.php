<?php
session_start();
include 'koneksi.php';

$fotoid = $_GET['fotoid']; // Ensure the key matches what you sent in the URL
$userid = $_SESSION['userid'];

$ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE id_like='$fotoid' AND id_user='$userid'");

if (mysqli_num_rows($ceksuka) ==1 ) {
   while($row = mysqli_fetch_array($ceksuka)){
    $likeid = $row['like_id'];
    $query = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE id_like='$likeid'");

    echo "<script>
    location.href='../admin/home1.php';
    </script>";
   }
}else{
    $tanggallike = date('Y-m-d'); // Correctly formatted date string
    $query = mysqli_query($koneksi, "INSERT INTO like_foto VALUES('', '$fotoid', '$userid', '$tanggallike')");
    
    if ($query) {
        echo "<script>
        location.href='../admin/home1.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
}

// Fix the date format by putting it in quotes
 // Handle query error
}
?>


 <?php
    // session_start();
    // include 'koneksi.php';
    
    // // require_once("koneksi.php");

    // $fotoid = $_GET['fotoid'];
    // $userid = $_SESSION['userid'];

    // $tanggalike = date('Y-m-d');
    // $query = mysqli_query($koneksi, 
    // "INSERT INTO like_foto VALUES('','$fotoid','$userid','$tanggalike')");

    // echo "<script>
    // location.href='../admin/home2.php';
    // </script>";

    // $ceksuka = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE id_foto='$fotoid' AND id_user='$userid'");

    // if(mysqli_num_rows($ceksuka) == 1) {
    //     while($row = mysqli_fetch_array($ceksuka)) {
    //         $likeid = $row['id_like'];
    //         $query = mysqli_query($koneksi, "DELETE FROM like_foto WHERE id_like='$likeid'");

    //         if ($query == 'admin') {
    //             echo "<script>
    //                 document.addEventListener('DOMContentLoaded', function() {
    //                     Swal.fire({
    //                         title: 'Berhasil!',
    //                         text: 'Like Berhasil Dihapus',
    //                         icon: 'success'
    //                     }).then(function() {
    //                         window.location.href = '../admin/index.php';
    //                     });
    //                 });
    //             </script>";
    //         } else {
    //             echo "<script>
    //                 document.addEventListener('DOMContentLoaded', function() {
    //                     Swal.fire({
    //                         title: 'Berhasil!',
    //                         text: 'Like Berhasil Dihapus',
    //                         icon: 'success'
    //                     }).then(function() {
    //                         window.location.href = '../user/index.php';
    //                     });
    //                 });
    //             </script>";
    //         }
    //     }
    // } else {
    //     $tanggalike = date('Y-m-d');
    //     $query = "INSERT INTO like_foto (id_foto, id_user, tanggal_like) VALUES ('$fotoid', '$userid', '$tanggalike')";
    //     $sql = mysqli_query($koneksi, $query);

    //     if ($role == 'admin') {
    //         echo "<script>
    //             document.addEventListener('DOMContentLoaded', function() {
    //                 Swal.fire({
    //                     title: 'Berhasil!',
    //                     text: 'Like Berhasil Ditambahkan',
    //                     icon: 'success'
    //                 }).then(function() {
    //                     window.location.href = '../admin/index.php';
    //                 });
    //             });
    //         </script>";
    //     } else {
    //         echo "<script>
    //             document.addEventListener('DOMContentLoaded', function() {
    //                 Swal.fire({
    //                     title: 'Berhasil!',
    //                     text: 'Like Berhasil Ditambahkan',
    //                     icon: 'success'
    //                 }).then(function() {
    //                     window.location.href = '../user/index.php';
    //                 });
    //             });
    //         </script>";
    //     }
    // }
?> 