<?php
    session_start();
    require_once("koneksi.php");

    if(isset($_POST['tambah'])) {
        $judul_foto = $_POST['judul_foto'];
        $deskripsi_foto = $_POST['deskripsi_foto'];
        $tanggal = date('Y-m-d');
        $albumid = $_POST['id_album'];
        $foto = $_FILES['lokasi_file']['name'];
        $tmp = $_FILES['lokasi_file']['tmp_name'];
        $lokasi = '../assets/img/';
        $namafoto = rand(). '-'.$foto;
        $userid = $_SESSION['userid'];

        move_uploaded_file($tmp, $lokasi.$namafoto);
        
        $query = "INSERT INTO foto (judul_foto,
                                    deskripsi_foto,
                                    tanggal_unggah,
                                    lokasi_file,
                                    id_album,
                                    id_user) 
                    VALUES ('$judul_foto',
                            '$deskripsi_foto', 
                            '$tanggal', 
                            '$namafoto', 
                            '$albumid', 
                            '$userid')";
          
        $sql = mysqli_query($koneksi, $query);

        echo "<script>
            alert('Data berhasil disimpan');
            location.href='../admin/foto.php';
        </script>";
    }

    if(isset($_POST['edit'])) {
        $id = $_POST['fotoid'];
        $judul_foto = $_POST['judul_foto'];
        $deskripsi_foto = $_POST['deskripsi_foto'];
        $tanggal = date('Y-m-d');
        $albumid = $_POST['id_album'];

        $query = "UPDATE foto SET judul_foto='$judul_foto',
                                  deskripsi_foto='$deskripsi_foto',
                                  tanggal_unggah='$tanggal',
                                  id_album='$albumid'
                   WHERE id_foto='$id'";

        $sql = mysqli_query($koneksi, $query);

        echo "<script>
            alert('Data berhasil diperbarui');
            location.href='../admin/foto.php';
        </script>";
    }

    if(isset($_POST['hapus'])) {
        $fotoid = $_POST['fotoid'];

        $query = "DELETE FROM foto WHERE id_foto='$fotoid'";

        $sql = mysqli_query($koneksi, $query);

        echo "<script>
            alert('Data berhasil dihapus');
            location.href='../admin/foto.php';
        </script>";
    }
?>
