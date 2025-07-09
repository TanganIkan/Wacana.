<?php
// Selalu mulai session di baris paling atas
session_start();
include_once("../php/connection.php");

$user_role = $_SESSION['role'] ?? 'guest'; // Default ke 'guest' jika tidak ada session

// Logika untuk mengambil data artikel dari database
// (Saya asumsikan Anda sudah memiliki logika ini. Jika belum, tambahkan di sini)
// Contoh:
$sql = "SELECT * FROM articles ORDER BY published_at DESC LIMIT 20"; // Ambil 10 artikel terbaru
$result = $conn->query($sql);
$datas = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $datas[] = $row;
  }
}
// $conn->close(); // Sebaiknya jangan ditutup jika masih ada query lain di halaman ini

// sweet alert login berhasil
$loginSuccess = '';
if (isset($_SESSION['login_success'])) {
  $loginSuccess = $_SESSION['login_success'];
  unset($_SESSION['login_success']);
}
// sweet alert artikel berhasil ditambahkan
$formMessage = '';
$formMessageType = '';
if (isset($_SESSION['success'])) {
  $formMessage = $_SESSION['success'];
  $formMessageType = 'success';
  unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
  $formMessage = $_SESSION['error'];
  $formMessageType = 'error';
  unset($_SESSION['error']);
}

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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../public/css/output.css" />
  <title>Wacana</title>
</head>

<body class="bg-[#d9d9d9] max-w-7xl mx-auto relative">

  <div id="formModal"
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
      <?php if (isset($_SESSION['user_id'])): ?>

        <span class="text-sm font-medium hidden sm:block">Halo, <?= htmlspecialchars($_SESSION['name']); ?></span>

        <?php if ($user_role === 'admin'): ?>
          <a href="./admin-dashboard.php"
            class="bg-white py-2 px-4 capitalize border-black border hover:shadow-[3px_3px_0_0_black] font-semibold duration-200">Admin</a>
        <?php endif; ?>

        <a href="./list-artikel.php"
          class="bg-white py-2 px-4 capitalize border-black border hover:shadow-[3px_3px_0_0_black] font-semibold duration-200">List
          Artikel</a>

        <a id="openModalBtn"
          class="bg-white py-2 px-4 capitalize border-black border hover:shadow-[3px_3px_0_0_black] font-semibold duration-200 cursor-pointer">
          Tambah Artikel
        </a>

        <a href="./logout.php"
          class="bg-red-600 text-white py-2 px-4 capitalize border-black hover:shadow-[3px_3px_0_0_black] border font-semibold duration-200 logout-btn">Logout</a>

      <?php else: ?>
        <a href="./login.php"
          class="bg-white py-2 px-4 uppercase border-black border hover:shadow-[3px_3px_0_0_black] font-bold duration-200">Mulai
          Menulis</a>
      <?php endif; ?>
    </div>
  </nav>

  <main class="xl:mx-0 mx-10">
    <?php if (!empty($datas)): ?>
      <?php
      // 1. TENTUKAN ARTIKEL UTAMA
      // Cek apakah ada cukup artikel. Jika ada, pakai artikel ke-6 (indeks 5).
      // Jika tidak, pakai artikel terbaru (indeks 0) sebagai cadangan agar tidak error.
      if (isset($datas[5])) {
        $main_article = $datas[4];
      } else {
        $main_article = $datas[0];
      }
      // Simpan ID artikel utama untuk perbandingan nanti
      $main_article_id = $main_article['id'];
      ?>

      <section class="mb-4">
        <a href="artikel.php?id=<?= htmlspecialchars($main_article['id']) ?>" class="block group">
          <div class="relative border border-black overflow-hidden aspect-video md:aspect-[2.5/1]">
            <img src="<?= htmlspecialchars($main_article["cover_image"]) ?>"
              alt="<?= htmlspecialchars($main_article["title"]) ?>"
              class="w-full h-full object-cover object-center group-hover:scale-105 duration-300 lazy-loaded" />
            <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-black/80 to-transparent"></div>
            <div class="absolute bottom-0 p-4 sm:p-6 lg:p-8 text-white w-full">
              <span
                class="mb-2 inline-block self-start bg-black py-1 px-3 text-xs capitalize text-white"><?= htmlspecialchars($main_article["category"]) ?></span>
              <h1 class="font-bold text-xl sm:text-2xl lg:text-4xl leading-tight line-clamp-2 capitalize">
                <?= htmlspecialchars($main_article["title"]) ?>
              </h1>

              <span class="mt-4 block text-sm opacity-80">
                <?= date('d F Y', strtotime($main_article["published_at"])) ?>
              </span>
            </div>
          </div>
        </a>
      </section>

      <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
          <?php
          // Loop melalui SEMUA artikel yang diambil dari database
          foreach ($datas as $data):
            // 2. LEWATI JIKA ARTIKEL INI ADALAH ARTIKEL UTAMA
            // Ini untuk mencegah artikel utama muncul dua kali
            if ($data['id'] == $main_article_id) {
              continue; // Lanjut ke iterasi berikutnya
            }
            ?>
            <a href="artikel.php?id=<?= htmlspecialchars($data['id']) ?>"
              class="group flex flex-col border bg-white border-black hover:shadow-[4px_4px_0_0_black] duration-200 hover:-translate-y-1">
              <div class="aspect-video overflow-hidden border-b border-black">
                <img src="<?= htmlspecialchars($data["cover_image"]) ?>" alt="<?= htmlspecialchars($data["title"]) ?>"
                  class="w-full h-full object-cover group-hover:scale-105 duration-300 lazy-loaded" />
              </div>
              <div class="flex flex-col flex-grow p-3">
                <span
                  class="mb-2 inline-block self-start bg-black py-1 px-3 text-xs capitalize text-white"><?= htmlspecialchars($data["category"]) ?></span>
                <h2 class="flex-grow font-semibold capitalize text-base line-clamp-2">
                  <?= htmlspecialchars($data["title"]) ?>
                </h2>

                <span class="mt-2 text-xs text-gray-500">
                  <?= date('d M Y', strtotime($data["published_at"])) ?>
                </span>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    <?php else: ?>
      <p class="text-center py-10">Belum ada artikel untuk ditampilkan.</p>
    <?php endif; ?>
  </main>

  <footer class="w-full px-4 sm:px-6 lg:px-8 py-10 bg-black text-white mt-10">
    <p class="text-center text-xs">© <?= date("Y") ?> Wacana. All rights reserved</p>
  </footer>

  <script>
    // Script untuk notifikasi login
    <?php if ($loginSuccess): ?>
      Swal.fire({ icon: 'success', title: 'Login Berhasil', text: '<?= htmlspecialchars($loginSuccess, ENT_QUOTES) ?>', confirmButtonColor: '#22c55e' });
    <?php endif; ?>

    // Script untuk notifikasi hasil simpan artikel
    <?php if ($formMessage): ?>
      Swal.fire({ icon: '<?= $formMessageType ?>', title: '<?= ($formMessageType === "success") ? "Berhasil" : "Gagal" ?>', text: '<?= htmlspecialchars($formMessage, ENT_QUOTES) ?>', confirmButtonColor: '<?= ($formMessageType === "success") ? "#22c55e" : "#ef4444" ?>' });
    <?php endif; ?>

    // Script untuk kontrol Modal
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const formModal = document.getElementById('formModal');

    const openModal = () => formModal.classList.remove('invisible', 'opacity-0', 'scale-95');
    const closeModal = () => formModal.classList.add('invisible', 'opacity-0', 'scale-95');

    // PENTING: Hanya tambahkan event listener jika tombolnya ada (saat sudah login)
    if (openModalBtn) {
      openModalBtn.addEventListener('click', openModal);
    }

    closeModalBtn.addEventListener('click', closeModal);

    formModal.addEventListener('click', (event) => {
      if (event.target === formModal) {
        closeModal();
      }
    });

    // Script untuk konfirmasi logout
    document.addEventListener('click', function (event) {
      // Cek apakah elemen yang diklik memiliki kelas 'logout-btn'
      if (event.target.classList.contains('logout-btn')) {

        // 1. Mencegah link berjalan secara otomatis
        event.preventDefault();

        const logoutUrl = event.target.href;

        // 2. Tampilkan dialog konfirmasi SweetAlert
        Swal.fire({
          title: 'Anda yakin ingin logout?',
          text: "Anda akan keluar dari sesi login ini.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6e7881',
          confirmButtonText: 'Ya, logout!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          // 3. Jika pengguna mengklik "Ya, logout!"
          if (result.isConfirmed) {
            // Arahkan ke URL logout
            window.location.href = logoutUrl;
          }
        });
      }
    });
  </script>
</body>

</html>