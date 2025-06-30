<?php
session_start();
include "navbar.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>List Options</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: url('7000 22 & 23-12 (1).jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container-main {
            padding-top: 80px;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }
        .headline {
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .option-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
            justify-content: center;
        }
        .option-item {
            position: relative;
            cursor: pointer;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.7);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #1f1f1f;
            padding: 30px;
            width: 220px;
            height: 260px;
            text-align: center;
            justify-content: center;
        }
        .option-item:hover {
            transform: scale(1.05);
            box-shadow: 0 0 25px #00bfff;
        }
        .option-image {
            position: relative;
            width: 120px;
            height: 120px;
            flex-shrink: 0;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .option-image img.bg-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
            border-radius: 15px;
        }
        .option-image img.logo {
            position: static;
            width: 60px;
            height: auto;
            margin-top: 8px;
            object-fit: contain;
            pointer-events: none;
        }
        .option-label {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            user-select: none;
        }
        .option-label.lokal {
            font-family: 'Harabara', cursive;
            font-size: 1.2rem;
        }
    </style>
</head>
    <body>
        <div class="background-overlay"></div>

    <main class="container-main" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh;">
        <div class="headline" style="text-align: center; margin-bottom: 40px; color: white; font-family: 'Harabara', sans-serif;">Choose your favourite transportation<br>Track them now!</div>
        <div class="option-list">
            <a href="pesan_transjakarta.php" class="option-item" aria-label="Pesan Tiket TransJakarta" style="width: 440px; height: 320px; border-radius: 25px; flex-direction: column; justify-content: center; padding: 20px 30px;">
                <div class="option-image" style="background-image: url('Transjakarta Bus with Route Information__ (1).jpg'); background-size: cover; background-position: center; width: 400px; height: 200px; margin-bottom: 20px;">
                </div>
                <img src="bus_trans_jakarta-removebg-preview (1).png" alt="TransJakarta Logo" class="logo" style="width: 140px; height: auto; margin-bottom: 10px;" />
                <div class="option-label" style="font-size: 1.8rem;"></div>
            </a>
            <a href="pesan_krl.php" class="option-item" aria-label="Pesan Tiket KAI" style="width: 440px; height: 320px; border-radius: 25px; flex-direction: column; justify-content: center; padding: 20px 30px;">
                <div class="option-image" style="background-image: url('IMG_0261.jpg'); background-size: cover; background-position: center; width: 400px; height: 200px; margin-bottom: 20px;">
                </div>
                <img src="KAI Commuter Single Color White Version (1).png" alt="KAI Logo" class="logo" style="width: 140px; height: auto; margin-bottom: 10px;" />
                <div class="option-label" style="font-size: 1.8rem;"></div>
            </a>
            <a href="pesan_kai_lokal.php" class="option-item" aria-label="Pesan Tiket KAI Lokal" style="width: 440px; height: 320px; border-radius: 25px; flex-direction: column; justify-content: center; padding: 20px 30px;">
                <div class="option-image" style="background-image: url('CC203 02 03-1.jpg'); background-size: cover; background-position: center; width: 400px; height: 200px; margin-bottom: 20px;">
                </div>
                <img src="KAI Commuter Single Color White Version (1).png" alt="KAI Lokal Logo" class="logo" style="width: 140px; height: auto; margin-bottom: 10px;" />
                <div class="option-label lokal">Lokal</div>
            </a>
        </div>
    </main>
    </body>
    <style>
        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('7000 22 & 23-12 (1).jpg') no-repeat center center fixed;
            background-size: cover;
            filter: brightness(0.3);
            z-index: -1;
        }
    </style>
</html>
