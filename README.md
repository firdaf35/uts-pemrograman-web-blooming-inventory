
#  BLOOMING

## Inventory & Sales Management System

**Aplikasi Manajemen Inventaris dan Penjualan Florist Berbasis Web**

![Laravel](https://img.shields.io/badge/Laravel-Framework-FF2D55?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

---

## 📌 1. Project Overview

Blooming merupakan aplikasi berbasis web untuk mengelola inventaris dan transaksi pada usaha florist.

### 🎯 Tujuan

- Mempermudah pengelolaan data inventaris.
- Mengelola produk, kategori, dan supplier.
- Mencatat transaksi pembelian dan penjualan.
- Menjaga konsistensi stok.
- Menerapkan autentikasi dan hak akses pengguna.

### 🗂️ Informasi Proyek

| Informasi | Keterangan |
|---|---|
| Nama Aplikasi | Blooming |
| Mata Kuliah | Pemrograman Web  |
| Jenis Tugas | Ujian Tengah Semester (UTS) |
| Framework | Laravel |
| Bahasa Pemrograman | PHP |
| Database | MySQL |

---

## 🛠️ 2. Requirements

- PHP sesuai versi Laravel yang digunakan.
- Composer.
- Laravel.
- MySQL dan XAMPP.
- Visual Studio Code.
- Git.

---

## ⚙️ 3. Installation

### 1. Clone Repository

```bash
git clone <URL_REPOSITORY>
cd blooming
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database

- Jalankan Apache dan MySQL melalui XAMPP.
- Buka phpMyAdmin.
- Buat database bernama `blooming`.
- Sesuaikan konfigurasi database di `.env`.

### 5. Migration dan Seeder

```bash
php artisan migrate --seed
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000`.

---

## 🔧 4. Environment Setup

Sesuaikan konfigurasi database pada file `.env`.

```env
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
```


---

## 🗄️ 5. Migration & Seeding

Jalankan migration:

```bash
php artisan migrate
```

Jalankan seeder:

```bash
php artisan db:seed
```

Atau jalankan keduanya sekaligus:

```bash
php artisan migrate --seed
```

---

## 👥 6. Demo Account

| Role | Email | Password |
|---|---|---|
| Admin | `admin@blooming.com` | Sesuai seeder |
| Staff | `staff@blooming.com` | Sesuai seeder |



---

## ✨ 7. Features

### Authentication & Authorization
- Login dan logout.
- Pembatasan akses berdasarkan role.

### Master Data
- Pengelolaan kategori.
- Pengelolaan produk.
- Pengelolaan supplier.

### Transaksi
- Pencatatan pembelian.
- Pencatatan penjualan.
- Pengelolaan stok berdasarkan transaksi.
- Pembatalan transaksi sesuai hak akses.

### Laporan
- Menampilkan laporan transaksi sesuai implementasi aplikasi.

### Validasi
- Validasi input.
- Pesan sukses dan kesalahan.
- Middleware untuk otorisasi.

---

## ⚠️ 8. Known Limitations

- Aplikasi berjalan pada lingkungan pengembangan lokal.
- Fitur mengikuti implementasi yang tersedia pada proyek.
- Akun demo bergantung pada seeder.
- Pengujian tambahan diperlukan sebelum deployment produksi.

---

## 📚 Technologies Used

- Laravel
- PHP
- MySQL
- Eloquent ORM
- Blade
- HTML dan CSS
- XAMPP
- Git dan GitHub

---

**Blooming — UTS Pemrograman Web 2**

*Grow with grace. Manage with care.*
