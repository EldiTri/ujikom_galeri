<?php
session_start();
session_destroy();
echo "<script>
alert('logout    berhasil');
location.href='../login.php';
</script>";


?>