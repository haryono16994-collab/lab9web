<?php
$pageTitle = 'Latihan function';
$c  = isset($_GET['c'])  && is_numeric($_GET['c'])  ? (float)$_GET['c']  : 36.6;
$n  = isset($_GET['n'])  && is_numeric($_GET['n'])  ? (float)$_GET['n']  : 78;
$h  = isset($_GET['h'])  && is_numeric($_GET['h'])  ? (float)$_GET['h']  : 2400000;
$j  = isset($_GET['j'])  && is_numeric($_GET['j'])  ? (int)$_GET['j']    : 3;
$luas = hitungLuasPersegiPanjang(8, 5);
?>
<div class="grid2">
<section class="card prose">
    <h3>Contoh bagian E</h3>
    <dl class="kv">
        <dt>tampilkanSalam()</dt><dd><?php tampilkanSalam(); ?></dd>
        <dt>sapaPengguna("Rina")</dt><dd><?php sapaPengguna('Rina'); ?></dd>
        <dt>hitungLuasPersegiPanjang(8, 5)</dt><dd>Luas: <?= $luas ?></dd>
        <dt>hitungDiskon(200000)</dt><dd><?= e(formatRupiah(hitungDiskon(200000))) ?> (10%)</dd>
        <dt>hitungDiskon(200000, 15)</dt><dd><?= e(formatRupiah(hitungDiskon(200000, 15))) ?> (15%)</dd>
        <dt>formatRupiah(150000)</dt><dd><?= e(formatRupiah(150000)) ?></dd>
        <dt>e('&lt;script&gt;…')</dt><dd><?= e('<script>alert("uji")</script>') ?></dd>
        <dt>validasiEmail('a@b.id')</dt><dd><?= validasiEmail('a@b.id') ? 'valid' : 'tidak valid' ?>; 'a@' → <?= validasiEmail('a@') ? 'valid' : 'tidak valid' ?></dd>
        <dt>ringkasTeks(…, 25)</dt><dd><?= e(ringkasTeks('Modularisasi membagi aplikasi menjadi bagian kecil', 25)) ?></dd>
    </dl>
    <p class="muted">Semua function berada di <code>helpers/functions.php</code> dan dimuat sekali dengan <code>require_once</code> oleh router — dipakai di Home, Kontak, Dashboard, dan halaman ini.</p>
</section>

<section class="card form-card">
    <h3>Latihan 1–3 interaktif</h3>
    <form method="get" action="<?= e(BASE_URL . '/index.php') ?>">
        <input type="hidden" name="page" value="latihan/function">
        <div class="row2">
            <div class="field"><label for="c">Suhu Celcius</label><input id="c" name="c" type="number" step="any" value="<?= e($c) ?>"></div>
            <div class="field"><label for="n">Nilai ujian</label><input id="n" name="n" type="number" step="any" value="<?= e($n) ?>"></div>
        </div>
        <div class="row2">
            <div class="field"><label for="h">Harga satuan (Rp)</label><input id="h" name="h" type="number" step="any" value="<?= e($h) ?>"></div>
            <div class="field"><label for="j">Jumlah</label><input id="j" name="j" type="number" value="<?= e($j) ?>"></div>
        </div>
        <button class="btn" type="submit">Hitung</button>
    </form>
    <dl class="kv result">
        <dt>konversiCelciusKeFahrenheit()</dt><dd><?= e(round(konversiCelciusKeFahrenheit($c), 2)) ?> °F</dd>
        <dt>tentukanStatusNilai()</dt><dd><?= e(tentukanStatusNilai($n)) ?></dd>
        <dt>hitungTotal()</dt><dd><?= e(formatRupiah(hitungTotal($h, $j))) ?></dd>
    </dl>
    <p class="muted">Rentang nilai: ≥85 A · ≥70 B · ≥55 C · ≥40 D · selain itu E.</p>
</section>
</div>
