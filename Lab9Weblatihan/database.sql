-- Praktikum 8 & 9 — dijalankan manual lewat phpMyAdmin (opsional; aplikasi sudah membuatnya otomatis)
CREATE DATABASE IF NOT EXISTS latihan1;
USE latihan1;

CREATE TABLE IF NOT EXISTS data_barang (
  id_barang  INT(10) AUTO_INCREMENT PRIMARY KEY,
  kategori   VARCHAR(30),
  nama       VARCHAR(50),
  gambar     VARCHAR(100),
  harga_beli DECIMAL(10,0),
  harga_jual DECIMAL(10,0),
  stok       INT(4)
);

INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok) VALUES
('Elektronik', 'HP Samsung Android', 'hp_samsung.jpg', 2000000, 2400000, 5),
('Elektronik', 'HP Xiaomi Android', 'hp_xiaomi.jpg', 1000000, 1400000, 5),
('Elektronik', 'HP OPPO Android', 'hp_oppo.jpg', 1800000, 2300000, 5);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(60) NOT NULL,
  username VARCHAR(30) NOT NULL UNIQUE,
  email VARCHAR(80) NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'staff',
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Akun admin dibuat otomatis oleh config/database.php (admin / admin123)
