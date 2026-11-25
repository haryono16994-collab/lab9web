<?php
// index.php — titik masuk aplikasi sekaligus ROUTER (whitelist rute).
session_start();
ob_start(); // supaya redirect di dalam modul tetap bisa dikirim sebelum HTML header

define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));

require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/config/database.php';

// Whitelist: hanya halaman di daftar ini yang boleh dimuat.
$routes = [
    'dashboard'        => __DIR__ . '/views/dashboard.php',
    // Praktikum 8 — CRUD data barang
    'barang/list'      => __DIR__ . '/modules/barang/list.php',
    'barang/add'       => __DIR__ . '/modules/barang/add.php',
    'barang/edit'      => __DIR__ . '/modules/barang/edit.php',
    'barang/delete'    => __DIR__ . '/modules/barang/delete.php',
    // Praktikum 9 — CRUD pengguna
    'user/list'        => __DIR__ . '/modules/user/list.php',
    'user/add'         => __DIR__ . '/modules/user/add.php',
    'user/edit'        => __DIR__ . '/modules/user/edit.php',
    'user/delete'      => __DIR__ . '/modules/user/delete.php',
    // Autentikasi
    'auth/login'       => __DIR__ . '/modules/auth/login.php',
    'auth/logout'      => __DIR__ . '/modules/auth/logout.php',
    // Latihan praktikum
    'latihan/home'     => __DIR__ . '/modules/latihan/home.php',
    'latihan/about'    => __DIR__ . '/modules/latihan/about.php',
    'latihan/profil'   => __DIR__ . '/modules/latihan/profil.php',
    'latihan/kontak'   => __DIR__ . '/modules/latihan/kontak.php',
    'latihan/function' => __DIR__ . '/modules/latihan/function.php',
    'latihan/include'  => __DIR__ . '/modules/latihan/include.php',
    'latihan/jawaban'  => __DIR__ . '/modules/latihan/jawaban.php',
];
// Halaman yang boleh dibuka tanpa login
$publicRoutes = ['auth/login', 'auth/logout', 'latihan/home', 'latihan/about', 'latihan/profil', 'latihan/kontak', 'latihan/function', 'latihan/include', 'latihan/jawaban'];

$page = $_GET['page'] ?? 'dashboard';
if ($page === '') $page = 'dashboard';
$pageTitle = 'Dashboard';

if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $page = '404';
    $contentFile = __DIR__ . '/views/404.php';
} elseif (!in_array($page, $publicRoutes, true) && !isLoggedIn()) {
    flash('error', 'Silakan masuk terlebih dahulu untuk membuka halaman tersebut.');
    redirect('auth/login');
} else {
    $contentFile = $routes[$page];
}

// Modul dijalankan lebih dulu (ditampung), agar bisa mengatur $pageTitle & melakukan redirect.
ob_start();
require $contentFile;
$content = ob_get_clean();

require_once __DIR__ . '/views/header.php';
echo $content;
require_once __DIR__ . '/views/footer.php';
