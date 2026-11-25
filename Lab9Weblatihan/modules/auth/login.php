<?php
// modules/auth/login.php — form masuk.
$pageTitle = 'Masuk';
if (isLoggedIn()) redirect('dashboard');
$error = null; $username = '';
if (isPost()) {
    $username = trim((string)($_POST['username'] ?? ''));
    $pw = (string)($_POST['password'] ?? '');
    $u = csrfValid() ? dbOne($conn, "SELECT * FROM users WHERE username = ?", 's', [$username]) : null;
    if ($u && password_verify($pw, $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => (int)$u['id'], 'nama' => $u['nama'], 'username' => $u['username'], 'role' => $u['role']];
        flash('success', 'Selamat datang kembali, ' . $u['nama'] . '.');
        redirect('dashboard');
    }
    $error = 'Username atau kata sandi salah.';
}
?>
<section class="card login">
    <h2>Masuk ke aplikasi</h2>
    <p class="muted">Akun awal: <code>admin</code> / <code>admin123</code></p>
    <?php if ($error): ?><div class="flash error"><span><?= e($error) ?></span></div><?php endif; ?>
    <form method="post" action="<?= e(url('auth/login')) ?>">
        <?= csrfField() ?>
        <div class="field"><label for="username">Username</label><input id="username" name="username" value="<?= e($username) ?>" autofocus required></div>
        <div class="field"><label for="password">Kata sandi</label><input id="password" type="password" name="password" required></div>
        <button class="btn block" type="submit">Masuk</button>
    </form>
</section>
