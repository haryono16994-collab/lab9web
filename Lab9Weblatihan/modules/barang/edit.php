<?php
// modules/barang/edit.php — UPDATE: ubah barang.
$pageTitle = 'Ubah barang';
$errors = [];
$id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
$data = $id > 0 ? dbOne($conn, "SELECT * FROM data_barang WHERE id_barang = ?", 'i', [$id]) : null;
if (!$data) { flash('error', 'Data barang tidak tersedia.'); redirect('barang/list'); }
$v = $data;

if (isPost()) {
    if (!csrfValid()) { $errors[] = 'Sesi formulir tidak valid, muat ulang halaman.'; }
    $v = array_merge($data, [
        'nama' => trim((string)($_POST['nama'] ?? '')), 'kategori' => (string)($_POST['kategori'] ?? ''),
        'harga_jual' => trim((string)($_POST['harga_jual'] ?? '')), 'harga_beli' => trim((string)($_POST['harga_beli'] ?? '')),
        'stok' => trim((string)($_POST['stok'] ?? '')),
    ]);
    if ($v['nama'] === '' || mb_strlen($v['nama']) > 50) $errors[] = 'Nama barang wajib diisi (maks. 50 karakter).';
    if (!in_array($v['kategori'], ['Komputer', 'Elektronik', 'Hand Phone'], true)) $errors[] = 'Kategori tidak valid.';
    foreach (['harga_jual' => 'Harga jual', 'harga_beli' => 'Harga beli', 'stok' => 'Stok'] as $k => $lbl) {
        if (!ctype_digit((string)$v[$k])) $errors[] = "$lbl harus berupa angka bulat ≥ 0.";
    }
    $gambarBaru = uploadGambar($_FILES['file_gambar'] ?? [], $errUpload);
    if ($errUpload) $errors[] = $errUpload;

    if (!$errors) {
        $gambar = $gambarBaru ?: $data['gambar'];
        dbExec($conn, "UPDATE data_barang SET nama=?, kategori=?, harga_jual=?, harga_beli=?, stok=?, gambar=? WHERE id_barang=?",
            'ssiiisi', [$v['nama'], $v['kategori'], (int)$v['harga_jual'], (int)$v['harga_beli'], (int)$v['stok'], $gambar, $id]);
        if ($gambarBaru) hapusGambar($data['gambar']); // hapus file lama setelah diganti
        flash('success', 'Barang “' . $v['nama'] . '” berhasil diperbarui.');
        redirect('barang/list');
    }
    if (!empty($gambarBaru)) hapusGambar($gambarBaru);
}
$aksi = url('barang/edit'); $edit = true;
require __DIR__ . '/_form.php';
