<?php
$userName   = $_SESSION['user_name'] ?? 'Cikocut';
$orderId    = $order['kode_pesanan'] ?? 'FKS-240217-0832';
$outletName = $order['outlet'] ?? 'ForKos GC';
$pickupCode = $order['pickup_code'] ?? 'A 127';
$itemName   = $order['nama_menu'] ?? '1x Caramel Macchiato';
$itemDetail = $order['catatan'] ?? 'Reguler, Normal Ice, Less Sugar';
$itemPrice  = $order['total_harga'] ?? 28000;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelacakan - ForKos Coffee</title>
    <!-- Bootstrap 5 CDN & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .tracking-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 28px auto;
        }

        .tracking-card {
            background: #ffffff;
            border: 1.5px solid #ececec;
            border-radius: 20px;
            padding: 20px 22px;
        }

        .order-meta-box {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 14px 18px;
        }

        .tracking-stepper {
            position: relative;
            padding-left: 0;
            margin: 0;
            list-style: none;
        }

        .tracking-step {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding-bottom: 24px;
        }

        .tracking-step:last-child {
            padding-bottom: 0;
        }

        .tracking-step::before {
            content: "";
            position: absolute;
            left: 15px;
            top: 32px;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
        }
        .stepper-item.completed:not(:last-child)::before {
            background-color: var(--tomoro-orange, #fa5a00);
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
            background-color: #e5e7eb;
            color: #6b7280;
        }
        .stepper-item.active .stepper-dot {
            background-color: var(--tomoro-orange, #fa5a00);
            color: #ffffff;
        }
        .stepper-item.completed .stepper-dot {
            background-color: var(--tomoro-orange, #fa5a00);
            color: #ffffff;
            box-shadow: 0 0 0 6px rgba(250, 90, 0, 0.18);
        }

        .step-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: #1f242d;
            margin-bottom: 2px;
        }

        .tracking-step.active .step-title {
            color: #fa5a00;
        }

        .tracking-step.pending .step-title {
            color: #6c757d;
            font-weight: 600;
        }

        .step-desc {
            font-size: 0.78rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .pickup-code-card {
            background: linear-gradient(145deg, #161b29 0%, #0d111a 100%);
            border-radius: 22px;
            padding: 28px 24px;
            color: #ffffff;
            text-align: center;
            box-shadow: 0 10px 28px rgba(13, 17, 26, 0.22);
        }

        .pickup-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #9ca3af;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .pickup-number {
            font-size: 2.3rem;
            font-weight: 800;
            letter-spacing: 2px;
            color: #ffffff;
            margin-bottom: 18px;
        }

        .qr-wrapper {
            background: #ffffff;
            border-radius: 16px;
            padding: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .qr-wrapper i {
            font-size: 5.5rem;
            line-height: 1;
            color: #111827;
        }

        .btn-pesan-lagi {
            background-color: #fa5a00;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 11px 20px;
            font-weight: 700;
            font-size: 0.88rem;
            box-shadow: 0 6px 16px rgba(250, 90, 0, 0.25);
            transition: all 0.2s ease;
        }

        .btn-pesan-lagi:hover {
            background-color: #e04e00;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-kembali-home {
            background-color: #ffffff;
            color: #1f242d;
            border: 1.5px solid #dee2e6;
            border-radius: 14px;
            padding: 11px 20px;
            font-weight: 700;
            font-size: 0.88rem;
            transition: all 0.2s ease;
        }

        .btn-kembali-home:hover {
            border-color: #fa5a00;
            color: #fa5a00;
        }
    </style>
</head>
<body class="app-body">

    <!-- Top Navbar Seragam -->
    <nav class="navbar navbar-expand-md navbar-light forkos-navbar sticky-top">
        <div class="container">
            <div class="d-flex align-items-center gap-2">
                <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="index.php?page=home">
                    <div class="brand-mini-icon">
                        <i class="bi bi-cup-hot-fill text-white"></i>
                    </div>
                    <span class="fw-bold fs-6 brand-text">FORKOS <span class="text-orange">COFFEE</span></span>
                </a>
                <span class="badge-ui">UI-005</span>
            </div>
            
            <!-- Menu Navigasi Desktop -->
            <div class="d-none d-md-flex align-items-center gap-3">
                <div class="forkos-nav-links">
                    <a href="index.php?page=home" class="forkos-nav-link">Home</a>
                    <a href="index.php?page=katalog" class="forkos-nav-link">Katalog Menu</a>
                    <a href="index.php?page=voucher" class="forkos-nav-link">Voucher</a>
                    <a href="index.php?page=pesanan" class="forkos-nav-link active">Pesanan</a>
                </div>
                <a href="index.php?page=login" class="btn btn-outline-tomoro btn-sm px-3 rounded-pill ms-2">
                    <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($userName) ?>
                </a>
            </div>

            <!-- Tampilan Kanan Mobile -->
            <div class="d-flex d-md-none align-items-center">
                <a href="index.php?page=login" class="btn btn-sm btn-light rounded-circle p-1">
                    <i class="bi bi-person-fill text-dark fs-5"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama Responsif -->
    <main class="container py-4 py-md-5">

        <!-- Header Terpusat -->
        <div class="tracking-header">
            <h2 class="fw-bold text-dark mb-1">Detail Pelacakan</h2>
            <p class="text-muted small mb-0">Pantau status pesanan kopimu secara langsung sebelum diambil di outlet.</p>
        </div>

        <!-- Grid 2 Kolom di Desktop, 1 Kolom di HP -->
        <div class="row g-4 justify-content-center mx-auto" style="max-width: 940px;">

            <!-- Kolom Kiri: Info Pesanan, Stepper Status, & Rincian Item -->
            <div class="col-12 col-lg-7">
                
                <!-- Kartu Info & Stepper -->
                <div class="tracking-card shadow-sm mb-3">
                    <div class="order-meta-box d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <div>
                            <span class="d-block text-muted" style="font-size: 0.72rem;">ID Pesanan</span>
                            <span class="fw-bold text-dark" style="font-size: 0.95rem;"><?= htmlspecialchars($orderId) ?></span>
                        </div>
                        <div class="text-end">
                            <span class="d-block text-muted" style="font-size: 0.72rem;">Outlet Pengambilan</span>
                            <span class="fw-bold text-orange" style="font-size: 0.95rem;"><?= htmlspecialchars($outletName) ?></span>
                        </div>
                    </div>

                    <ul class="tracking-stepper">
                        <li class="tracking-step done">
                            <div class="step-circle"><i class="bi bi-check-lg"></i></div>
                            <div>
                                <p class="step-title">Pesanan Diterima</p>
                                <p class="step-desc">09:42 WIB</p>
                            </div>
                        </li>
                        <li class="tracking-step active">
                            <div class="step-circle"><i class="bi bi-clock"></i></div>
                            <div>
                                <p class="step-title">Sedang Dibuat</p>
                                <p class="step-desc">Barista sedang meracik kopimu</p>
                            </div>
                        </li>
                        <li class="tracking-step pending">
                            <div class="step-circle">3</div>
                            <div>
                                <p class="step-title">Siap Diambil</p>
                                <p class="step-desc">Tunjukkan kode pengambilan ke kasir</p>
                            </div>
                        </li>
                        <li class="tracking-step pending">
                            <div class="step-circle">4</div>
                            <div>
                                <p class="step-title">Selesai</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Kartu Rincian Item -->
                <div class="tracking-card shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold text-dark mb-1"><?= htmlspecialchars($itemName) ?></h6>
                            <span class="text-muted small"><?= htmlspecialchars($itemDetail) ?></span>
                        </div>
                        <span class="fw-bold text-orange fs-6">Rp<?= number_format($itemPrice, 0, ',', '.') ?></span>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Kartu Pick-up Code & Tombol Aksi -->
            <div class="col-12 col-lg-5">
                
                <div class="pickup-code-card mb-3">
                    <p class="pickup-label">Pick-up Code</p>
                    <div class="pickup-number"><?= htmlspecialchars($pickupCode) ?></div>
                    
                    <div class="qr-wrapper">
                        <i class="bi bi-qr-code"></i>
                    </div>
                    
                    <p class="small text-secondary mb-0" style="color: #9ca3af !important;">
                        Tunjukkan kode ini ke barista outlet
                    </p>
                </div>

                <div class="d-grid gap-2">
                    <a href="index.php?page=katalog" class="btn btn-pesan-lagi text-decoration-none">
                        <i class="bi bi-cup-hot me-1"></i> Pesan Menu Lainnya
                    </a>
                    <a href="index.php?page=home" class="btn btn-kembali-home text-decoration-none">
                        Kembali ke Home
                    </a>
                </div>

            </div>

        </div>

    </main>

    <!-- Bottom Navigation Bar (Khusus Layar HP) -->
    <div class="mobile-bottom-nav d-md-none">
        <a href="index.php?page=home" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
        </a>
        <a href="index.php?page=pesanan" class="nav-bottom-item active text-decoration-none">
            <i class="bi bi-bag-fill"></i>
            <span>Pesanan</span>
        </a>
    </div>

</body>
</html>