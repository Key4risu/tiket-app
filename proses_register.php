<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Validasi sederhana
    if (empty($nama) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Semua field wajib diisi.";
        header("Location: register.php");
        exit;
    }

    // Cek apakah email sudah terdaftar
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email sudah digunakan.";
        header("Location: register.php");
        exit;
    }

    // Simpan pengguna baru
    $stmt = $koneksi->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil. Silakan login.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Registrasi gagal. Coba lagi.";
        header("Location: register.php");
        exit;
    }
}
?>
