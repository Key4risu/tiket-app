<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Lupa Password - TiketKu</title>
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
        .password-display {
            margin-top: 15px;
            padding: 10px;
            background-color: #222;
            border-radius: 5px;
            word-break: break-all;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2 class="text-center mb-4">Lupa Password</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['display_password'])): ?>
        <div class="password-display">
            <strong>Password Anda:</strong> <?= htmlspecialchars($_SESSION['display_password']); ?>
        </div>
        <?php unset($_SESSION['display_password']); ?>
    <?php endif; ?>

    <form action="proses_lupa_password.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Masukkan Email Akun Anda</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus />
        </div>
        <button type="submit" class="btn btn-primary w-100">Tampilkan Password</button>
    </form>

    <div class="mt-3 text-center">
        <a href="login.php" class="text-info">Kembali ke Login</a>
    </div>
</div>
</body>
</html>
