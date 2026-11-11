<?php
/**
 * Controller OrderController
 * Arsitektur: MVC - Controller Layer
 * Dokumen SDD: Bab 1.4 & Bab 5.2.5 (UI-005 Halaman Detail Pelacakan Status Pesanan & Pick-up Code)
 */

class OrderController {
    /**
     * Menampilkan halaman pelacakan status pesanan aktif (UI-005)
     */
    public function index(): void {
        $orderData = [
            'id_pesanan'       => 'TMR-240217-0832',
            'outlet'           => 'ForKos GC',
            'status'           => 'Sedang Dibuat',
            'estimasi'         => 'Barista sedang meracik kopimu',
            'pick_up_code'     => 'A 127',
            'item_nama'        => 'Caramel Macchiato',
            'kuantitas'        => 1,
            'kustomisasi'      => 'Reguler, Normal Ice, Less Sugar',
            'total_harga'      => 28000
        ];

        $this->renderView('pesanan', [
            'order' => $orderData
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
