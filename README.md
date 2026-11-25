# Lab9Web — Stok Kampus (PHP Modular + MySQL)

| | |
|---|---|
| **Nama** | Haryono |
| **NIM** | 312510292 |
| **Program Studi** | Teknik Informatika |
| **Mata Kuliah** | Pemrograman Web OBE |
| **Praktikum** | 8 (PHP & MySQL) dan 9 (PHP Modular) |
| **Laporan** | `Laporan_Praktikum_8_9_Haryono_312510292.docx` |

Gabungan **Praktikum 8** (CRUD PHP & MySQL, data barang) dan **Praktikum 9** (PHP modular: template, function, struktur direktori, routing whitelist, `.htaccess`).

## Tujuan project
- Membuat CRUD data barang (`data_barang`) dan pengguna (`users`) dengan MySQLi.
- Memecah aplikasi menjadi modul dengan tanggung jawab jelas.
- Semua halaman memakai template bersama dan diakses lewat router `index.php?page=...`.

## Kebutuhan perangkat
XAMPP (Apache + MySQL/MariaDB), PHP 7.4+, browser, VS Code. Tidak perlu library tambahan.

## Cara menjalankan
1. Salin folder `Lab9Web` ke `htdocs` (mis. `D:\xampp\htdocs\Lab9Web`).
2. Jalankan **Apache** dan **MySQL** di XAMPP Control.
3. Buka `http://localhost/Lab9Web/`.
4. Database `latihan1`, tabel, dan data awal **dibuat otomatis** oleh `config/database.php` (atau impor manual `database.sql` lewat phpMyAdmin).
5. Masuk dengan **admin / admin123**.

## Struktur direktori
```
Lab9Web/
├── index.php              router + whitelist rute
├── .htaccess              URL ringkas (opsional)
├── database.sql           skrip database manual
├── config/database.php    satu-satunya koneksi database
├── views/                 header.php footer.php dashboard.php 404.php
├── helpers/functions.php  function umum (format, validasi, CSRF, flash, DB, upload)
├── modules/
│   ├── barang/            list add edit delete (+ _form.php)    ← Praktikum 8
│   ├── user/              list add edit delete (+ _form.php)
│   ├── auth/              login logout
│   └── latihan/           home about profil kontak function include jawaban (+ pesan.php)
├── assets/css, assets/js  style.css, app.js
└── uploads/               gambar barang
```
Pemetaan Praktikum 8 → 9: `koneksi.php`→`config/database.php`, `index.php`→`modules/barang/list.php`, `tambah.php`→`add.php`, `ubah.php`→`edit.php`, `hapus.php`→`delete.php`.

## Daftar rute
| `page` | Isi | Akses |
|---|---|---|
| `dashboard` | Ringkasan, struktur, daftar rute | Login |
| `barang/list` `barang/add` `barang/edit` `barang/delete` | CRUD barang | Login |
| `user/list` `user/add` `user/edit` `user/delete` | CRUD pengguna | Login |
| `auth/login` `auth/logout` | Masuk / keluar | Publik |
| `latihan/home` `about` `profil` `kontak` | Latihan 1 (template) | Publik |
| `latihan/function` | Latihan function 1–4 | Publik |
| `latihan/include` | Uji include vs require | Publik |
| `latihan/jawaban` | Analisis hasil, 10 pertanyaan, tabel debugging | Publik |

Rute tak dikenal (mis. `?page=admin/rahasia`, kosong, atau array `?page[]=x`) → **404**.

## Langkah praktikum (ringkas)
**Praktikum 8:** jalankan MySQL → buat database `latihan1` & tabel `data_barang` → isi 3 data → koneksi → Read → Create (upload gambar) → Update → Delete.
**Praktikum 9:** uji include/require → template header/footer → function & `helpers` → struktur direktori → router whitelist + 404 → `.htaccess` → integrasi CRUD → Latihan 1–4 → tantangan mandiri.

### Tantangan mandiri (semua dikerjakan)
- Menu aktif: `navActive()` di `helpers/functions.php`.
- Pesan sukses/gagal: `flash()` dan `flashRender()`.
- Pembatasan akses: rute di luar `$publicRoutes` wajib login.
- URL rewrite: `.htaccess` (butuh `mod_rewrite` + `AllowOverride All`).

## Peningkatan keamanan dibanding modul
Prepared statement (anti SQL injection), `e()` untuk escaping (anti XSS), tambah/ubah/hapus lewat **POST + token CSRF**, whitelist rute, validasi server-side, validasi upload (ekstensi, ukuran, `getimagesize`), `password_hash`, `session_regenerate_id`, detail error DB hanya ke log.

## Screenshot
Simpan di folder `screenshots/` lalu tautkan di sini:

| Bagian | Berkas |
|---|---|
| XAMPP & phpMyAdmin (Lab 8) | `screenshots/01-xampp.png` |
| Tabel & data `data_barang` | `screenshots/02-database.png` |
| Read / Create / Update / Delete | `screenshots/03-crud.png` |
| Struktur direktori | `screenshots/04-struktur.png` |
| Template header/footer | `screenshots/05-template.png` |
| Function & include/require | `screenshots/06-function.png` |
| Routing & halaman 404 | `screenshots/07-routing.png` |
| CRUD barang & pengguna via router | `screenshots/08-integrasi.png` |

## Kendala & solusi
| Kendala | Solusi |
|---|---|
| Gambar di `index.php` Lab 8 tidak tampil (path `gambar/gambar/…`) | Hanya nama file disimpan di DB; file di `uploads/` |
| `enctype="multipart/formdata"` salah ketik di `ubah.php` | Dibenarkan `multipart/form-data` |
| Pilihan kategori di form ubah selalu cocok `Komputer` | Memakai `selected($k, $v['kategori'])` |
| CSS tidak tampil saat URL berubah | `asset()` berbasis `BASE_URL` |
| Function already declared | `require_once` |
