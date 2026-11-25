<?php
// modules/barang/add.php — CREATE: tambah barang.
$pageTitle = 'Tambah barang';
$v = ['nama' => '', 'kategori' => 'Elektronik', 'harga_jual' => '', 'harga_beli' => '', 'stok' => '', 'gambar' => null];
$errors = [];

if (isPost()) {
    if (!csrfValid()) { $errors[] = 'Sesi formulir tidak valid, muat ulang halaman.'; }
    $v = array_merge($v, [
        'nama' => trim((string)($_POST['nama'] ?? '')), 'kategori' => (string)($_POST['kategori'] ?? ''),
        'harga_jual' => trim((string)($_POST['harga_jual'] ?? '')), 'harga_beli' => trim((string)($_POST['harga_beli'] ?? '')),
        'stok' => trim((string)($_POST['stok'] ?? '')),
    ]);
    if ($v['nama'] === '' || mb_strlen($v['nama']) > 50) $errors[] = 'Nama barang wajib diisi (maks. 50 karakter).';
    if (!in_array($v['kategori'], ['Komputer', 'Elektronik', 'Hand Phone'], true)) $errors[] = 'Kategori tidak valid.';
    foreach (['harga_jual' => 'Harga jual', 'harga_beli' => 'Harga beli', 'stok' => 'Stok'] as $k => $lbl) {
        if (!ctype_digit($v[$k])) $errors[] = "$lbl harus berupa angka bulat ≥ 0.";
    }
    $gambar = uploadGambar($_FILES['file_gambar'] ?? [], $errUpload);
    if ($errUpload) $errors[] = $errUpload;

    if (!$errors) {
        dbExec($conn, "INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) VALUES (?,?,?,?,?,?)",
            'ssiiis', [$v['nama'], $v['kategori'], (int)$v['harga_jual'], (int)$v['harga_beli'], (int)$v['stok'], $gambar]);
        flash('success', 'Barang “' . $v['nama'] . '” berhasil ditambahkan.');
        redirect('barang/list');
    }
    if (!empty($gambar)) hapusGambar($gambar); // batalkan upload jika validasi gagal
}
$aksi = url('barang/add'); $edit = false;
require __DIR__ . '/_form.php';
