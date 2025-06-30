<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $jenis_tiket = $_POST['jenis_tiket']; // Harusnya "KAI Lokal"
    $route = $_POST['route'] ?? '';
    $jumlah = intval($_POST['jumlah']);
    $harga = intval($_POST['harga']);
    $tanggal = $_POST['tanggal_pesan'];

    // Map route to asal and tujuan
    $routeMap = [
        "KA Lokal Merak" => ["Merak", "Jakarta Kota"], // Example mapping, adjust as needed
    ];

    if (!isset($routeMap[$route])) {
        $_SESSION['error'] = "Jalur KAI Lokal tidak valid.";
        header("Location: pesan_kai_lokal.php");
        exit;
    }

    $asal = $routeMap[$route][0];
    $tujuan = $routeMap[$route][1];

    if ($jumlah <= 0 || $harga < 0 || empty($tanggal)) {
        $_SESSION['error'] = "Semua field harus diisi dengan benar.";
        header("Location: pesan_kai_lokal.php");
        exit;
    }

    $stmt = $koneksi->prepare("INSERT INTO pemesanan (user_id, jenis_tiket, asal, tujuan, jumlah, harga, tanggal_pesan) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiis", $user_id, $jenis_tiket, $asal, $tujuan, $jumlah, $harga, $tanggal);

    if ($stmt->execute()) {
        if (!isset($_SESSION['order_ids'])) {
            $_SESSION['order_ids'] = [];
        }
        $_SESSION['order_ids'][] = $koneksi->insert_id;
        header("Location: pilihan_setelah_pesan.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal menyimpan data.";
        header("Location: pesan_kai_lokal.php");
        exit;
    }

    $stmt->close();
}
?>
