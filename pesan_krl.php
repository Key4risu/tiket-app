<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Pesan Tiket KRL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        html, body {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('KRL-14.jpg') no-repeat center center fixed !important;
            background-size: cover !important;
            color: white !important;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        body {
            padding-top: 0 !important;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background-color: rgba(31, 31, 31, 0.8) !important;
            padding: 30px;
            border-radius: 10px;
            box-shadow: none !important;
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
        <h2 class="text-center mb-4">Form Pemesanan Tiket KRL</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form id="pesanKrlForm" method="POST" action="proses_pesan_krl.php">
            <input type="hidden" name="jenis_tiket" value="KRL" />
            <div class="mb-3">
                <label for="route" class="form-label">Pilih Jalur KRL</label>
                <select class="form-control" id="route" name="route" required>
                    <option value="" disabled selected>Pilih jalur</option>
                    <option value="Bogor-Jakarta Kota">Bogor – Jakarta Kota</option>
                    <option value="Bekasi-Jakarta Kota">Bekasi – Jakarta Kota (via Manggarai)</option>
                    <option value="Rangkasbitung-Tanah Abang">Rangkasbitung – Tanah Abang</option>
                    <option value="Tangerang-Duri">Tangerang – Duri</option>
                    <option value="Cikarang-Jakarta Kota">Cikarang – Jakarta Kota</option>
                </select>
                <small id="stations" style="color: #ccc; display: block; margin-top: 5px;"></small>
                <small style="color: red; display: block; margin-top: 5px; font-size: 1rem;">Hindari stasiun ramai untuk mempermudah perjalanan</small>
            </div>

            <div class="mb-3" style="display:none;">
                <label for="asal" class="form-label">Stasiun Asal</label>
                <input type="text" class="form-control" id="asal" name="asal" required />
            </div>
            <div class="mb-3" style="display:none;">
                <label for="tujuan" class="form-label">Stasiun Tujuan</label>
                <input type="text" class="form-control" id="tujuan" name="tujuan" required />
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Tiket</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="1" required />
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga per Tiket</label>
                <input type="number" class="form-control" id="harga" name="harga" value="5000" min="0" required />
            </div>

            <div class="mb-3">
                <label>Total Harga:</label>
                <div id="totalHarga" style="font-weight: bold; font-size: 1.2rem;">Rp 0</div>
            </div>

            <div class="mb-3">
                <label for="tanggal_pesan" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" min="<?= date('Y-m-d') ?>" required />
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary" id="pesanTiketBtn">Pesan Tiket</button>
                <a href="dashboard.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <script>
        const stationsMap = {
            "Bogor-Jakarta Kota": "Stasiun penting: Bogor, Cilebut, Depok, Manggarai, Gondangdia, Jakarta Kota",
            "Bekasi-Jakarta Kota": "Stasiun penting: Bekasi, Jatinegara, Manggarai, Sudirman, Juanda, Jakarta Kota",
            "Rangkasbitung-Tanah Abang": "Stasiun penting: Rangkasbitung, Maja, Parungpanjang, Serpong, Palmerah, Tanah Abang",
            "Tangerang-Duri": "Stasiun penting: Tangerang, Batu Ceper, Grogol, Duri",
            "Cikarang-Jakarta Kota": "Stasiun penting: Cikarang, Tambun, Bekasi, Jatinegara, Manggarai, Jakarta Kota"
        };

        const routeSelect = document.getElementById('route');
        const stationsInfo = document.getElementById('stations');
        const asalInput = document.getElementById('asal');
        const tujuanInput = document.getElementById('tujuan');

        routeSelect.addEventListener('change', function() {
            stationsInfo.textContent = stationsMap[this.value] || '';

            // Map route to asal and tujuan
            const route = this.value;
            switch(route) {
                case "Bogor-Jakarta Kota":
                    asalInput.value = "Bogor";
                    tujuanInput.value = "Jakarta Kota";
                    break;
                case "Bekasi-Jakarta Kota":
                    asalInput.value = "Bekasi";
                    tujuanInput.value = "Jakarta Kota";
                    break;
                case "Rangkasbitung-Tanah Abang":
                    asalInput.value = "Rangkasbitung";
                    tujuanInput.value = "Tanah Abang";
                    break;
                case "Tangerang-Duri":
                    asalInput.value = "Tangerang";
                    tujuanInput.value = "Duri";
                    break;
                case "Cikarang-Jakarta Kota":
                    asalInput.value = "Cikarang";
                    tujuanInput.value = "Jakarta Kota";
                    break;
                default:
                    asalInput.value = "";
                    tujuanInput.value = "";
            }
        });

        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateTotalHarga() {
            const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
            const harga = parseInt(document.getElementById('harga').value) || 0;
            const total = jumlah * harga;
            document.getElementById('totalHarga').textContent = formatRupiah(total);
        }

        document.getElementById('jumlah').addEventListener('input', updateTotalHarga);
        document.getElementById('harga').addEventListener('input', updateTotalHarga);

        // Initialize total harga on page load
        updateTotalHarga();
    </script>
</body>
</html>
