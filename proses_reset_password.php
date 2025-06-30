<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($password) || empty($password_confirm)) {
        $_SESSION['error'] = "Password dan konfirmasi password harus diisi.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit;
    }

    if ($password !== $password_confirm) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak sama.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit;
    }

$stmt = $koneksi->prepare("SELECT id, token_expiry FROM users WHERE token_reset = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Token reset password tidak valid atau sudah kadaluarsa.";
    header("Location: login.php");
    exit;
}

$user = $result->fetch_assoc();

$token_expiry = strtotime($user['token_expiry']);
$current_time = time();

if ($token_expiry < $current_time) {
    $_SESSION['error'] = "Token reset password tidak valid atau sudah kadaluarsa.";
    header("Location: login.php");
    exit;
}

    // Hash password baru
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Update password dan hapus token reset
    $updateStmt = $koneksi->prepare("UPDATE users SET password = ?, token_reset = NULL, token_expiry = NULL WHERE id = ?");
    $updateStmt->bind_param("si", $password_hash, $user['id']);
    $updateStmt->execute();

    $_SESSION['success'] = "Password berhasil direset. Silakan login dengan password baru Anda.";
    header("Location: login.php");
    exit;
}
?>
