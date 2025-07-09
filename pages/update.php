<?php
session_start();
include_once("../php/connection.php"); // Pastikan path ini benar

// 1. Pastikan skrip dijalankan via metode POST dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Ambil semua data dari form
    $id = (int) $_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $category = $conn->real_escape_string($_POST['category']);
    $old_image = $_POST['old_image']; // Path gambar lama dari hidden input

    // Defaultnya, path foto adalah foto yang lama
    $path_foto = $old_image;

    // 3. Logika untuk mengganti gambar
    // Cek jika ada file foto BARU yang di-upload dan tidak ada error
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $folder = "./public/assets/"; // Sesuaikan path folder upload Anda

        // Buat nama file baru yang unik
        $path_foto_baru = $folder . time() . "_" . basename($_FILES['foto']['name']);

        // Pindahkan file baru ke folder tujuan
        if (move_uploaded_file($foto_tmp, $path_foto_baru)) {
            // Jika upload file baru berhasil, hapus file gambar lama
            if (file_exists($old_image)) {
                unlink($old_image);
            }
            // Gunakan path foto yang baru
            $path_foto = $path_foto_baru;
        }
        // Jika upload baru gagal, $path_foto akan tetap menggunakan $old_image
    }

    // 4. Update data di database menggunakan prepared statement
    $sql = "UPDATE articles SET title = ?, content = ?, category = ?, cover_image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    // Bind parameter: s = string, i = integer
    $stmt->bind_param("ssssi", $title, $content, $category, $path_foto, $id);

    // 5. Eksekusi dan beri notifikasi
    if ($stmt->execute()) {
        $_SESSION['message'] = "Artikel berhasil diperbarui.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal memperbarui artikel: " . $stmt->error;
        $_SESSION['message_type'] = "error";
    }
    $stmt->close();
}

$conn->close();
// 6. Arahkan kembali ke halaman daftar artikel
header("Location: list-artikel.php");
exit();
?>