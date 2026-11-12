<?php
$item = $item ?? ['id' => 1, 'nama' => 'Caramel Macchiato', 'harga' => 28000];
$outlet = $outlet ?? 'ForKos Coffee GC';
$outletId = $outletId ?? 'gc';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang &amp; Checkout - ForKos Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body.checkout-body {
            padding-bottom: 76px;
        }
        .checkout-frame {
            width: 100%;
            max-width: none;
            margin: 0;
            display: flex;
            flex-direction: column;
            border-radius: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            transition: box-shadow .2s ease;
        }
        .checkout-frame:hover { box-shadow: 0 8px 26px rgba(31, 36, 45, .08); }
        .checkout-badge {
            color: #858585;
            border-color: #d1d1d1;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            padding: 5px 9px;
        }
        .checkout-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 14px 0 22px;
        }
        .checkout-back {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            display: grid;
            place-items: center;
            border: 1px solid #dedede;
            border-radius: 13px;
            color: #171717;
            font-size: 1.25rem;
            text-decoration: none;
        }
        .checkout-title {
            margin: 0;
            color: #171717;
            font-size: 1.5rem;
            font-weight: 400;
        }
        .pickup-card {
            display: flex;
            align-items: center;
            gap: 16px;
            min-height: 82px;
            padding: 14px 18px;
            border-radius: 20px;
            background: #fff5ef;
            color: var(--tomoro-orange);
        }
        .pickup-card i { font-size: 1.35rem; }
        .pickup-label {
            display: block;
            margin-bottom: 2px;
            color: #777;
            font-size: .9rem;
        }
        .pickup-name {
            color: #171717;
            font-size: 1rem;
            font-weight: 700;
        }
        .checkout-section-title {
            margin: 26px 0 14px;
            color: #171717;
            font-size: 1.3rem;
            font-weight: 400;
        }
        .order-card {
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 120px;
            padding: 12px;
            border: 1px solid #e6e6e6;
            border-radius: 20px;
        }
        .order-image {
            width: 84px;
            height: 84px;
            flex: 0 0 84px;
            display: grid;
            place-items: center;
            border-radius: 15px;
            background: #fafafa;
            color: #aa5a00;
            font-size: 2.5rem;
        }
        .order-info { flex: 1; min-width: 0; }
        .order-name {
            margin: 0 0 7px;
            color: #171717;
            font-size: .95rem;
            font-weight: 700;
        }
        .order-customization {
            margin: 0;
            color: #777;
            font-size: .72rem;
            line-height: 1.5;
        }
        .edit-item {
            display: inline-block;
            margin-top: 6px;
            color: var(--tomoro-orange);
            font-size: .78rem;
            font-weight: 700;
            text-decoration: none;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #171717;
            font-weight: 700;
        }
        .quantity-button {
            width: 32px;
            height: 32px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 12px;
            background: #f0f0f0;
            color: #171717;
            font-weight: 700;
        }
        .voucher-card {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
            padding: 16px;
            border: 1.5px dashed var(--tomoro-orange);
            border-radius: 18px;
            background: #fff;
            text-align: left;
        }
        .voucher-title {
            display: block;
            color: var(--tomoro-orange);
            font-size: .95rem;
            font-weight: 700;
        }
        .voucher-hint {
            display: block;
            margin-top: 3px;
            color: #888;
            font-size: .72rem;
        }
        .voucher-card > i { color: #171717; font-size: 1.1rem; }
        .payment-options {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }
        .payment-option {
            min-width: 0;
            min-height: 50px;
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px;
            border: 1px solid #dedede;
            border-radius: 15px;
            color: #171717;
            cursor: pointer;
        }
        .payment-option.selected { border: 1.5px solid var(--tomoro-orange); }
        .payment-option > i { font-size: 1.2rem; }
        .payment-option span {
            flex: 1;
            white-space: nowrap;
            font-size: .69rem;
            font-weight: 700;
        }
        .payment-option input {
            width: 16px;
            height: 16px;
            flex: 0 0 16px;
            margin: 0;
            accent-color: var(--tomoro-orange);
        }
        .payment-summary {
            margin-top: 22px;
            padding-top: 1px;
            border-top: 1px solid #e9e9e9;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            color: #171717;
            font-size: .85rem;
        }
        .summary-row strong { font-weight: 700; }
        .summary-total {
            margin-top: 12px;
            padding-top: 14px;
            border-top: 1px solid #e9e9e9;
            font-size: 1.05rem;
        }
        .summary-total strong {
            color: var(--tomoro-orange);
            font-size: 1.2rem;
        }
        .checkout-action {
            margin-top: auto;
            padding-top: 24px;
        }
        .pay-button {
            display: flex;
            width: 100%;
            min-height: 68px;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 19px;
            border: 0;
            border-radius: 18px;
            background: #ff6900;
            color: #fff;
            font-size: .9rem;
            font-weight: 800;
            text-decoration: none;
        }
        .pay-button:hover,
        .pay-button:focus-visible {
            background: var(--tomoro-orange-hover);
            color: #fff;
        }
        @media (max-width: 380px) {
            .payment-option { gap: 5px; padding: 7px 5px; }
            .payment-option span { font-size: .62rem; }
        }
        @media (min-width: 768px) {
            .checkout-frame { padding: 32px; }
        }
        @media (min-width: 992px) {
            .checkout-frame {
                display: grid;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
                column-gap: clamp(24px, 4vw, 56px);
                align-content: start;
            }
            .checkout-badge,
            .checkout-heading,
            .pickup-card { grid-column: 1 / -1; }
            .checkout-order { grid-column: 1; grid-row: 4; }
            .voucher-card { grid-column: 1; grid-row: 5; align-self: start; }
            .checkout-payment { grid-column: 2; grid-row: 4; }
            .payment-summary { grid-column: 2; grid-row: 5; }
            .checkout-action { grid-column: 2; grid-row: 6; }
        }
    </style>
</head>
<body class="app-body checkout-body">
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
            <a href="index.php?page=pesanan" class="nav-link text-dark fw-semibold">Pesanan</a>
        </div>
        <span class="badge-ui d-md-none">UI-004</span>
    </div>
</nav>
<main class="container py-3 py-md-4 checkout-container">
<section class="checkout-frame bg-white p-3 p-md-4">
    <span class="badge-ui checkout-badge">UI-004</span>

    <header class="checkout-heading">
        <a href="index.php?page=katalog&amp;outlet=<?= urlencode($outletId) ?>" class="checkout-back" aria-label="Kembali ke katalog">
            <i class="bi bi-chevron-left"></i>
        </a>
        <h1 class="checkout-title">Keranjang &amp; Checkout</h1>
    </header>

    <section class="pickup-card" aria-label="Outlet pengambilan">
        <i class="bi bi-geo-alt"></i>
        <div>
            <span class="pickup-label">Ambil di</span>
            <span class="pickup-name"><?= htmlspecialchars($outlet) ?></span>
        </div>
    </section>

    <section class="checkout-order" aria-labelledby="order-heading">
        <h2 class="checkout-section-title" id="order-heading">Pesanan kamu</h2>
        <div class="order-card">
            <div class="order-image" aria-hidden="true">
                <i class="bi bi-cup-hot-fill"></i>
            </div>
            <div class="order-info">
                <h3 class="order-name"><?= htmlspecialchars($item['nama']) ?></h3>
                <p class="order-customization">Reguler &bull; Gula Normal<br>Tanpa topping</p>
                <a class="edit-item" href="index.php?page=katalog&amp;outlet=<?= urlencode($outletId) ?>">Ubah Item</a>
            </div>
            <div class="quantity-control" aria-label="Jumlah item">
                <button class="quantity-button" type="button" id="kurangi" aria-label="Kurangi jumlah">&minus;</button>
                <span id="jumlah">1</span>
                <button class="quantity-button" type="button" id="tambah" aria-label="Tambah jumlah">&plus;</button>
            </div>
        </div>
    </section>

    <button class="voucher-card" type="button">
        <span>
            <span class="voucher-title">Pakai Voucher</span>
            <span class="voucher-hint">Punya kode promo?</span>
        </span>
        <i class="bi bi-chevron-right"></i>
    </button>

    <section class="checkout-payment" aria-labelledby="payment-heading">
        <h2 class="checkout-section-title" id="payment-heading">Metode pembayaran</h2>
        <div class="payment-options">
            <label class="payment-option">
                <i class="bi bi-wallet2"></i>
                <span>E-Wallet</span>
                <input type="radio" name="pembayaran" value="ewallet" form="checkoutForm" aria-label="E-Wallet">
            </label>
            <label class="payment-option selected">
                <i class="bi bi-wallet2"></i>
                <span>QRIS</span>
                <input type="radio" name="pembayaran" value="qris" form="checkoutForm" checked aria-label="QRIS">
            </label>
            <label class="payment-option">
                <i class="bi bi-wallet2"></i>
                <span>Transfer</span>
                <input type="radio" name="pembayaran" value="transfer" form="checkoutForm" aria-label="Transfer">
            </label>
        </div>
    </section>

    <section class="payment-summary" aria-labelledby="summary-heading">
        <h2 class="checkout-section-title" id="summary-heading">Ringkasan pembayaran</h2>
        <div class="summary-row">
            <span>Subtotal</span>
            <strong id="subtotal">Rp<?= number_format((int)$item['harga'], 0, ',', '.') ?></strong>
        </div>
        <div class="summary-row">
            <span>Biaya layanan</span>
            <strong>Rp2.000</strong>
        </div>
        <div class="summary-row summary-total">
            <span>Total</span>
            <strong id="total">Rp<?= number_format((int)$item['harga'] + 2000, 0, ',', '.') ?></strong>
        </div>
    </section>

    <div class="checkout-action">
        <form id="checkoutForm" action="index.php?page=pelacakan" method="post">
            <input type="hidden" name="item_id" value="<?= (int)$item['id'] ?>">
            <input type="hidden" name="quantity" id="quantityInput" value="1">
            <input type="hidden" name="outlet" value="<?= htmlspecialchars($outletId, ENT_QUOTES, 'UTF-8') ?>">
        </form>
        <button class="pay-button" type="submit" form="checkoutForm">
            <span>Bayar Sekarang</span>
            <span id="totalTombol">Rp<?= number_format((int)$item['harga'] + 2000, 0, ',', '.') ?></span>
        </button>
    </div>
</section>
</main>
<div class="mobile-bottom-nav d-md-none">
    <a href="index.php?page=home" class="nav-bottom-item text-decoration-none">
        <i class="bi bi-house-door-fill"></i>
        <span>Home</span>
    </a>
    <a href="index.php?page=katalog" class="nav-bottom-item active text-decoration-none">
        <i class="bi bi-bag"></i>
        <span>Pesan</span>
    </a>
</div>
<script>
    (() => {
        const hargaItem = <?= (int)$item['harga'] ?>;
        const biayaLayanan = 2000;
        let jumlah = 1;
        const formatRupiah = nilai => 'Rp' + nilai.toLocaleString('id-ID');
        const jumlahEl = document.getElementById('jumlah');
        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('total');
        const totalTombolEl = document.getElementById('totalTombol');
        const quantityInput = document.getElementById('quantityInput');

        function perbaruiRingkasan() {
            jumlahEl.textContent = jumlah;
            quantityInput.value = jumlah;
            subtotalEl.textContent = formatRupiah(hargaItem * jumlah);
            const total = formatRupiah(hargaItem * jumlah + biayaLayanan);
            totalEl.textContent = total;
            totalTombolEl.textContent = total;
        }

        document.getElementById('kurangi').addEventListener('click', () => {
            jumlah = Math.max(1, jumlah - 1);
            perbaruiRingkasan();
        });
        document.getElementById('tambah').addEventListener('click', () => {
            jumlah += 1;
            perbaruiRingkasan();
        });
        document.querySelectorAll('input[name="pembayaran"]').forEach(input => {
            input.addEventListener('change', () => {
                document.querySelectorAll('.payment-option').forEach(option => {
                    option.classList.toggle('selected', option.contains(input) && input.checked);
                });
            });
        });
    })();
</script>
</body>
</html>
