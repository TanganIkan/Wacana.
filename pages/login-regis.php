<?php
session_start();
include_once("../php/connection.php");

// REGISTER
if (isset($_POST['register'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $passwordRaw = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? ''; // Ambil konfirmasi password

    // 1. PERIKSA KECOCOKAN PASSWORD
    if ($passwordRaw !== $confirmPassword) {
        $_SESSION['register_error'] = "Konfirmasi password tidak cocok.";
        // Logika untuk redirect kembali dengan pesan error
        header("Location: register.php");
        exit();
    }

    // 2. Cek apakah email sudah ada (gunakan prepared statement)
    $sqlCheck = "SELECT id FROM users WHERE email = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        $_SESSION['register_error'] = "Email sudah terdaftar.";
        header("Location: register.php");
        exit();
    }
    $stmtCheck->close();

    // 3. Hash password
    $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

    // 4. Tetapkan role default secara otomatis
    $default_role = 'user';

    // 5. Masukkan pengguna baru ke database
    $sqlInsert = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ssss", $name, $email, $password, $default_role);

    if ($stmtInsert->execute()) {
        $_SESSION['register_success'] = "Registrasi berhasil! Silakan login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['register_error'] = "Terjadi kesalahan saat registrasi.";
        header("Location: register.php");
        exit();
    }
}

// LOGIN
if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 1. Gunakan Prepared Statement untuk keamanan
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // 2. Simpan informasi penting ke Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            $_SESSION['login_success'] = "Login successful!";

            // Arahkan berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: admin-dashboard.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        }
    }

    // Jika email tidak ditemukan atau password salah
    $_SESSION['login_error'] = "Invalid email or password";
    $_SESSION['active_form'] = 'login';
    $_SESSION['sweetalert'] = ['type' => 'error', 'message' => 'Invalid email or password'];
    header("Location: login.php");
    exit();
}
