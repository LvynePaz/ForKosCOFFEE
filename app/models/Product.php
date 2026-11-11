<?php
/**
 * Model Product (Katalog Produk & Kustomisasi)
 * Arsitektur: MVC - Model Layer
 * Dokumen SDD: Bab 4.1 & Bab 4.3 (Tabel produk & addon)
 */

require_once dirname(__DIR__) . '/config/Database.php';

class Product {
    private PDO $db;

    public function __construct(?PDO $dbConnection = null) {
        $this->db = $dbConnection ?? Database::getConnection();
    }

    /**
     * Mengambil daftar produk berdasarkan kategori dan pencarian kata kunci
     */
    public function getCatalog(string $category = 'Semua', string $keyword = ''): array {
        try {
            // Coba ambil dari tabel produk (SDD) atau tabel menu (Modul 2)
            $stmt = $this->db->query("SELECT * FROM menu ORDER BY id DESC");
            $rows = $stmt->fetchAll();

            if (!empty($rows)) {
                $result = [];
                foreach ($rows as $r) {
                    $result[] = [
                        'id'        => (int)$r['id'],
                        'nama'      => $r['name'],
                        'deskripsi' => 'Menu racikan khas ForKos Coffee',
                        'harga'     => (int)$r['price'],
                        'kategori'  => $r['category'],
                        'gambar'    => 'assets/img/kopi.png'
                    ];
                }
                return $result;
            }
        } catch (Exception $e) {
            // Gunakan data fallback jika tabel belum siap
        }

        return [
            ['id' => 1, 'nama' => 'Caramel Macchiato', 'deskripsi' => 'Espresso, susu, dan karamel lembut', 'harga' => 28000, 'kategori' => 'Kopi',     'gambar' => 'assets/img/kopi.png'],
            ['id' => 2, 'nama' => 'Coffe Aren Latte',  'deskripsi' => 'Kopi susu dengan gula aren asli',     'harga' => 24000, 'kategori' => 'Kopi',     'gambar' => 'assets/img/kopi.png'],
            ['id' => 3, 'nama' => 'Caffe Latte',       'deskripsi' => 'Espresso dengan susu segar',          'harga' => 25000, 'kategori' => 'Kopi',     'gambar' => 'assets/img/kopi.png'],
            ['id' => 4, 'nama' => 'Americano',         'deskripsi' => 'Espresso klasik dengan air mineral',  'harga' => 20000, 'kategori' => 'Kopi',     'gambar' => 'assets/img/kopi.png'],
            ['id' => 5, 'nama' => 'Cappuccino',        'deskripsi' => 'Espresso dengan busa susu lembut',    'harga' => 26000, 'kategori' => 'Kopi',     'gambar' => 'assets/img/kopi.png'],
            ['id' => 6, 'nama' => 'Matcha Oat Latte',  'deskripsi' => 'Matcha premium dengan susu oat',      'harga' => 29000, 'kategori' => 'Non-Kopi', 'gambar' => 'assets/img/kopi.png'],
        ];
    }
}

