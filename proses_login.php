<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Ambil data user berdasarkan email
    $stmt = $koneksi->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Jika email ditemukan
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Login berhasil
            $_SESSION['user_id'] = $user_id;
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah.";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
        header("Location: login.php");
        exit;
    }

    $stmt->close();
}
?>
