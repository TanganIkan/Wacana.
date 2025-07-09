<?php
session_start();
include_once("../php/connection.php");

// 1. Ambil ID artikel dari URL dan pastikan itu adalah angka
$artikel_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($artikel_id <= 0) {
    die("ID Artikel tidak valid.");
}

// 2. Ambil data artikel dari database
$sql = "SELECT * FROM articles WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $artikel_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $artikel = $result->fetch_assoc();
} else {
    http_response_code(404);
    die("Artikel tidak ditemukan.");
}
$stmt->close();

// 3. Ambil 4 artikel terbaru lainnya untuk sidebar
$sql_recent = "SELECT id, title, cover_image, published_at FROM articles WHERE id != ? ORDER BY published_at DESC LIMIT 4";
$stmt_recent = $conn->prepare($sql_recent);
$stmt_recent->bind_param("i", $artikel_id);
$stmt_recent->execute();
$result_recent = $stmt_recent->get_result();
$recent_articles = [];
while ($row = $result_recent->fetch_assoc()) {
    $recent_articles[] = $row;
}
$stmt_recent->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($artikel['title']) ?></title>
    <link rel="stylesheet" href="../public/css/output.css" />
    <style>
        .article-content p {
            margin-bottom: 1.5rem;
            line-height: 1.75;
        }

        .article-content h2,
        .article-content h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-[#d9d9d9]">

    <nav
        class="relative flex items-center justify-between px-6 py-4 my-3 bg-black border text-white border-white max-w-7xl mx-auto xl:mx-auto lg:mx-10 md:mx-10 sm:mx-10">
        <div class="flex-1">
            <a href="index.php" class="text-xl font-bold italic uppercase">Wacana.</a>
        </div>
        <div class="flex-1 flex justify-end gap-x-2">
            <a href="index.php"
                class="bg-black py-2 px-4 capitalize border-white border hover:shadow-[3px_3px_0_0_white] font-semibold duration-200">
                Kembali
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 px-4 lg:px-0">

        <main class="lg:col-span-2 bg-white p-6 sm:p-8 md:p-10 border border-black shadow-[4px_4px_0_0_black]">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-black leading-tight mb-4">
                <?= htmlspecialchars($artikel['title']) ?>
            </h1>
            <div class="flex items-center text-sm text-gray-600 mb-6">
                <span class="bg-black text-white py-1 px-3 text-xs capitalize">
                    <?= htmlspecialchars($artikel['category']) ?>
                </span>
                <?php if (!empty($artikel['published_at'])): ?>
                    <span class="mx-2">•</span>
                    <span><?= date('d F Y', strtotime($artikel['published_at'])) ?></span>
                <?php endif; ?>
            </div>
            <div class="aspect-video w-full overflow-hidden mb-8 border border-black">
                <img src="<?= htmlspecialchars($artikel['cover_image']) ?>"
                    alt="<?= htmlspecialchars($artikel['title']) ?>" class="w-full h-full object-cover">
            </div>
            <div class="article-content text-gray-800 text-lg">
                <?= nl2br(htmlspecialchars($artikel['content'])); ?>
            </div>
        </main>

        <aside class="lg:col-span-1">
            <div class="sticky top-5 bg-white p-6 border border-black shadow-[4px_4px_0_0_black]">
                <h3 class="text-2xl font-bold mb-4 border-b-2 border-black pb-2">Artikel Terbaru</h3>
                <div class="space-y-4">
                    <?php foreach ($recent_articles as $recent): ?>
                        <a href="artikel.php?id=<?= $recent['id'] ?>" class="flex items-start gap-4 group">
                            <div class="w-20 h-20 overflow-hidden border border-black flex-shrink-0">
                                <img src="<?= htmlspecialchars($recent['cover_image']) ?>"
                                    alt="<?= htmlspecialchars($recent['title']) ?>"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-200">
                            </div>

                            <div class="flex-1">
                                <h4 class="font-semibold text-base leading-tight group-hover:underline mb-1">
                                    <?= htmlspecialchars($recent['title']) ?>
                                </h4>
                                <span class="text-xs text-gray-500">
                                    <?= date('d M Y', strtotime($recent['published_at'])) ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>

    </div>

    <footer class="w-full mt-10 px-4 sm:px-6 lg:px-8 py-10 bg-black text-white">
        <p class="text-center text-xs text-gray-600">© 2025 Creative. All rights reserved</p>
    </footer>

</body>

</html>