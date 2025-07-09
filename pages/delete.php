<?php
session_start();
include_once("../php/connection.php"); // Pastikan path ini benar

// 1. Cek apakah user sudah login. Jika belum, hentikan proses.
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

// Ambil ID artikel dari URL dan ID user dari session
$article_id_to_delete = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$logged_in_user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

if ($article_id_to_delete > 0) {
    // 2. Ambil data artikel (user_id dan path gambar) sebelum dihapus
    $sql_select = "SELECT user_id, cover_image FROM articles WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $article_id_to_delete);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($article = $result->fetch_assoc()) {
        $article_owner_id = $article['user_id'];
        $image_path = $article['cover_image'];

        // 3. Verifikasi Kepemilikan: Cek apakah user adalah pemilik artikel atau admin
        if ($logged_in_user_id == $article_owner_id || $user_role === 'admin') {

            // 4. Hapus file gambar dari server jika ada
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // 5. Hapus record artikel dari database
            $sql_delete = "DELETE FROM articles WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $article_id_to_delete);

            if ($stmt_delete->execute()) {
                $_SESSION['message'] = "Artikel berhasil dihapus.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Gagal menghapus artikel dari database.";
                $_SESSION['message_type'] = "error";
            }
            $stmt_delete->close();

        } else {
            // Jika user mencoba menghapus artikel milik orang lain
            $_SESSION['message'] = "Akses ditolak. Anda tidak memiliki izin untuk menghapus artikel ini.";
        }
    } else {
        $_SESSION['message'] = "Artikel tidak ditemukan.";
    }
    $stmt_select->close();
} else {
    $_SESSION['message'] = "ID artikel tidak valid.";
}

$conn->close();
// 6. Arahkan kembali ke halaman daftar artikel
header("Location: list-artikel.php");
exit();
?>