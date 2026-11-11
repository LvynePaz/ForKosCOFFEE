<?php
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
$qrContent = $order['id_pesanan'] . '|' . preg_replace('/\s+/', '', $order['pick_up_code']);
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
        .tracking-frame {
            width: 100%;
            max-width: none;
            margin: 0;
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            align-content: start;
            gap: 16px;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            transition: box-shadow .2s ease;
        }
        .tracking-frame:hover { box-shadow: 0 8px 26px rgba(31, 36, 45, .08); }
        .tracking-badge,
        .tracking-header,
        .order-meta,
        .order-summary,
        .home-button,
        .tracking-nav { grid-column: 1 / -1; }
        .tracking-steps { grid-column: 1; }
        .pickup-code-card { grid-column: 1; }
        .tracking-badge {
            color: #858585;
            border-color: #d1d1d1;
            border-radius: 7px;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 3px 7px;
        }
        .tracking-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0 24px;
        }
        .tracking-back {
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            display: grid;
            place-items: center;
            border: 1px solid #dedede;
            border-radius: 10px;
            color: #171717;
            text-decoration: none;
        }
        .tracking-title {
            margin: 0;
            color: #171717;
            font-size: 1.05rem;
            font-weight: 400;
        }
        .order-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 24px;
            padding: 0 12px;
        }
        .meta-label {
            display: block;
            margin-bottom: 3px;
            color: #888;
            font-size: .68rem;
        }
        .meta-value {
            display: block;
            color: #171717;
            font-size: .65rem;
            font-weight: 700;
        }
        .tracking-steps {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 0 0 22px;
            padding: 0;
            list-style: none;
        }
        .tracking-steps::before {
            position: absolute;
            top: 14px;
            bottom: 30px;
            left: 12px;
            width: 2px;
            background: #e5e5e5;
            content: "";
        }
        .tracking-step {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            min-height: 32px;
        }
        .step-indicator {
            z-index: 1;
            width: 24px;
            height: 24px;
            flex: 0 0 24px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #efefef;
            color: #171717;
            font-size: .6rem;
            font-weight: 700;
        }
        .tracking-step.completed .step-indicator,
        .tracking-step.current .step-indicator {
            background: #ff6900;
            color: #fff;
        }
        .step-name {
            margin: 3px 0 4px;
            color: #171717;
            font-size: .66rem;
            font-weight: 700;
        }
        .step-detail {
            margin: 0;
            color: #888;
            font-size: .63rem;
        }
        .pickup-code-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 205px;
            margin-bottom: 14px;
            border-radius: 18px;
            border: 1px solid var(--tomoro-orange-border);
            background: var(--tomoro-orange-light);
            color: var(--tomoro-dark);
        }
        .pickup-code-label {
            margin-bottom: 8px;
            color: var(--tomoro-orange);
            font-size: .62rem;
            font-weight: 800;
            letter-spacing: 2px;
        }
        .pickup-code {
            margin-bottom: 8px;
            font-size: 1.65rem;
            font-weight: 700;
            letter-spacing: 5px;
            line-height: 1.1;
        }
        .pickup-code-qr {
            width: 96px;
            height: 96px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #fff;
        }
        .pickup-code-qr img,
        .pickup-code-qr canvas {
            display: block;
            max-width: 88px;
            max-height: 88px;
        }
        .pickup-instruction {
            margin: 7px 0 0;
            color: var(--tomoro-gray);
            font-size: .52rem;
        }
        .order-summary {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            padding: 0 2px 12px;
            border-bottom: 1px solid #eee;
        }
        .summary-product {
            margin: 0 0 3px;
            color: #171717;
            font-size: .65rem;
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
            margin: 12px 0 20px;
            padding: 13px 12px;
            border-radius: 13px;
            background: #ff6900;
            box-shadow: 0 7px 15px rgba(255, 105, 0, .2);
            color: #fff;
            font-size: .85rem;
            font-weight: 700;
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
<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="index.php?page=home">
            <div class="brand-mini-icon"><i class="bi bi-cup-hot-fill text-white"></i></div>
            <span class="fw-bold fs-6 brand-text">FORKOS <span class="text-orange">COFFEE</span></span>
        </a>
        <div class="d-none d-md-flex align-items-center gap-3">
            <a href="index.php?page=home" class="nav-link text-dark fw-semibold">Home</a>
            <a href="index.php?page=katalog" class="nav-link text-dark fw-semibold">Katalog Menu</a>
            <a href="index.php?page=voucher" class="nav-link text-dark fw-semibold">Voucher</a>
            <a href="index.php?page=pesanan" class="nav-link active fw-bold text-orange">Pesanan</a>
        </div>
        <span class="badge-ui d-md-none">UI-005</span>
    </div>
</nav>
<main class="container py-3 py-md-4 tracking-container">
<section class="tracking-frame bg-white">
    <span class="badge-ui tracking-badge">UI-005</span>

    <header class="tracking-header">
        <a href="index.php?page=checkout&amp;id=<?= (int)$order['item_id'] ?>&amp;outlet=<?= urlencode($outletId) ?>" class="tracking-back" aria-label="Kembali ke checkout">
            <i class="bi bi-chevron-left"></i>
        </a>
        <h1 class="tracking-title">Detail Pelacakan</h1>
    </header>

    <section class="order-meta" aria-label="Informasi pesanan">
        <div>
            <span class="meta-label">ID Pesanan</span>
            <span class="meta-value"><?= htmlspecialchars($order['id_pesanan']) ?></span>
        </div>
        <div>
            <span class="meta-label">Outlet</span>
            <span class="meta-value"><?= htmlspecialchars($order['outlet']) ?></span>
        </div>
    </section>

    <ol class="tracking-steps" aria-label="Status pesanan">
        <li class="tracking-step completed">
            <span class="step-indicator"><i class="bi bi-check-lg"></i></span>
            <div>
                <h2 class="step-name">Pesanan Diterima</h2>
                <p class="step-detail">09.42</p>
            </div>
        </li>
        <li class="tracking-step current" aria-current="step">
            <span class="step-indicator">2</span>
            <div>
                <h2 class="step-name">Sedang Dibuat</h2>
                <p class="step-detail"><?= htmlspecialchars($order['estimasi']) ?></p>
            </div>
        </li>
        <li class="tracking-step">
            <span class="step-indicator">3</span>
            <div>
                <h2 class="step-name">Siap Diambil</h2>
                <p class="step-detail">&mdash;</p>
            </div>
        </li>
        <li class="tracking-step">
            <span class="step-indicator">4</span>
            <div>
                <h2 class="step-name">Selesai</h2>
                <p class="step-detail">&mdash;</p>
            </div>
        </li>
    </ol>

    <section class="pickup-code-card" aria-label="Kode pengambilan">
        <span class="pickup-code-label">QR PICK-UP SEMENTARA</span>
        <strong class="pickup-code"><?= htmlspecialchars($order['pick_up_code']) ?></strong>
        <div class="pickup-code-qr" id="pickupQr" role="img" aria-label="QR sementara untuk kode pengambilan <?= htmlspecialchars($order['pick_up_code']) ?>"></div>
        <p class="pickup-instruction">Tunjukkan kode ini saat mengambil pesanan</p>
    </section>

    <section class="order-summary" aria-label="Ringkasan item">
        <div>
            <h2 class="summary-product"><?= (int)$order['kuantitas'] ?>&times; <?= htmlspecialchars($order['item_nama']) ?></h2>
            <p class="summary-customization"><?= htmlspecialchars($order['kustomisasi']) ?></p>
        </div>
        <p class="summary-price">Rp<?= number_format((int)$order['total_harga'] + 2000, 0, ',', '.') ?></p>
    </section>

    <a class="home-button" href="index.php">Kembali ke Home</a>

    <nav class="mobile-bottom-nav tracking-nav" aria-label="Navigasi bawah">
        <a href="index.php" class="nav-bottom-item active text-decoration-none">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
        </a>
        <a href="index.php?page=checkout&amp;id=<?= (int)$order['item_id'] ?>&amp;outlet=<?= urlencode($outletId) ?>" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-bag"></i>
            <span>Pesanan</span>
        </a>
    </nav>
</section>
</main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        new QRCode(document.getElementById('pickupQr'), {
            text: <?= json_encode($qrContent, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>,
            width: 88,
            height: 88,
            colorDark: '#1f242d',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });
    </script>
    </body>
    </html>
