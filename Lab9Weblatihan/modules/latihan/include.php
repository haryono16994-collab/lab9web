<?php
$pageTitle = 'Uji include / require';
$ada = is_file(__DIR__ . '/pesan.php');
?>
<section class="card prose">
    <h2>Praktik: include vs require</h2>
    <p>Eksperimen dari modul bagian C.3, dijalankan langsung. Baris di bawah dicetak dari kode PHP halaman ini.</p>
    <div class="demo">
        <p>Sebelum pemanggilan</p>
        <?php include __DIR__ . '/pesan.php'; ?>
        <p>Sesudah pemanggilan</p>
    </div>
    <h3>Bagaimana jika file tidak ada?</h3>
    <?php $hasil = @include __DIR__ . '/pesan-tidak-ada.php'; // @ menyembunyikan warning agar halaman tetap rapi ?>
    <div class="demo">
        <p><code>include 'pesan-tidak-ada.php'</code> mengembalikan <code><?= var_export($hasil, true) ?></code> — hanya <em>warning</em>, kode setelahnya <strong>tetap berjalan</strong> (baris ini terbukti tercetak).</p>
        <p><code>require 'pesan-tidak-ada.php'</code> akan menghasilkan <em>fatal error</em> dan eksekusi <strong>berhenti</strong> — itulah sebabnya contoh require tidak dijalankan di halaman ini.</p>
    </div>
    <div class="table-wrap"><table class="t">
        <thead><tr><th>Konstruksi</th><th>Jika file tidak ada</th><th>Pemakaian umum</th></tr></thead>
        <tbody>
            <tr><td><code>include</code></td><td>Peringatan; eksekusi lanjut</td><td>File tambahan tidak kritis</td></tr>
            <tr><td><code>require</code></td><td>Error fatal; eksekusi berhenti</td><td>File wajib (konfigurasi database)</td></tr>
            <tr><td><code>include_once</code></td><td>Seperti include, tanpa muat ulang</td><td>Helper opsional dari banyak modul</td></tr>
            <tr><td><code>require_once</code></td><td>Seperti require, tanpa muat ulang</td><td>Konfigurasi / file inti, sekali muat</td></tr>
        </tbody>
    </table></div>
    <p class="muted">Status <code>pesan.php</code> saat ini: <?= $ada ? 'tersedia ✔' : 'tidak ditemukan ✘' ?>. Untuk mencoba sendiri, ubah nama file itu sementara lalu muat ulang halaman ini.</p>
</section>
