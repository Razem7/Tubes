# 🛒 GadgetHub

> Marketplace jual beli gadget & elektronik bekas — dibangun dengan Laravel 11.

[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)

---

## ✨ Fitur

| Fitur | User | Merchant | Super Admin |
|---|:---:|:---:|:---:|
| Lihat & cari produk | ✅ | ✅ | ✅ |
| Beli produk (COD) | ✅ | — | — |
| Jual produk | — | ✅ | ✅ |
| Manajemen stok | — | ✅ | ✅ |
| Dashboard penjualan | — | ✅ | ✅ |
| Chat dengan penjual/pembeli | ✅ | ✅ | — |
| Favorit produk | ✅ | ✅ | — |
| Edit profil & alamat | ✅ | ✅ | ✅ |
| Ganti password | ✅ | ✅ | ✅ |
| Kelola user & kategori | — | — | ✅ |
| Kelola banner | — | — | ✅ |
| Approve pendaftaran merchant | — | — | ✅ |
| Notifikasi real-time | ✅ | ✅ | — |

---

## 🔧 Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18

---

## 🚀 Instalasi

### 1. Clone & install dependencies

```bash
git clone https://github.com/Razem7/Tubes.git
cd Tubes
composer install
npm install
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`, sesuaikan bagian database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gadgethub
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Buat database

Buka phpMyAdmin atau MySQL client, jalankan:

```sql
CREATE DATABASE gadgethub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Migrate & seed

```bash
php artisan migrate --seed
```

### 5. Storage symlink

```bash
php artisan storage:link
```

### 6. Build assets

```bash
npm run build
```

> Untuk development, gunakan `npm run dev` agar hot-reload aktif.

### 7. Jalankan server

```bash
php artisan serve
```

Buka **http://localhost:8000** di browser.

---

## 🔑 Akun Default (setelah seeding)

| Role | Email | Password |
|---|---|---|
| Super Admin | admin@gadgethub.com | password |

---

## 📁 Struktur Role

```
user        → Bisa beli produk, chat, favorit
merchant    → Bisa jual produk, kelola stok & penjualan
super_admin → Full akses manajemen platform
```

---

## 🛠️ Troubleshooting

### ❌ Error tablespace saat migrate

Terjadi kalau database pernah dihapus manual (lewat file system) tanpa `DROP DATABASE`.

**Solusi:** Di phpMyAdmin → tab SQL, jalankan:

```sql
DROP DATABASE IF EXISTS gadgethub;
CREATE DATABASE gadgethub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Lalu jalankan ulang:

```bash
php artisan migrate --seed
```

### ❌ Foto tidak muncul

Pastikan sudah menjalankan storage link:

```bash
php artisan storage:link
```

### ❌ Error 500 / key not set

Pastikan sudah generate app key:

```bash
php artisan key:generate
```

---

## 🧑‍💻 Tech Stack

- **Backend:** Laravel 11 (PHP 8.2)
- **Frontend:** Blade + TailwindCSS 3 + Vite
- **Database:** MySQL 8
- **Auth:** Laravel built-in session auth
- **Storage:** Laravel Storage (local disk / `public`)
- **Notifikasi:** Laravel Notifications (database)
