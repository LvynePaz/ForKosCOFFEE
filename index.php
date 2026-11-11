<?php
session_start();
$userName =$_SESSION['user_name'] ?? 'Cikocut';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ForKos Coffee</title>
    <!-- Bootstrap 5 CDN & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="mobile-viewport-body">

    <div class="mobile-frame">
        <!-- Badge Identifikasi Mockup SDD UI-002 -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge-ui">UI-002</span>
            <a href="login.php" class="text-muted small text-decoration-none" style="font-size: 0.75rem;">Login</a>
        </div>

        <!-- Greeting Profil Pengguna -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <p class="text-muted mb-0" style="font-size: 0.8rem;">Selamat datang kembali !</p>
                <h4 class="fw-bold text-dark mb-0">Halo, <?= htmlspecialchars($userName) ?>!</h4>
            </div>
            <div class="avatar-circle">
                <i class="bi bi-person-fill text-white fs-4"></i>
            </div>
        </div>

        <!-- Menu Utama (3 Tombol Grid: Tanpa Favorit) -->
        <div class="mb-4">
            <p class="section-sub-title">MENU UTAMA</p>
            <div class="row g-2 text-center">
                <div class="col-4">
                    <a href="katalog.php" class="menu-item-btn active text-decoration-none">
                        <i class="bi bi-cup-hot fs-4"></i>
                        <span>Pesan Sekarang</span>
                    </a>
                </div>
                <div class="col-4">
                    <div class="menu-item-btn">
                        <i class="bi bi-ticket-perforated fs-4"></i>
                        <span>Voucher</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="menu-item-btn">
                        <i class="bi bi-clock-history fs-4"></i>
                        <span>Riwayat</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Ringkasan Akun (Hanya Voucher Saya) -->
        <div class="row g-2 mb-4">
            <div class="col-12">
                <div class="card-summary p-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="icon-summary-box text-orange">
                            <i class="bi bi-ticket"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold text-dark" style="font-size: 0.82rem;">Voucher Saya</span>
                            <span class="badge bg-light text-orange border border-warning" style="font-size: 0.65rem;">0 Tersedia</span>
                            <span class="d-block text-muted" style="font-size: 0.65rem;">Kupon hemat s/d 40%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Promo Hari Ini -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold text-dark" style="font-size: 0.9rem;">Promo Istimewa Hari Ini</span>
                <span class="text-orange small fw-bold" style="font-size: 0.75rem; cursor: pointer;">Semua Promo</span>
            </div>
            <div class="promo-banner-card">
                <span class="badge-pickup">KHUSUS SELF PICK-UP</span>
                <h5 class="fw-bold text-white mt-2 mb-1" style="font-size: 1.05rem;">Diskon 30% Ambil Sendiri</h5>
                <p class="text-light opacity-75 small mb-3" style="font-size: 0.72rem;">Gunakan kode: <strong>yiesanlimaratusjadirefund</strong></p>
                <button type="button" class="btn-klaim-voucher">Klaim Voucher</button>
            </div>
        </div>

        <!-- Pilih Outlet Terdekat -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold text-dark" style="font-size: 0.9rem;">Pilih Outlet Terdekat</span>
                <span class="text-orange small" style="font-size: 0.75rem; cursor: pointer;">Lihat Semua (8 Gerai)</span>
            </div>
            
            <!-- Outlet 1: TOMORO Coffee GC -->
            <div class="card-outlet mb-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-pin-box"><i class="bi bi-geo-alt-fill text-orange"></i></div>
                    <div>
                        <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">TOMORO Coffee GC</span>
                        <span class="d-block text-muted" style="font-size: 0.7rem;">Jl. Grand City Balikpapan No.2</span>
                        <span class="d-block text-muted" style="font-size: 0.65rem;"><strong>0.4 km</strong> &bull; Buka &bull; 24 JAM</span>
                        <span class="d-block text-muted" style="font-size: 0.6rem;">Est. 8-12 menit</span>
                    </div>
                </div>
                <span class="badge-status-pilih">Dipilih</span>
            </div>

            <!-- Outlet 2: TOMORO Coffee Batu Ampar -->
            <div class="card-outlet d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-pin-box"><i class="bi bi-geo-alt-fill text-orange"></i></div>
                    <div>
                        <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">TOMORO Coffee Batu Ampar</span>
                        <span class="d-block text-muted" style="font-size: 0.7rem;">Jl. Bangka IX No. 24, Balikpapan</span>
                        <span class="d-block text-muted" style="font-size: 0.65rem;"><strong>0.8 km</strong> &bull; Buka &bull; 24 JAM</span>
                        <span class="d-block text-muted" style="font-size: 0.6rem;">Est. 10-15 menit</span>
                    </div>
                </div>
                <span class="badge-status-outlet">Outlet Aktif</span>
            </div>
        </div>

        <!-- Bottom Navigation Bar Sesuai Mockup -->
        <div class="mobile-bottom-nav">
            <a href="index.php" class="nav-bottom-item active text-decoration-none">
                <i class="bi bi-house-door-fill"></i>
                <span>Home</span>
            </a>
            <a href="#" class="nav-bottom-item text-decoration-none">
                <i class="bi bi-bag"></i>
                <span>Pesanan</span>
            </a>
        </div>
    </div>

</body>
</html>