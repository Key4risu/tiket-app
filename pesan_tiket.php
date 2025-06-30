<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil pesan error dari session jika ada
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000000;
            color: white;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            background-color: #1f1f1f;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

<div class="container">
    <h2>Pesan Tiket</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger mt-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php else: ?>
        <p class="mt-4">Terjadi kesalahan saat memproses permintaan Anda.</p>
    <?php endif; ?>

    <div class="btn-back">
        <a href="dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
