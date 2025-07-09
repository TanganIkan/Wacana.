<?php
session_start();

$registerSuccess = '';
if (isset($_SESSION['register_success'])) {
  $registerSuccess = $_SESSION['register_success'];
  unset($_SESSION['register_success']);
}

$errors = [
  'login' => $_SESSION['login_error'] ?? '',
];

$activeForm = $_SESSION['active_form'] ?? 'login';

unset($_SESSION['login_error'], $_SESSION['active_form']);

function isActiveForm($formName, $activeForm)
{
  return $formName === $activeForm ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Page</title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link rel="stylesheet" href="../public/css/output.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: "Inter", sans-serif;
    }
  </style>
</head>

<body class="bg-[#d9d9d9] min-h-screen flex flex-col">
  <header class="flex justify-between items-center px-6 py-4">
    <!-- Header content if any -->
  </header>

  <main class="flex-grow flex justify-center items-center px-4 relative overflow-hidden">
    <!-- Background decorations (only show on large screens) -->
    <div aria-hidden="true" class="hidden lg:flex absolute inset-0 justify-between items-center pointer-events-none">
      <!-- Left images -->
      <div class="relative w-1/3 h-[80%] flex justify-center">
        <img src="./public/assets/11.webp" alt="img 11" class="absolute right-[-70px] top-[70px] w-[390px]" />
        <img src="./public/assets/12.webp" alt="img 12" class="absolute left-[-20px] top-[200px] w-[390px]" />
        <img src="./public/assets/garis1.webp" alt="garis"
          class="absolute right-[-35px] top-[150px] w-[200px] h-[250px] opacity-50 -z-10" />
        <img src="./public/assets/garis1.webp" alt="garis"
          class="absolute right-[160px] top-[150px] w-[200px] h-[250px] opacity-50 -z-10" />
        <img src="./public/assets/garis1.webp" alt="garis"
          class="absolute right-[350px] top-[150px] w-[200px] h-[250px] opacity-50 -z-10" />
      </div>

      <!-- Right images -->
      <div class="relative w-1/3 h-[80%] flex justify-center">
        <img src="./public/assets/21.webp" alt="img 21" class="absolute right-[40px] top-[-10px] w-[390px]" />
        <img src="./public/assets/22.webp" alt="img 22" class="absolute right-[300px] top-[210px] w-[390px]" />
        <img src="./public/assets/3.webp" alt="pesawat" class="absolute right-[250px] top-[1px] w-[390px]" />
        <img src="./public/assets/garis1.webp" alt="garis"
          class="absolute right-[-35px] top-[150px] w-[200px] h-[250px] opacity-50 -z-10" />
        <img src="./public/assets/garis1.webp" alt="garis"
          class="absolute right-[160px] top-[150px] w-[200px] h-[250px] opacity-50 -z-10" />
        <img src="./public/assets/garis1.webp" alt="garis"
          class="absolute right-[350px] top-[150px] w-[200px] h-[250px] opacity-50 -z-10" />
      </div>
    </div>

    <!-- SVG wave background -->
    <div aria-hidden="true" class="absolute inset-0 flex justify-center items-center pointer-events-none -z-10">
      <svg class="w-full max-w-md h-48" fill="none" stroke="#b3b3b3" stroke-linecap="round" stroke-linejoin="round"
        stroke-width="1" viewBox="0 0 320 80" preserveAspectRatio="none">
        <path
          d="M0 20c20 0 20 20 40 20s20-20 40-20 20 20 40 20 20-20 40-20 20 20 40 20 20-20 40-20 20 20 40 20 20-20 40-20v40H0z" />
        <path
          d="M0 40c20 0 20 20 40 20s20-20 40-20 20 20 40 20 20-20 40-20 20 20 40 20 20-20 40-20 20 20 40 20 20-20 40-20v40H0z"
          transform="translate(0,20)" />
        <path
          d="M0 60c20 0 20 20 40 20s20-20 40-20 20 20 40 20 20-20 40-20 20 20 40 20 20-20 40-20 20 20 40 20 20-20 40-20v40H0z"
          transform="translate(0,40)" />
      </svg>
    </div>

    <!-- Login Form Card -->
    <div id="login-form" <?= isActiveForm('login', $activeForm); ?>
      class="relative w-full max-w-md bg-gradient-to-b from-white to-[#f7f7f7] rounded-sm p-8 shadow-2xl z-10 border border-black">
      <h1 class="text-center text-[22px] font-semibold text-black mb-2">Login</h1>
      <p class="text-center text-[15px] text-gray-600 mb-4">Masukkan detail untuk melakukan login</p>
      <form class="space-y-5" action="login-regis.php" method="post">
        <div>
          <label for="email" class="block text-[12px] font-semibold text-black mb-1">Email*</label>
          <input id="email" name="email" type="email" placeholder="Masukkan email" autocomplete="email"
            class="w-full rounded-xm border border-black px-3 py-2 text-[14px] text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300" />
        </div>

        <div>
          <label for="password" class="block text-[12px] font-semibold text-black mb-1">Password*</label>
          <input id="password" name="password" type="password" placeholder="Masukkan password"
            autocomplete="current-password"
            class="w-full rounded-sm border border-black px-3 py-2 text-[14px] text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-300" />
        </div>

        <p class="text-[10px] text-black max-w-[280px]">
          Informasi ini akan disimpan dengan aman sesuai dengan
          <strong>Ketentuan Layanan</strong>
          <a href="#" class="underline font-semibold">Kebijakan Privasi</a>
        </p>

        <div class="mt-6 flex flex-col sm:flex-row sm:space-x-4 space-y-3 sm:space-y-0">
          <!-- Tombol -->
          <button type="button" onclick="goToRegister()"
            class="border border-black rounded-sm px-6 py-2 text-[14px] font-semibold text-black hover:bg-gray-100 w-full sm:w-auto shadow-[3px_3px_0px_0px_black] transition duration-300 ease-in-out">
            Belum memiliki akun?
          </button>

          <!-- Script -->
          <script>
            function goToRegister() {
              // Tambahkan kelas animasi fade-out ke body
              document.body.classList.add("fade-out");

              // Setelah animasi selesai (300ms), redirect ke register.php
              setTimeout(() => {
                window.location.href = "register.php";
              }, 300);
            }
          </script>

          <!-- CSS Transisi -->
          <style>
            body.fade-out {
              opacity: 0;
              transition: opacity 0.3s ease-in-out;
            }
          </style>

          <button type="submit" name="login"
            class="bg-yellow-300 rounded-sm border border-black px-8 py-2 text-[14px] font-semibold text-black hover:brightness-90 w-full sm:w-auto shadow-[3px_3px_0px_0px_black]">Login</button>
        </div>
      </form>
    </div>
  </main>
  <?php if ($registerSuccess): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Registration Successful',
        text: '<?= htmlspecialchars($registerSuccess, ENT_QUOTES) ?>',
        draggable: true
      });
    </script>
  <?php endif; ?>

  <?php if (!empty($errors['login'])): ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: '<?= htmlspecialchars($errors['login'], ENT_QUOTES) ?>',
        confirmButtonColor: '#ef4444'
      });
    </script>
  <?php endif; ?>
</body>

</html>