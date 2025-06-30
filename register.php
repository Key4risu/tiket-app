<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - TiketKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('Transjakarta articulated buses at Harmoni Central Busway, Central Jakarta, Indonesia_ 1 May 2016 (1).jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            margin-top: 0;
            max-width: 400px;
            background-color: rgba(30, 30, 30, 0.8);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Daftar Akun</h2>
    <form action="proses_register.php" method="post">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Daftar</button>
        <div class="mt-3 text-center">
            <a href="login.php" class="text-info">Sudah punya akun? Masuk</a>
        </div>
    </form>
</div>

</body>
</html>
