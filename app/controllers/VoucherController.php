<?php
/**
 * Controller VoucherController
 * Arsitektur: MVC - Controller Layer
 * Dokumen SDD: Bab 1.4 & Bab 4.1 (Voucher & DiskonStrategy)
 */

class VoucherController {
    /**
     * Menampilkan daftar voucher dan promo aktif
     */
    public function index(): void {
        $vouchers = [
            [
                'kode'      => 'yiesanlimaratusjadirefund',
                'judul'     => 'Diskon 30% Ambil Sendiri',
                'deskripsi' => 'Khusus pesanan pick-up mandiri di outlet ForKos Coffee',
                'diskon'    => '30%',
                'status'    => 'Aktif'
            ],
            [
                'kode'      => 'FORKOSHEMAT',
                'judul'     => 'Potongan Rp5.000',
                'deskripsi' => 'Minimal belanja Rp25.000 untuk semua varian kopi',
                'diskon'    => 'Rp5.000',
                'status'    => 'Aktif'
            ]
        ];

        $this->renderView('voucher', [
            'vouchers' => $vouchers
        ]);
    }

    private function renderView(string $viewName, array $data = []): void {
        extract($data);
        $fullPath = dirname(__DIR__) . '/views/' . $viewName . '.php';

        if (!file_exists($fullPath)) {
            die("File view tidak ditemukan: " . htmlspecialchars($fullPath));
        }

        require $fullPath;
    }
}
