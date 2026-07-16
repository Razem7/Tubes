# GadgetHub — Setup Guide

Marketplace jual beli barang elektronik bekas.

## Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18

## Instalasi

### 1. Clone & install dependencies

```bash
git clone <repo-url>
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

### 7. Jalankan server

```bash
php artisan serve
```

Buka http://localhost:8000

---

## Akun Default (setelah seeding)

| Role  | Email             | Password |
|-------|-------------------|----------|
| Admin | admin@gadgethub.com | password |

---

## Troubleshooting

### Error tablespace saat migrate

Terjadi kalau database pernah dihapus manual (lewat file system) tanpa DROP DATABASE.

**Solusi:** Di phpMyAdmin → tab SQL, jalankan:

```sql
DROP DATABASE IF EXISTS gadgethub;
CREATE DATABASE gadgethub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Lalu `php artisan migrate --seed` lagi.

### Foto tidak muncul

Pastikan sudah menjalankan:

```bash
php artisan storage:link
```
