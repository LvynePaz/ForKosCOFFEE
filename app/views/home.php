<?php
$userName = $_SESSION['user_name'] ?? 'Cikocut';
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
<body class="app-body">

    <!-- Top Navbar (Tampil di Desktop & Mobile) -->
    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="index.php?page=home">
                <div class="brand-mini-icon">
                    <i class="bi bi-cup-hot-fill text-white"></i>
                </div>
                <span class="fw-bold fs-6 brand-text">FORKOS <span class="text-orange">COFFEE</span></span>
            </a>
            
            <!-- Menu Navigasi Desktop -->
            <div class="d-none d-md-flex align-items-center gap-3">
                <a href="index.php?page=home" class="nav-link active fw-bold text-orange">Home</a>
                <a href="index.php?page=katalog" class="nav-link text-dark fw-semibold">Katalog Menu</a>
                <a href="index.php?page=voucher" class="nav-link text-dark fw-semibold">Voucher</a>
                <a href="index.php?page=pesanan" class="nav-link text-dark fw-semibold">Pesanan</a>
                <a href="index.php?page=login" class="btn btn-outline-tomoro btn-sm px-3 rounded-pill ms-2">
                    <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($userName) ?>
                </a>
            </div>

            <!-- Tampilan Kanan Mobile (Badge UI & Avatar) -->
            <div class="d-flex d-md-none align-items-center gap-2">
                <span class="badge-ui">UI-002</span>
                <a href="index.php?page=login" class="btn btn-sm btn-light rounded-circle p-1">
                    <i class="bi bi-person-fill text-dark fs-5"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama Halaman -->
    <main class="container py-3 py-md-4">
        
        <!-- Sapaan Pengguna -->
        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
            <div>
                <p class="text-muted mb-0 small">Selamat datang kembali!</p>
                <h3 class="fw-bold text-dark mb-0">Halo, <?= htmlspecialchars($userName) ?>!</h3>
            </div>
            <div class="avatar-circle shadow-sm">
                <i class="bi bi-person-fill text-white fs-4"></i>
            </div>
        </div>

        <!-- Grid Responsif: Desktop 2 Kolom, Mobile Otomatis Menumpuk Sesuai Urutan Figma -->
        <div class="row gy-2 gx-3 g-lg-4">
            
            <!-- Kolom Kiri: Menu Utama -> Voucher Saya -> Promo Istimewa -->
            <div class="col-12 col-lg-7">
                
                <!-- 1. Menu Utama -->
                <div class="mb-3 mb-md-4">
                    <p class="section-sub-title">MENU UTAMA</p>
                    <div class="row g-2 g-md-3 text-center">
                        <div class="col-4">
                            <a href="index.php?page=katalog" class="menu-item-btn active text-decoration-none">
                                <i class="bi bi-cup-hot fs-4"></i>
                                <span>Pesan Sekarang</span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="index.php?page=voucher" class="menu-item-btn text-decoration-none">
                                <i class="bi bi-ticket-perforated fs-4"></i>
                                <span>Voucher</span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="index.php?page=pesanan&tab=riwayat" class="menu-item-btn text-decoration-none">
                                <i class="bi bi-clock-history fs-4"></i>
                                <span>Riwayat</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 2. Kartu Voucher Saya (Tepat di bawah Menu Utama, tanpa judul Status Akun) -->
                <div class="mb-3 mb-md-4">
                    <a href="index.php?page=voucher" class="text-decoration-none">
                        <div class="card-summary p-2 p-md-3 shadow-sm">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-summary-box text-orange">
                                        <i class="bi bi-ticket fs-4"></i>
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-dark" style="font-size: 0.88rem;">Voucher Saya</span>
                                        <span class="badge bg-light text-orange border border-warning" style="font-size: 0.68rem;">0 Tersedia</span>
                                        <span class="d-block text-muted small mt-1">Kupon hemat s/d 40%</span>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-muted pe-2 fs-6"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- 3. Promo Istimewa Hari Ini -->
<div class="mb-2" style="margin-bottom: 12px !important;">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="fw-bold text-dark" style="font-size: 0.9rem;">Promo Istimewa Hari Ini</span>
        <a href="index.php?page=voucher" class="text-orange small fw-bold text-decoration-none" style="font-size: 0.75rem;">Semua Promo</a>
    </div>
    <div class="promo-banner-card shadow-sm">
        <span class="badge-pickup">KHUSUS SELF PICK-UP</span>
        <h4 class="fw-bold text-white mt-2 mb-1" style="font-size: 1.1rem;">Diskon 30% Ambil Sendiri</h4>
        <p class="text-light opacity-75 small mb-3" style="font-size: 0.75rem;">Gunakan kode promo: <strong>yiesanlimaratusjadirefund</strong></p>
        <a href="index.php?page=voucher&claim=yiesanlimaratusjadirefund" class="btn-klaim-voucher text-decoration-none">
            Klaim Voucher
        </a>
    </div>
</div>

            </div>

            <!-- Kolom Kanan: Pilih Outlet Terdekat -->
            <div class="col-12 col-lg-5">
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-dark" style="font-size: 0.9rem;">Pilih Outlet Terdekat</span>
                        <a href="index.php?page=katalog" class="text-orange small text-decoration-none" style="font-size: 0.75rem;">Lihat Semua (8 Gerai)</a>
                    </div>
                    
                    <!-- Outlet 1: TOMORO Coffee GC -->
                    <a href="index.php?page=katalog&outlet=gc" class="text-decoration-none text-dark d-block mb-2 mb-md-3">
                        <div class="card-outlet p-2 p-md-3 d-flex justify-content-between align-items-center shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-pin-box">
                                    <i class="bi bi-geo-alt-fill text-orange fs-4"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">TOMORO Coffee GC</span>
                                    <span class="d-block text-muted small">Jl. Grand City Balikpapan No.2</span>
                                    <span class="d-block text-muted small mt-1"><strong>0.4 km</strong> &bull; Buka 24 JAM &bull; Est. 8-12 menit</span>
                                </div>
                            </div>
                            <span class="badge-status-pilih">Dipilih</span>
                        </div>
                    </a>

                    <!-- Outlet 2: TOMORO Coffee Batu Ampar -->
                    <a href="index.php?page=katalog&outlet=batu_ampar" class="text-decoration-none text-dark d-block">
                        <div class="card-outlet p-2 p-md-3 d-flex justify-content-between align-items-center shadow-sm">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-pin-box">
                                    <i class="bi bi-geo-alt-fill text-orange fs-4"></i>
                                </div>
                                <div>
                                    <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">TOMORO Coffee Batu Ampar</span>
                                    <span class="d-block text-muted small">Jl. Bangka IX No. 24, Balikpapan</span>
                                    <span class="d-block text-muted small mt-1"><strong>0.8 km</strong> &bull; Buka 24 JAM &bull; Est. 10-15 menit</span>
                                </div>
                            </div>
                            <span class="badge-status-outlet">Outlet Aktif</span>
                        </div>
                    </a>
                </div>

            </div>

        </div>

    </main>

    <!-- Bottom Navigation Bar (Otomatis Hanya Muncul di HP / Layar Sempit) -->
    <div class="mobile-bottom-nav d-md-none">
        <a href="index.php?page=home" class="nav-bottom-item active text-decoration-none">
            <i class="bi bi-house-door-fill"></i>
            <span>Home</span>
        </a>
        <a href="index.php?page=pesanan" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-bag"></i>
            <span>Pesanan</span>
        </a>
    </div>

</body>
</html>