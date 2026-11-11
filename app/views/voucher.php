<?php
/**
 * View: Daftar Voucher & Kupon Promo
 * Arsitektur: MVC - View Layer (Flat View)
 * Dokumen SDD: Bab 4.1 & Bab 5.2.2
 * 
 * @var array $vouchers
 */
$vouchers = $vouchers ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Promo - ForKos Coffee</title>
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
        .mobile-frame-voucher {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 36px;
            padding: 26px 20px;
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.45);
        }
        .voucher-ticket {
            background: #fff8f5;
            border: 1.5px dashed var(--tomoro-orange, #fa5a00);
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 12px;
            position: relative;
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

<div class="mobile-frame-voucher">
    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="index.php" class="btn-back-link" title="Kembali">
            <i class="bi bi-chevron-left"></i>
        </a>
        <h6 class="fw-bold mb-0 text-dark">Kupon & Voucher Saya</h6>
        <span class="badge-ui">PROMO</span>
    </div>

    <p class="text-muted small mb-3">Gunakan kode voucher saat checkout untuk menikmati potongan harga menarik.</p>

    <!-- Daftar Tiket Voucher -->
    <?php foreach ($vouchers as $v): ?>
        <div class="voucher-ticket">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="badge bg-danger rounded-pill px-2 py-1 small"><?= htmlspecialchars($v['diskon']) ?> OFF</span>
                    <h6 class="fw-bold text-dark mt-2 mb-1"><?= htmlspecialchars($v['judul']) ?></h6>
                    <p class="text-muted small mb-2" style="font-size: 0.72rem;"><?= htmlspecialchars($v['deskripsi']) ?></p>
                </div>
            </div>
            <div class="bg-white p-2 rounded-3 border d-flex justify-content-between align-items-center">
                <code class="fw-bold text-orange" style="font-size: 0.85rem;"><?= htmlspecialchars($v['kode']) ?></code>
                <span class="badge bg-light text-muted border">Tersedia</span>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="mt-4">
        <a href="index.php?page=katalog" class="btn btn-coffee-submit py-2 text-decoration-none text-center d-block">
            Pesan Kopi Sekarang
        </a>
    </div>
</div>

</body>
</html>

