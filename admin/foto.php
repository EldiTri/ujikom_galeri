<?php
    session_start();
    require_once("../config/koneksi.php");
    $userid = $_SESSION['userid'];

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
    <title>Album</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <style>
        /* Mengubah background halaman menjadi biru cerah */
        body {
            background-color: #add8e6; /* Warna biru cerah */
        }

        /* Navbar dengan warna biru */
        .navbar {
            background-color: #007bff; /* Warna biru gelap */
        }

        /* Warna header pada card dan modal */
        .card-header, .modal-header {
            background-color: #007bff; /* Warna biru pada header */
            color: white;
        }

        /* Navbar text color */
        .navbar a, .navbar .navbar-brand {
            color: white; /* Teks navbar putih */
        }

        /* Mengubah warna footer */
        footer {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark"> <!-- Menambahkan class navbar-dark untuk navbar dengan teks putih -->
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
                    <div class="card-header">Tambah Foto</div>
                    <div class="card-body">
                        <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                            <label for="" class="form-label">Judul Foto</label>
                            <input type="text" class="form-control" name="judul_foto" required>
                            <label for="" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi_foto" required></textarea>
                            <label for="" class="form-label">Tanggal Unggah</label>
                            <input type="date" class="form-control" name="tanggal" required>
                            <label for="" class="form-label">Album</label>
                            <select type="text" class="form-control" name="id_album">
                                <?php
                                    $sql_album = mysqli_query($koneksi, "SELECT * FROM album WHERE id_user='$userid'");
                                    while($data_album = mysqli_fetch_array($sql_album)) { ?>
                                        <option value="<?php echo $data_album['id_album'] ?>">
                                            <?php echo $data_album['nama_album'] ?>
                                        </option>
                                <?php } ?>   
                            </select>
                            <label for="" class="form-label">File</label>
                            <input type="file" class="form-control" name="lokasi_file" required>
                            <button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah Data</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-header">Data Foto</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal</th>
                                    <th>Lokasi File</th>
                                    <th>Album</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $userid = $_SESSION['userid'];
                                    $query = "SELECT * from foto where id_user='$userid'";
                                    $sql = mysqli_query($koneksi, $query);
                                    while($data = mysqli_fetch_array($sql)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['judul_foto'] ?></td>
                                    <td><?php echo $data['deskripsi_foto'] ?></td>
                                    <td><?php echo $data['tanggal_unggah'] ?></td>
                                    <td><?php echo $data['lokasi_file'] ?></td>
                                    <td><?php echo $data['id_album'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['id_foto']?>">Edit</button>

                                        <div class="modal fade" id="edit<?php echo $data['id_foto']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../config/aksi_foto.php" method="POST">
                                                            <input type="hidden" name="fotoid" value="<?php echo $data['id_foto']?>">
                                                            <label for="" class="form-label">Judul Foto</label>
                                                            <input type="text" class="form-control" name="judul_foto" value="<?php echo $data['judul_foto'] ?>" required>

                                                            <label for="" class="form-label">Deskripsi</label>
                                                            <textarea class="form-control" name="deskripsi_foto" required><?php echo $data['deskripsi_foto'] ?></textarea>

                                                            <label for="" class="form-label">Tanggal Unggah</label>
                                                            <input type="date" class="form-control" name="tanggal" value="<?php echo $data['tanggal_unggah'] ?>" required>

                                                            <label for="" class="form-label">Album</label>
                                                            <select type="text" class="form-control" name="id_album">
                                                                <?php
                                                                    $sql_album = mysqli_query($koneksi, "SELECT * FROM album");
                                                                    while($data_album = mysqli_fetch_array($sql_album)) { ?>
                                                                        <option value="<?php echo $data_album['id_album'] ?>" 
                                                                            <?php if($data['id_album'] == $data_album['id_album']) echo 'selected'; ?>>
                                                                            <?php echo $data_album['nama_album'] ?>
                                                                        </option>
                                                                <?php } ?>   
                                                            </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-warning" name="edit">Edit Data</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['id_foto']?>">Hapus</button>
                                        <div class="modal fade" id="hapus<?php echo $data['id_foto']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../config/aksi_foto.php" method="POST">
                                                            <input type="hidden" name="fotoid" value="<?php echo $data['id_foto']?>">
                                                            Apakah anda yakin akan menghapus data <strong><?php echo $data['judul_foto']?></strong>
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
