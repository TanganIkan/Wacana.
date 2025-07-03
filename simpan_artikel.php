<?php
session_start();
include("../php/connection.php");

// Ambil data dari form
$judul     = $conn->real_escape_string($_POST['judul']);
$isi       = $conn->real_escape_string($_POST['isi']);
$published = date("Y-m-d H:i:s");

$user_id   = 2;
$author    = "Admin";
$slug      = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $judul)) . '-' . time();
$article_type = "berita";

// Upload foto
$foto   = $_FILES['foto']['name'];
$tmp    = $_FILES['foto']['tmp_name'];
$folder = __DIR__ . "/../public/assets/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$filename       = time() . "_" . basename($foto);
$path_foto      = $folder . $filename;
$path_foto_db   = "/public/assets/" . $filename;

if (move_uploaded_file($tmp, $path_foto)) {
    // Simpan ke database
    $sql = "INSERT INTO articles (
                user_id, article_name, slug, author, release_time,
                content, article_type, image_url, status
            ) VALUES (
                $user_id, '$judul', '$slug', '$author', '$published',
                '$isi', '$article_type', '$path_foto_db', 'published'
            )";

    if ($conn->query($sql)) {
        $_SESSION['success'] = "Artikel berhasil disimpan.";
    } else {
        $_SESSION['error'] = "Gagal menyimpan artikel: " . $conn->error;
    }
} else {
    $_SESSION['error'] = "Upload foto gagal.";
}

$conn->close();
header("Location: form.php");
exit;
?>
