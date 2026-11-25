<?php
// modules/user/list.php — daftar pengguna.
$pageTitle = 'Pengguna';
$users = dbAll($conn, "SELECT id, nama, username, email, role, created_at FROM users ORDER BY id ASC");
?>
<div class="toolbar"><p class="muted">Kelola akun yang bisa masuk ke aplikasi.</p>
    <a class="btn" href="<?= e(url('user/add')) ?>">Tambah pengguna</a></div>
<section class="card flush"><div class="table-wrap"><table class="t">
    <thead><tr><th>Nama</th><th>Username</th><th>Email</th><th>Peran</th><th>Dibuat</th><th class="r">Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($users as $u): $self = (int)$u['id'] === (int)currentUser()['id']; ?>
        <tr>
            <td><strong><?= e($u['nama']) ?></strong><?= $self ? ' <span class="badge">Anda</span>' : '' ?></td>
            <td><code><?= e($u['username']) ?></code></td>
            <td><?= e($u['email']) ?></td>
            <td><span class="badge <?= $u['role'] === 'admin' ? 'ok' : '' ?>"><?= e($u['role']) ?></span></td>
            <td><?= e(date('d M Y', strtotime($u['created_at']))) ?></td>
            <td class="r act">
                <a class="btn sm ghost" href="<?= e(url('user/edit', ['id' => $u['id']])) ?>">Ubah</a>
                <?php if (!$self): ?>
                <form method="post" action="<?= e(url('user/delete')) ?>" data-confirm="Hapus pengguna “<?= e($u['nama']) ?>”?">
                    <?= csrfField() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                    <button class="btn sm danger" type="submit">Hapus</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody></table></div></section>
