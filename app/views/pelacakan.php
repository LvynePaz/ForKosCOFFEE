<?php
$userName = $_SESSION['user_name'] ?? 'Cikocut';
$order = $order ?? [
    'id_pesanan'   => 'FKS-240517-0832',
    'outlet'       => 'ForKos GC',
    'status'       => 'Sedang Dibuat',
    'estimasi'     => 'Barista sedang meracik',
    'pick_up_code' => 'A 127',
    'item_nama'    => 'Caramel Macchiato',
    'kuantitas'    => 1,
    'kustomisasi'  => 'Reguler • Gula Normal',
    'total_harga'  => 30000,
    'items'        => [
        [
            'id' => 1,
            'nama' => 'Caramel Macchiato',
            'quantity' => 1,
            'harga' => 28000,
            'kustomisasi' => 'Reguler • Gula Normal'
        ]
    ]
];
$qrContent = ($order['id_pesanan'] ?? 'FKS-240517-0832') . '|' . preg_replace('/\s+/', '', $order['pick_up_code'] ?? 'A127');
$outletId = $order['outlet_id'] ?? 'gc';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pelacakan - ForKos Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .tracking-container {
            max-width: 520px;
            margin: 0 auto;
            padding-bottom: 80px;
        }
        .tracking-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 24px 22px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
        }
        .tracking-back-btn {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            color: #1f2937;
            text-decoration: none;
            transition: all .2s;
        }
        .tracking-back-btn:hover {
            background: #f9fafb;
            color: #111827;
        }

        /* Stepper matching SDD Gambar 5.6 */
        .stepper-wrapper {
            position: relative;
            padding-left: 12px;
            margin: 20px 0 24px;
        }
        .stepper-row {
            display: flex;
            align-items: flex-start;
            position: relative;
            padding-bottom: 20px;
        }
        .stepper-row:last-child {
            padding-bottom: 0;
        }
        .stepper-connector {
            position: absolute;
            top: 26px;
            left: 13px;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }
        .stepper-connector.active {
            background: #fa5a00;
        }
        .stepper-icon {
            z-index: 2;
            width: 28px;
            height: 28px;
            flex: 0 0 28px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 700;
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }
        .stepper-row.completed .stepper-icon {
            background: #fa5a00;
            color: #ffffff;
            border-color: #fa5a00;
        }
        .stepper-row.current .stepper-icon {
            background: #fa5a00;
            color: #ffffff;
            border-color: #fa5a00;
            box-shadow: 0 0 0 3px rgba(250, 90, 0, 0.2);
        }
        .stepper-text {
            margin-left: 14px;
        }
        .stepper-text h2 {
            font-size: 0.88rem;
            font-weight: 700;
            margin: 0 0 2px;
            color: #111827;
        }
        .stepper-text p {
            font-size: 0.76rem;
            color: #6b7280;
            margin: 0;
        }

        /* Pick-up Code Card (Dark Card per SDD Gambar 5.6) */
        .pickup-dark-card {
            background: #111317;
            border-radius: 20px;
            padding: 24px 20px;
            text-align: center;
            color: #ffffff;
            margin-bottom: 22px;
        }
        .pickup-label {
            color: #fa5a00;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 2.5px;
            margin-bottom: 6px;
        }
        .pickup-code-number {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: 4px;
            line-height: 1.1;
            margin-bottom: 16px;
            color: #ffffff;
        }
        .pickup-qr-box {
            display: inline-block;
            background: #ffffff;
            padding: 10px;
            border-radius: 12px;
        }
        .pickup-qr-box img,
        .pickup-qr-box canvas {
            display: block;
            margin: 0 auto;
        }
        .pickup-note {
            color: #9ca3af;
            font-size: 0.72rem;
            margin-top: 14px;
            margin-bottom: 0;
        }

        /* Order items summary */
        .order-summary-box {
            background: #fdfdfd;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 22px;
        }
        .btn-home-orange {
            background: #fa5a00;
            color: #ffffff;
            font-weight: 700;
        }
        .summary-customization {
            margin: 0;
            color: #888;
            font-size: .55rem;
        }
        .summary-price {
            margin: 0;
            color: var(--tomoro-orange);
            font-size: .68rem;
            font-weight: 700;
        }
        .home-button {
            display: block;
            width: 100%;
            text-align: center;
            text-decoration: none;
        }
        .home-button:hover,
        .home-button:focus-visible {
            background: var(--tomoro-orange-hover);
            color: #fff;
        }
        @media (max-width: 767.98px) {
            .tracking-frame { padding: 20px 16px 88px; gap: 12px; }
        }
        @media (min-width: 768px) {
            .tracking-frame { padding: 32px; gap: 20px 32px; }
            .tracking-title { font-size: 1.4rem; }
            .meta-label, .meta-value { font-size: .85rem; }
            .step-name { font-size: .9rem; }
            .step-detail { font-size: .8rem; }
            .summary-product { font-size: .9rem; }
            .summary-customization { font-size: .78rem; }
            .summary-price { font-size: .9rem; }
            .tracking-nav { display: none; }
        }
        @media (min-width: 992px) {
            .tracking-frame { grid-template-columns: minmax(0, 1.1fr) minmax(320px, .9fr); }
            .tracking-steps { grid-column: 1; align-self: center; }
            .pickup-code-card { grid-column: 2; grid-row: 4; min-height: 260px; }
            .order-summary { margin-top: 4px; }
            .home-button { width: 100%; }
        }
    </style>
</head>
<body class="app-body">

    <!-- Top Navbar Seragam -->
    <nav class="navbar navbar-expand-md navbar-light forkos-navbar sticky-top">
        <div class="container">
            <div class="d-flex align-items-center gap-2">
                <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="index.php?page=home">
                    <div class="brand-mini-icon"><i class="bi bi-cup-hot-fill text-white"></i></div>
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

<main class="container py-3 py-md-4 tracking-container">

    <div class="tracking-card">
        <!-- Header -->
        <div class="d-flex align-items-center gap-3 mb-3">
            <a href="index.php?page=checkout&amp;outlet=<?= urlencode($outletId) ?>" class="tracking-back-btn" aria-label="Kembali ke checkout">
                <i class="bi bi-chevron-left"></i>
            </a>
            <h1 class="h5 mb-0 fw-bold text-dark">Detail Pelacakan</h1>
        </div>

        <!-- Order Meta -->
        <div class="row g-2 mb-3 pb-3 border-bottom">
            <div class="col-6">
                <span class="text-muted d-block" style="font-size: 0.72rem;">ID Pesanan</span>
                <strong class="d-block text-dark" style="font-size: 0.85rem;"><?= htmlspecialchars($order['id_pesanan']) ?></strong>
            </div>
            <div class="col-6">
                <span class="text-muted d-block" style="font-size: 0.72rem;">Outlet</span>
                <strong class="d-block text-dark" style="font-size: 0.85rem;"><?= htmlspecialchars($order['outlet']) ?></strong>
            </div>
        </div>

        <!-- Stepper Timeline Status -->
        <div class="stepper-wrapper">
            <div class="stepper-row completed">
                <div class="stepper-connector active"></div>
                <div class="stepper-icon"><i class="bi bi-check-lg"></i></div>
                <div class="stepper-text">
                    <h2>Pesanan Diterima</h2>
                    <p>09.42</p>
                </div>
            </div>

            <div class="stepper-row current">
                <div class="stepper-connector"></div>
                <div class="stepper-icon">2</div>
                <div class="stepper-text">
                    <h2>Sedang Dibuat</h2>
                    <p><?= htmlspecialchars($order['estimasi'] ?? 'Barista sedang meracik') ?></p>
                </div>
            </div>

            <div class="stepper-row">
                <div class="stepper-connector"></div>
                <div class="stepper-icon">3</div>
                <div class="stepper-text">
                    <h2>Siap Diambil</h2>
                    <p>&mdash;</p>
                </div>
            </div>

            <div class="stepper-row">
                <div class="stepper-icon">4</div>
                <div class="stepper-text">
                    <h2>Selesai</h2>
                    <p>&mdash;</p>
                </div>
            </div>
        </div>

        <!-- Pick-up Code Card (Dark card persis SDD Gambar 5.6) -->
        <section class="pickup-dark-card" aria-label="Kode pengambilan pesanan">
            <div class="pickup-label">PICK-UP CODE</div>
            <div class="pickup-code-number"><?= htmlspecialchars($order['pick_up_code']) ?></div>
            <div class="pickup-qr-box">
                <div id="pickupQr" role="img" aria-label="QR Code Pick-up"></div>
            </div>
            <p class="pickup-note">Tunjukkan kode ini saat mengambil pesanan</p>
        </section>

        <!-- Daftar Semua Menu yang Dipesan -->
        <?php 
        $orderItems = $order['items'] ?? [
            [
                'nama' => $order['item_nama'] ?? 'Caramel Macchiato',
                'quantity' => $order['kuantitas'] ?? 1,
                'harga' => $order['subtotal'] ?? 28000,
                'kustomisasi' => $order['kustomisasi'] ?? 'Reguler • Gula Normal'
            ]
        ];
        ?>
        <section class="order-summary-box" aria-label="Ringkasan item pesanan">
            <div class="fw-bold text-dark small mb-2">Item Pesanan (<?= count($orderItems) ?>)</div>
            <?php foreach ($orderItems as $idx => $it): ?>
                <div class="d-flex justify-content-between align-items-start py-2 <?= $idx > 0 ? 'border-top' : '' ?>">
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 0.88rem;">
                            <?= (int)$it['quantity'] ?>&times; <?= htmlspecialchars($it['nama']) ?>
                        </div>
                        <div class="text-muted" style="font-size: 0.74rem;">
                            <?= htmlspecialchars($it['kustomisasi'] ?? 'Reguler • Gula Normal') ?>
                        </div>
                    </div>
                    <div class="fw-bold text-orange" style="font-size: 0.88rem;">
                        Rp<?= number_format((int)$it['harga'] * (int)$it['quantity'], 0, ',', '.') ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-between align-items-center pt-2 mt-1 border-top text-muted" style="font-size: 0.78rem;">
                <span>Biaya Layanan</span>
                <span class="fw-semibold text-dark">Rp<?= number_format((int)($order['biaya_layanan'] ?? 2000), 0, ',', '.') ?></span>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2 mt-1 border-top">
                <span class="fw-bold text-dark">Total Pembayaran</span>
                <span class="fw-bold text-orange fs-6">
                    Rp<?= number_format((int)($order['total_harga'] ?? 30000), 0, ',', '.') ?>
                </span>
            </div>
        </section>

        <!-- Tombol Aksi -->
        <a class="btn-home-orange" href="index.php?page=home">Kembali ke Home</a>
    </div>

</main>

<!-- Bottom Nav Mobile -->
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById('pickupQr'), {
        text: <?= json_encode($qrContent, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
        width: 110,
        height: 110,
        colorDark: '#111317',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.M
    });
</script>
</body>
</html>
