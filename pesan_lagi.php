<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$last_order_id = $_SESSION['last_order_id'] ?? null;
if (!$last_order_id) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Pesan Tiket Lagi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: url('peron.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
            padding: 40px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: rgba(31, 31, 31, 0.8);
            padding: 30px;
            border-radius: 10px;
        }
        a.btn {
            margin: 10px;
            width: 200px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Pesanan Berhasil!</h2>
        <p>Apakah Anda ingin memesan tiket transportasi lainnya?</p>
        <div>
            <a href="list_options.php" class="btn btn-primary">Pesan Tiket Lain</a>
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
        <div style="margin-top: 30px;">
            <a href="cetak_qr.php" class="btn btn-success">Lihat QR Code Pesanan</a>
        </div>
    </div>
</body>
</html>
