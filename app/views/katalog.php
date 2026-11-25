<?php
$userName    = $_SESSION['user_name'] ?? 'Cikocut';
$outletParam = $_GET['outlet'] ?? 'gc';
$outletName  = ($outletParam === 'batu_ampar') ? 'ForKos Coffee Batu Ampar' : 'ForKos Coffee GC';

// Ambil data dari controller ($menus atau $products) jika tersedia, atau gunakan daftar bawaan
$rawItems = (!empty($menus) && is_array($menus)) ? $menus : ((!empty($products) && is_array($products)) ? $products : []);

$menuList = !empty($rawItems) ? $rawItems : [
    [
        'id'        => 1,
        'nama'      => 'Caramel Macchiato',
        'deskripsi' => 'Espresso, susu, dan karamel lembut',
        'harga'     => 28000,
        'kategori'  => 'Kopi',
    ],
    [
        'id'        => 2,
        'nama'      => 'Coffe Aren Latte',
        'deskripsi' => 'Kopi susu dengan gula aren asli',
        'harga'     => 24000,
        'kategori'  => 'Kopi',
    ],
    [
        'id'        => 3,
        'nama'      => 'Caffe Latte',
        'deskripsi' => 'Espresso dengan susu segar',
        'harga'     => 25000,
        'kategori'  => 'Kopi',
    ],
    [
        'id'        => 4,
        'nama'      => 'Americano',
        'deskripsi' => 'Espresso klasik dengan air mineral',
        'harga'     => 20000,
        'kategori'  => 'Kopi',
    ],
    [
        'id'        => 5,
        'nama'      => 'Cappuccino',
        'deskripsi' => 'Espresso dengan busa susu lembut',
        'harga'     => 26000,
        'kategori'  => 'Kopi',
    ],
    [
        'id'        => 6,
        'nama'      => 'Matcha Oat Latte',
        'deskripsi' => 'Matcha premium dengan susu oat',
        'harga'     => 29000,
        'kategori'  => 'Non-Kopi',
    ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Menu - ForKos Coffee</title>
    <!-- Bootstrap 5 CDN & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .katalog-header {
            text-align: center;
            max-width: 620px;
            margin: 0 auto 24px auto;
        }

        .outlet-selector-box {
            background: #ffffff;
            border: 1.5px solid #ececec;
            border-radius: 18px;
            padding: 14px 20px;
            max-width: 580px;
            margin: 0 auto 16px auto;
        }

        .search-bar-box {
            background: #ffffff;
            border: 1.5px solid #ececec;
            border-radius: 50px;
            padding: 8px 18px;
            max-width: 580px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: border-color 0.2s ease;
        }

        .search-bar-box:focus-within {
            border-color: #fa5a00;
        }

        .search-bar-box input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 0.9rem;
            color: #1f242d;
            background: transparent;
        }

        .category-pills-wrapper {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 28px;
        }

        .category-pill {
            background: #ffffff;
            border: 1.5px solid #e5e7eb;
            color: #4b5563;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 18px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .category-pill:hover {
            border-color: #fa5a00;
            color: #fa5a00;
        }

        .category-pill.active {
            background-color: #fa5a00;
            border-color: #fa5a00;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(250, 90, 0, 0.25);
        }

        .menu-product-card {
            background: #ffffff;
            border: 1.5px solid #ececec;
            border-radius: 18px;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .menu-product-card:hover {
            transform: translateY(-2px);
            border-color: #ffd8c2;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .menu-icon-thumb {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background-color: #fff5ef;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .menu-icon-thumb i {
            font-size: 1.65rem;
            color: #fa5a00;
        }

        .btn-add-cart {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background-color: #fa5a00;
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(250, 90, 0, 0.25);
            transition: background-color 0.2s ease, transform 0.15s ease;
        }

        .btn-add-cart:hover {
            background-color: #e04e00;
            color: #ffffff;
            transform: scale(1.05);
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
                <span class="badge-ui">UI-003</span>
            </div>
            
            <!-- Menu Navigasi Desktop -->
            <div class="d-none d-md-flex align-items-center gap-3">
                <div class="forkos-nav-links">
                    <a href="index.php?page=home" class="forkos-nav-link">Home</a>
                    <a href="index.php?page=katalog" class="forkos-nav-link active">Katalog Menu</a>
                    <a href="index.php?page=voucher" class="forkos-nav-link">Voucher</a>
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
    <main class="container py-3 py-md-4">

        <!-- Header Terpusat -->
        <div class="katalog-header">
            <h2 class="fw-bold text-dark mb-2">Pilih Menu Favoritmu</h2>
            <p class="text-muted small mb-0">Temukan kopi dan minuman favoritmu, dibuat segar untuk menemani harimu.</p>
        </div>

        <!-- Kartu Outlet Pilihan -->
        <div class="outlet-selector-box d-flex justify-content-between align-items-center shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-pin-box">
                    <i class="bi bi-geo-alt-fill text-orange fs-5"></i>
                </div>
                <div>
                    <span class="d-block text-muted" style="font-size: 0.72rem;">Outlet pilihan</span>
                    <span class="fw-bold text-dark" style="font-size: 0.95rem;"><?= htmlspecialchars($outletName) ?></span>
                </div>
            </div>
            <a href="index.php?page=home" class="btn btn-outline-tomoro btn-sm px-3 rounded-pill" style="font-size: 0.78rem;">
                Ganti Outlet
            </a>
        </div>

        <!-- Kolom Pencarian -->
        <div class="search-bar-box shadow-sm">
            <i class="bi bi-search text-muted"></i>
            <input type="text" id="searchMenuInput" placeholder="Cari kopi favoritmu" onkeyup="filterMenu()">
        </div>

        <!-- Filter Kategori -->
        <div class="category-pills-wrapper">
            <button type="button" class="category-pill active" onclick="pilihKategori('Semua', this)">Semua</button>
            <button type="button" class="category-pill" onclick="pilihKategori('Kopi', this)">Kopi</button>
            <button type="button" class="category-pill" onclick="pilihKategori('Non-Kopi', this)">Non-Kopi</button>
            <button type="button" class="category-pill" onclick="pilihKategori('Makanan', this)">Makanan</button>
            <button type="button" class="category-pill" onclick="pilihKategori('Snack', this)">Snack</button>
        </div>

        <!-- Grid Daftar Menu -->
        <div class="row g-3" id="menuGridContainer">
            <?php foreach ($menuList as $item): ?>
                <?php
                    $id        = $item['id'] ?? 1;
                    $nama      = $item['nama'] ?? ($item['nama_menu'] ?? 'Menu Kopi');
                    $deskripsi = $item['deskripsi'] ?? 'Racikan spesial ForKos Coffee';
                    $harga     = $item['harga'] ?? 25000;
                    $kategori  = $item['kategori'] ?? 'Kopi';
                ?>
                <div class="col-12 col-md-6 col-lg-4 menu-card-col"
                     data-nama="<?= htmlspecialchars(strtolower($nama)) ?>"
                     data-kategori="<?= htmlspecialchars($kategori) ?>">
                    <div class="menu-product-card shadow-sm">
                        <div class="d-flex align-items-center gap-3 overflow-hidden">
                            <div class="menu-icon-thumb">
                                <i class="bi bi-cup-hot-fill"></i>
                            </div>
                            <div class="text-truncate">
                                <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.92rem;">
                                    <?= htmlspecialchars($nama) ?>
                                </h6>
                                <p class="text-muted mb-1 text-truncate" style="font-size: 0.74rem;">
                                    <?= htmlspecialchars($deskripsi) ?>
                                </p>
                                <span class="fw-bold text-orange" style="font-size: 0.88rem;">
                                    Rp<?= number_format($harga, 0, ',', '.') ?>
                                </span>
                            </div>
                        </div>

                        <a href="index.php?page=katalog&amp;action=add&amp;id=<?= urlencode((string)$id) ?>&amp;outlet=<?= urlencode($outletId) ?>"
                           class="btn-add-cart text-decoration-none"
                           title="Tambah <?= htmlspecialchars($nama) ?> ke Keranjang">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Floating Cart Bar (Kotak Panjang Keranjang Saat Ada Menu Dipilih) -->
        <?php if (!empty($cartCount) && $cartCount > 0): ?>
            <div class="fixed-bottom p-3 d-flex justify-content-center" style="z-index: 1040;">
                <div class="shadow-lg rounded-pill px-4 py-3 d-flex align-items-center justify-content-between" style="width: min(92%, 620px); background: #1f242d; color: #ffffff;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="position-relative">
                            <i class="bi bi-bag-check-fill fs-3 text-orange"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                                <?= $cartCount ?>
                            </span>
                        </div>
                        <div>
                            <span class="d-block fw-bold text-white small"><?= $cartCount ?> Menu Dipilih</span>
                            <span class="text-orange fw-bold" style="font-size: 0.95rem;">Rp<?= number_format($cartTotal, 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <a href="index.php?page=checkout&amp;outlet=<?= urlencode($outletId) ?>" class="btn rounded-pill px-4 py-2 fw-bold text-white d-flex align-items-center gap-2" style="background-color: var(--tomoro-orange, #fa5a00); border: 0;">
                        <span>Lihat Keranjang</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>

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

    <!-- Script Pencarian & Filter Kategori -->
    <script>
        let kategoriAktif = 'Semua';

        function pilihKategori(kategori, tombol) {
            kategoriAktif = kategori;
            document.querySelectorAll('.category-pill').forEach(btn => btn.classList.remove('active'));
            tombol.classList.add('active');
            filterMenu();
        }

        function filterMenu() {
            const kataKunci = document.getElementById('searchMenuInput').value.toLowerCase();
            const cards = document.querySelectorAll('.menu-card-col');

            cards.forEach(card => {
                const namaMenu = card.getAttribute('data-nama');
                const katMenu  = card.getAttribute('data-kategori');
                const cocokNama = namaMenu.includes(kataKunci);
                const cocokKat  = (kategoriAktif === 'Semua' || katMenu.toLowerCase() === kategoriAktif.toLowerCase());

                card.style.display = (cocokNama && cocokKat) ? '' : 'none';
            });
        }
    </script>
</body>
</html>