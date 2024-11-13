<?php
    session_start();
    require_once("../config/koneksi.php");
    $userid = $_SESSION['userid'];
    $nama = $_SESSION['nama'];

    if($_SESSION['status'] != 'login') {
        echo "<script>
            alert('Anda belum login');
            location.href='../index.php';
        </script>";
    }
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
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top navbar-custom shadow">
    <div class="container">
        <a class="fs-1 text-primary" href="index.php" style="text-decoration: none">Galeri Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav mx-auto">
                <a href="galeri.php" class="nav-link active">Galeri</a>
                <a href="album.php" class="nav-link">Album</a>
                <a href="foto.php" class="nav-link">Foto</a>
            </div>
            <p class="m-1">Hello, <?php echo $nama ?></p>
            <a href="../config/aksi_logout.php" class="btn btn-primary m-1 rounded-pill">Keluar</a>
        </div>
    </div>
    </nav>

    <div class="container pt-3">
        Album :
        <a href="galeri.php" class="btn btn-outline-primary">Semua Foto</a>
        <?php
            $query = mysqli_query($koneksi, "SELECT * FROM album WHERE id_user='$userid'");
            while($row = mysqli_fetch_array($query)) { ?>
                <a href="galeri.php?albumid=<?php echo $row['id_album'] ?>" class="btn btn-outline-primary">
                    <?php echo $row['nama_album'] ?>
                </a>
            <?php } ?>

        <div class="row">
            <?php
            if(isset($_GET['albumid'])) {
                $albumid = $_GET['albumid'];
                $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE id_user='$userid' AND id_album='$albumid'");
                while($data = mysqli_fetch_array($query)) { ?>
                    <div class="col-md-3 mt-2">
                        <div class="card mb-2">
                            <img src="../assets/img/<?php echo $data['lokasi_file']?>" class="card-img-top" title="<?php echo $data['judul_foto']?>" style="height:12rem;">
                            <div class="card-footer text-center">
                                <a style="color: red"><i class="fa fa-heart"></i></a>
                                <?php
                                    $fotoid = $data['id_foto'];
                                    $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE id_foto='$fotoid'");
                                    echo mysqli_num_rows($like). ' Suka';
                                ?>
                                <a style="color: blue"><i class="fa fa-comment"></i></a>
                                <?php
                                    $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE id_foto='$fotoid'");
                                    echo mysqli_num_rows($jmlkomen). ' Komentar';
                                ?>
                            </div>
                        </div>
                    </div>
            <?php } }  else { 
                $query = mysqli_query($koneksi, "SELECT * FROM  foto WHERE id_user='$userid'");
                while($data = mysqli_fetch_array($query)) {
            ?>
            <div class="col-md-3 mt-2">
                <div class="card">
                    <img src="../assets/img/<?php echo $data['lokasi_file']?>" class="card-img-top" title="<?php echo $data['judul_foto']?>" style="height:12rem;">
                    <div class="card-footer text-center">
                        <a style="color: red"><i class="fa fa-heart"></i></a>
                        <?php 
                            $fotoid = $data['id_foto'];
                            $like = mysqli_query($koneksi, "SELECT * FROM like_foto WHERE id_foto='$fotoid'");
                            echo mysqli_num_rows($like). ' Suka';
                        ?>
                        <a style="color: blue"><i class="fa fa-comment"></i></a>
                        <?php
                            $jmlkomen = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE id_foto='$fotoid'");
                            echo mysqli_num_rows($jmlkomen). ' Komentar';
                         ?>
                    </div>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check if dark mode is already enabled
        if (localStorage.getItem('dark-mode') === 'enabled') {
            document.body.classList.add('bg-dark', 'text-light');
            document.getElementById('navbar').classList.add('bg-dark', 'navbar-dark', 'text-light');
            document.getElementById('mode-icon').classList.remove('fa-moon-o');
            document.getElementById('mode-icon').classList.add('fa-sun-o');
        }

        document.getElementById('toggle-dark-mode').addEventListener('click', function() {
            const body = document.getElementById('body');
            const navbar = document.getElementById('navbar');
            const modeIcon = document.getElementById('mode-icon');

            // Toggle dark mode classes
            body.classList.toggle('bg-dark');
            body.classList.toggle('text-light');
            navbar.classList.toggle('bg-dark');
            navbar.classList.toggle('navbar-dark');
            navbar.classList.toggle('text-light');
            navbar.classList.toggle('bg-light');
            navbar.classList.toggle('navbar-light');

            // Check if dark mode is enabled and update icon and localStorage
            if (body.classList.contains('bg-dark')) {
                modeIcon.classList.remove('fa-moon-o');
                modeIcon.classList.add('fa-sun-o');
                localStorage.setItem('dark-mode', 'enabled'); // Set dark mode
            } else {
                modeIcon.classList.remove('fa-sun-o');
                modeIcon.classList.add('fa-moon-o');
                localStorage.setItem('dark-mode', 'disabled'); // Remove dark mode
            }
        });
    </script>
</body>
</html>