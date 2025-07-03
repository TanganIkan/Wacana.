<?php
include_once("../php/connection.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link rel="stylesheet" href="../public/css/output.css" />
  <title>Home</title>
</head>

<body class="bg-[#faf2ef] max-w-7xl mx-auto">
  <nav
    class="relative flex items-center justify-between px-6 py-3 my-3 bg-white border border-black xl:mx-0 mx-10">
    <h1 class="text-xl font-bold uppercase">www</h1>

      <a  href="./form.php"
        class="bg-[#ae7aff] text-white py-2 px-4 capitalize border-black border hover:shadow-[3px_3px_0_0_black] font-semibold duration-200">
        Tambah Artikel
      </a>
    </div>
  </nav>

  <main class=" xl:mx-0 mx-10">
    <section class="mb-4">
      <?php
      $data = $datas[5];
      ?>

      <a href="" class="block">
        <div class="relative border overflow-hidden h-[31.25rem]">
          <img
            src="<?= $data["cover_image"] ?>"
            alt="<?= $data["title"] ?>"
            class="aspect-video object-cover w-full" />

          <div class="absolute bottom-0 left-0 w-full h-56 bg-gradient-to-t from-black/90 to-transparent pointer-events-none"></div>

          <div class="absolute bottom-0 p-4 text-white w-full">
            <span class="bg-black/70 text-white py-1 px-3 text-xs inline-block rounded mb-2">
              <?= $data["category"] ?>
            </span>
            <h1 class="font-semibold text-xl leading-tight line-clamp-2 capitalize"><?= $data["title"] ?></h1>
            <p class="text-sm opacity-80 line-clamp-2"><?= $data["content"] ?></p>
            <span class="text-xs opacity-70 block mt-1">
              <?= date('d M Y', strtotime($data["created_at"])) ?>
            </span>
          </div>
        </div>
      </a>

      
    </section>

    <section>
      <div
        class="grid-cols-4 md:grid-cols-3 grid gap-5">
        <?php
        foreach ($datas as $data) {
        ?>
          <a href="#" class="border bg-white hover:shadow-[4px_4px_0_0_black] duration-200 hover:scale-[101%]">
            <img
              src="<?= $data["cover_image"] ?>"
              alt="" <?= $data["title"] ?>"
              class="aspect-video object-cover border-b" />
            <div class="h-full flex flex-col justify-between p-2.5 gap-2.5">
              <div>
                <span class="bg-black text-white py-1 px-4 capitalize text-xs inline-block border-black border mb-2.5">
                  <?= $data["category"] ?>
                </span>
                <h1 class="font-semibold text-base capitalize"><?= $data["title"] ?></h1>
                <p class="text-md opacity-50 line-clamp-2">
                  <?= $data["content"] ?>
                </p>
                <span class="text-xs">
                  <?= date('d M Y', strtotime($data["created_at"])) ?>
                </span>
              </div>
            </div>
          </a>
        <?php } ?>
      </div>

      <button
        class="border w-full mx-auto my-10 block py-3 hover:shadow-[4px_4px_0_0_black] duration-200 font-semibold capitalize bg-white">
        Tampilkan Lebih Banyak
      </button>
    </section>
  </main>

</body>

</html>

