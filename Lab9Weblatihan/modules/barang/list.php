<?php
// modules/barang/list.php — READ: daftar barang + pencarian.
$pageTitle = 'Data barang';
$q = trim((string)($_GET['q'] ?? ''));
if ($q !== '') {
    $like = '%' . $q . '%';
    $rows = dbAll($conn, "SELECT * FROM data_barang WHERE nama LIKE ? OR kategori LIKE ? ORDER BY id_barang DESC", 'ss', [$like, $like]);
} else {
    $rows = dbAll($conn, "SELECT * FROM data_barang ORDER BY id_barang DESC");
}
?>
<div class="toolbar">
    <form class="search" method="get" action="<?= e(BASE_URL . '/index.php') ?>">
        <input type="hidden" name="page" value="barang/list">
        <input type="search" name="q" value="<?= e($q) ?>" placeholder="Cari nama atau kategori…" aria-label="Cari barang">
        <button class="btn ghost" type="submit">Cari</button>
    </form>
    <a class="btn" href="<?= e(url('barang/add')) ?>">Tambah barang</a>
</div>

<section class="card flush">
    <div class="table-wrap"><table class="t">
        <thead><tr><th>Gambar</th><th>Nama barang</th><th>Kategori</th><th class="r">Harga jual</th><th class="r">Harga beli</th><th>Stok</th><th class="r">Aksi</th></tr></thead>
        <tbody>
        <?php if (!$rows): ?>
            <tr><td colspan="7" class="empty"><?= $q !== '' ? 'Tidak ada barang yang cocok dengan “' . e($q) . '”.' : 'Belum ada data. Klik “Tambah barang” untuk memulai.' ?></td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= gambarBarang($row['gambar'], $row['nama']) ?></td>
                <td><strong><?= e($row['nama']) ?></strong></td>
                <td><span class="badge"><?= e($row['kategori']) ?></span></td>
                <td class="r"><?= e(formatRupiah((float)$row['harga_jual'])) ?></td>
                <td class="r"><?= e(formatRupiah((float)$row['harga_beli'])) ?></td>
                <td><?= badgeStok((int)$row['stok']) ?></td>
                <td class="r act">
                    <a class="btn sm ghost" href="<?= e(url('barang/edit', ['id' => $row['id_barang']])) ?>">Ubah</a>
                    <form method="post" action="<?= e(url('barang/delete')) ?>" data-confirm="Hapus “<?= e($row['nama']) ?>”? Tindakan ini tidak bisa dibatalkan.">
                        <?= csrfField() ?><input type="hidden" name="id" value="<?= (int)$row['id_barang'] ?>">
                        <button class="btn sm danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
</section>
