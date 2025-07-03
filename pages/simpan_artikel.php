<?php
session_start(); // Mulai session
include("../php/connection.php");
// Ambil data dari form
$title = $conn->real_escape_string($_POST['title']);
$content = $conn->real_escape_string($_POST['content']);
$category = $conn->real_escape_string($_POST['category']);
$published = date("Y-m-d H:i:s");
// Upload foto
$foto = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
$folder = "./public/assets/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$path_foto = $folder . time() . "_" . basename($foto);
if (move_uploaded_file($tmp, $path_foto)) {
    // Simpan ke database
    $sql = "INSERT INTO articles (user_id, title, content, cover_image, published_at, category) VALUES (1,'$title', '$content', '$path_foto','$published', '$category')";

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
?>
