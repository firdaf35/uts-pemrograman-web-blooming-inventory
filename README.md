<div align="center">🌷 BLOOMING

Inventory & Sales Management System

Aplikasi Manajemen Inventaris dan Penjualan Florist Berbasis Web

""Laravel" (https://img.shields.io/badge/Laravel-Framework-FF2D55?style=for-the-badge&logo=laravel&logoColor=white)" (https://laravel.com/)
""PHP" (https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php&logoColor=white)" (https://www.php.net/)
""MySQL" (https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)" (https://www.mysql.com/)
""UTS" (https://img.shields.io/badge/Project-UTS%20Pemrograman%20Web%202-9B4965?style=for-the-badge)" (#)

Grow with grace. Manage with care.

</div>---

📌 1. Project Overview

Blooming Inventory & Sales Management System merupakan aplikasi berbasis web untuk membantu pengelolaan inventaris dan transaksi pada usaha florist.

Aplikasi ini dikembangkan menggunakan Laravel dan MySQL dengan menerapkan konsep Model–View–Controller (MVC), Eloquent ORM, autentikasi, otorisasi berbasis role, validasi data, dan logika transaksi untuk menjaga konsistensi stok.

🎯 Tujuan Proyek

- Mempermudah pengelolaan data inventaris florist.
- Mengimplementasikan operasi CRUD pada data master.
- Mengelola transaksi pembelian dan penjualan.
- Menjaga konsistensi stok berdasarkan transaksi.
- Menerapkan autentikasi dan pembatasan hak akses.
- Menyediakan dashboard dan laporan untuk mendukung pemantauan operasional.

🗂️ Informasi Proyek

Informasi| Keterangan
Nama Aplikasi| Blooming
Nama Proyek| Blooming Inventory & Sales Management System
Mata Kuliah| Pemrograman Web 2
Jenis Tugas| Ujian Tengah Semester (UTS)
Framework| Laravel
Bahasa Pemrograman| PHP
Database| MySQL
ORM| Eloquent ORM
Frontend| Blade, HTML, CSS
Tools| XAMPP, Visual Studio Code, Git, GitHub

---

🛠️ 2. Requirements

Pastikan perangkat telah memiliki perangkat lunak berikut sebelum menjalankan aplikasi.

Komponen| Kegunaan
PHP| Menjalankan aplikasi Laravel
Composer| Mengelola dependensi PHP
Laravel| Framework pengembangan aplikasi
MySQL| Menyimpan data aplikasi
XAMPP| Menyediakan server lokal dan MySQL
Visual Studio Code| Editor kode program
Git| Mengelola versi kode
Node.js dan npm| Mengelola dependensi frontend jika diperlukan

«Catatan: Versi PHP dan Composer harus sesuai dengan kebutuhan Laravel pada proyek. Periksa "composer.json" untuk persyaratan versi yang tepat.»

---

⚙️ 3. Installation

Ikuti langkah-langkah berikut untuk memasang aplikasi di lingkungan lokal Windows.

Step 1 — Clone Repository

git clone <URL_REPOSITORY>

Masuk ke direktori proyek:

cd uts-pemrograman-web-2-blooming-inventory

Jika proyek sudah tersedia di komputer, buka folder proyek melalui Visual Studio Code.

Step 2 — Install Dependencies

Jalankan perintah berikut untuk menginstal dependensi PHP:

composer install

Step 3 — Setup Environment

Salin file ".env.example" menjadi ".env".

Untuk Windows PowerShell:

Copy-Item .env.example .env

Buat application key:

php artisan key:generate

Step 4 — Setup Database

1. Buka XAMPP Control Panel.
2. Jalankan Apache dan MySQL.
3. Buka "http://localhost/phpmyadmin".
4. Buat database dengan nama "blooming".
5. Sesuaikan konfigurasi database di file ".env".

Step 5 — Run Migration and Seeder

Setelah konfigurasi database selesai, jalankan:

php artisan migrate --seed

Perintah tersebut menjalankan migration dan seeder untuk membuat tabel serta mengisi data awal yang telah didefinisikan pada proyek.

Step 6 — Run Application

Jalankan server Laravel:

php artisan serve

Buka browser dan akses:

http://127.0.0.1:8000

---

🔧 4. Environment Setup

Konfigurasikan file ".env" sesuai pengaturan lokal.

Contoh konfigurasi database:

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

Important Notes

- Sesuaikan username, password, dan port MySQL dengan konfigurasi XAMPP.
- "APP_DEBUG=true" hanya digunakan untuk pengembangan lokal.
- Jangan mengunggah file ".env" ke GitHub karena dapat berisi informasi rahasia.
- Gunakan ".env.example" untuk menyediakan contoh konfigurasi tanpa kredensial pribadi.

---

🗄️ 5. Migration & Seeding

Laravel menggunakan migration untuk membangun struktur database dan seeder untuk menyiapkan data awal.

Menjalankan Migration

php artisan migrate

Menjalankan Seeder

php artisan db:seed

Menjalankan Migration dan Seeder Sekaligus

php artisan migrate --seed

Reset Database

php artisan migrate:fresh --seed

«⚠️ Peringatan: "migrate:fresh --seed" akan menghapus seluruh tabel beserta datanya sebelum membuat ulang database. Gunakan hanya jika memang ingin melakukan reset.»

---

👥 6. Demo Account

Aplikasi menyediakan akun demo untuk menguji hak akses berdasarkan role.

Role| Email| Password
Admin| "admin@blooming.com"| "BloomingAdmin2026!"
Staff| "staff@blooming.com"| "StaffBlooming2026!"
User| "user@blooming.com"| "UserBlooming2026!"

«Penting: kredensial di atas harus sesuai dengan akun yang benar-benar dibuat oleh seeder proyek. Jika berbeda, gunakan kredensial yang berlaku pada database lokal.»

Akun demo digunakan untuk keperluan pengujian aplikasi dan bukan untuk penggunaan produksi.

---

✨ 7. Features

🔐 Authentication & Authorization

- Login dan logout pengguna.
- Autentikasi untuk mengakses halaman aplikasi.
- Pembatasan akses berdasarkan role.
- Halaman khusus untuk akses terbatas dan halaman tidak ditemukan.

📊 Dashboard

- Menampilkan ringkasan informasi inventaris.
- Menyediakan navigasi ke fitur aplikasi sesuai hak akses.

🌸 Master Data

Modul| Fitur
Kategori| Melihat, menambah, mengubah, dan menghapus kategori sesuai hak akses
Produk| Mengelola data produk dan informasi persediaan
Supplier| Mengelola data pemasok

📦 Pembelian

- Menampilkan daftar transaksi pembelian.
- Membuat transaksi pembelian.
- Menampilkan detail pembelian.
- Menambahkan stok melalui transaksi pembelian yang berhasil.
- Membatalkan transaksi sesuai hak akses dan aturan stok.

🛍️ Penjualan

- Menampilkan daftar transaksi penjualan.
- Membuat transaksi penjualan.
- Menampilkan detail penjualan.
- Memvalidasi stok sebelum transaksi diproses.
- Mengurangi stok ketika transaksi berhasil.
- Membatalkan transaksi sesuai hak akses dan aturan pengembalian stok.

📑 Laporan

- Menampilkan laporan transaksi sesuai implementasi aplikasi.
- Membatasi akses laporan berdasarkan role pengguna.

👤 Manajemen Pengguna

- Melihat daftar akun.
- Menambah, mengubah, dan menghapus akun sesuai hak akses admin.

🛡️ Validasi & Konsistensi Data

- Validasi input pada sisi server.
- Pesan sukses dan kesalahan yang mudah dipahami.
- Middleware untuk otorisasi.
- Proteksi CSRF melalui mekanisme Laravel.
- Penggunaan Eloquent ORM untuk interaksi dengan database.

---

⚠️ 8. Known Limitations

1. Aplikasi dikembangkan untuk lingkungan lokal dan belum dikonfigurasi untuk deployment produksi.
2. Fitur yang tersedia bergantung pada implementasi controller, model, migration, seeder, dan route dalam repository.
3. Akun demo harus tersedia melalui seeder atau mekanisme inisialisasi akun.
4. Data laporan bergantung pada data transaksi yang tersimpan di database.
5. Hak akses pengguna mengikuti konfigurasi middleware dan route aplikasi.
6. Pengujian menyeluruh dan konfigurasi keamanan tambahan tetap diperlukan sebelum aplikasi digunakan pada lingkungan produksi.

---

🧪 Testing & Documentation

Dokumentasi pengujian dan screenshot aplikasi dapat ditambahkan pada repository untuk mendukung proses penilaian.

Contoh struktur folder dokumentasi:

docs/
├── ERD.png
├── screenshots/
│   ├── dashboard.png
│   ├── products.png
│   ├── purchases.png
│   └── sales.png
└── test-cases.md

Tambahkan file dokumentasi dan screenshot setelah benar-benar tersedia di repository.

---

📚 Technologies Used

- Laravel — Framework backend.
- PHP — Bahasa pemrograman.
- MySQL — Sistem manajemen database.
- Eloquent ORM — Pengelolaan data dan relasi.
- Blade — Template engine Laravel.
- HTML & CSS — Antarmuka aplikasi.
- XAMPP — Lingkungan server lokal.
- Git & GitHub — Version control dan penyimpanan repository.

---

<div align="center">🌷 BLOOMING

UTS Pemrograman Web 2

Grow with grace. Manage with care.

</div>