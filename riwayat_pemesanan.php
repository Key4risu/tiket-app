<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include "config.php";

$user_id = $_SESSION['user_id'];

$sql = "
SELECT 
    tanggal_pesan,
    GROUP_CONCAT(DISTINCT jenis_tiket) AS jenis_tiket_list,
    SUM(jumlah) AS total_jumlah,
    SUM(jumlah * harga) AS total_harga,
    MIN(id) AS min_id,
    MIN(asal) AS asal,
    MIN(tujuan) AS tujuan
FROM pemesanan
WHERE user_id = ?
GROUP BY tanggal_pesan
ORDER BY tanggal_pesan DESC
";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Riwayat Pemesanan - LOCAMU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body, html {
            margin: 0;
            padding: 20px;
            background: url('TM 7122 2.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background-color: rgba(31, 31, 31, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            color: #00bfff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1f1f1f;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #333;
            text-align: left;
        }
        th {
            background-color: #333;
        }
        tr:hover {
            background-color: #333;
        }
        a.btn-view {
            background-color: #00bfff;
            color: black;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        a.btn-view:hover {
            background-color: #009acd;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Riwayat Pemesanan Tiket</h2>
        <?php if ($result->num_rows === 0): ?>
            <p>Tidak ada riwayat pemesanan tiket.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Jenis Tiket</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Tanggal Berangkat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['min_id']) ?></td>
                        <td>
                            <?php
                            $jenis_tiket_array = explode(',', $order['jenis_tiket_list']);
                            if (count($jenis_tiket_array) > 1) {
                                echo "Rangkap transportasi";
                            } else {
                                echo htmlspecialchars($order['jenis_tiket_list']);
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($order['asal']) ?></td>
                        <td><?= htmlspecialchars($order['tujuan']) ?></td>
                        <td><?= htmlspecialchars($order['total_jumlah']) ?></td>
                        <td>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($order['tanggal_pesan']) ?></td>
                        <td>
                            <a href="cetak_qr.php?order_ids=<?= urlencode($order['min_id']) ?>" class="btn-view" target="_blank" rel="noopener noreferrer">Lihat Tiket</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
