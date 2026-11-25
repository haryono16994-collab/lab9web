<?php
// modules/user/add.php — tambah pengguna.
$pageTitle = 'Tambah pengguna';
$v = ['nama' => '', 'username' => '', 'email' => '', 'role' => 'staff'];
$errors = [];
if (isPost()) {
    if (!csrfValid()) $errors[] = 'Sesi formulir tidak valid, muat ulang halaman.';
    foreach (['nama', 'username', 'email'] as $k) $v[$k] = trim((string)($_POST[$k] ?? ''));
    $v['role'] = in_array($_POST['role'] ?? '', ['admin', 'staff'], true) ? $_POST['role'] : 'staff';
    $pw = (string)($_POST['password'] ?? '');
    if ($v['nama'] === '') $errors[] = 'Nama wajib diisi.';
    if (!preg_match('/^[A-Za-z0-9_.]{3,30}$/', $v['username'])) $errors[] = 'Username 3–30 karakter: huruf, angka, titik, atau garis bawah.';
    if (!validasiEmail($v['email'])) $errors[] = 'Format email tidak valid.';
    if (strlen($pw) < 6) $errors[] = 'Kata sandi minimal 6 karakter.';
    if (!$errors && dbOne($conn, "SELECT id FROM users WHERE username = ?", 's', [$v['username']])) $errors[] = 'Username sudah dipakai.';
    if (!$errors) {
        dbExec($conn, "INSERT INTO users (nama, username, email, role, password) VALUES (?,?,?,?,?)", 'sssss',
            [$v['nama'], $v['username'], $v['email'], $v['role'], password_hash($pw, PASSWORD_DEFAULT)]);
        flash('success', 'Pengguna “' . $v['nama'] . '” berhasil ditambahkan.');
        redirect('user/list');
    }
}
$aksi = url('user/add'); $edit = false;
require __DIR__ . '/_form.php';
