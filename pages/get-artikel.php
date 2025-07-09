<?php
include_once("../php/connection.php"); // Pastikan path ini benar

// Pastikan ID ada dan valid
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'ID Artikel tidak valid.']);
    exit();
}

// Ambil data dari database menggunakan prepared statement
$sql = "SELECT * FROM articles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();
$conn->close();

if ($article) {
    // Set header sebagai JSON dan kirim data artikel
    header('Content-Type: application/json');
    echo json_encode($article);
} else {
    // Jika artikel tidak ditemukan
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'Artikel tidak ditemukan.']);
}
?>