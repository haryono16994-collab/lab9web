<?php
// helpers/functions.php — function umum yang dipakai banyak modul.
// Dimuat dengan require_once agar tidak terjadi "Function already declared".

/* ===== Latihan function (Praktikum 9 bagian E) ===== */
function tampilkanSalam() { echo 'Selamat belajar PHP modular!'; }
function sapaPengguna($nama) { echo 'Halo, ' . htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); }
function hitungLuasPersegiPanjang($panjang, $lebar) { return $panjang * $lebar; }
function hitungDiskon(float $harga, float $persen = 10): float { return $harga * ($persen / 100); }
function konversiCelciusKeFahrenheit($c) { return ($c * 9 / 5) + 32; }
function tentukanStatusNilai($nilai) {
    if ($nilai >= 85) return 'A (Sangat Baik)';
    if ($nilai >= 70) return 'B (Baik)';
    if ($nilai >= 55) return 'C (Cukup)';
    if ($nilai >= 40) return 'D (Kurang)';
    return 'E (Gagal)';
}
function hitungTotal($harga, $jumlah) { return $harga * $jumlah; }
function formatRupiah(float $angka): string { return 'Rp ' . number_format($angka, 0, ',', '.'); }
function e($nilai): string { return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8'); }
function validasiEmail(string $email): bool { return filter_var($email, FILTER_VALIDATE_EMAIL) !== false; }
function ringkasTeks(string $teks, int $batas = 100): string {
    $teks = trim($teks);
    if (mb_strlen($teks) <= $batas) return $teks;
    return rtrim(mb_substr($teks, 0, $batas)) . '…';
}

/* ===== Routing & URL ===== */
function url(string $page = 'dashboard', array $params = []): string {
    return BASE_URL . '/index.php?' . http_build_query(['page' => $page] + $params);
}
function asset(string $path): string { return BASE_URL . '/assets/' . ltrim($path, '/'); }
function redirect(string $page, array $params = []): void { header('Location: ' . url($page, $params)); exit; }
function navActive(string $prefix): string {
    $p = $GLOBALS['page'] ?? '';
    return ($p === $prefix || strpos($p, rtrim($prefix, '/') . '/') === 0) ? 'active' : '';
}

/* ===== Flash message (tantangan mandiri) ===== */
function flash(string $tipe, string $pesan): void { $_SESSION['flash'][] = ['t' => $tipe, 'm' => $pesan]; }
function flashRender(): string {
    if (empty($_SESSION['flash'])) return '';
    $out = '';
    foreach ($_SESSION['flash'] as $f) {
        $out .= '<div class="flash ' . e($f['t']) . '" role="status"><span>' . e($f['m']) . '</span><button type="button" class="x" aria-label="Tutup">&times;</button></div>';
    }
    unset($_SESSION['flash']);
    return $out;
}

/* ===== Keamanan: CSRF & autentikasi ===== */
function csrfToken(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrfField(): string { return '<input type="hidden" name="csrf" value="' . csrfToken() . '">'; }
function csrfValid(): bool { return isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$_POST['csrf']); }
function isPost(): bool { return $_SERVER['REQUEST_METHOD'] === 'POST'; }
function requirePost(): void {
    if (!isPost() || !csrfValid()) { flash('error', 'Permintaan tidak valid. Operasi ubah data harus lewat form (POST).'); redirect('dashboard'); }
}
function isLoggedIn(): bool { return !empty($_SESSION['user']); }
function currentUser(): array { return $_SESSION['user'] ?? []; }

/* ===== Database (prepared statement) ===== */
function dbAll(mysqli $c, string $sql, string $types = '', array $params = []): array {
    $st = $c->prepare($sql);
    if ($types !== '') $st->bind_param($types, ...$params);
    $st->execute();
    $res = $st->get_result();
    $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    $st->close();
    return $rows;
}
function dbOne(mysqli $c, string $sql, string $types = '', array $params = []): ?array { return dbAll($c, $sql, $types, $params)[0] ?? null; }
function dbExec(mysqli $c, string $sql, string $types = '', array $params = []): int {
    $st = $c->prepare($sql);
    if ($types !== '') $st->bind_param($types, ...$params);
    $st->execute();
    $n = $st->affected_rows;
    $st->close();
    return $n;
}

/* ===== Upload gambar & tampilan barang ===== */
function uploadGambar(array $file, ?string &$error): ?string {
    $error = null;
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) { $error = 'Upload gambar gagal (kode ' . $file['error'] . ').'; return null; }
    if ($file['size'] > 2 * 1024 * 1024) { $error = 'Ukuran gambar maksimal 2 MB.'; return null; }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true) || @getimagesize($file['tmp_name']) === false) {
        $error = 'File harus berupa gambar (jpg, png, gif, webp).'; return null;
    }
    $dir = dirname(__DIR__) . '/uploads';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $nama = uniqid('brg_') . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $nama)) { $error = 'Gagal menyimpan file gambar.'; return null; }
    return $nama;
}
function hapusGambar(?string $nama): void {
    if ($nama && basename($nama) === $nama && is_file(dirname(__DIR__) . '/uploads/' . $nama)) @unlink(dirname(__DIR__) . '/uploads/' . $nama);
}
function gambarBarang(?string $gambar, string $nama): string {
    if ($gambar && basename($gambar) === $gambar && is_file(dirname(__DIR__) . '/uploads/' . $gambar)) {
        return '<img class="thumb" src="' . e(BASE_URL . '/uploads/' . $gambar) . '" alt="' . e($nama) . '">';
    }
    return '<span class="thumb ph" aria-hidden="true">' . e(mb_strtoupper(mb_substr($nama, 0, 1))) . '</span>';
}
function badgeStok(int $stok): string {
    if ($stok <= 0) return '<span class="badge bad">Habis</span>';
    if ($stok <= 5) return '<span class="badge warn">' . $stok . ' · menipis</span>';
    return '<span class="badge ok">' . $stok . '</span>';
}
function selected($a, $b): string { return (string)$a === (string)$b ? 'selected' : ''; }
