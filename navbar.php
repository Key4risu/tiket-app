<nav class="navbar-custom">
    <div class="navbar-left">
        <a href="dashboard.php" class="logo-link" aria-label="Home">
            <img src="WhatsApp_Image_2025-04-17_at_20.58.28__1_-removebg-preview (1).png" alt="Logo" style="height: 40px;">
        </a>
        <a href="list_options.php">Pesan Tiket</a>
        <a href="riwayat_pemesanan.php">Riwayat Pesanan</a>
    </div>
    <div class="navbar-right">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="login.php">Login / Register</a>
        <?php else: ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </div>
</nav>

<div id="page-transition-overlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('page-transition-overlay');
    overlay.style.transition = 'opacity 0.5s ease';
    overlay.style.opacity = '0';

    // Fade out overlay on page load
    window.onload = () => {
        overlay.style.opacity = '0';
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 500);
    };

    // Attach click event to all internal links
    document.querySelectorAll('a[href]').forEach(link => {
        const url = new URL(link.href, window.location.origin);
        if (url.origin === window.location.origin) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                overlay.style.display = 'block';
                overlay.style.opacity = '1';
                setTimeout(() => {
                    window.location.href = link.href;
                }, 500);
            });
        }
    });
});
</script>

<style>
    .navbar-custom {
        background-color: #000000;
        padding: 10px 20px;
        margin-top: 0;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: Arial, sans-serif;
        box-shadow: 0 2px 4px rgba(0,0,0,0.5);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
    }
    .navbar-custom a {
        color: white;
        text-decoration: none;
        margin-right: 20px;
        font-weight: 600;
        font-size: 1rem;
    }
    .navbar-custom a:hover {
        text-decoration: underline;
    }
    .navbar-left {
        display: flex;
        align-items: center;
    }
    .navbar-left a.logo-link {
        margin-right: 25px;
        display: flex;
        align-items: center;
    }
    .navbar-left a.logo-link img {
        height: 40px;
        vertical-align: middle;
    }
    .navbar-right a {
        font-weight: 600;
        font-size: 1rem;
    }
    #page-transition-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: black;
        opacity: 0;
        display: none;
        z-index: 1050;
        pointer-events: none;
    }
</style>
