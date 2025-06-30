<?php
ob_start();
session_start();
include "config.php";
require 'phpqrcode/qrlib.php';

if (!isset($_GET['id']) || !isset($_SESSION['user_id'])) {
    http_response_code(400);
    exit('Invalid request');
}

$order_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Ambil data pemesanan dari database
$stmt = $koneksi->prepare("SELECT * FROM pemesanan WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    exit('Tiket tidak ditemukan');
}

$tiket = $result->fetch_assoc();

// TEST: Gunakan data QR sederhana untuk isolasi masalah
$qrData = "TEST QR CODE DATA";

// Bersihkan buffer output sebelum mengirim header dan gambar
ob_clean();
header('Content-Type: image/png');
QRcode::png($qrData, null, QR_ECLEVEL_H, 8);
ob_end_flush();
exit;
?>
