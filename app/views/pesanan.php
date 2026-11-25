<?php
/**
 * View: Detail Pelacakan Status Pesanan & Pick-up Code (UI-005)
 * Arsitektur: MVC - View Layer
 * Dokumen SDD: Bab 5.2.5 (UI-005)
 * 
 * @var array $order
 */
$order = $order ?? [
    'id_pesanan'   => 'TMR-240217-0832',
    'outlet'       => 'ForKos GC',
    'status'       => 'Sedang Dibuat',
    'estimasi'     => 'Barista sedang meracik kopimu',
    'pick_up_code' => 'A 127',
    'item_nama'    => 'Caramel Macchiato',
    'kuantitas'    => 1,
    'kustomisasi'  => 'Reguler, Normal Ice, Less Sugar',
    'total_harga'  => 28000
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelacakan - ForKos Coffee</title>
    <!-- Fonts & Bootstrap 5 -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .tracking-card-container {
            background: #ffffff;
            border: 1.5px solid #ececec;
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        }
        @media (min-width: 768px) {
            .tracking-card-container {
                padding: 36px;
            }
        }
        .stepper-item {
            display: flex;
            align-items: flex-start;
            position: relative;
            padding-bottom: 22px;
        }
        .stepper-item:last-child {
            padding-bottom: 0;
        }
        .stepper-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 26px;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
        }
        .stepper-item.completed:not(:last-child)::before {
            background-color: var(--tomoro-orange, #fa5a00);
        }
        .stepper-dot {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            margin-right: 14px;
            z-index: 2;
            color: #9ca3af;
        }
        .stepper-item.active .stepper-dot {
            background-color: var(--tomoro-orange, #fa5a00);
            color: #ffffff;
            box-shadow: 0 0 0 4px rgba(250, 90, 0, 0.2);
        }
        .stepper-item.completed .stepper-dot {
            background-color: var(--tomoro-orange, #fa5a00);
            color: #ffffff;
        }
        .pickup-code-box {
            background: linear-gradient(145deg, #1f242d 0%, #11141a 100%);
            color: #ffffff;
            border-radius: 20px;
            padding: 24px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .pickup-code-number {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 3px;
            color: #ffffff;
            margin: 6px 0;
        }
        .qr-placeholder {
            width: 100px;
            height: 100px;
            background: #ffffff;
            border-radius: 14px;
            margin: 12px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111827;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="app-body">

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="index.php?page=home">
                <div class="brand-mini-icon">
                    <i class="bi bi-cup-hot-fill text-white"></i>
                </div>
                <span class="fw-bold fs-6 brand-text">FORKOS <span class="text-orange">COFFEE</span></span>
            </a>
            
            <div class="d-none d-md-flex align-items-center gap-3">
                <a href="index.php?page=home" class="nav-link text-dark fw-semibold">Home</a>
                <a href="index.php?page=katalog" class="nav-link text-dark fw-semibold">Katalog Menu</a>
                <a href="index.php?page=voucher" class="nav-link text-dark fw-semibold">Voucher</a>
                <a href="index.php?page=pesanan" class="nav-link active fw-bold text-orange">Pesanan</a>
            </div>

            <div class="d-flex d-md-none align-items-center gap-2">
                <span class="badge-ui">UI-005</span>
            </div>
        </div>
    </nav>

    <!-- Konten Utama (Window/Desktop 2 Kolom, Mobile 1 Kolom) -->
    <main class="container py-3 py-md-5" style="max-width: 980px;">
        
        <div class="d-flex align-items-center justify-content-between mb-3 mb-md-4">
            <div class="d-flex align-items-center gap-3">
                <a href="index.php?page=home" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-arrow-left fs-5"></i>
                </a>
                <div>
                    <h3 class="fw-bold text-dark mb-0">Detail Pelacakan</h3>
                    <p class="text-muted small mb-0">Pantau progres pembuatan kopimu secara real-time.</p>
                </div>
            </div>
            <span class="badge-ui d-none d-md-inline-block">UI-005</span>
        </div>

        <div class="tracking-card-container">
            <!-- Header ID Pesanan & Outlet -->
            <div class="bg-light p-3 px-4 rounded-4 d-flex justify-content-between align-items-center mb-4 border">
                <div>
                    <div class="text-muted small" style="font-size: 0.75rem;">ID Pesanan</div>
                    <div class="fw-bold text-dark"><?= htmlspecialchars($order['id_pesanan']) ?></div>
                </div>
                <div class="text-end">
                    <div class="text-muted small" style="font-size: 0.75rem;">Outlet Pengambilan</div>
                    <div class="fw-bold text-orange fs-6"><?= htmlspecialchars($order['outlet']) ?></div>
                </div>
            </div>

            <div class="row g-4 align-items-start">
                
                <!-- Kolom Kiri: Stepper Status & Rincian Menu -->
                <div class="col-12 col-md-6 order-2 order-md-1">
                    <h6 class="fw-bold text-dark mb-3">Status Pemesanan</h6>
                    <div class="py-2 px-1 mb-4">
                        <div class="stepper-item completed">
                            <div class="stepper-dot"><i class="bi bi-check-lg"></i></div>
                            <div>
                                <div class="fw-bold text-dark small">Pesanan Diterima</div>
                                <div class="text-muted" style="font-size: 0.72rem;">09:42 WIB</div>
                            </div>
                        </div>
                        <div class="stepper-item active">
                            <div class="stepper-dot"><i class="bi bi-clock-fill"></i></div>
                            <div>
                                <div class="fw-bold text-orange small">Sedang Dibuat</div>
                                <div class="text-muted" style="font-size: 0.72rem;"><?= htmlspecialchars($order['estimasi']) ?></div>
                            </div>
                        </div>
                        <div class="stepper-item">
                            <div class="stepper-dot">3</div>
                            <div>
                                <div class="fw-bold text-muted small">Siap Diambil</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Tunjukkan kode pengambilan ke kasir</div>
                            </div>
                        </div>
                        <div class="stepper-item">
                            <div class="stepper-dot">4</div>
                            <div>
                                <div class="fw-bold text-muted small">Selesai</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Pesanan telah diserahkan</div>
                            </div>
                        </div>
                    </div>

                    <!-- Rincian Menu -->
                    <div class="p-3 bg-light rounded-3 border">
                        <span class="text-muted d-block small mb-2" style="font-size: 0.75rem;">RINCIAN PESANAN</span>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold text-dark"><?= $order['kuantitas'] ?>x <?= htmlspecialchars($order['item_nama']) ?></div>
                                <div class="text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($order['kustomisasi']) ?></div>
                            </div>
                            <div class="fw-bold text-orange fs-5">
                                Rp<?= number_format($order['total_harga'], 0, ',', '.') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Black Pick-Up Code Card + QR (Sesuai SDD Gambar 5.6) -->
                <div class="col-12 col-md-6 order-1 order-md-2">
                    <div class="pickup-code-box">
                        <div class="text-uppercase tracking-wider text-white-50 small fw-bold" style="font-size: 0.75rem;">PICK-UP CODE</div>
                        <div class="pickup-code-number"><?= htmlspecialchars($order['pick_up_code']) ?></div>
                        <div class="qr-placeholder">
                            <i class="bi bi-qr-code text-dark" style="font-size: 4rem;"></i>
                        </div>
                        <div class="text-white-50 mt-2" style="font-size: 0.75rem;">Tunjukkan kode atau QR ini ke barista saat mengambil kopi</div>
                    </div>

                    <div class="mt-4">
                        <a href="index.php?page=home" class="btn btn-klaim-voucher w-100 py-3 text-center text-decoration-none">
                            <i class="bi bi-house-door me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <!-- Bottom Nav untuk Layar HP -->
    <div class="mobile-bottom-nav d-md-none">
        <a href="index.php?page=home" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
        </a>
        <a href="index.php?page=katalog" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-cup-hot"></i>
            <span>Menu</span>
        </a>
        <a href="index.php?page=pesanan" class="nav-bottom-item active text-decoration-none">
            <i class="bi bi-bag-fill"></i>
            <span>Pesanan</span>
        </a>
    </div>

</body>
</html>
