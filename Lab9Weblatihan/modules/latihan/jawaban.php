<?php
$pageTitle = 'Pertanyaan pemahaman';
$analisis = [
 'Bagian mana yang digunakan bersama oleh semua halaman?' => 'Header (pembuka HTML, sidebar, topbar) dan footer (penutup) dari views/header.php dan views/footer.php, plus style.css dan app.js.',
 'Apa yang terjadi jika teks navigasi diubah pada header.php?' => 'Seluruh halaman ikut berubah karena semuanya memuat file yang sama; cukup mengubah satu tempat.',
 'Mengapa konten halaman tidak diletakkan seluruhnya di header.php?' => 'Header hanya untuk bagian yang sama di semua halaman. Jika konten ikut di sana, semua halaman akan menampilkan isi yang sama dan tanggung jawab file menjadi kabur.',
 'Apa manfaat require_once dibanding menyalin kode header ke setiap halaman?' => 'Tidak ada duplikasi, perubahan cukup sekali, file tidak termuat ganda (menghindari "Function already declared"), dan error fatal bila file wajib hilang membuat masalah cepat terdeteksi.',
];
$qa = [
 ['1. Pengertian modularisasi dan tiga manfaatnya', 'Modularisasi adalah teknik membagi aplikasi menjadi bagian kecil berdasarkan fungsi/tanggung jawab. Manfaat: (1) kode bisa dipakai ulang, (2) pemeliharaan lebih mudah karena perubahan terpusat, (3) pekerjaan tim dapat dibagi per modul dan lebih kecil risiko konflik.'],
 ['2. include vs require saat file tidak ditemukan', 'include menghasilkan peringatan (warning) dan eksekusi umumnya berlanjut; require menghasilkan error fatal dan eksekusi dihentikan.'],
 ['3. Mengapa require_once cocok untuk konfigurasi database?', 'Konfigurasi wajib ada (tanpa itu aplikasi tidak bisa bekerja) sehingga require; dan harus dimuat satu kali agar koneksi/variabel tidak dideklarasikan berulang sehingga _once.'],
 ['4. Parameter, argumen, dan nilai return', 'Parameter adalah variabel pada deklarasi function; argumen adalah nilai yang dikirim saat function dipanggil; return mengembalikan nilai ke pemanggil sehingga dapat disimpan, dihitung, atau dipakai dalam kondisi (berbeda dengan echo yang hanya menampilkan).'],
 ['5. Mengapa header & footer dipisah dari konten?', 'Agar bagian yang sama tidak ditulis berulang, tampilan konsisten, dan konten tiap halaman fokus pada tugasnya sendiri.'],
 ['6. Fungsi index.php pada routing', 'Menjadi satu-satunya pintu masuk (router): membaca parameter page, memvalidasi dengan whitelist, lalu memuat header, modul yang sesuai, dan footer.'],
 ['7. Mengapa router memakai whitelist?', 'Hanya halaman yang didaftarkan aplikasi yang bisa dimuat; input URL tidak pernah menjadi path file, sehingga rute tak dikenal otomatis menjadi 404.'],
 ['8. Risiko bila input page langsung digabung menjadi path require', 'Path traversal / local file inclusion: penyerang dapat memuat file yang tidak dimaksudkan (misalnya ../config/database.php atau file sistem) dan bahkan mengeksekusi kode.'],
 ['9. Fungsi RewriteCond dan RewriteRule', 'RewriteCond menetapkan syarat (di sini: permintaan bukan file dan bukan direktori yang ada). RewriteRule mengarahkan permintaan yang memenuhi syarat ke index.php?page=… agar URL lebih ringkas.'],
 ['10. Bagian CRUD untuk config, views, helpers, modules', 'config: koneksi database. views: header, footer, dashboard, 404. helpers: function umum (format rupiah, validasi, escaping, CSRF). modules: halaman list/add/edit/delete per fitur (barang, user, auth).'],
];
?>
<section class="card prose">
    <h2>Analisis hasil (bagian D)</h2>
    <?php foreach ($analisis as $q => $a): ?><details><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details><?php endforeach; ?>
</section>
<section class="card prose">
    <h2>Pertanyaan pemahaman (bagian L)</h2>
    <?php foreach ($qa as [$q, $a]): ?><details><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details><?php endforeach; ?>
</section>
<section class="card prose">
    <h2>Debugging umum (bagian K)</h2>
    <div class="table-wrap"><table class="t">
        <thead><tr><th>Gejala</th><th>Kemungkinan penyebab</th><th>Perbaikan</th></tr></thead>
        <tbody>
        <tr><td>Failed opening required</td><td>Path salah / file tidak ada</td><td>Periksa struktur folder; pakai <code>__DIR__</code></td></tr>
        <tr><td>Function already declared</td><td>File function dimuat lebih dari sekali</td><td>Gunakan <code>require_once</code></td></tr>
        <tr><td>CSS tidak tampil</td><td>Path aset keliru saat URL berubah</td><td>Pakai <code>asset()</code> berbasis <code>BASE_URL</code></td></tr>
        <tr><td>Halaman 404 dari router</td><td>Nilai page tidak ada di whitelist</td><td>Periksa ejaan dan daftar rute</td></tr>
        <tr><td>URL rewrite tidak bekerja</td><td>mod_rewrite / AllowOverride belum aktif</td><td>Periksa konfigurasi Apache dan lokasi <code>.htaccess</code></td></tr>
        <tr><td>Konten tampil ganda</td><td>Header/footer dipanggil dari lebih dari satu tempat</td><td>Hanya <code>index.php</code> yang memuat layout</td></tr>
        </tbody>
    </table></div>
</section>
