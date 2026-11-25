<?php /* views/header.php — template bersama: awal dokumen, sidebar navigasi, topbar. */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> — Stok Kampus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Sora:wght@600;700;800&display=swap">
    <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body>
<div class="shell">
    <aside class="side" id="side">
        <a class="brand" href="<?= e(url('dashboard')) ?>">
            <span class="logo" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7l9-4 9 4-9 4-9-4z"/><path d="M3 7v10l9 4 9-4V7"/><path d="M12 11v10"/></svg>
            </span>
            <span>Stok Kampus<small>Praktikum 8 &amp; 9</small></span>
        </a>
        <nav class="menu" aria-label="Navigasi utama">
            <?php if (isLoggedIn()): ?>
                <p class="grp">Aplikasi</p>
                <a class="<?= $page === 'dashboard' ? 'active' : '' ?>" href="<?= e(url('dashboard')) ?>">Dashboard</a>
                <a class="<?= navActive('barang') ?>" href="<?= e(url('barang/list')) ?>">Data barang</a>
                <a class="<?= navActive('user') ?>" href="<?= e(url('user/list')) ?>">Pengguna</a>
            <?php endif; ?>
            <p class="grp">Latihan</p>
            <a class="<?= $page === 'latihan/home' ? 'active' : '' ?>" href="<?= e(url('latihan/home')) ?>">Home</a>
            <a class="<?= $page === 'latihan/about' ? 'active' : '' ?>" href="<?= e(url('latihan/about')) ?>">Tentang</a>
            <a class="<?= $page === 'latihan/profil' ? 'active' : '' ?>" href="<?= e(url('latihan/profil')) ?>">Profil</a>
            <a class="<?= $page === 'latihan/kontak' ? 'active' : '' ?>" href="<?= e(url('latihan/kontak')) ?>">Kontak</a>
            <a class="<?= $page === 'latihan/function' ? 'active' : '' ?>" href="<?= e(url('latihan/function')) ?>">Latihan function</a>
            <a class="<?= $page === 'latihan/include' ? 'active' : '' ?>" href="<?= e(url('latihan/include')) ?>">Uji include / require</a>
            <a class="<?= $page === 'latihan/jawaban' ? 'active' : '' ?>" href="<?= e(url('latihan/jawaban')) ?>">Pertanyaan pemahaman</a>
        </nav>
        <div class="me">
            <?php if (isLoggedIn()): $u = currentUser(); ?>
                <span class="av"><?= e(mb_strtoupper(mb_substr($u['nama'], 0, 1))) ?></span>
                <span class="who"><strong><?= e($u['nama']) ?></strong><small><?= e($u['role']) ?></small></span>
                <a class="out" href="<?= e(url('auth/logout')) ?>" title="Keluar">Keluar</a>
            <?php else: ?>
                <a class="btn block" href="<?= e(url('auth/login')) ?>">Masuk</a>
            <?php endif; ?>
        </div>
    </aside>

    <div class="main">
        <header class="top">
            <button class="burger" id="burger" type="button" aria-label="Buka menu" aria-controls="side">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <h1><?= e($pageTitle) ?></h1>
        </header>
        <main class="content">
            <?= flashRender() ?>
