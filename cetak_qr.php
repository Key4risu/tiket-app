<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "config.php";

$order_ids = $_GET['order_ids'] ?? $_SESSION['order_ids'] ?? null;

if (!$order_ids) {
    echo "ID tiket tidak ditemukan.";
    exit;
}

if (is_array($order_ids)) {
    $order_ids_array = $order_ids;
} else {
    $order_ids_array = explode(',', $order_ids);
}

// Prepare placeholders for query
$placeholders = implode(',', array_fill(0, count($order_ids_array), '?'));

// Prepare statement to get all orders
$sql = "SELECT p.*, u.nama FROM pemesanan p JOIN users u ON p.user_id = u.id WHERE p.id IN ($placeholders)";
$stmt = $koneksi->prepare($sql);

$types = str_repeat('i', count($order_ids_array));
$stmt->bind_param($types, ...$order_ids_array);
$stmt->execute();
$result = $stmt->get_result();

$tickets = [];
while ($row = $result->fetch_assoc()) {
    $tickets[] = $row;
}

if (empty($tickets)) {
    echo "Data tiket tidak ditemukan.";
    exit;
}

// Build combined QR data string
$qrDataParts = [];
if (is_array($tickets) && count($tickets) > 0) {
    foreach ($tickets as $tiket) {
        $qrDataParts[] = "Tiket {$tiket['jenis_tiket']} - ID: {$tiket['id']}, Pemesan: {$tiket['nama']}, Dari: {$tiket['asal']} ke {$tiket['tujuan']}, Jumlah: {$tiket['jumlah']}, Tanggal: {$tiket['tanggal_pesan']}";
    }
    $qrData = implode("\n---\n", $qrDataParts);
} else {
    $qrData = "";
}

// Encode data for URL
$qrDataEncoded = urlencode($qrData);
// Use goqr.me API to generate QR code
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=280x280&data={$qrDataEncoded}";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tiket Berhasil Dipesan - LOCAMU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: url('BJIR-1.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card-container {
            background-color: rgba(10, 10, 10, 0.85);
            border-radius: 30px;
            padding: 40px 40px 50px 40px;
            width: 320px;
            text-align: center;
            box-shadow: 0 0 40px #00bfff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card-container h2 {
            color: #00bfff;
            font-weight: 900;
            margin-bottom: 20px;
            font-size: 26px;
            text-shadow: 0 0 12px #00bfff;
        }
        .instruction {
            font-size: 16px;
            margin-bottom: 30px;
            color: #bbb;
        }
        .qr-code {
            background-color: white;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 0 25px rgba(0, 191, 255, 0.8);
            width: 260px;
            height: 260px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }
        .qr-code img {
            border-radius: 10px;
            width: 240px;
            height: 240px;
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.7);
        }
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 25px;
            width: 100%;
        }
        .btn-download, .btn-back {
            flex: 1;
            padding: 16px 0;
            font-weight: 800;
            font-size: 1.2rem;
            border-radius: 15px;
            border: none;
            cursor: pointer;
            transition: background-color 0.4s ease, box-shadow 0.4s ease;
            text-decoration: none;
            color: black;
            user-select: none;
            box-shadow: 0 0 20px #00bfff;
        }
        .btn-download {
            background-color: #00bfff;
        }
        .btn-download:hover {
            background-color: #0086c9;
            color: white;
            box-shadow: 0 0 30px #0086c9;
        }
        .btn-back {
            background-color: #444;
            color: white;
            box-shadow: 0 0 20px #444;
        }
        .btn-back:hover {
            background-color: #222;
            box-shadow: 0 0 30px #222;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="card-container" role="main" aria-label="Tiket berhasil dipesan">
        <h2>🎫 Tiket Berhasil Dipesan</h2>
        <div class="instruction">Silakan simpan atau cetak tiket berikut:</div>
        <div class="qr-code" role="img" aria-label="Kode QR tiket">
            <img src="<?= $qrUrl ?>" alt="QR Code tiket" width="280" height="280" />
        </div>
        <div class="btn-group">
            <a href="<?= $qrUrl ?>" download="tiket_combined.png" class="btn-download" target="_blank" rel="noopener noreferrer" role="button" aria-label="Unduh Tiket">Unduh Tiket</a>
            <a href="dashboard.php" class="btn-back" role="button" aria-label="Kembali ke Dashboard">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
