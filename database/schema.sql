-- =====================================================
-- Database Schema for ForKos Coffee
-- Berdasarkan Dokumen SDD (Deskripsi Perancangan Perangkat Lunak)
-- Target DBMS: MySQL / MariaDB (XAMPP)
-- Engine: InnoDB (Mendukung Relasi Foreign Key)
-- =====================================================

CREATE DATABASE IF NOT EXISTS forkos_coffee 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE forkos_coffee;

-- Nonaktifkan pengecekan foreign key sementara agar pembuatan/penataan ulang tabel lancar
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Tabel Pengguna (Pelanggan)
CREATE TABLE IF NOT EXISTS pengguna (
    id_pengguna INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    no_telepon VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- 2. Tabel Kasir
CREATE TABLE IF NOT EXISTS kasir (
    id_kasir INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- 3. Tabel Outlet
CREATE TABLE IF NOT EXISTS outlet (
    id_outlet INT AUTO_INCREMENT PRIMARY KEY,
    nama_outlet VARCHAR(100) NOT NULL,
    lokasi VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- 4. Tabel Produk
CREATE TABLE IF NOT EXISTS produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    id_outlet INT NOT NULL,
    nama_produk VARCHAR(100) NOT NULL,
    harga DOUBLE NOT NULL,
    CONSTRAINT fk_produk_outlet FOREIGN KEY (id_outlet) REFERENCES outlet(id_outlet) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Tabel Addon (Kustomisasi Ukuran, Gula, Es, Topping)
CREATE TABLE IF NOT EXISTS addon (
    id_addon INT AUTO_INCREMENT PRIMARY KEY,
    nama_addon VARCHAR(50) NOT NULL,
    harga_tambahan DOUBLE NOT NULL
) ENGINE=InnoDB;

-- 6. Tabel Keranjang
CREATE TABLE IF NOT EXISTS keranjang (
    id_keranjang INT AUTO_INCREMENT PRIMARY KEY,
    id_pengguna INT NOT NULL,
    CONSTRAINT fk_keranjang_pengguna FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 7. Tabel Item Keranjang
CREATE TABLE IF NOT EXISTS item_keranjang (
    id_item INT AUTO_INCREMENT PRIMARY KEY,
    id_keranjang INT NOT NULL,
    id_produk INT NOT NULL,
    id_addon INT NULL,
    kuantitas INT NOT NULL DEFAULT 1,
    subtotal DOUBLE NOT NULL,
    CONSTRAINT fk_item_keranjang FOREIGN KEY (id_keranjang) REFERENCES keranjang(id_keranjang) ON DELETE CASCADE,
    CONSTRAINT fk_item_produk FOREIGN KEY (id_produk) REFERENCES produk(id_produk) ON DELETE CASCADE,
    CONSTRAINT fk_item_addon FOREIGN KEY (id_addon) REFERENCES addon(id_addon) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 8. Tabel Voucher
CREATE TABLE IF NOT EXISTS voucher (
    id_voucher INT AUTO_INCREMENT PRIMARY KEY,
    id_kasir INT NOT NULL,
    kode_voucher VARCHAR(50) NOT NULL UNIQUE,
    nilai_diskon DOUBLE NOT NULL,
    status_aktif TINYINT(1) NOT NULL DEFAULT 1,
    CONSTRAINT fk_voucher_kasir FOREIGN KEY (id_kasir) REFERENCES kasir(id_kasir) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 9. Tabel Pesanan (Transaksi Utama)
CREATE TABLE IF NOT EXISTS pesanan (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
    id_pengguna INT NOT NULL,
    id_outlet INT NOT NULL,
    id_voucher INT NULL,
    id_kasir INT NOT NULL,
    total_harga DOUBLE NOT NULL,
    status_pesanan VARCHAR(50) NOT NULL DEFAULT 'Pesanan Diterima',
    kode_pengambilan VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pesanan_pengguna FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna) ON DELETE RESTRICT,
    CONSTRAINT fk_pesanan_outlet FOREIGN KEY (id_outlet) REFERENCES outlet(id_outlet) ON DELETE RESTRICT,
    CONSTRAINT fk_pesanan_voucher FOREIGN KEY (id_voucher) REFERENCES voucher(id_voucher) ON DELETE SET NULL,
    CONSTRAINT fk_pesanan_kasir FOREIGN KEY (id_kasir) REFERENCES kasir(id_kasir) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 10. Tabel Detail Pesanan
CREATE TABLE IF NOT EXISTS detail_pesanan (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL,
    id_produk INT NOT NULL,
    id_addon INT NULL,
    kuantitas INT NOT NULL,
    subtotal DOUBLE NOT NULL,
    CONSTRAINT fk_detail_pesanan FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan) ON DELETE CASCADE,
    CONSTRAINT fk_detail_produk FOREIGN KEY (id_produk) REFERENCES produk(id_produk) ON DELETE RESTRICT,
    CONSTRAINT fk_detail_addon FOREIGN KEY (id_addon) REFERENCES addon(id_addon) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 11. Tabel Pembayaran
CREATE TABLE IF NOT EXISTS pembayaran (
    id_pembayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL,
    metode_pembayaran VARCHAR(50) NOT NULL,
    status_pembayaran VARCHAR(50) NOT NULL DEFAULT 'Success',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pembayaran_pesanan FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan) ON DELETE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;
