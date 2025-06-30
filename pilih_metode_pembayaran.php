<?php
session_start();

if (!isset($_SESSION['order_ids']) || empty($_SESSION['order_ids'])) {
    header("Location: dashboard.php");
    exit;
}

include "config.php";

$order_ids = $_SESSION['order_ids'];
$ids_placeholder = implode(',', array_fill(0, count($order_ids), '?'));

// Prepare statement to get total price
$sql = "SELECT SUM(harga * jumlah) AS total_harga FROM pemesanan WHERE id IN ($ids_placeholder)";
$stmt = $koneksi->prepare($sql);

$types = str_repeat('i', count($order_ids));
$stmt->bind_param($types, ...$order_ids);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_harga = $row['total_harga'] ?? 0;

$order_ids_str = implode(',', $order_ids);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Pilih Metode Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: url('7023 x 8618 JAKK.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .payment-option {
            display: inline-block;
            margin: 20px;
            cursor: pointer;
            border: 2px solid #808080;
            border-radius: 10px;
            padding: 20px;
            transition: border-color 0.3s ease;
            background-color: #808080;
        }
        .payment-option:hover {
            border-color: #00bfff;
        }
        .payment-option img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto 10px;
        }
        .btn-proceed {
            margin-top: 30px;
            padding: 10px 30px;
            font-size: 1.2rem;
            border-radius: 30px;
        }
        .total-price {
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <form method="GET" action="cetak_qr.php">
        <h2 style="font-family: 'Harabara', cursive; font-size: 3.5rem; letter-spacing: 0.28em;">Pilih Metode Pembayaran</h2>
        <div class="total-price">Total Harga: Rp <?= number_format($total_harga, 0, ',', '.') ?></div>
        <input type="hidden" name="order_ids" value="<?= htmlspecialchars($order_ids_str) ?>" />
        <input type="hidden" id="payment_method" name="payment_method" value="QRIS" />
        <div>
            <label class="payment-option" for="qris">
                <input type="radio" id="qris" name="payment" value="QRIS" checked style="display:none;" />
                <img src="bffc6618-b1d4-4df2-809f-27445a5a55b7.png" alt="QRIS" />
                QRIS
            </label>
            <label class="payment-option" for="gopay">
                <input type="radio" id="gopay" name="payment" value="Go-Pay" style="display:none;" />
                <img src="Logo GoPay (PNG-2160p) - FileVector69.png" alt="Go-Pay" />
                Go-Pay
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-proceed">Lanjutkan Pembayaran</button>
    </form>

    <script>
        const paymentRadios = document.querySelectorAll('input[name="payment"]');
        const paymentMethodInput = document.getElementById('payment_method');

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                paymentMethodInput.value = radio.value;
            });
        });
    </script>
</body>
</html>
