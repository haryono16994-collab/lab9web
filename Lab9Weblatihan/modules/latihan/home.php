<?php $pageTitle = 'Halaman Home'; // Latihan 1: tanpa salinan header/footer — layout dipasang oleh router ?>
<section class="card prose">
    <h2>Halaman Home</h2>
    <p>Ini adalah konten khusus halaman beranda. Header, sidebar navigasi, dan footer di sekitar teks ini <strong>tidak ditulis di file ini</strong>; semuanya datang dari <code>views/header.php</code> dan <code>views/footer.php</code>.</p>
    <p>Coba ubah teks menu di <code>views/header.php</code> — seluruh halaman ikut berubah.</p>
    <p><?php tampilkanSalam(); ?> <?php sapaPengguna('Rina'); ?>.</p>
</section>
