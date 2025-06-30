<?php
// Matikan semua error reporting untuk menghilangkan notice dan warning
error_reporting(0);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Tiket TransJakarta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('006188700_1662971924-Bus_Transjakarta_Kembali_Beroperasi_24_Jam-merdeka-6 (1).jpg') no-repeat center center fixed !important;
            background-size: cover !important;
            color: white !important;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        body {
            padding-top: 100px !important;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            max-width: 400px;
            margin: auto;
            background-color: #444444 !important;
            padding: 30px;
            border-radius: 10px;
            box-shadow: none !important;
            margin-top: 0 !important;
        }
        label {
            color: #ccc;
        }
        input, select, textarea {
            background-color: black !important;
            color: white !important;
            border: 1px solid #333 !important;
        }
        input::placeholder, textarea::placeholder {
            color: #888 !important;
        }
        .btn-primary {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }
        .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="form-container">
        <h2 class="text-center mb-4">Form Pemesanan Tiket TransJakarta</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="proses_pesan_transjakarta.php" method="POST">
            <input type="hidden" name="jenis_tiket" value="TransJakarta">

            <div class="mb-3">
                <label for="koridor" class="form-label">Pilih Koridor Transjakarta</label>
                <select class="form-control" name="koridor" id="koridor" required>
                    <option value="" disabled selected>Pilih koridor</option>
                    <option value="Koridor 1">Koridor 1 - Blok M – Kota</option>
                    <option value="Koridor 2">Koridor 2 - Pulogadung – Monas</option>
                    <option value="Koridor 3">Koridor 3 - Kalideres – Monas</option>
                    <option value="Koridor 4">Koridor 4 - Pulogadung – Galunggung</option>
                    <option value="Koridor 5">Koridor 5 - Kampung Melayu – Ancol</option>
                    <option value="Koridor 6">Koridor 6 - Ragunan – Galunggung</option>
                    <option value="Koridor 7">Koridor 7 - Kampung Rambutan – Kampung Melayu</option>
                    <option value="Koridor 8">Koridor 8 - Lebak Bulus – Pasar Baru</option>
                    <option value="Koridor 9">Koridor 9 - Pinang Ranti – Pluit</option>
                    <option value="Koridor 10">Koridor 10 - Tanjung Priok – PGC (Cililitan)</option>
                    <option value="Koridor 11">Koridor 11 - Kampung Melayu – Pulo Gebang</option>
                    <option value="Koridor 12">Koridor 12 - Tanjung Priok – Pluit</option>
                    <option value="Koridor 13">Koridor 13 - CBD Ciledug – Tegal Mampang</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="asal" class="form-label">Halte Asal</label>
                <select class="form-control" name="asal" id="asal" required>
                    <option value="" disabled selected>Pilih halte asal</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tujuan" class="form-label">Halte Tujuan</label>
                <select class="form-control" name="tujuan" id="tujuan" required>
                    <option value="" disabled selected>Pilih halte tujuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Tiket</label>
                <input type="number" class="form-control" name="jumlah" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga per Tiket</label>
                <input type="number" class="form-control" name="harga" value="3500" required readonly id="harga">
            </div>
            <div class="mb-3">
                <label>Total Harga:</label>
                <div id="totalHarga" style="font-weight: bold; font-size: 1.2rem;">Rp 0</div>
            </div>
            <div class="mb-3">
                <label for="tanggal_pesan" class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal_pesan" required id="tanggal_pesan">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Pesan Tiket</button>
                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
<script>
    const koridorHalteMap = {
        "Koridor 1": ["Blok M", "Senayan", "Bundaran HI", "Harmoni", "Kota"],
        "Koridor 2": ["Pulogadung", "Monas"],
        "Koridor 3": ["Kalideres", "Monas"],
        "Koridor 4": ["Pulogadung", "Galunggung"],
        "Koridor 5": ["Kampung Melayu", "Ancol"],
        "Koridor 6": ["Ragunan", "Galunggung"],
        "Koridor 7": ["Kampung Rambutan", "Cawang", "Kampung Melayu"],
        "Koridor 8": ["Lebak Bulus", "Pasar Baru"],
        "Koridor 9": ["Pinang Ranti", "Pluit"],
        "Koridor 10": ["Tanjung Priok", "PGC", "Cililitan"],
        "Koridor 11": ["Kampung Melayu", "Pulo Gebang"],
        "Koridor 12": ["Tanjung Priok", "Pluit"],
        "Koridor 13": ["CBD Ciledug", "Tegal Mampang"]
    };

    const koridorSelect = document.getElementById('koridor');
    const asalSelect = document.getElementById('asal');
    const tujuanSelect = document.getElementById('tujuan');

    function populateHalteOptions(halteSelect, options) {
        halteSelect.innerHTML = '<option value="" disabled selected>Pilih halte</option>';
        options.forEach(halte => {
            const option = document.createElement('option');
            option.value = halte;
            option.textContent = halte;
            halteSelect.appendChild(option);
        });
    }

    koridorSelect.addEventListener('change', () => {
        const selectedKoridor = koridorSelect.value;
        const halteOptions = koridorHalteMap[selectedKoridor] || [];
        populateHalteOptions(asalSelect, halteOptions);
        populateHalteOptions(tujuanSelect, halteOptions);
    });

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function updateTotalHarga() {
        const jumlah = parseInt(document.querySelector('input[name="jumlah"]').value) || 0;
        const harga = parseInt(document.querySelector('input[name="harga"]').value) || 0;
        const total = jumlah * harga;
        document.getElementById('totalHarga').textContent = formatRupiah(total);
    }

    document.querySelector('input[name="jumlah"]').addEventListener('input', updateTotalHarga);

    // Initialize total harga on page load
    updateTotalHarga();
</script>
</body>
</html>
