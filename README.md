BLOOMING

Inventory & Sales Management System

Aplikasi Manajemen Inventaris dan Penjualan Florist Berbasis Web

Dibangun menggunakan Laravel dan MySQL untuk membantu pengelolaan data bunga, persediaan, pembelian, penjualan, dan laporan pada usaha florist.

---

1. Project Overview

Deskripsi Proyek

Blooming Inventory & Sales Management System merupakan aplikasi berbasis web yang dirancang untuk mendukung pengelolaan inventaris dan transaksi pada usaha florist. Aplikasi ini membantu pengguna dalam mengelola data produk, kategori, pemasok, pembelian, penjualan, serta memantau ketersediaan stok barang.

Proyek ini dikembangkan menggunakan framework Laravel dengan pendekatan Model–View–Controller (MVC), database MySQL, Eloquent ORM, autentikasi pengguna, otorisasi berdasarkan role, validasi data, dan logika transaksi.

Tujuan

- Mempermudah pengelolaan data inventaris florist.
- Menerapkan operasi CRUD pada data master.
- Mengelola transaksi pembelian dan penjualan.
- Menjaga konsistensi stok berdasarkan transaksi.
- Menerapkan autentikasi dan pembatasan akses pengguna.
- Menyediakan dashboard dan laporan untuk membantu pemantauan operasional.

Informasi Proyek

Informasi| Keterangan
Nama Aplikasi| Blooming
Jenis Aplikasi| Inventory & Sales Management System
Framework| Laravel
Bahasa Pemrograman| PHP
Database| MySQL
ORM| Eloquent ORM
Frontend| Blade, HTML, CSS
Lingkungan Pengembangan| XAMPP dan Visual Studio Code

---

2. Requirements

Pastikan perangkat sudah memiliki perangkat lunak berikut.

Komponen| Keterangan
PHP| Versi yang kompatibel dengan versi Laravel proyek
Composer| Untuk mengelola dependensi PHP
MySQL| Database melalui XAMPP
Laravel| Framework aplikasi
Node.js dan npm| Untuk instalasi dependensi frontend dan kompilasi aset Vite, jika diperlukan
Visual Studio Code| Editor kode
Web Browser| Untuk menjalankan aplikasi

Catatan: Versi PHP yang digunakan harus sesuai dengan persyaratan pada "composer.json" dan versi Laravel di proyek.

---

3. Installation

Ikuti langkah-langkah berikut untuk menjalankan proyek pada Windows.

Langkah 1 — Menyiapkan Proyek

Clone repository dari GitHub:

git clone <URL_REPOSITORY>

Masuk ke direktori proyek:

cd blooming

Jika proyek sudah berada di komputer, buka folder proyek tersebut melalui Visual Studio Code.

Langkah 2 — Menginstal Dependensi PHP

Jalankan:

composer install

Perintah ini menginstal dependensi PHP yang dibutuhkan aplikasi.

Langkah 3 — Menyiapkan File Environment

Salin file ".env.example" menjadi ".env".

Pada Windows PowerShell:

Copy-Item .env.example .env

Langkah 4 — Membuat Application Key

Jalankan:

php artisan key:generate

Jika PHP belum terdaftar pada PATH Windows dan menggunakan instalasi XAMPP di "C:\xampp", gunakan:

& "C:\xampp\php\php.exe" artisan key:generate

Langkah 5 — Menyiapkan Database

Nyalakan Apache dan MySQL melalui XAMPP Control Panel.

Buka phpMyAdmin melalui:

"http://localhost/phpmyadmin"

Buat database baru dengan nama:

"blooming"

Konfigurasikan koneksi database pada file ".env" sesuai pengaturan MySQL lokal.

Langkah 6 — Menjalankan Migrasi dan Seeder

Pastikan konfigurasi database sudah benar, kemudian ikuti bagian Migration & Seeding.

Langkah 7 — Menjalankan Aplikasi

Jalankan server Laravel:

php artisan serve

Jika menggunakan PHP bawaan XAMPP:

& "C:\xampp\php\php.exe" artisan serve

Buka aplikasi melalui:

"http://127.0.0.1:8000"

---

4. Environment Setup

Konfigurasikan file ".env" sesuai lingkungan pengembangan lokal.

Contoh konfigurasi:

APP_NAME=Blooming
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blooming
DB_USERNAME=root
DB_PASSWORD=

Perhatian:

- Sesuaikan nama database, username, password, dan port dengan konfigurasi MySQL pada komputer.
- "APP_DEBUG=true" hanya digunakan selama pengembangan lokal.
- Jangan mengunggah file ".env" yang berisi kredensial ke repository GitHub.
- Repository harus menyediakan ".env.example" tanpa informasi rahasia.

---

5. Migration & Seeding

Laravel menyediakan migration untuk membentuk struktur tabel database dan seeder untuk mengisi data awal.

Menjalankan Migration

php artisan migrate

Perintah ini menjalankan migration yang belum diterapkan pada database.

Menjalankan Seeder

php artisan db:seed

Seeder digunakan untuk menyiapkan data awal yang telah didefinisikan pada proyek, seperti kategori, produk, pemasok, dan akun demo apabila tersedia dalam seeder.

Menjalankan Migration dan Seeder Sekaligus

Untuk database baru:

php artisan migrate --seed

Reset Database untuk Pengembangan

Peringatan: perintah berikut menghapus tabel yang ada beserta datanya, kemudian menjalankan ulang migration dan seeder.

php artisan migrate:fresh --seed

Gunakan hanya jika memang ingin mereset database lokal dan tidak ada data yang perlu dipertahankan.

---

6. Demo Account

Aplikasi menyediakan akun demo untuk pengujian berdasarkan role pengguna.

Role| Email| Password
Admin| "admin@blooming.com"| "BloomingAdmin2026!"
Staff| "staff@blooming.com"| "StaffBlooming2026!"
User| "user@blooming.com"| "UserBlooming2026!"

Catatan: akun demo tersebut harus tersedia melalui seeder proyek. Jika kredensial pada seeder berbeda, gunakan akun dan password yang benar-benar dibuat oleh seeder.

Akun demo digunakan untuk keperluan pengujian aplikasi. Jangan menggunakan kredensial pribadi atau password produksi sebagai akun demo.

---

7. Features

A. Authentication

- Login pengguna.
- Logout pengguna.
- Akses halaman aplikasi untuk pengguna yang telah terautentikasi.
- Pembatasan akses berdasarkan role.

B. Dashboard

- Menampilkan ringkasan informasi inventaris.
- Menyediakan navigasi ke modul aplikasi sesuai hak akses.

C. Master Data

- Kategori: melihat dan mengelola kategori produk.
- Produk: mengelola data produk dan persediaan.
- Supplier: mengelola data pemasok.

D. Pembelian

- Menampilkan daftar transaksi pembelian.
- Membuat transaksi pembelian.
- Menampilkan detail transaksi.
- Menambah stok berdasarkan transaksi pembelian yang berhasil.
- Membatalkan transaksi sesuai hak akses dan aturan stok yang diterapkan.

E. Penjualan

- Menampilkan daftar transaksi penjualan.
- Membuat transaksi penjualan.
- Menampilkan detail transaksi.
- Memvalidasi ketersediaan stok sebelum penjualan.
- Mengurangi stok ketika transaksi berhasil.
- Membatalkan transaksi sesuai hak akses dan aturan pengembalian stok yang diterapkan.

F. Laporan

- Menampilkan laporan transaksi sesuai implementasi aplikasi.
- Membatasi akses laporan berdasarkan role.

G. User Management

- Menampilkan dan mengelola akun pengguna sesuai hak akses admin.

H. Authorization dan Validasi

- Middleware untuk membatasi akses berdasarkan role.
- Validasi input pada sisi server.
- Pesan sukses dan kesalahan untuk membantu pengguna memahami hasil operasi.
- Perlindungan terhadap akses halaman yang tidak diizinkan.

---

8. Known Limitations

Beberapa hal yang perlu diperhatikan selama pengembangan dan pengujian:

1. Aplikasi masih dijalankan pada lingkungan pengembangan lokal menggunakan XAMPP dan Laravel development server.
2. Ketersediaan fitur bergantung pada implementasi controller, model, migration, seeder, dan route yang terdapat pada repository.
3. Akun demo hanya dapat digunakan apabila telah dibuat melalui seeder atau mekanisme inisialisasi akun yang tersedia.
4. Data laporan bergantung pada transaksi yang tersimpan di database.
5. Hak akses setiap role mengikuti konfigurasi middleware dan route aplikasi.
6. Aplikasi belum dapat dianggap siap produksi sebelum dilakukan pengujian keamanan, validasi transaksi, dan konfigurasi deployment.

---

Teknologi yang Digunakan

- Laravel
- PHP
- MySQL
- Eloquent ORM
- Blade Template Engine
- HTML dan CSS
- XAMPP
- Visual Studio Code
- Git dan GitHub

---

Menjalankan Aplikasi Secara Singkat

Setelah konfigurasi awal selesai, jalankan:

composer install
php artisan optimize:clear
php artisan migrate --seed
php artisan serve

Kemudian buka "http://127.0.0.1:8000" melalui browser.

Jika menggunakan PHP XAMPP yang belum terdaftar pada PATH, ganti perintah "php artisan" dengan:

& "C:\xampp\php\php.exe" artisan optimize:clear
& "C:\xampp\php\php.exe" artisan migrate --seed
& "C:\xampp\php\php.exe" artisan serve

Blooming — Inventory & Sales Management System

Grow with grace. Manage with care.