<?php

class Voucher {
    // Daftar ini dipakai bersama oleh halaman Voucher dan proses checkout.
    public function getActive(): array {
        return [
            [
                'kode'      => 'yiesanlimaratusjadirefund',
                'judul'     => 'Diskon 30% Ambil Sendiri',
                'deskripsi' => 'Khusus pesanan pick-up mandiri di outlet ForKos Coffee',
                'diskon'    => '30%',
                'badge'     => '30% OFF',
                'tipe'      => 'persen',
                'nilai'     => 30,
                'minimum'   => 0,
                'status'    => 'Aktif'
            ],
            [
                'kode'      => 'FORKOSHEMAT',
                'judul'     => 'Potongan Rp5.000',
                'deskripsi' => 'Minimal belanja Rp25.000 untuk semua varian kopi',
                'diskon'    => 'Rp5.000',
                'badge'     => 'Rp5.000 OFF',
                'tipe'      => 'nominal',
                'nilai'     => 5000,
                'minimum'   => 25000,
                'status'    => 'Aktif'
            ]
        ];
    }

    public function findActive(string $code): ?array {
        foreach ($this->getActive() as $voucher) {
            if (strcasecmp($voucher['kode'], trim($code)) === 0) {
                return $voucher;
            }
        }

        return null;
    }

    public function isEligible(array $voucher, int $subtotal): bool {
        return $subtotal > 0 && $subtotal >= (int)$voucher['minimum'];
    }

    public function calculateDiscount(array $voucher, int $subtotal): int {
        if (!$this->isEligible($voucher, $subtotal)) {
            return 0;
        }

        $discount = $voucher['tipe'] === 'persen'
            ? (int)floor($subtotal * (int)$voucher['nilai'] / 100)
            : (int)$voucher['nilai'];

        return min($discount, $subtotal);
    }
}
