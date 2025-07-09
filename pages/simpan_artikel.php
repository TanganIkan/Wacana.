<?php
session_start();
include("../php/connection.php");

// 1. Pastikan user sudah login untuk bisa menyimpan
if (!isset($_SESSION['user_id'])) {
    // Jika tidak login, kirim pesan error (idealnya dalam format JSON jika form di-handle AJAX)
    // Untuk sekarang, kita hentikan saja prosesnya.
    die("Akses ditolak. Anda harus login untuk membuat artikel.");
}

// Cek apakah data POST ada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Ambil user_id dari SESSION
    $user_id = $_SESSION['user_id'];

    // Ambil data lain dari form
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $category = $conn->real_escape_string($_POST['category']);

    // Logika upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $folder = "./public/assets/"; // Sesuaikan path jika perlu

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $path_foto = $folder . time() . "_" . basename($foto);

        if (move_uploaded_file($tmp, $path_foto)) {
            // 3. Masukkan data ke database DENGAN user_id yang benar
            $sql = "INSERT INTO articles (user_id, title, content, cover_image, category, published_at) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            // 'i' untuk user_id (integer), 's' untuk string lainnya
            $stmt->bind_param("issss", $user_id, $title, $content, $path_foto, $category);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Artikel baru berhasil dibuat.";
                $_SESSION["message_type"] = "success";
            } else {
                $_SESSION['message'] = "Gagal menyimpan artikel: " . $stmt->error;
                $_SESSION["message_type"] = "error";
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = "Upload foto gagal.";
        }
    } else {
        $_SESSION['message'] = "Foto tidak ditemukan atau terjadi error saat upload.";
    }
}

$conn->close();
// Arahkan kembali ke halaman list artikel untuk melihat hasilnya
header("Location: list-artikel.php");
exit();
?>