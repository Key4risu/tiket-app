<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - LOCAMU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('BJIR-3.jpg') no-repeat center center fixed;
            background-size: cover;
            filter: brightness(0.6);
            z-index: -1;
        }
        nav.navbar-custom {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            font-weight: 600;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 10;
        }
        nav.navbar-custom a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        nav.navbar-custom a:hover {
            color: #00bfff;
        }
        .navbar-left {
            display: flex;
            align-items: center;
        }
        .navbar-left .logo-link {
            font-weight: 700;
            font-size: 1.5rem;
            color: white;
            text-decoration: none;
            margin-right: 40px;
        }
        main.container-main {
            padding-top: 80px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding-left: 50px;
            color: white;
        }
        .search-bar {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            padding: 10px 20px;
            width: 300px;
            border: none;
            color: black;
            font-size: 1rem;
            margin-bottom: 15px;
            backdrop-filter: blur(5px);
        }
        .headline {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .subheadline {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 40px;
        }
        .btn-contact {
            background-color: white;
            color: black;
            font-weight: 600;
            padding: 10px 25px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: fixed;
            bottom: 30px;
            right: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        .btn-contact:hover {
            background-color: #00bfff;
            color: white;
        }
        @media (max-width: 768px) {
            main.container-main {
                padding-left: 20px;
                align-items: center;
                text-align: center;
            }
            .search-bar {
                width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <?php include 'navbar.php'; ?>
    <main class="container-main" style="align-items: center; text-align: center;">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <video autoplay muted loop playsinline style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -1;">
                <source src="Untitled video - Made with Clipchamp (1).mp4" type="video/mp4" />
                Your browser does not support the video tag.
            </video>
        <?php else: ?>
            <div class="background" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: url('BJIR-3.jpg') no-repeat center center fixed; background-size: cover; filter: brightness(0.6); z-index: -1;"></div>
        <?php endif; ?>
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; width: 100%; padding-top: 0; padding-left: 0;">
            <img src="WhatsApp_Image_2025-04-17_at_20.58.28__1_-removebg-preview (1).png" alt="LOCAMU Logo" style="height: 160px; margin-bottom: 40px;" />
            <div style="display: flex; gap: 20px; justify-content: center; width: 100%;">
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="login.php" class="btn btn-primary btn-lg">Silahkan Login / Register</a>
                <?php else: ?>
                    <a href="list_options.php" class="btn btn-primary btn-lg">🚆 Pesan Tiket Sekarang</a>
                <?php endif; ?>
            </div>
        </div>
</main>
<div id="loginPopupContainer" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; flex-direction: column;">
    <iframe src="login_popup.html" style="border:none; width: 320px; height: 350px; border-radius: 8px;"></iframe>
    <button id="closeLoginPopup" style="margin-top: 10px; padding: 8px 16px; border: none; border-radius: 4px; background-color: #0d6efd; color: white; cursor: pointer;">Tutup</button>
</div>
    <button class="btn-contact" id="contactUsBtn">Contact us</button>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginBtn = document.getElementById('loginRegisterBtn');
            const loginPopupContainer = document.getElementById('loginPopupContainer');
            const closeLoginPopupBtn = document.getElementById('closeLoginPopup');
            const contactUsBtn = document.getElementById('contactUsBtn');

            // Show login popup if URL has ?registered=1
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('registered') === '1') {
                loginPopupContainer.style.display = 'flex';
            }

            if (loginBtn) {
                loginBtn.addEventListener('click', () => {
                    loginPopupContainer.style.display = 'flex';
                });
            }

            if (closeLoginPopupBtn) {
                closeLoginPopupBtn.addEventListener('click', () => {
                    loginPopupContainer.style.display = 'none';
                });
            }

            if (contactUsBtn) {
                contactUsBtn.addEventListener('click', () => {
                    window.location.href = 'https://wa.me/qr/NUZXJGNFBYGPF1';
                });
            }
        });
    </script>
</body>
</html>
