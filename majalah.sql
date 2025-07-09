-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2025 at 03:24 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `majalah`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `title`, `content`, `cover_image`, `published_at`, `created_at`, `updated_at`, `category`) VALUES
(45, 3, 'Ingat bintang iklan ini? kini ia sedang menekuni PHP agar terbeli lamborghini', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751854378_WhatsApp Image 2025-07-04 at 12.46.16_9c9c4345.jpg', '2025-07-07 10:12:58', '2025-07-07 02:12:58', '2025-07-07 02:20:15', 'Bisnis'),
(46, 3, 'Dikarenakan Sering Adu Nasib Saat Bercerita, Seorang Ardi Nekat Memakan Temannya', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751854979_WhatsApp Image 2025-07-04 at 12.48.16_75151e7d.jpg', '2025-07-07 10:22:59', '2025-07-07 02:22:59', '2025-07-07 02:22:59', 'Hiburan'),
(47, 3, 'Cara cepat Lulus Kuliah dan bikin skripsi pakai chatgpt', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751855072_WhatsApp Image 2025-07-04 at 12.56.19_ae808fff.jpg', '2025-07-07 10:24:32', '2025-07-07 02:24:32', '2025-07-07 02:24:32', 'Teknologi'),
(48, 3, 'Mereka pingsan, karena desak-desakan\\\' – Puluhan ribu pengangguran bersaing di bursa kerja', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751855115_WhatsApp Image 2025-07-04 at 13.01.36_6cfb226a.jpg', '2025-07-07 10:25:15', '2025-07-07 02:25:15', '2025-07-07 02:25:15', 'Lifestyle'),
(49, 3, 'Seorang artis perempuan terkenal viral karna masuk berita tv', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751855140_WhatsApp Image 2025-07-04 at 13.05.27_b9363e4e.jpg', '2025-07-07 10:25:40', '2025-07-07 02:25:40', '2025-07-07 02:25:40', 'Hiburan'),
(50, 3, 'alasan agar cowo tidak memanjangkan rambutnya agar tidak terjadi hal seperti ini', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751855169_WhatsApp Image 2025-07-04 at 13.08.57_1fff300b.jpg', '2025-07-07 10:26:09', '2025-07-07 02:26:09', '2025-07-07 02:26:09', 'Hiburan'),
(51, 3, 'Panda, Kalkun, dan Deretan Hewan Dengan IQ Terendah di Dunia', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751855198_WhatsApp Image 2025-07-06 at 20.19.30_e5cdb1a3.jpg', '2025-07-07 10:26:38', '2025-07-07 02:26:38', '2025-07-07 02:26:38', 'Edukasi'),
(52, 3, 'Mengapa Anak Zaman Dulu Lebih Pendek dibanding Sekarang?', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751855229_WhatsApp Image 2025-07-06 at 20.22.07_bec950d2.jpg', '2025-07-07 10:27:09', '2025-07-07 02:27:09', '2025-07-07 02:27:09', 'Edukasi'),
(53, 3, 'Daun Belimbing Jadi Incaran Negara Asing, Ini Khasiat Medisnya', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751855260_WhatsApp Image 2025-07-06 at 20.24.33_24a3d37f.jpg', '2025-07-07 10:27:40', '2025-07-07 02:27:40', '2025-07-07 02:27:40', 'Edukasi'),
(54, 3, 'disebut game anak anak, ternyata game kotak kotak ini bikin manusia birahi', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit expedita quod cumque harum, earum dolor alias maiores atque reiciendis. Nesciunt at hic architecto dolorum impedit ab molestias error soluta laboriosam enim blanditiis accusantium, iste, et ut? Modi, iste. Cupiditate consequuntur nisi optio placeat dolor dolorum adipisci sapiente, alias doloremque odit necessitatibus inventore eos quasi maiores deleniti perspiciatis eius aspernatur, officiis itaque eligendi culpa ipsum nulla, asperiores ipsa? Saepe ipsum natus voluptas repellat non ut nam dolorem, optio obcaecati fuga quibusdam consequatur porro cumque magnam inventore officia? Quaerat laborum exercitationem quia, minima quisquam eveniet iste architecto, animi aliquam culpa vero enim?', './public/assets/1751855289_WhatsApp Image 2025-07-06 at 20.49.16_08533dbf.jpg', '2025-07-07 10:28:09', '2025-07-07 02:28:09', '2025-07-07 02:28:09', 'Hiburan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'tuadi', 'tuadi@gmail.com', '$2y$10$MjyWuDSaR6JiHTvRSQJc9OlfG7xwX1ttQa3Vtsg9ZTvpICTQza9wK', 'user', '2025-07-03 15:00:38'),
(3, 'admin', 'admin@gmail.com', '$2y$10$0/ZfE.5gGfdIn3NSvO.YZujnmV0kVIu3zvkvFMsc40bfJobi3bBGa', 'admin', '2025-07-03 16:38:04'),
(5, 'adit', 'adit@gmail.com', '$2y$10$j9d/EzMZ4vLPOYg6QimD2.Air6jWb5R9CcDG0/uS1yx2WktMvT69O', 'user', '2025-07-06 12:53:56'),
(6, 'ardi', 'ardi@gmail.com', '$2y$10$ltMonNI8PFeaOmnGs2Bi8O.Ej9RJxXzmgaGSlnIV2TMVqK88tcp6m', 'user', '2025-07-07 02:55:11'),
(7, 'adit1', 'adit1@gmail.com', '$2y$10$qGjdygJnmW.IwuC8W6Z3b.LcwbShQ.V/g3dfABpjckY9ksEOQhF4K', 'user', '2025-07-07 09:20:59'),
(8, 'adit2', 'adit2@gmail.com', '$2y$10$DhgZJ36B6sCRsQv2BwGnCeZKy/4v9WI.f99k6gAeqQEGx8jsKw4Pa', 'user', '2025-07-07 09:36:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
