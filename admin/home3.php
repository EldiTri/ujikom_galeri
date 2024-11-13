<?php
session_start();
include'../config/koneksi.php';
$userid = $_SESSION['userid'];
if ($_SESSION['status'] != 'login') {
    echo "<script>
    alert('Anda Belum Login!');
    location.href='../index.php';
    </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
      <a href="home3.php" class="nav-link">Home</a>
        <a href="album.php" class="nav-link">Album</a>
        <a href="foto.php" class="nav-link">Foto</a>

        

      </div>
      

      <a href="../config/aksi_logout.php" class="btn btn-outline-danger-1">KELUAR</a>
    </div>
  </div>
</nav>  
    <div class="container mt-3">
        Album : 
        <?php
        $album = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
        while($row = mysqli_fetch_array($album)){ ?>
        <a href="home.php?albumid=<?php echo $row['albumid'] ?>" class="btn btn-outline-primary"><?php echo $row['namaalbum'] ?></a>
        <?php } ?>
        <div class="row">
            <?php
            if(isset($_GET['albumid'])) {
                $albumid = $_GET['albumid'];
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid' AND albumid='$albumid'");
                while($data = mysqli_fetch_array($query)){ ?>
            <div class="col-md-3 mt-3">
                    <div class="card">
                        <img  style="height:12rem"; src="../assets/img/ <?php echo $data['lokasi_foto']?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
                        <div class="card-footer text-center">
                           
                            <?php
                            $fotoid = $data['fotoid'];
                            $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$id_foto' AND userid='$userid'");
                            if (mysqli_num_rows($ceksuka) == 1) { ?>
                             <a href="../config/proses_like.php?fotoid=<?php echo $data['id_foto']?>" type="submit" name="suka"><i class="fa fa-heart"></i></a>
                            <?php }else{ ?>
                            <a href="../config/proses_like.php?fotoid=<?php echo $data['id_foto']?>" type="submit" name="suka"><i class="fa-regular fa-heart"></i></a>
                            <?php } 
                            $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE id_foto='$id_foto'");
                            echo mysqli_num_rows($like). ' Suka';
                            ?>
                            <a href=""><i class="fa-regular fa-comment"></i></a>3 komentar
                        </div>
                    </div>
                </div>
                
            <?php }}else {

        
            $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE userid='$userid'");
            while ($data = mysqli_fetch_array($query)) {
                ?>
                <div class="col-md-3 mt-3">
                    <div class="card">
                        <img  style="height:12rem"; src="../assets/img/ <?php echo $data['lokasifile']?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>">
                        <div class="card-footer text-center">
                           
                            <?php
                            $fotoid = $data['fotoid'];
                            $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$id_foto' AND userid='$userid'");
                            if (mysqli_num_rows($ceksuka) == 1) { ?>
                             <a href="../config/proses_like.php?fotoid=<?php echo $data['id_foto']?>" type="submit" name="suka"><i class="fa fa-heart"></i></a>
                            <?php }else{ ?>
                            <a href="../config/proses_like.php?fotoid=<?php echo $data['id_foto']?>" type="submit" name="suka"><i class="fa-regular fa-heart"></i></a>
                            <?php } 
                            $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$id_foto'");
                            echo mysqli_num_rows($like). ' Suka';
                            ?>
                            <a href=""><i class="fa-regular fa-comment"></i></a>3 komentar
                        </div>
                    </div>
                </div>
            <?php } } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>