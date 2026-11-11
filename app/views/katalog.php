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
        body.mobile-viewport-body {
            background: #ffffff;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            align-items: flex-start;
        }
        .mobile-frame.katalog-frame {
            border-radius: 0;
            padding: 24px 20px 20px;
            min-height: 876px;
            box-shadow: 0 40px 70px rgba(0, 0, 0, .55);
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
            margin-top: 20px;
        }
        .search-box i { font-size: 1.05rem; color: #1f242d; }
        .search-box input {
            border: 0; outline: 0; width: 100%;
            font-size: .88rem; color: #1f242d; background: transparent;
        }
        .kategori-scroll {
            display: flex; gap: 10px;
            overflow-x: auto;
            margin: 14px -20px 0 0;
            padding: 4px 20px 4px 0;
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
        .menu-list { margin-top: 14px; display: flex; flex-direction: column; gap: 14px; }
        .card-produk {
            display: flex; align-items: center; gap: 14px;
            padding: 10px 14px 10px 10px;
            background: #fff;
            border: 1px solid #ececec;
            border-radius: 18px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }
        .produk-img {
            width: 82px; height: 82px; flex: 0 0 82px;
            border-radius: 14px;
            background: #f5f5f6;
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .produk-img img { width: 100%; height: 100%; object-fit: cover; }
        .produk-info { flex: 1; min-width: 0; }
        .produk-nama  { font-size: 1.05rem; font-weight: 700; color: #111; margin: 0 0 4px; line-height: 1.2; }
        .produk-desc  { font-size: .68rem; color: #6c757d; margin: 0 0 8px; line-height: 1.3; }
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
        .menu-kosong { display: none; text-align: center; color: #8c8c8c; font-size: .85rem; padding: 30px 0; }
    </style>
</head>

<body class="mobile-viewport-body">
<div class="mobile-frame katalog-frame">

    <div class="d-flex justify-content-between align-items-center">
        <span class="badge-ui">UI-003</span>
        <a href="index.php?page=menu-tambah" class="btn btn-sm btn-outline-danger py-0 px-2 fw-bold" style="font-size: 0.75rem;">+ Tambah Menu Baru</a>
    </div>

    <div class="d-flex align-items-center justify-content-between mt-3">
        <div class="d-flex align-items-center gap-3">
            <a href="index.php" class="btn-back" aria-label="Kembali">
                <i class="bi bi-chevron-left"></i>
            </a>
            <div>
                <div class="outlet-label">Outlet pilihan</div>
                <div class="outlet-name"><?= htmlspecialchars($outlet) ?></div>
            </div>
        </div>
        <a href="index.php" class="btn-ganti-outlet">Ganti Outlet</a>
    </div>

    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="cariMenu" placeholder="Cari kopi favoritmu" autocomplete="off">
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
                    <img src="<?= htmlspecialchars($p['gambar']) ?>"
                         alt="<?= htmlspecialchars($p['nama']) ?>"
                         onerror="this.style.display='none'">
                </div>
                <div class="produk-info">
                    <h6 class="produk-nama"><?= htmlspecialchars($p['nama']) ?></h6>
                    <p class="produk-desc"><?= htmlspecialchars($p['deskripsi']) ?></p>
                    <p class="produk-harga">Rp<?= number_format($p['harga'], 0, ',', '.') ?></p>
                </div>
                <a href="index.php?page=menu-edit&id=<?= (int)$p['id'] ?>" class="btn-tambah"
                   title="Edit Menu <?= htmlspecialchars($p['nama']) ?>">
                    <i class="bi bi-pencil-square" style="font-size: 0.95rem;"></i>
                </a>
            </div>
        <?php endforeach; ?>
        <div class="menu-kosong" id="menuKosong">Menu tidak ditemukan</div>
    </div>

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

