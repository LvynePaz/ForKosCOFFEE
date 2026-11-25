<?php
$userName    = $_SESSION['user_name'] ?? 'Cikocut';
$claimedCode = trim($_GET['claim'] ?? '');

$voucherList = (!empty($vouchers) && is_array($vouchers)) ? $vouchers : [
    [
        'badge'       => '30% OFF',
        'judul'       => 'Diskon 30% Ambil Sendiri',
        'deskripsi'   => 'Khusus pesanan pick-up mandiri di outlet ForKos Coffee',
        'kode'        => 'yiesanlimaratusjadirefund',
        'status'      => 'Tersedia',
    ],
    [
        'badge'       => 'Rp5.000 OFF',
        'judul'       => 'Potongan Rp5.000',
        'deskripsi'   => 'Minimal belanja Rp25.000 untuk semua varian kopi',
        'kode'        => 'FORKOSHEMAT',
        'status'      => 'Tersedia',
    ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kupon & Voucher - ForKos Coffee</title>
    <!-- Bootstrap 5 CDN & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .voucher-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 28px auto;
        }

        .voucher-card {
            background: #fff9f5;
            border: 1.5px dashed #fa5a00;
            border-radius: 18px;
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .voucher-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(250, 90, 0, 0.12);
        }

        .voucher-badge {
            display: inline-block;
            background-color: #dc3545;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            margin-bottom: 10px;
            width: fit-content;
        }

        .voucher-code-box {
            background: #ffffff;
            border: 1px solid #ececec;
            border-radius: 12px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-top: 14px;
        }

        .voucher-code-text {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fa5a00;
            word-break: break-all;
        }

        .btn-copy-code {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #1f242d;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 8px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .btn-copy-code:hover {
            background: #fa5a00;
            border-color: #fa5a00;
            color: #ffffff;
        }

        .btn-copy-code.copied {
            background: #198754;
            border-color: #198754;
            color: #ffffff;
        }

        .btn-pesan-sekarang {
            background-color: #fa5a00;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 12px 28px;
            font-weight: 700;
            font-size: 0.92rem;
            box-shadow: 0 6px 16px rgba(250, 90, 0, 0.28);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-pesan-sekarang:hover {
            background-color: #e04e00;
            color: #ffffff;
            transform: translateY(-2px);
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
                <span class="badge-ui">PROMO</span>
            </div>
            
            <!-- Menu Navigasi Desktop -->
            <div class="d-none d-md-flex align-items-center gap-3">
                <div class="forkos-nav-links">
                    <a href="index.php?page=home" class="forkos-nav-link">Home</a>
                    <a href="index.php?page=katalog" class="forkos-nav-link">Katalog Menu</a>
                    <a href="index.php?page=voucher" class="forkos-nav-link active">Voucher</a>
                    <a href="index.php?page=pesanan" class="forkos-nav-link">Pesanan</a>
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

    <!-- Konten Utama -->
    <main class="container py-4 py-md-5">

        <!-- Header Terpusat -->
        <div class="voucher-header">
            <h2 class="fw-bold text-dark mb-2">Kupon & Voucher Saya</h2>
            <p class="text-muted mb-0">Gunakan kode voucher saat checkout untuk menikmati potongan harga menarik.</p>
        </div>

        <!-- Notifikasi Jika Baru Klaim Voucher dari Home -->
        <?php if (!empty($claimedCode)): ?>
            <div class="alert alert-success d-flex align-items-center justify-content-between rounded-4 shadow-sm mb-4 mx-auto" style="max-width: 820px;">
                <div>
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Voucher <strong><?= htmlspecialchars($claimedCode) ?></strong> berhasil diklaim dan siap dipakai saat checkout!
                </div>
                <button type="button" class="btn-close btn-sm" onclick="this.parentElement.remove()"></button>
            </div>
        <?php endif; ?>

        <!-- Grid Kartu Voucher -->
        <div class="row g-3 g-md-4 justify-content-center mx-auto" style="max-width: 860px;">
            <?php foreach ($voucherList as $v): ?>
                <?php
                    $badge     = $v['badge'] ?? 'PROMO';
                    $judul     = $v['judul'] ?? ($v['nama_voucher'] ?? 'Promo Spesial');
                    $deskripsi = $v['deskripsi'] ?? 'Berlaku untuk pemesanan di ForKos Coffee';
                    $kode      = $v['kode'] ?? ($v['kode_voucher'] ?? '');
                ?>
                <div class="col-12 col-md-6">
                    <div class="voucher-card shadow-sm">
                        <div>
                            <span class="voucher-badge"><?= htmlspecialchars($badge) ?></span>
                            <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($judul) ?></h5>
                            <p class="text-muted small mb-0"><?= htmlspecialchars($deskripsi) ?></p>
                        </div>

                        <div class="voucher-code-box">
                            <span class="voucher-code-text"><?= htmlspecialchars($kode) ?></span>
                            <button type="button"
                                    class="btn-copy-code"
                                    onclick="salinKode('<?= htmlspecialchars($kode, ENT_QUOTES) ?>', this)">
                                <i class="bi bi-clipboard me-1"></i>Salin
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tombol Aksi ke Katalog Menu -->
        <div class="text-center mt-4 mt-md-5">
            <a href="index.php?page=katalog" class="btn-pesan-sekarang text-decoration-none">
                <i class="bi bi-cup-hot-fill"></i> Pesan Kopi Sekarang
            </a>
        </div>

    </main>

    <!-- Bottom Navigation Bar (Khusus Layar HP) -->
    <div class="mobile-bottom-nav d-md-none">
        <a href="index.php?page=home" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-house-door"></i>
            <span>Home</span>
        </a>
        <a href="index.php?page=pesanan" class="nav-bottom-item text-decoration-none">
            <i class="bi bi-bag"></i>
            <span>Pesanan</span>
        </a>
    </div>

    <!-- Script Salin Kode Voucher -->
    <script>
        function salinKode(kode, tombol) {
            navigator.clipboard.writeText(kode).then(() => {
                const teksAsli = tombol.innerHTML;
                tombol.classList.add('copied');
                tombol.innerHTML = '<i class="bi bi-check2 me-1"></i>Tersalin';
                setTimeout(() => {
                    tombol.classList.remove('copied');
                    tombol.innerHTML = teksAsli;
                }, 1800);
            });
        }
    </script>
</body>
</html>