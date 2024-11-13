<?php
$hostname = 'localhost';
$userdb = 'root';
$passdb ='';
$namedb = 'ujikom_galeri';

$koneksi = mysqli_connect($hostname,$userdb,$passdb,$namedb);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<?php
// $hostname = 'localhost';
// $userdb = 'root';
// $passdb = '';
// $namedb = 'ujikom_galeri';

// $koneksi = mysqli_connect($hostname, $userdb, $passdb, $namedb);

// if (!$koneksi) {
//     die("Koneksi gagal: " . mysqli_connect_error());
// }

?>