<?php
// modules/user/delete.php — hapus pengguna (POST + CSRF; tidak boleh menghapus akun sendiri).
requirePost();
$id = (int)($_POST['id'] ?? 0);
if ($id === (int)currentUser()['id']) {
    flash('error', 'Anda tidak dapat menghapus akun yang sedang dipakai.');
} elseif ($id > 0 && dbExec($conn, "DELETE FROM users WHERE id = ?", 'i', [$id]) > 0) {
    flash('success', 'Pengguna telah dihapus.');
} else {
    flash('error', 'Pengguna tidak ditemukan.');
}
redirect('user/list');
