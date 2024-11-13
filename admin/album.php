<?php
session_start();
require_once("../config/koneksi.php");

if ($_SESSION['status'] != 'login') {
    echo "<script>alert('Anda belum login'); location.href='../index.php';</script>";
    exit;
}

$userid = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <style>
        /* Mengubah background halaman menjadi biru cerah */
        body {
            background-color: #add8e6; /* Warna biru cerah */
        }

        /* Navbar dengan teks putih */
        .navbar {
            background-color: #007bff; /* Biru yang lebih gelap untuk navbar */
        }

        .navbar a, .navbar .navbar-brand {
            color: white !important; /* Warna teks navbar menjadi putih */
        }

        footer {
            background-color: #f1f1f1;
        }

        .card-header, .modal-header {
            background-color: #007bff; /* Warna biru pada header */
            color: white; /* Warna teks header menjadi putih */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">Website Galeri</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
                    <a href="home1.php" class="nav-link">Home</a>
                    <a href="album.php" class="nav-link">Album</a>
                    <a href="foto.php" class="nav-link">Foto</a>
                </div>
                <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header">Tambah Album</div>
                    <div class="card-body">
                        <form action="../config/aksi_album.php" method="POST">
                            <label for="" class="form-label">Nama Album</label>
                            <input type="text" class="form-control" name="nama_album" required>
                            <label for="" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" required></textarea>
                            <label for="" class="form-label">Tanggal Dibuat</label>
                            <input type="date" class="form-control" name="tanggal_dibuat" required>
                            <button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">Data Album</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Album</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = $koneksi->query("SELECT * FROM album");
                                
                                while ($data = mysqli_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['nama_album'] ?></td>
                                    <td><?php echo $data['deskripsi'] ?></td>
                                    <td><?php echo $data['tanggal_dibuat'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['id_album']?>">Edit</button>
                                        <div class="modal fade" id="edit<?php echo $data['id_album']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../config/aksi_album.php" method="POST">
                                                            <input type="hidden" name="albumid" value="<?php echo $data['id_album']?>">
                                                            <label for="" class="form-label">Nama Album</label>
                                                            <input type="text" class="form-control" name="namaalbum" value="<?php echo $data['nama_album'] ?>" required>
                                                            <label for="" class="form-label">Deskripsi</label>
                                                            <textarea class="form-control" name="deskripsi" required><?php echo $data['deskripsi'] ?></textarea>
                                                            <label for="" class="form-label">Tanggal Dibuat</label>
                                                            <input type="date" class="form-control" name="tanggal" value="<?php echo $data['tanggal_buat'] ?>" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-warning" name="edit">Edit Data</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['id_album']?>">Hapus</button>
                                        <div class="modal fade" id="hapus<?php echo $data['id_album']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../config/aksi_album.php" method="POST">
                                                            <input type="hidden" name="albumid" value="<?php echo $data['id_album']?>">
                                                            Apakah anda yakin akan menghapus data <strong><?php echo $data['nama_album']?></strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" name="hapus">Hapus Data</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>&copy; UKK RPL 2024 | Eldi</p>
    </footer>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
