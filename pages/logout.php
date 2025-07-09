<?php
session_start(); // Memulai session untuk mengaksesnya

// 1. Hapus semua variabel session
$_SESSION = array();

// 2. Hancurkan session
session_destroy();

// 3. Arahkan pengguna kembali ke halaman utama
header("Location: index.php");
exit();
?>