<?php
/**
 * View: Detail Pelacakan Status Pesanan & Pick-up Code (UI-005)
 * Arsitektur: MVC - View Layer (Flat View)
 * Dokumen SDD: Bab 5.2.5 (UI-005)
 * 
 * @var array $order
 */
$order = $order ?? [
    'id_pesanan'   => 'FKS-240217-0832',
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body.mobile-viewport-body {
            background-color: #2b2b2b;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px 10px;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .mobile-frame-track {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 36px;
            padding: 26px 20px;
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.45);
        }
        .stepper-item {
            display: flex;
            align-items: flex-start;
            position: relative;
            padding-bottom: 20px;
        }
        .stepper-item:last-child {
            padding-bottom: 0;
        }
        .stepper-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 24px;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
        }
        .stepper-item.completed:not(:last-child)::before {
            background-color: var(--tomoro-orange, #fa5a00);
        }
        .stepper-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
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
            background-color: #111827;
            color: #ffffff;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .pickup-code-number {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: 3px;
            color: #ffffff;
            margin: 4px 0;
        }
        .qr-placeholder {
            width: 90px;
            height: 90px;
            background: #ffffff;
            border-radius: 12px;
            margin: 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111827;
        }
        .btn-back-link {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid #e3e5e8;
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #1f242d;
            text-decoration: none;
        }
    </style>
</head>
<body class="mobile-viewport-body">

<div class="mobile-frame-track">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="index.php" class="btn-back-link" title="Kembali">
            <i class="bi bi-chevron-left"></i>
        </a>
        <h6 class="fw-bold mb-0 text-dark">Detail Pelacakan</h6>
        <span class="badge-ui">UI-005</span>
    </div>

    <!-- ID Pesanan & Outlet -->
    <div class="bg-light p-3 rounded-4 d-flex justify-content-between align-items-center mb-3">
        <div>
            <div class="text-muted" style="font-size: 0.7rem;">ID Pesanan</div>
            <div class="fw-bold small text-dark"><?= htmlspecialchars($order['id_pesanan']) ?></div>
        </div>
        <div class="text-end">
            <div class="text-muted" style="font-size: 0.7rem;">Outlet Pengambilan</div>
            <div class="fw-bold small text-orange"><?= htmlspecialchars($order['outlet']) ?></div>
        </div>
    </div>

    <!-- Stepper Status Pesanan (SDD Bab 5.2.5) -->
    <div class="py-2 px-1 mb-2">
        <div class="stepper-item completed">
            <div class="stepper-dot"><i class="bi bi-check"></i></div>
            <div>
                <div class="fw-bold small text-dark">Pesanan Diterima</div>
                <div class="text-muted" style="font-size: 0.68rem;">09:42 WIB</div>
            </div>
        </div>
        <div class="stepper-item active">
            <div class="stepper-dot"><i class="bi bi-clock-fill"></i></div>
            <div>
                <div class="fw-bold small text-orange">Sedang Dibuat</div>
                <div class="text-muted" style="font-size: 0.68rem;"><?= htmlspecialchars($order['estimasi']) ?></div>
            </div>
        </div>
        <div class="stepper-item">
            <div class="stepper-dot">3</div>
            <div>
                <div class="fw-bold small text-muted">Siap Diambil</div>
                <div class="text-muted" style="font-size: 0.68rem;">Tunjukkan kode pengambilan ke kasir</div>
            </div>
        </div>
        <div class="stepper-item">
            <div class="stepper-dot">4</div>
            <div>
                <div class="fw-bold small text-muted">Selesai</div>
            </div>
        </div>
    </div>

    <!-- Panel Pick-Up Code & QR Code (SDD Gambar 5.6) -->
    <div class="pickup-code-box">
        <div class="text-uppercase tracking-wider text-white-50 small" style="font-size: 0.7rem;">PICK-UP CODE</div>
        <div class="pickup-code-number"><?= htmlspecialchars($order['pick_up_code']) ?></div>
        <div class="qr-placeholder">
            <i class="bi bi-qr-code text-dark" style="font-size: 3.5rem;"></i>
        </div>
        <div class="text-white-50" style="font-size: 0.65rem;">Tunjukkan kode ini ke barista outlet</div>
    </div>

    <!-- Rincian Ringkas Pesanan -->
    <div class="d-flex justify-content-between align-items-center py-2 px-1 border-top border-bottom mb-3">
        <div>
            <div class="fw-bold small text-dark"><?= $order['kuantitas'] ?>x <?= htmlspecialchars($order['item_nama']) ?></div>
            <div class="text-muted" style="font-size: 0.68rem;"><?= htmlspecialchars($order['kustomisasi']) ?></div>
        </div>
        <div class="fw-bold small text-orange">
            Rp<?= number_format($order['total_harga'], 0, ',', '.') ?>
        </div>
    </div>

    <!-- Tombol Kembali ke Home -->
    <a href="index.php" class="btn btn-coffee-submit py-2 text-decoration-none text-center d-block">
        Kembali ke Home
    </a>
</div>

</body>
</html>

