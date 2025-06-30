<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - TiketKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('Tayo💙 Trans Jakarta (1).jpg') no-repeat center center fixed;
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
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2 class="text-center mb-4">Masuk Akun</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php elseif (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form action="proses_login.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                      <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                      <path d="M8 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
                    </svg>
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
        <div class="mt-3 text-center">
            <a href="register.php" class="text-info">Belum punya akun? Daftar</a>
        </div>
        <div class="mt-2 text-center">
            <a href="lupa_password.php" class="text-warning">Lupa Password?</a>
        </div>
    </form>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.innerHTML = '';
        if (type === 'password') {
            this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                      <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                      <path d="M8 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
                    </svg>`;
        } else {
            this.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                      <path d="M13.359 11.238l2.147 2.146-.708.708-2.147-2.146a8.06 8.06 0 0 1-4.501 1.31C3 13.256 0 8 0 8s1.655-2.72 4.168-4.487L1.354 1.187l.708-.708 12 12-.708.707-1.995-1.995zM11.297 9.14a3 3 0 0 0-4.243-4.243l4.243 4.243z"/>
                      <path d="M5.525 6.637a3 3 0 0 0 4.243 4.243l-4.243-4.243z"/>
                    </svg>`;
        }
    });
</script>
</body>
</html>
