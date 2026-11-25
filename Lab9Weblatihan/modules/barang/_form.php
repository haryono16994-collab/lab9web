<?php
// modules/barang/_form.php — tampilan form dipakai bersama oleh add.php dan edit.php (bukan rute).
// Variabel: $v (nilai), $errors, $aksi (url tujuan), $edit (bool)
$kategoriList = ['Komputer', 'Elektronik', 'Hand Phone'];
?>
<section class="card form-card">
    <form method="post" action="<?= e($aksi) ?>" enctype="multipart/form-data" novalidate>
        <?= csrfField() ?>
        <?php if ($edit): ?><input type="hidden" name="id" value="<?= (int)$v['id_barang'] ?>"><?php endif; ?>
        <?php if ($errors): ?><div class="flash error"><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

        <div class="field"><label for="nama">Nama barang</label>
            <input id="nama" type="text" name="nama" maxlength="50" value="<?= e($v['nama']) ?>" required></div>

        <div class="field"><label for="kategori">Kategori</label>
            <select id="kategori" name="kategori">
                <?php foreach ($kategoriList as $k): ?>
                    <option value="<?= e($k) ?>" <?= selected($k, $v['kategori']) ?>><?= e($k) ?></option>
                <?php endforeach; ?>
            </select></div>

        <div class="row2">
            <div class="field"><label for="harga_jual">Harga jual (Rp)</label>
                <input id="harga_jual" type="number" min="0" step="1" name="harga_jual" value="<?= e($v['harga_jual']) ?>" required></div>
            <div class="field"><label for="harga_beli">Harga beli (Rp)</label>
                <input id="harga_beli" type="number" min="0" step="1" name="harga_beli" value="<?= e($v['harga_beli']) ?>" required></div>
        </div>

        <div class="field"><label for="stok">Stok</label>
            <input id="stok" type="number" min="0" step="1" name="stok" value="<?= e($v['stok']) ?>" required></div>

        <div class="field"><label for="file_gambar">File gambar <?= $edit ? '(kosongkan jika tidak diganti)' : '(opsional, maks. 2 MB)' ?></label>
            <div class="upload">
                <div id="preview"><?= $edit ? gambarBarang($v['gambar'], $v['nama']) : '<span class="thumb ph">+</span>' ?></div>
                <input id="file_gambar" type="file" name="file_gambar" accept="image/*">
            </div></div>

        <div class="actions">
            <button class="btn" type="submit" name="submit" value="1">Simpan</button>
            <a class="btn ghost" href="<?= e(url('barang/list')) ?>">Batal</a>
        </div>
    </form>
</section>
