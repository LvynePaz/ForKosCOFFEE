<?php
/**
 * View: Katalog Menu & Kustomisasi (UI-003)
 * Arsitektur: MVC - View Layer (Flat View)
 * Dokumen SDD: Bab 5.2.3 (UI-003)
 * 
 * @var string $outlet
 * @var array  $produk
 * @var array  $kategori
 */
$outlet   = $outlet ?? 'TOMORO Coffee GC';
$outletId = $outletId ?? 'gc';
$produk   = $produk ?? [];
$kategori = $kategori ?? ['Semua', 'Kopi', 'Non-Kopi', 'Makanan', 'Snack'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Menu - ForKos Coffee</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        body.catalog-body {
            padding-bottom: 76px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        }
        .catalog-page {
            width: 100%;
            max-width: 1320px;
            margin-inline: auto;
        }
        .catalog-title {
            color: #1f242d;
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 800;
        }
        .catalog-subtitle {
            max-width: 620px;
            margin: 0 auto;
            color: #6c757d;
        }
        .catalog-outlet {
            width: min(100%, 760px);
            margin: 0 auto;
            padding: 16px 18px;
            border: 1px solid #ececec;
            border-radius: 16px;
            background: #fff;
        }
        .catalog-search-wrap {
            width: min(100%, 760px);
            margin: 22px auto 0;
        }
        .badge-ui {
            letter-spacing: 2px;
            border: 1.5px solid #c9ccd1;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
            padding: 3px 8px;
            color: #6b7280;
        }
        .btn-back {
            width: 36px; height: 36px;
            border: 1px solid #e3e5e8;
            border-radius: 10px;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            color: #1f242d; padding: 0;
            text-decoration: none;
        }
        .outlet-label { font-size: .78rem; color: #6c757d; line-height: 1.1; }
        .outlet-name  { font-size: 1.1rem; font-weight: 500; color: #1f242d; line-height: 1.25; }
        .btn-ganti-outlet {
            border: 1.5px solid var(--tomoro-orange);
            color: var(--tomoro-orange);
            background: #fff;
            border-radius: 10px;
            font-size: .72rem;
            font-weight: 700;
            padding: 8px 10px;
            text-decoration: none;
            line-height: 1;
        }
        .btn-ganti-outlet:hover { background: var(--tomoro-orange-light); color: var(--tomoro-orange); }
        .search-box {
            display: flex; align-items: center; gap: 10px;
            border: 1px solid #e3e5e8;
            border-radius: 14px;
            padding: 0 14px;
            height: 44px;
            background: #fff;
            margin-top: 0;
        }
        .search-box i { font-size: 1.05rem; color: #1f242d; }
        .search-box input {
            border: 0; outline: 0; width: 100%;
            font-size: .88rem; color: #1f242d; background: transparent;
        }
        .kategori-scroll {
            display: flex; gap: 10px;
            overflow-x: auto;
            justify-content: center;
            margin: 18px auto 0;
            padding: 4px 2px 8px;
            scrollbar-width: none;
        }
        .kategori-scroll::-webkit-scrollbar { display: none; }
        .pill-kategori {
            flex: 0 0 auto;
            border: 1px solid #dfe1e5;
            background: #fff;
            color: #1f242d;
            border-radius: 50px;
            font-size: .82rem;
            font-weight: 500;
            padding: 9px 15px;
            line-height: 1.2;
            cursor: pointer;
        }
        .pill-kategori.active {
            background: var(--tomoro-orange);
            border-color: var(--tomoro-orange);
            color: #fff;
            font-weight: 700;
            padding: 9px 16px;
        }
        .menu-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr));
            gap: 16px;
            margin-top: 24px;
        }
        .card-produk {
            display: flex; align-items: center; gap: 14px;
            min-width: 0;
            padding: 14px;
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .04);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }
        .card-produk:hover {
            border-color: var(--tomoro-orange-border);
            box-shadow: 0 8px 22px rgba(31, 36, 45, .08);
            transform: translateY(-2px);
        }
        .produk-img {
            width: 76px; height: 76px; flex: 0 0 76px;
            border-radius: 14px;
            background: var(--tomoro-orange-light);
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            color: var(--tomoro-orange);
            font-size: 1.8rem;
        }
        .produk-img img { width: 100%; height: 100%; object-fit: cover; }
        .produk-img img[hidden] { display: none; }
        .produk-img i[hidden] { display: none; }
        .produk-info { flex: 1; min-width: 0; }
        .produk-nama  { font-size: .98rem; font-weight: 700; color: #111; margin: 0 0 4px; line-height: 1.3; overflow-wrap: anywhere; }
        .produk-desc  { font-size: .76rem; color: #6c757d; margin: 0 0 8px; line-height: 1.45; }
        .produk-harga { font-size: 1rem; font-weight: 800; color: var(--tomoro-orange); margin: 0; line-height: 1; }
        .btn-tambah {
            width: 32px; height: 32px; flex: 0 0 32px;
            border: 0; border-radius: 9px;
            background: var(--tomoro-orange);
            color: #fff; font-size: 1.15rem;
            display: flex; align-items: center; justify-content: center;
            padding: 0;
            text-decoration: none;
            transition: background-color .15s ease, transform .15s ease;
        }
        .btn-tambah:hover { background: var(--tomoro-orange-hover); transform: scale(1.06); color: #fff; }
        .btn-tambah:focus-visible { outline: 3px solid rgba(250, 90, 0, .3); outline-offset: 3px; }
        .menu-kosong { display: none; grid-column: 1 / -1; text-align: center; color: #8c8c8c; font-size: .9rem; padding: 30px 0; }
        @media (max-width: 575.98px) {
            .catalog-outlet { padding: 14px; }
            .kategori-scroll { justify-content: flex-start; margin-left: -16px; margin-right: -16px; padding: 4px 16px 8px; }
            .menu-list { gap: 12px; margin-top: 18px; }
            .card-produk { gap: 11px; padding: 11px; }
            .produk-img { width: 64px; height: 64px; flex-basis: 64px; }
            .produk-nama { font-size: .9rem; }
            .produk-desc { font-size: .7rem; }
        }
    </style>
</head>

<body class="app-body catalog-body">
<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="index.php?page=home">
            <div class="brand-mini-icon"><i class="bi bi-cup-hot-fill text-white"></i></div>
            <span class="fw-bold fs-6 brand-text">FORKOS <span class="text-orange">COFFEE</span></span>
        </a>
        <div class="d-none d-md-flex align-items-center gap-3">
            <a href="index.php?page=home" class="nav-link text-dark fw-semibold">Home</a>
            <a href="index.php?page=katalog" class="nav-link active fw-bold text-orange">Katalog Menu</a>
            <a href="index.php?page=voucher" class="nav-link text-dark fw-semibold">Voucher</a>
            <a href="index.php?page=pesanan" class="nav-link text-dark fw-semibold">Pesanan</a>
        </div>
        <span class="badge-ui d-md-none">UI-003</span>
    </div>
</nav>

<main class="container py-3 py-md-4 catalog-page">
    <header class="text-center mb-4 mb-md-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge-ui d-none d-md-inline-block">UI-003</span>
            <span class="d-md-none"></span>
            <a href="index.php?page=menu-tambah" class="btn btn-sm btn-outline-tomoro rounded-pill px-3 fw-bold">
                <i class="bi bi-plus-lg me-1"></i>Tambah Menu
            </a>
        </div>
        <h1 class="catalog-title mb-2">Pilih Menu Favoritmu</h1>
        <p class="catalog-subtitle mb-0">Temukan kopi dan minuman favoritmu, dibuat segar untuk menemani harimu.</p>
    </header>

    <section class="catalog-outlet" aria-label="Outlet pilihan">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3 min-w-0">
                <div class="icon-pin-box flex-shrink-0">
                    <i class="bi bi-geo-alt-fill text-orange"></i>
                </div>
                <div class="min-w-0">
                    <div class="outlet-label">Outlet pilihan</div>
                    <div class="outlet-name"><?= htmlspecialchars($outlet) ?></div>
                </div>
            </div>
            <a href="index.php?page=home" class="btn-ganti-outlet flex-shrink-0">Ganti Outlet</a>
        </div>
    </section>

    <div class="catalog-search-wrap">
        <label class="visually-hidden" for="cariMenu">Cari menu</label>
        <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="cariMenu" placeholder="Cari kopi favoritmu" autocomplete="off">
        </div>
    </div>

    <div class="kategori-scroll" id="kategoriTab">
        <?php foreach ($kategori as $i => $k): ?>
            <button type="button"
                    class="pill-kategori <?= $i === 0 ? 'active' : '' ?>"
                    data-kategori="<?= htmlspecialchars($k) ?>"><?= htmlspecialchars($k) ?></button>
        <?php endforeach; ?>
    </div>

    <div class="menu-list" id="menuList">
        <?php foreach ($produk as $p): ?>
            <div class="card-produk"
                 data-nama="<?= htmlspecialchars(strtolower($p['nama'])) ?>"
                 data-kategori="<?= htmlspecialchars($p['kategori']) ?>">
                <div class="produk-img">
                     <?php if (!empty($p['gambar']) && is_file(dirname(__DIR__, 2) . '/' . ltrim($p['gambar'], '/\\'))): ?>
                         <img src="<?= htmlspecialchars($p['gambar']) ?>"
                              alt="<?= htmlspecialchars($p['nama']) ?>"
                              onerror="this.hidden=true; this.nextElementSibling.hidden=false">
                         <i class="bi bi-cup-hot-fill" aria-hidden="true" hidden></i>
                     <?php else: ?>
                         <i class="bi bi-cup-hot-fill" aria-hidden="true"></i>
                     <?php endif; ?>
                 </div>
                <div class="produk-info">
                    <h6 class="produk-nama"><?= htmlspecialchars($p['nama']) ?></h6>
                    <p class="produk-desc"><?= htmlspecialchars($p['deskripsi']) ?></p>
                    <p class="produk-harga">Rp<?= number_format($p['harga'], 0, ',', '.') ?></p>
                </div>
                <a href="index.php?page=checkout&amp;id=<?= (int)$p['id'] ?>&amp;outlet=<?= urlencode($outletId) ?>" class="btn-tambah"
                   title="Pilih <?= htmlspecialchars($p['nama']) ?>" aria-label="Pilih <?= htmlspecialchars($p['nama']) ?>">
                    <i class="bi bi-bag-plus" style="font-size: 0.95rem;"></i>
                </a>
            </div>
        <?php endforeach; ?>
        <div class="menu-kosong" id="menuKosong">Menu tidak ditemukan</div>
    </div>
</main>
<div class="mobile-bottom-nav d-md-none">
    <a href="index.php?page=home" class="nav-bottom-item text-decoration-none">
        <i class="bi bi-house-door-fill"></i>
        <span>Home</span>
    </a>
    <a href="index.php?page=pesanan" class="nav-bottom-item text-decoration-none">
        <i class="bi bi-bag"></i>
        <span>Pesanan</span>
    </a>
</div>

<script>
    (function () {
        const input = document.getElementById('cariMenu');
        const tabs  = document.querySelectorAll('.pill-kategori');
        const cards = document.querySelectorAll('.card-produk');
        const kosong = document.getElementById('menuKosong');
        let kategoriAktif = 'Semua';

        function terapkanFilter() {
            const q = input.value.trim().toLowerCase();
            let tampil = 0;
            cards.forEach(c => {
                const cocokNama = c.dataset.nama.includes(q);
                const cocokKat  = kategoriAktif === 'Semua' || c.dataset.kategori === kategoriAktif;
                const show = cocokNama && cocokKat;
                c.style.display = show ? 'flex' : 'none';
                if (show) tampil++;
            });
            kosong.style.display = tampil ? 'none' : 'block';
        }

        input.addEventListener('input', terapkanFilter);
        tabs.forEach(t => t.addEventListener('click', () => {
            tabs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            kategoriAktif = t.dataset.kategori;
            terapkanFilter();
        }));
    })();
</script>
</body>
</html>
