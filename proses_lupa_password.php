<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (empty($email)) {
        $_SESSION['error'] = "Email harus diisi.";
        header("Location: lupa_password.php");
        exit;
    }

    // Cek apakah email terdaftar
    $stmt = $koneksi->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Email tidak ditemukan.";
        header("Location: lupa_password.php");
        exit;
    }

    $user = $result->fetch_assoc();

    // Generate token reset password
    $token = bin2hex(random_bytes(16));
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Simpan token dan expiry ke database
    $updateStmt = $koneksi->prepare("UPDATE users SET token_reset = ?, token_expiry = ? WHERE email = ?");
    $updateStmt->bind_param("sss", $token, $expiry, $email);
    $updateStmt->execute();

    // Buat link reset password
    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/reset_password.php?token=" . $token;

    // Tampilkan link reset password langsung ke user
    $_SESSION['success'] = "Link reset password Anda: <a href='" . htmlspecialchars($resetLink) . "'>" . htmlspecialchars($resetLink) . "</a>";

    header("Location: lupa_password.php");
    exit;
}
?>
