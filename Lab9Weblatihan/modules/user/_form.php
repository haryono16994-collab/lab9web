<?php // modules/user/_form.php — form pengguna bersama add/edit (bukan rute). Variabel: $v, $errors, $aksi, $edit ?>
<section class="card form-card">
    <form method="post" action="<?= e($aksi) ?>" novalidate>
        <?= csrfField() ?>
        <?php if ($edit): ?><input type="hidden" name="id" value="<?= (int)$v['id'] ?>"><?php endif; ?>
        <?php if ($errors): ?><div class="flash error"><ul><?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
        <div class="field"><label for="nama">Nama lengkap</label><input id="nama" type="text" name="nama" maxlength="60" value="<?= e($v['nama']) ?>" required></div>
        <div class="row2">
            <div class="field"><label for="username">Username</label><input id="username" type="text" name="username" maxlength="30" value="<?= e($v['username']) ?>" required></div>
            <div class="field"><label for="role">Peran</label>
                <select id="role" name="role"><?php foreach (['admin', 'staff'] as $r): ?><option value="<?= $r ?>" <?= selected($r, $v['role']) ?>><?= $r ?></option><?php endforeach; ?></select></div>
        </div>
        <div class="field"><label for="email">Email</label><input id="email" type="email" name="email" maxlength="80" value="<?= e($v['email']) ?>" required></div>
        <div class="field"><label for="password">Kata sandi <?= $edit ? '(kosongkan jika tidak diganti)' : '(min. 6 karakter)' ?></label>
            <input id="password" type="password" name="password" autocomplete="new-password" <?= $edit ? '' : 'required' ?>></div>
        <div class="actions"><button class="btn" type="submit">Simpan</button><a class="btn ghost" href="<?= e(url('user/list')) ?>">Batal</a></div>
    </form>
</section>
