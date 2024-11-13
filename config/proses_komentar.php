<?php
session_start();
require_once("koneksi.php");

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Anda belum login!'); location.href='../index.php';</script>";
    exit;
}


if (isset($_POST['tambah'])) {
  $fotoid = $_POST['id_foto'];
  $komentar = $_POST['isi_komentar'];
  $tanggal = $_POST['tanggal_komentar'];
  $userid = $_SESSION['userid'];

  $query = "INSERT INTO komentar_foto (id_foto, isi_komentar, tanggal_komentar, id_user) 
            VALUES ('$foto', '$komentar', '$tanggal', '$userid')";

  if (mysqli_query($koneksi, $query)) {
      echo "<script>alert('Data berhasil disimpan'); location.href='../admin/home1.php';</script>";
  } else {
      echo "<script>alert('Error: " . mysqli_error($koneksi) . "'); location.href='../admin/home1.php';</script>";
  }
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
    

    <div class="container">
        

            <div class="col-md-8">
                
                       
                            <thead>
                            <div class="row">
            <div class="col-md-4">
                <div class="card mt-2">

                <?php
                                $no = 1;
                                $userid = $_SESSION['userid'];
                                $query = "SELECT * from foto where id_user='$userid'";
                                    $sql = mysqli_query($koneksi, $query);
                                    while($data = mysqli_fetch_array($sql)){ 
                                ?>
                    <div class="card-header">Tambah Komentar</div>
                    <div class="card-body">
                        <form action="#" method="POST">
                        <label for="" class="form-label">Nama Album</label>
                        <input type="text" name="id_foto"
                         id="edit<?php echo $data['id_foto']?>" value="<?php echo $data['id_foto']?>"  class="form-control"  required>
                        
                        <label for="" class="form-label">Nama Album</label>
                        <input type="text" value="<?php echo $data['id_user']?>"  class="form-control" name="id_user" required>    
                            
                            <label for="" class="form-label">Isi Komentar</label>
                            <input  class="form-control" name="isi_komentar" required>
                            <label for="" class="form-label">Tanggal komentar</label>
                            <input type="date" class="form-control" name="tanggal_komentar" required>
                            <button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
                            
                          
                                
                             
                                    
                                
                                               
                                    
                                <?php } ?>
                            
                        
                 

    
</body>
</html>
