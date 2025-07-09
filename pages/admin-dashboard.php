<?php
session_start();
include_once("../php/connection.php");

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php'); // Arahkan non-admin ke halaman utama
    exit();
}

$loginSuccess = '';
if (isset($_SESSION['login_success'])) {
    $loginSuccess = $_SESSION['login_success'];
    unset($_SESSION['login_success']);
}

// Ambil jumlah total artikel
$total_articles_result = $conn->query("SELECT COUNT(id) as total FROM articles");
$total_articles = $total_articles_result->fetch_assoc()['total'];

// Ambil jumlah total pengguna
$total_users_result = $conn->query("SELECT COUNT(id) as total FROM users WHERE role != 'admin'"); // Hanya pengguna biasa
$total_users = $total_users_result->fetch_assoc()['total'];

// Ambil jumlah artikel baru hari ini
$articles_today_result = $conn->query("SELECT COUNT(id) as total FROM articles WHERE DATE(published_at) = CURDATE()");
$articles_today = $articles_today_result->fetch_assoc()['total'];


// AMBIL 5 ARTIKEL TERBARU DARI SEMUA PENGGUNA
$sql_recent = "
    SELECT 
        articles.id, 
        articles.title, 
        users.name as author_name 
    FROM articles 
    JOIN users ON articles.user_id = users.id 
    ORDER BY articles.published_at DESC 
    LIMIT 5
";
$recent_articles_result = $conn->query($sql_recent);

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../public/css/output.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#d9d9d9] max-w-7xl mx-auto relative">

    <nav
        class="relative flex items-center justify-between px-6 py-4 my-3 bg-white border text-black border-black xl:mx-0 mx-10">
        <div class="flex-1">
            <a href="index.php" class="text-xl italic font-bold uppercase">Wacana.</a>
        </div>
        <div class="flex-1 flex justify-end items-center gap-x-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="text-sm font-medium hidden sm:block">Halo, <?= htmlspecialchars($_SESSION['name']); ?></span>
                <a href="./logout.php"
                    class="bg-red-600 text-white py-2 px-4 capitalize border-black hover:shadow-[3px_3px_0_0_black] border font-semibold duration-200 logout-btn">Logout</a>
            <?php else: ?>
                <a href="./login.php"
                    class="bg-white py-2 px-4 capitalize border-black border hover:shadow-[3px_3px_0_0_black] font-semibold duration-200">Get
                    In Touch</a>
            <?php endif; ?>
        </div>
    </nav>

    <main class="xl:mx-0 mx-10 py-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Selamat Datang, Admin!</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 border border-black shadow-[4px_4px_0_0_black]">
                <h3 class="text-sm font-medium text-gray-500">Total Artikel</h3>
                <p class="text-3xl font-bold text-gray-900"><?= $total_articles; ?></p>
            </div>
            <div class="bg-white p-6 border border-black shadow-[4px_4px_0_0_black]">
                <h3 class="text-sm font-medium text-gray-500">Total Pengguna</h3>
                <p class="text-3xl font-bold text-gray-900"><?= $total_users; ?></p>
            </div>
            <div class="bg-white p-6 border border-black shadow-[4px_4px_0_0_black]">
                <h3 class="text-sm font-medium text-gray-500">Postingan Hari Ini</h3>
                <p class="text-3xl font-bold text-gray-900"><?= $articles_today; ?></p>
            </div>
        </div>

        <div class="bg-white border border-black overflow-hidden">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Artikel Terbaru</h2>
                <a href="list-artikel.php"
                    class="bg-white hover:shadow-[3px_3px_0_0_black] border border-black text-black font-semibold py-2 px-4">
                    Kelola Semua Artikel &rarr;
                </a>
            </div>
            <div class="border-t border-black">
                <table class="min-w-full divide-y divide-black">
                    <tbody class="bg-white divide-y divide-black">
                        <?php if ($recent_articles_result->num_rows > 0): ?>
                            <?php while ($article = $recent_articles_result->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($article['title']); ?>
                                        </p>
                                        <p class="text-sm text-gray-500">oleh <?= htmlspecialchars($article['author_name']); ?>
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="artikel.php?id=<?= $article['id']; ?>" target="_blank"
                                            class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td class="px-6 py-4 text-center text-gray-500">Belum ada artikel.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Script untuk menampilkan SweetAlert jika login berhasil
        <?php if (!empty($loginSuccess)): ?>
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: 'Selamat datang kembali, Admin!',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>

        // Script untuk konfirmasi logout
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('logout-btn')) {
                event.preventDefault();
                const logoutUrl = event.target.href;
                Swal.fire({
                    title: 'Anda yakin ingin logout?', icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7881', confirmButtonText: 'Ya, logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = logoutUrl;
                    }
                });
            }
        });
    </script>
</body>

</html>