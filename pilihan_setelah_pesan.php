<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'pesan_lagi') {
            header("Location: list_options.php");
            exit;
        } elseif ($_POST['action'] === 'lanjut_bayar') {
            header("Location: pilih_metode_pembayaran.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Pilihan Setelah Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: url('RK8.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: rgba(31, 31, 31, 0.85);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
        }
        button {
            margin: 10px;
            width: 150px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Pemesanan Berhasil</h2>
        <p>Apakah Anda ingin memesan tiket lainnya atau melanjutkan ke pembayaran?</p>
        <form method="POST">
            <button type="submit" name="action" value="pesan_lagi" class="btn btn-primary">Pesan Tiket Lainnya</button>
            <button type="submit" name="action" value="lanjut_bayar" class="btn btn-success">Lanjutkan Pembayaran</button>
        </form>
    </div>
</body>
</html>
