<?php
$pageTitle = 'Dashboard';
$s = dbOne($conn, "SELECT COUNT(*) jml, COALESCE(SUM(stok),0) stok, COALESCE(SUM(stok*harga_beli),0) modal, COALESCE(SUM(stok*(harga_jual-harga_beli)),0) laba FROM data_barang");
$jmlUser = dbOne($conn, "SELECT COUNT(*) c FROM users")['c'];
$terbaru = dbAll($conn, "SELECT * FROM data_barang ORDER BY id_barang DESC LIMIT 5");
$menipis = dbOne($conn, "SELECT COUNT(*) c FROM data_barang WHERE stok <= 5")['c'];
?>
<section class="hero">
    <div>
        <p class="kicker">Halo, <?= e(currentUser()['nama'] ?? '') ?></p>
        <h2>Persediaan Anda bernilai <?= e(formatRupiah((float)$s['modal'])) ?></h2>
        <p>Potensi laba bila seluruh stok terjual: <strong><?= e(formatRupiah((float)$s['laba'])) ?></strong>.
        <?= $menipis > 0 ? "$menipis barang stoknya menipis." : 'Semua stok aman.' ?></p>
    </div>
    <a class="btn light" href="<?= e(url('barang/add')) ?>">Tambah barang</a>
</section>

<section class="stats">
    <div class="stat"><span>Jenis barang</span><b><?= (int)$s['jml'] ?></b></div>
    <div class="stat"><span>Total unit stok</span><b><?= (int)$s['stok'] ?></b></div>
    <div class="stat"><span>Stok menipis</span><b><?= (int)$menipis ?></b></div>
    <div class="stat"><span>Pengguna</span><b><?= (int)$jmlUser ?></b></div>
</section>

<section class="grid2">
    <div class="card">
        <div class="card-h"><h3>Barang terbaru</h3><a href="<?= e(url('barang/list')) ?>">Lihat semua</a></div>
        <?php if (!$terbaru): ?>
            <p class="empty">Belum ada barang. <a href="<?= e(url('barang/add')) ?>">Tambahkan yang pertama.</a></p>
        <?php else: ?>
        <ul class="mini">
            <?php foreach ($terbaru as $b): ?>
                <li><?= gambarBarang($b['gambar'], $b['nama']) ?>
                    <span><strong><?= e($b['nama']) ?></strong><small><?= e($b['kategori']) ?></small></span>
                    <em><?= e(formatRupiah((float)$b['harga_jual'])) ?></em></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-h"><h3>Struktur direktori</h3></div>
<pre class="tree">project/
├── index.php            <i># router + whitelist</i>
├── config/
│   └── database.php     <i># koneksi MySQLi</i>
├── views/
│   ├── header.php  footer.php
│   ├── dashboard.php  404.php
├── helpers/
│   └── functions.php    <i># function umum</i>
├── modules/
│   ├── user/    list add edit delete
│   ├── barang/  list add edit delete
│   ├── auth/    login logout
│   └── latihan/ home about kontak ...
├── assets/  css/  js/
└── uploads/             <i># gambar barang</i></pre>
    </div>
</section>

<section class="card">
    <div class="card-h"><h3>Daftar rute (whitelist)</h3></div>
    <div class="table-wrap"><table class="t">
        <thead><tr><th>Parameter <code>page</code></th><th>File yang dimuat</th><th>Akses</th></tr></thead>
        <tbody>
        <?php foreach ($routes as $r => $f): ?>
            <tr><td><a href="<?= e(url($r)) ?>"><code><?= e($r) ?></code></a></td>
                <td><code><?= e(ltrim(str_replace(str_replace('\\', '/', dirname(__DIR__)), '', str_replace('\\', '/', $f)), '/')) ?></code></td>
                <td><?= in_array($r, $publicRoutes, true) ? '<span class="badge">Publik</span>' : '<span class="badge ok">Perlu login</span>' ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
</section>
