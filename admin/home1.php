<?php
session_start();
require_once("../config/koneksi.php");

$userid = $_SESSION['userid'];
$nama = $_SESSION['nama'];

// Cek apakah pengguna sudah login
if ($_SESSION['status'] != 'login') {
    echo "<script>
        alert('Anda belum login');
        location.href='../index.php';
    </script>";
}

// Menampilkan foto dari album atau semua foto
$albumid = isset($_GET['albumid']) ? $_GET['albumid'] : null;
$queryFoto = "SELECT * FROM foto WHERE id_user='$userid'";
if ($albumid) {
    $queryFoto .= " AND id_album='$albumid'";
}
$fotoQuery = mysqli_query($koneksi, $queryFoto);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <style>
        /* Mengubah background halaman menjadi biru cerah */
        body {
            background-color: #add8e6; /* Warna biru cerah */
        }

        /* Navbar styles */
        .navbar {
            background-color: #0056b3; /* Biru gelap untuk navbar */
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-nav .nav-link.active {
            background-color: #003b73 !important; /* Menyoroti link aktif dengan warna biru lebih gelap */
        }

        .navbar-toggler-icon {
            background-color: white; /* Ubah warna icon navbar menjadi putih */
        }

        footer {
            background-color: #f1f1f1;
        }

        .card-header, .modal-header {
            background-color: #0056b3; /* Warna biru pada header */
            color: white;
        }

        .btn-outline-primary {
            border-color: #0056b3;
            color: #0056b3;
        }

        .btn-outline-primary:hover {
            background-color: #0056b3;
            color: white;
        }

        .modal_xl {
            max-width: 90%;
        }

        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 10;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top shadow">
        <div class="container">
            <a href="index.php" class="navbar-brand">Galeri Foto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav mx-auto">
                    <a href="home1.php" class="nav-link active">Galeri</a>
                    <a href="album.php" class="nav-link">Album</a>
                    <a href="foto.php" class="nav-link">Foto</a>
                </div>
                <p class="m-1 text-white">HELLO <?php echo $nama ?></p>
                <a href="../config/aksi_logout.php" class="btn btn-primary m-1 rounded-pill">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Display Album Links -->
        <div>Album :</div>
        <a href="home1.php" class="btn btn-outline-primary">Semua Foto</a>
        <?php
            $queryAlbum = mysqli_query($koneksi, "SELECT * FROM album WHERE id_user='$userid'");
            while ($row = mysqli_fetch_array($queryAlbum)) {
        ?>
            <a href="home1.php?albumid=<?php echo $row['id_album'] ?>" class="btn btn-outline-primary">
                <?php echo $row['nama_album'] ?>
            </a>
        <?php } ?>

        <div class="row">
            <?php
            while ($data = mysqli_fetch_array($fotoQuery)) {
                $fotoid = $data['id_foto'];
                $cekLike = mysqli_query($koneksi, "SELECT * FROM foto WHERE id_foto='$fotoid'");
                $isLiked = mysqli_num_rows($cekLike) > 0;
            ?>
                <div class="col-md-3 mt-2">
                    
                     
                     
                    <div class="card mb-2">
                            <img src="../assets/img/<?php echo $data['lokasi_file']?>"
                             class="card-img-top" title="<?php echo $data['judul_foto']?>" style="height:12rem;">
                            <div class="card-footer text-center">
                            
                            <a href="../config/proses_like.php?fotoid=<?php echo $data['id_foto']?>"
                             type="submit" name="suka" style="color: red"><i class="fa fa-heart"></i></a> 
                            <?php 
                            $fotoid = $data['id_foto'];
                            $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE id_foto='$fotoid'");
                            echo mysqli_num_rows($like). ' Suka';
                            ?>
                            <!-- Comment Button -->
                            <a href="../config/proses_komentar.php?id_user=<?php echo $data['id_foto']?>"style="color: blue" type="button" data-bs-toggle="modal"
                            >
                            <i class="fa fa-comment"></i></a>
                            <?php
                                $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE id_foto='$fotoid'");
                                echo mysqli_num_rows($jmlkomen) . ' Komentar';
                            ?>
                            <!-- Comment Section -->
                            
                        </div>
            </a>
                    </div>
                    
                    <div class="modal fade" id="#komentar<?php echo $data['fotoid']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal_xl">
                        <div class="modal-content">
                          <div class="modal-body">
                           <div class="col-md-8">
                           <img src="../assets/img/<?php echo $data['lokasi_file']?>"
                           class="card-img-top" title="<?php echo $data['judul_foto']?>" >
                           </div>
                           <div class="col-md-4">
                          <div class="m-2">
                            <div class="overflow-auto">
                                <div class="sticky-top">  
                                 <strong><?php echo $data['judul_foto'] ?> </strong>
                                 <span class="badge bg-secondary"><?php echo $data['namalengkap'] ?></span>
                                 <span class="badge bg-secondary"><?php echo $data['tanggal_unggah'] ?></span>
                                 <span class="badge bg-secondary"><?php echo $data['nama_album'] ?></span>
                                </div>
                                <hr>
                                <p align="left"><?php echo $data['deskripsi_foto'] ?>
                            </p>
                            
                            <div class="sticky-bottom">
                                
                            </div>
                            </div>
                          </div>
                           </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
