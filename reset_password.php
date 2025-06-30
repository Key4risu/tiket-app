<?php
session_start();
include "config.php";

if (!isset($_GET['token'])) {
    $_SESSION['error'] = "Token reset password tidak ditemukan.";
    header("Location: login.php");
    exit;
}

$token = $_GET['token'];

// Cek token valid dan belum expired
$stmt = $koneksi->prepare("SELECT id FROM users WHERE token_reset = ? AND token_expiry > NOW()");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Token reset password tidak valid atau sudah kadaluarsa.";
    header("Location: login.php");
    exit;
}

$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Reset Password - TiketKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: url('Tayo💙 Trans Jakarta (1).jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            filter: brightness(0.8);
        }
        .container {
            max-width: 400px;
            background-color: rgba(30, 30, 30, 0.85);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2 class="text-center mb-4">Reset Password</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="proses_reset_password.php" method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" />
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" class="form-control" id="password" name="password" required autofocus />
            <div class="form-check mt-1">
                <input class="form-check-input" type="checkbox" id="showPassword" />
                <label class="form-check-label" for="showPassword">Tampilkan Password</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="password_confirm" class="form-label">Konfirmasi Password Baru</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required />
            <div class="form-check mt-1">
                <input class="form-check-input" type="checkbox" id="showPasswordConfirm" />
                <label class="form-check-label" for="showPasswordConfirm">Tampilkan Password</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        <div class="mt-3 text-center">
            <a href="login.php" class="text-info">Kembali ke Login</a>
        </div>
    </form>
    <script>
        document.getElementById('showPassword').addEventListener('change', function() {
            var pwd = document.getElementById('password');
            pwd.type = this.checked ? 'text' : 'password';
        });
        document.getElementById('showPasswordConfirm').addEventListener('change', function() {
            var pwdConfirm = document.getElementById('password_confirm');
            pwdConfirm.type = this.checked ? 'text' : 'password';
        });
    </script>
</div>
</body>
</html>
