<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Form Input Artikel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/css/output.css" />
</head>

<body class="bg-gradient-to-br from-blue-50 to-purple-100 min-h-screen flex items-center justify-center px-4">
  <div class="w-full max-w-2xl bg-white p-8 rounded-xl shadow-lg space-y-6">
    <h2 class="text-3xl font-bold text-center text-gray-800">Tambah Artikel</h2>

    <!-- Flash Message -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="p-4 bg-green-100 text-green-700 border border-green-300 rounded">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>
    <?php elseif (isset($_SESSION['error'])): ?>
      <div class="p-4 bg-red-100 text-red-700 border border-red-300 rounded">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <form action="simpan_artikel.php" method="POST" enctype="multipart/form-data" class="space-y-5">
      <!-- Judul Artikel -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1" for="title">Judul Artikel</label>
        <input type="text" name="title" id="title" required
          class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" />
      </div>

      <!-- Kategori Artikel -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1" for="category">Kategori Artikel</label>
        <input type="text" name="category" id="category" required
          class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" />
      </div>

      <!-- Isi Artikel -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1" for="content">Isi Artikel</label>
        <textarea name="content" id="content" rows="6" required
          class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm resize-none"></textarea>
      </div>

      <!-- Upload Foto -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1" for="foto">Upload Foto</label>
        <input type="file" name="foto" id="foto" accept="image/*" required
          class="w-full border border-gray-300 p-2 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" />
      </div>

      <!-- Tombol Submit -->
      <div>
        <button type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200">
          Simpan Artikel
        </button>
      </div>
    </form>

    <!-- Tombol Navigasi -->
    <div class="text-center">
      <a href="./index.php"
        class="inline-block bg-purple-500 hover:bg-purple-600 text-white py-2 px-6 rounded-lg font-semibold shadow transition duration-200">
        Kembali ke Daftar Artikel
      </a>
    </div>
  </div>
</body>

</html>
