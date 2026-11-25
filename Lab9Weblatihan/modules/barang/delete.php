<?php
// modules/barang/delete.php — DELETE: hanya lewat POST + token CSRF (bukan GET).
requirePost();
$id = (int)($_POST['id'] ?? 0);
$data = $id > 0 ? dbOne($conn, "SELECT nama, gambar FROM data_barang WHERE id_barang = ?", 'i', [$id]) : null;
if ($data && dbExec($conn, "DELETE FROM data_barang WHERE id_barang = ?", 'i', [$id]) > 0) {
    hapusGambar($data['gambar']);
    flash('success', 'Barang “' . $data['nama'] . '” telah dihapus.');
} else {
    flash('error', 'Barang tidak ditemukan.');
}
redirect('barang/list');
