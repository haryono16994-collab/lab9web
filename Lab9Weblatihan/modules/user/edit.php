<?php
// modules/user/edit.php — ubah pengguna.
$pageTitle = 'Ubah pengguna';
$errors = [];
$id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
$data = $id > 0 ? dbOne($conn, "SELECT id, nama, username, email, role FROM users WHERE id = ?", 'i', [$id]) : null;
if (!$data) { flash('error', 'Pengguna tidak ditemukan.'); redirect('user/list'); }
$v = $data;
if (isPost()) {
    if (!csrfValid()) $errors[] = 'Sesi formulir tidak valid, muat ulang halaman.';
    foreach (['nama', 'username', 'email'] as $k) $v[$k] = trim((string)($_POST[$k] ?? ''));
    $v['role'] = in_array($_POST['role'] ?? '', ['admin', 'staff'], true) ? $_POST['role'] : 'staff';
    $pw = (string)($_POST['password'] ?? '');
    if ($v['nama'] === '') $errors[] = 'Nama wajib diisi.';
    if (!preg_match('/^[A-Za-z0-9_.]{3,30}$/', $v['username'])) $errors[] = 'Username 3–30 karakter: huruf, angka, titik, atau garis bawah.';
    if (!validasiEmail($v['email'])) $errors[] = 'Format email tidak valid.';
    if ($pw !== '' && strlen($pw) < 6) $errors[] = 'Kata sandi minimal 6 karakter.';
    if (!$errors && dbOne($conn, "SELECT id FROM users WHERE username = ? AND id <> ?", 'si', [$v['username'], $id])) $errors[] = 'Username sudah dipakai.';
    if ((int)$id === (int)currentUser()['id'] && $v['role'] !== 'admin') $errors[] = 'Anda tidak dapat menurunkan peran akun Anda sendiri.';
    if (!$errors) {
        if ($pw !== '') {
            dbExec($conn, "UPDATE users SET nama=?, username=?, email=?, role=?, password=? WHERE id=?", 'sssssi',
                [$v['nama'], $v['username'], $v['email'], $v['role'], password_hash($pw, PASSWORD_DEFAULT), $id]);
        } else {
            dbExec($conn, "UPDATE users SET nama=?, username=?, email=?, role=? WHERE id=?", 'ssssi',
                [$v['nama'], $v['username'], $v['email'], $v['role'], $id]);
        }
        if ($id === (int)currentUser()['id']) { $_SESSION['user']['nama'] = $v['nama']; $_SESSION['user']['role'] = $v['role']; }
        flash('success', 'Data pengguna berhasil diperbarui.');
        redirect('user/list');
    }
}
$aksi = url('user/edit'); $edit = true;
require __DIR__ . '/_form.php';
