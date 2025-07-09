# Proyek Website Artikel "Wacana"

Selamat datang di Wacana, sebuah platform artikel sederhana yang dibangun menggunakan PHP native dan MySQL. Proyek ini memungkinkan pengguna untuk mendaftar, membuat, dan mengelola artikel mereka sendiri, dengan sistem peran untuk admin dan pengguna biasa.

## ✨ Fitur Utama
* **Autentikasi Pengguna**: Sistem registrasi dan login yang aman menggunakan `password_hash`.
* **Manajemen Artikel (CRUD)**: Fungsionalitas penuh untuk membuat, membaca, mengedit, dan menghapus artikel.
* **Sistem Peran (Role)**:
    * **User/Author**: Hanya bisa mengelola artikel miliknya sendiri.
    * **Admin**: Bisa melihat dan mengelola semua artikel dari semua pengguna.
* **UI Neobrutalism**:
    * **Modal Interaktif**: Menambah dan mengedit artikel dilakukan melalui modal popup tanpa perlu me-refresh halaman (AJAX).
    * **Notifikasi Modern**: Semua notifikasi (sukses, error, konfirmasi) menggunakan SweetAlert2.
* **Homepage Dinamis**:
    * **Carousel**: Menampilkan artikel-artikel unggulan dalam bentuk slide otomatis.
    * **Pagination**: Membagi daftar artikel menjadi beberapa halaman agar website tetap cepat dan rapi.
* **Dashboard Admin**: Halaman khusus untuk admin melihat statistik website dan mengakses alat manajemen.

## 🛠️ Teknologi yang Digunakan
* **Backend**: PHP (Native)
* **Frontend**: HTML, Tailwind CSS, JavaScript (ES6+)
* **Database**: MySQL / MariaDB
* **Library**: SweetAlert2, Swiper.js

## 🚀 Cara Menjalankan Proyek
Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/nama-anda/nama-repo-anda.git](https://github.com/nama-anda/nama-repo-anda.git)
    cd nama-repo-anda
    ```
2.  **Setup Database**
    * Buka **phpMyAdmin** atau alat database lainnya.
    * Buat sebuah database baru, misalnya dengan nama `wacana_db`.
    * Pilih database yang baru dibuat, lalu klik tab **"Import"**.
    * Unggah dan impor file `.sql` yang sudah tersedia di dalam repository ini.

3.  **Konfigurasi Koneksi**
    * Buka file `php/connection.php`.
    * Sesuaikan nama database, username, dan password dengan konfigurasi server lokal Anda.
    ```php
    $servername = "localhost";
    $username = "root";
    $password = ""; // Sesuaikan jika ada password
    $dbname = "majalah"; // Sesuaikan dengan nama database Anda
    ```

4.  **Jalankan Server**
    * Gunakan server lokal seperti Laragon, XAMPP, atau WAMP
    * Arahkan browser Anda ke folder proyek, contohnya: `http://localhost/wacana/pages/index.php`.
      
## 📊 Struktur Database
Proyek ini menggunakan dua tabel utama:

#### `users`
Menyimpan data pengguna dan peran mereka.
* `id` (INT, Primary Key, AI)
* `name` (VARCHAR)
* `email` (VARCHAR, Unique)
* `password` (VARCHAR, Hashed)
* `role` (ENUM: 'admin', 'user')
* `created_at` (TIMESTAMP)

#### `articles`
Menyimpan semua konten artikel.
* `id` (INT, Primary Key, AI)
* `user_id` (INT, Foreign Key ke `users.id`)
* `title` (VARCHAR)
* `content` (TEXT)
* `category` (VARCHAR)
* `cover_image` (VARCHAR)
* `published_at` (TIMESTAMP)

---

Terima kasih telah melihat proyek ini!
