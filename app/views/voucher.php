<?php
/**
 * View: Daftar Voucher & Kupon Promo (UI-002 Addon)
 * Arsitektur: MVC - View Layer
 * Dokumen SDD: Bab 4.1 & Bab 5.2.2
 * 
 * @var array $vouchers
 */
$vouchers = $vouchers ?? [
    [
        'kode'      => 'yiesanlimaratusjadirefund',
        'diskon'    => '30%',
        'judul'     => 'Diskon 30% Ambil Sendiri',
        'deskripsi' => 'Khusus Self Pick-up di seluruh outlet ForKos Coffee. Maksimal potongan Rp15.000.'
    ],
    [
        'kode'      => 'HEMATKOPI10',
        'diskon'    => '10%',
        'judul'     => 'Promo Kopi Pagi',
        'deskripsi' => 'Berlaku untuk semua menu kopi kategori Kopi Susu & Espresso base sebelum jam 11.00.'
    ],
    [
        'kode'      => 'FORKOSBARU',
        'diskon'    => '20%',
        'judul'     => 'Welcome New Member',
        'deskripsi' => 'Spesial untuk pesanan pertamamu di ForKos Coffee melalui pemesanan web.'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Promo - ForKos Coffee</title>
    <!-- Fonts & Bootstrap 5 -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .voucher-ticket-card {
            background: #ffffff;
            border: 1.5px dashed var(--tomoro-orange, #fa5a00);
            border-radius: 18px;
            padding: 20px;
            position: relative;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .voucher-ticket-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(250, 90, 0, 0.12);
        }
        .voucher-notch-left, .voucher-notch-right {
            position: absolute;
            top: 50%;
            width: 18px;
            height: 18px;
            background: var(--tomoro-bg, #f8f9fa);
            border-radius: 50%;
            transform: translateY(-50%);
        }
        .voucher-notch-left { left: -9px; }
        .voucher-notch-right { right: -9px; }
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
                <a href="index.php?page=voucher" class="nav-link active fw-bold text-orange">Voucher</a>
                <a href="index.php?page=pesanan" class="nav-link text-dark fw-semibold">Pesanan</a>
            </div>

            <div class="d-flex d-md-none align-items-center gap-2">
                <span class="badge-ui">PROMO</span>
            </div>
        </div>
    </nav>

    <!-- Konten Utama (Desktop lega, HP rapi) -->
    <main class="container py-3 py-md-5" style="max-width: 960px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="index.php?page=home" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <div>
                <h3 class="fw-bold text-dark mb-1">Kupon & Voucher Saya</h3>
                <p class="text-muted small mb-0">Pilih dan salin kode promo untuk digunakan saat checkout pesanan.</p>
            </div>
        </div>

        <!-- Grid Voucher -->
        <div class="row g-3 g-md-4">
            <?php foreach ($vouchers as $v): ?>
                <div class="col-12 col-md-6">
                    <div class="voucher-ticket-card h-100">
                        <div class="voucher-notch-left"></div>
                        <div class="voucher-notch-right"></div>
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-danger rounded-pill px-3 py-1 fw-bold"><?= htmlspecialchars($v['diskon']) ?> OFF</span>
                                <span class="badge bg-light text-success border border-success-subtle px-2 py-1 small">
                                    <i class="bi bi-check-circle me-1"></i>Tersedia
                                </span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($v['judul']) ?></h5>
                            <p class="text-muted small mb-3"><?= htmlspecialchars($v['deskripsi']) ?></p>
                        </div>
                        <div class="bg-light p-2 px-3 rounded-3 border d-flex justify-content-between align-items-center mt-2">
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.68rem;">KODE PROMO</small>
                                <code class="fw-bold text-orange fs-6"><?= htmlspecialchars($v['kode']) ?></code>
                            </div>
                            <a href="index.php?page=katalog" class="btn btn-outline-tomoro btn-sm rounded-pill px-3">
                                Pakai Menu
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="index.php?page=katalog" class="btn btn-klaim-voucher px-4 py-2 fs-6 text-decoration-none">
                <i class="bi bi-cup-hot me-2"></i>Pesan Sekarang & Gunakan Kupon
            </a>
        </div>
    </main>

    <!-- Bottom Nav untuk Mobile -->
    <div class="mobile-bottom-nav d-md-none">
        <a href="index.php?page=home" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
        </a>
        <a href="index.php?page=katalog" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-cup-hot"></i>
            <span>Menu</span>
        </a>
        <a href="index.php?page=pesanan" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-bag"></i>
            <span>Pesanan</span>
        </a>
    </div>

</body>
</html>
