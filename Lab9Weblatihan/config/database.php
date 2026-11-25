<?php
// config/database.php — SATU-SATUNYA tempat koneksi database dikelola (MySQLi).
// Otomatis membuat database "latihan1", tabel, dan data awal jika belum ada.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'latihan1';

try {
    $conn = new mysqli($host, $user, $pass);
    $conn->set_charset('utf8mb4');
    $conn->query("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    $conn->select_db($db);

    // Tabel dari Praktikum 8
    $conn->query("CREATE TABLE IF NOT EXISTS data_barang (
        id_barang  INT(10) AUTO_INCREMENT PRIMARY KEY,
        kategori   VARCHAR(30),
        nama       VARCHAR(50),
        gambar     VARCHAR(100),
        harga_beli DECIMAL(10,0),
        harga_jual DECIMAL(10,0),
        stok       INT(4)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Tabel pengguna (modul user & auth, Praktikum 9)
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id         INT AUTO_INCREMENT PRIMARY KEY,
        nama       VARCHAR(60)  NOT NULL,
        username   VARCHAR(30)  NOT NULL UNIQUE,
        email      VARCHAR(80)  NOT NULL,
        role       VARCHAR(20)  NOT NULL DEFAULT 'staff',
        password   VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Data awal barang (sesuai modul)
    if ((int)$conn->query("SELECT COUNT(*) c FROM data_barang")->fetch_assoc()['c'] === 0) {
        $conn->query("INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok) VALUES
            ('Elektronik', 'HP Samsung Android', 'hp_samsung.jpg', 2000000, 2400000, 5),
            ('Elektronik', 'HP Xiaomi Android', 'hp_xiaomi.jpg', 1000000, 1400000, 5),
            ('Elektronik', 'HP OPPO Android', 'hp_oppo.jpg', 1800000, 2300000, 5)");
    }
    // Akun awal: admin / admin123
    if ((int)$conn->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'] === 0) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $st = $conn->prepare("INSERT INTO users (nama, username, email, role, password) VALUES ('Administrator','admin','admin@kampus.test','admin',?)");
        $st->bind_param('s', $hash);
        $st->execute();
        $st->close();
    }
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());   // detail error tidak ditampilkan ke pengguna
    http_response_code(500);
    exit('Terjadi kesalahan pada koneksi database. Pastikan MySQL di XAMPP sudah berjalan.');
}
