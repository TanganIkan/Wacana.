<?php
session_start();
include_once("../php/connection.php"); // Pastikan path ini benar

$feedbackMessage = $_SESSION['message'] ?? '';
$feedbackType = $_SESSION['message_type'] ?? 'info';
unset($_SESSION['message'], $_SESSION['message_type']);

// 1. Cek apakah user sudah login. Jika belum, arahkan ke halaman login.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Ganti dengan halaman login Anda
    exit();
}

// 2. Ambil ID dan peran (role) user yang sedang login dari session
$logged_in_user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// 3. Siapkan kueri SQL dasar
$sql = "SELECT id, cover_image, title, category, published_at FROM articles";
$params = [];
$types = "";

// 4. Jika user BUKAN admin, tambahkan filter WHERE berdasarkan user_id
if ($user_role !== 'admin') {
    $sql .= " WHERE user_id = ?";
    $params[] = $logged_in_user_id;
    $types .= "i";
}

$sql .= " ORDER BY published_at DESC";

// 5. Eksekusi kueri menggunakan prepared statement
$stmt = $conn->prepare($sql);
if ($user_role !== 'admin') {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$articles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
}
$stmt->close();
$conn->close();

// Daftar Kategori Artikel
$categories = [
    'Teknologi',
    'Lifestyle',
    'Bisnis',
    'Olahraga',
    'Hiburan',
    'Edukasi'
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Artikel</title>
    <link rel="stylesheet" href="../public/css/output.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#d9d9d9] max-w-7xl mx-auto relative">

    <div id="addModal"
        class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4 duration-200 invisible opacity-0 scale-95">
        <div class="w-full max-w-2xl bg-[#d9d9d9] p-8 border border-black shadow-lg space-y-6 relative duration-300">
            <button id="closeModalBtn"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-3xl">&times;</button>
            <h2 class="text-3xl font-bold text-center">Tambah Artikel</h2>
            <form action="simpan_artikel.php" method="POST" enctype="multipart/form-data" class="space-y-5">
                <div>
                    <label class="block font-semibold mb-1" for="title">Judul Artikel</label>
                    <input type="text" name="title" id="title" required
                        class="w-full bg-white border border-black px-4 py-2 focus:outline-none focus:ring-1 shadow-[4px_4px_0_0_black]" />
                </div>
                <div>
                    <label class="block font-semibold mb-1" for="category">Kategori Artikel</label>
                    <select name="category" id="category" required
                        class="w-full bg-white border border-black px-4 py-2 focus:outline-none focus:ring-1 shadow-[4px_4px_0_0_black]">

                        <option value="" disabled selected>-- Pilih Kategori --</option>

                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category); ?>">
                                <?= htmlspecialchars($category); ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1" for="content">Isi Artikel</label>
                    <textarea name="content" id="content" rows="6" required
                        class="w-full bg-white border border-black px-4 py-2 focus:outline-none focus:ring-1 shadow-[4px_4px_0_0_black] resize-none"></textarea>
                </div>
                <div>
                    <label class="block font-semibold mb-1" for="foto">Upload Foto</label>
                    <input type="file" name="foto" id="foto" accept="image/*" required
                        class="w-full border border-black p-2 bg-white focus:outline-none focus:ring-1 shadow-[4px_4px_0_0_black]" />
                </div>
                <div>
                    <button type="submit"
                        class="w-full bg-white border-black border hover:shadow-[3px_3px_0_0_black] text-black font-semibold py-3 transition duration-200">Simpan
                        Artikel</button>
                </div>
            </form>
        </div>
    </div>

    <nav
        class="relative flex items-center justify-between px-6 py-4 my-3 bg-white border text-black border-black xl:mx-0 mx-10">
        <div class="flex-1">
            <a href="index.php" class="text-xl italic font-bold uppercase">Wacana.</a>
        </div>
        <div class="flex-1 flex justify-end items-center gap-x-4">
            <span class="text-sm font-medium hidden sm:block">Halo, <?= htmlspecialchars($_SESSION['name']); ?></span>

            <?php if ($user_role === 'admin'): ?>
                <a href="admin-dashboard.php"
                    class="bg-white py-2 px-4 capitalize border-black border hover:shadow-[3px_3px_0_0_black] font-semibold duration-200">
                    Admin
                </a>
            <?php endif; ?>

            <a href="list-artikel.php"
                class="bg-gray-200 py-2 px-4 capitalize border-black border font-semibold duration-200">
                List Artikel
            </a>

            <button id="openAddModalBtn"
                class="bg-white py-2 px-4 capitalize border-black border hover:shadow-[3px_3px_0_0_black] font-semibold duration-200 cursor-pointer">
                Tambah Artikel
            </button>

            <a href="logout.php"
                class="logout-btn bg-red-600 text-white py-2 px-4 capitalize border-black border hover:shadow-[3px_3px_0_0_black] font-semibold duration-200">
                Logout
            </a>
        </div>
    </nav>

    <main class="xl:mx-0 mx-10 py-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Manajemen Artikel</h1>
        <div class="bg-white shadow overflow-hidden border border-black">
            <table class="min-w-full divide-y divide-black-200">
                <thead class="bg-[#d9d9d9]]">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">No
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">
                            Gambar</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">
                            Judul
                            Artikel</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">
                            Kategori</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-black-200">
                    <?php if (empty($articles)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-black-500">Anda belum membuat artikel.</td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1;
                        foreach ($articles as $article): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black-500 align-top"><?= $i++; ?></td>
                                <td class="px-6 py-4">
                                    <img src="<?= htmlspecialchars($article['cover_image']); ?>" alt="Cover"
                                        class="w-24 h-16 object-cover border">
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-black-900 align-top">
                                    <?= htmlspecialchars($article['title']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-black-500 align-top">
                                    <?= htmlspecialchars($article['category']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 align-top">
                                    <button type="button" data-id="<?= $article['id']; ?>"
                                        class="edit-btn text-indigo-600 hover:text-indigo-900">Edit</button>

                                    <a href="delete.php?id=<?= $article['id']; ?>"
                                        class="delete-btn text-red-600 hover:text-red-900">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="editModal" class="fixed inset-0 bg-black/40 bg-opacity-50 z-50 flex items-center justify-center p-4 
                                opacity-0 invisible transition-all duration-300 ease-in-out scale-95">
        <div
            class="w-full max-w-2xl bg-[#d9d9d9] p-8 border border-blackshadow-lg relative max-h-[90vh] overflow-y-auto">
            <button id="closeEditModalBtn"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-3xl">&times;</button>
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Edit Artikel</h2>

            <form id="editForm" action="update.php" method="POST" enctype="multipart/form-data" class="space-y-5">
            </form>
        </div>
    </div>

    <script>
        // Menampilkan notifikasi dari PHP Session
        <?php if (!empty($feedbackMessage)): ?>
            Swal.fire({
                icon: '<?= $feedbackType; ?>',
                title: '<?= ($feedbackType === "success") ? "Berhasil!" : "Terjadi Kesalahan"; ?>',
                text: '<?= addslashes($feedbackMessage); ?>',
                timer: 2500,
                showConfirmButton: false
            });
        <?php endif; ?>

        // === LOGIKA UNTUK MODAL TAMBAH ARTIKEL ===
        // Ambil elemen modal dengan id 'addModal'
        const addModal = document.getElementById('addModal');

        // Ambil tombol pembuka modal dengan id 'openAddModalBtn'
        const openAddModalBtn = document.getElementById('openAddModalBtn');

        // Ambil tombol penutup modal dengan id 'closeModalBtn'
        const closeAddModalBtn = document.getElementById('closeModalBtn');

        // Berikan daftar kategori dari PHP ke JavaScript
        const categories = <?= json_encode($categories); ?>;

        if (openAddModalBtn) {
            const openAddModal = () => addModal.classList.remove('invisible', 'opacity-0', 'scale-95');
            const closeAddModal = () => addModal.classList.add('invisible', 'opacity-0', 'scale-95');

            // Baris ini sekarang akan berfungsi dengan benar
            openAddModalBtn.addEventListener('click', openAddModal);

            closeAddModalBtn.addEventListener('click', closeAddModal);
            addModal.addEventListener('click', (event) => {
                if (event.target === addModal) {
                    closeAddModal();
                }
            });
        }

        // === LOGIKA UNTUK MODAL EDIT & AKSI HAPUS ===
        const editModal = document.getElementById('editModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const editForm = document.getElementById('editForm');
        const tableBody = document.querySelector('tbody');

        if (tableBody) {
            const openEditModal = () => editModal.classList.remove('invisible', 'opacity-0', 'scale-95');
            const closeEditModal = () => editModal.classList.add('invisible', 'opacity-0', 'scale-95');
            closeEditModalBtn.addEventListener('click', closeEditModal);

            tableBody.addEventListener('click', async (event) => {
                // Logika untuk tombol Edit
                if (event.target.classList.contains('edit-btn')) {
                    const articleId = event.target.dataset.id;
                    try {
                        const response = await fetch(`get-artikel.php?id=${articleId}`);
                        if (!response.ok) throw new Error('Gagal mengambil data artikel.');
                        const article = await response.json();

                        let categoryOptions = '';
                        categories.forEach(category => {
                            // Cek apakah kategori ini sama dengan kategori artikel yang sedang diedit
                            const isSelected = (article.category === category) ? 'selected' : '';
                            categoryOptions += `<option value="${category}" ${isSelected}>${category}</option>`;
                        });

                        editForm.innerHTML = `
                <input type="hidden" name="id" value="${article.id}">
                <input type="hidden" name="old_image" value="${article.cover_image}">
                
                <div>
                    <label class="block font-semibold mb-1">Judul</label>
                    <input type="text" name="title" required value="${article.title}" class="w-full bg-white border border-black shadow-[4px_4px_0_0_black] focus:outline-none focus:ring-1 px-4 py-2 ">
                </div>
                
                <div>
                    <label class="block font-semibold mb-1">Kategori</label>
                    <select name="category" required class="w-full bg-white border border-black shadow-[4px_4px_0_0_black] focus:outline-none focus:ring-1 px-4 py-2 ">
                        ${categoryOptions}
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Isi</label>
                    <textarea name="content" rows="6" required class="w-full bg-white border border-black  shadow-[4px_4px_0_0_black] focus:outline-none focus:ring-1 px-4 py-2 ">${article.content}</textarea>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Foto Saat Ini</label>
                    <img src="${article.cover_image}" class="w-40 h-auto mb-2">
                    <label class="block font-semibold mb-1">Ganti Foto</label>
                    <input type="file" name="foto" class="w-full border border-black shadow-[4px_4px_0_0_black] p-2">
                </div>
                <button type="submit" class="w-full bg-white text-black font-semibold py-2 border border-black hover:shadow-[4px_4px_0_0_black]">Simpan Perubahan</button>
            `;
                        openEditModal();
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message
                        });
                    }
                }
                // Logika untuk tombol Hapus
                if (event.target.classList.contains('delete-btn')) {
                    event.preventDefault();
                    const deleteUrl = event.target.href;
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Artikel yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = deleteUrl;
                        }
                    });
                }
            });
        }

        // === LOGIKA UNTUK LOGOUT ===
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('logout-btn')) {
                event.preventDefault();
                const logoutUrl = event.target.href;
                Swal.fire({
                    title: 'Anda yakin ingin logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Ya, logout!',
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