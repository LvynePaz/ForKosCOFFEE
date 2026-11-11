<?php
/**
 * Database Connection Wrapper
 * Arsitektur: Application Tier (Database Access Layer)
 * Dokumen SDD: Bab 2.2
 */

class Database {
    private static ?PDO $connection = null;

    /**
     * Mendapatkan instance PDO koneksi database (Singleton Pattern)
     *
     * @return PDO
     * @throws Exception
     */
    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $localConfig = dirname(__DIR__, 2) . '/config/database.php';
            $exampleConfig = dirname(__DIR__, 2) . '/config/database.example.php';

            if (file_exists($localConfig)) {
                require $localConfig;
            } elseif (file_exists($exampleConfig)) {
                require $exampleConfig;
            } else {
                throw new Exception("File konfigurasi database tidak ditemukan pada direktori config/");
            }

            if (!isset($pdo) || !($pdo instanceof PDO)) {
                throw new Exception("Koneksi PDO gagal diinisialisasi.");
            }

            self::$connection = $pdo;
        }

        return self::$connection;
    }
}

