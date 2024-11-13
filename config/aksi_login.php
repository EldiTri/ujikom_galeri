<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; 

    // Fetch the user data from the database
    $sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");

    if (mysqli_num_rows($sql) > 0) {
        $data = mysqli_fetch_assoc($sql);
        
        // Verify the password
        if (password_verify($password, $data['password'])) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['userid'] = $data['id_user'];
            $_SESSION['status'] = 'login';
            echo "<script>
            alert('Login berhasil');
            location.href='../admin/home1.php';
            </script>";
        } else {
            echo "<script>
            alert('Username atau Password salah!');
            location.href='../login.php';
            </script>";
        }
    } else {
        echo "<script>
        alert('Username atau Password salah!');
        location.href='../login.php';
        </script>";
    }
} else {
    echo "<script>
    alert('Akses tidak valid!');
    location.href='../login.php';
    </script>";
}
?>
