<?php
/**
 * Model Outlet
 * Arsitektur: MVC - Model Layer
 * Dokumen SDD: Bab 4.1 & Bab 4.3 (Tabel outlet)
 */

require_once dirname(__DIR__) . '/config/Database.php';

class Outlet {
    private PDO $db;

    public function __construct(?PDO $dbConnection = null) {
        $this->db = $dbConnection ?? Database::getConnection();
    }

    /**
     * Mengambil seluruh data cabang outlet terdekat
     */
    public function findAll(): array {
        try {
            $stmt = $this->db->query("SELECT * FROM outlet ORDER BY id_outlet ASC");
            $outlets = $stmt->fetchAll();

            if (!empty($outlets)) {
                return $outlets;
            }
        } catch (Exception $e) {
            // Fallback jika tabel outlet di DB belum diisi data
        }

        // Data default sesuai rancangan SDD UI-002
        return [
            [
                'id_outlet'   => 1,
                'nama_outlet' => 'TOMORO Coffee GC',
                'lokasi'      => 'Jl. Grand City Balikpapan No.2',
                'jarak'       => '0.4 km',
                'status'      => 'Dipilih'
            ],
            [
                'id_outlet'   => 2,
                'nama_outlet' => 'TOMORO Coffee Batu Ampar',
                'lokasi'      => 'Jl. Bangka IX No. 24, Balikpapan',
                'jarak'       => '0.8 km',
                'status'      => 'Outlet Aktif'
            ]
        ];
    }
}

