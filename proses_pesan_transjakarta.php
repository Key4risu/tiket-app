<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $jenis_tiket = $_POST['jenis_tiket']; // harus "TransJakarta"
    $asal = $_POST['asal'];
    $tujuan = $_POST['tujuan'];
    $jumlah = intval($_POST['jumlah']);
    $harga = intval($_POST['harga']);
    $tanggal = $_POST['tanggal_pesan'];

    // Validasi input
    if ($jumlah <= 0 || $harga < 0 || empty($jenis_tiket) || empty($asal) || empty($tujuan) || empty($tanggal)) {
        $_SESSION['error'] = "Semua field harus diisi dengan benar.";
        header("Location: pesan_transjakarta.php");
        exit;
    }

    // Simpan ke database
    $stmt = $koneksi->prepare("INSERT INTO pemesanan (user_id, jenis_tiket, asal, tujuan, jumlah, harga, tanggal_pesan) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiis", $user_id, $jenis_tiket, $asal, $tujuan, $jumlah, $harga, $tanggal);

    if ($stmt->execute()) {
        if (!isset($_SESSION['order_ids'])) {
            $_SESSION['order_ids'] = [];
        }
        $_SESSION['order_ids'][] = $koneksi->insert_id;

        // Redirect ke pilihan_setelah_pesan.php
        header("Location: pilihan_setelah_pesan.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal memesan tiket.";
        header("Location: pesan_transjakarta.php");
        exit;
    }

    $stmt->close();
}
?>
