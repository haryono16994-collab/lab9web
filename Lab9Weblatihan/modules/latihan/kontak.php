<?php
$pageTitle = 'Kontak';
$err = []; $ok = null; $v = ['nama' => '', 'email' => '', 'pesan' => ''];
if (isPost()) {
    foreach ($v as $k => $_) $v[$k] = trim((string)($_POST[$k] ?? ''));
    if (!csrfValid()) $err[] = 'Sesi formulir tidak valid.';
    if ($v['nama'] === '') $err[] = 'Nama wajib diisi.';
    if (!validasiEmail($v['email'])) $err[] = 'Format email tidak valid.';
    if (mb_strlen($v['pesan']) < 10) $err[] = 'Pesan minimal 10 karakter.';
    if (!$err) { $ok = $v; $v = ['nama' => '', 'email' => '', 'pesan' => '']; }
}
?>
<div class="grid2">
<section class="card form-card">
    <h2>Hubungi kami</h2>
    <?php if ($err): ?><div class="flash error"><ul><?php foreach ($err as $x): ?><li><?= e($x) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <form method="post" action="<?= e(url('latihan/kontak')) ?>" novalidate>
        <?= csrfField() ?>
        <div class="field"><label for="nama">Nama</label><input id="nama" name="nama" value="<?= e($v['nama']) ?>"></div>
        <div class="field"><label for="email">Email</label><input id="email" type="email" name="email" value="<?= e($v['email']) ?>"></div>
        <div class="field"><label for="pesan">Pesan</label><textarea id="pesan" name="pesan" rows="4"><?= e($v['pesan']) ?></textarea></div>
        <button class="btn" type="submit">Kirim pesan</button>
    </form>
</section>
<section class="card prose">
    <h3>Hasil pemrosesan</h3>
    <?php if ($ok): ?>
        <p>Terima kasih, <strong><?= e($ok['nama']) ?></strong>! Pesan dari <code><?= e($ok['email']) ?></code> diterima (pesan tidak disimpan — hanya latihan).</p>
        <p class="muted">Ringkasan (<code>ringkasTeks()</code>, 60 karakter): “<?= e(ringkasTeks($ok['pesan'], 60)) ?>”</p>
    <?php else: ?>
        <p class="muted">Isi formulir untuk melihat validasi email (<code>validasiEmail()</code>) dan ringkasan teks (<code>ringkasTeks()</code>) bekerja.</p>
    <?php endif; ?>
</section>
</div>
