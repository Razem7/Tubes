# GadgetHub - Setup & Running Guide

## 🚀 Cara Menjalankan Aplikasi

### 1. Install Dependencies

#### Install Node.js Dependencies (untuk Tailwind CSS)
```bash
npm install
```

#### Build Assets (CSS & JS)
```bash
npm run build
```

Atau untuk development dengan auto-reload:
```bash
npm run dev
```

### 2. Setup Database

#### Edit file `.env`
Pastikan konfigurasi database sudah benar:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gadgethub
DB_USERNAME=root
DB_PASSWORD=
```

#### Buat Database
Buat database baru bernama `gadgethub` di MySQL/PhpMyAdmin

#### Jalankan Migration
```bash
php artisan migrate
```

### 3. Generate Application Key (jika belum)
```bash
php artisan key:generate
```

### 4. Jalankan Server
```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

---

## 📋 Fitur yang Sudah Dibuat (MVP)

### ✅ Autentikasi
- ✅ Registrasi akun baru
- ✅ Login
- ✅ Logout

### ✅ Manajemen Profil
- ✅ Lihat profil
- ✅ Edit profil
- ✅ Upload foto profil

### ✅ Manajemen Produk
- ✅ Lihat semua produk (Homepage)
- ✅ Pencarian & Filter produk:
  - Keyword (judul & deskripsi)
  - Lokasi
  - Harga (min-max)
  - Brand
  - Kondisi
- ✅ Lihat detail produk
- ✅ Upload produk baru (1-8 foto)
- ✅ Edit produk
- ✅ Hapus produk
- ✅ Lihat produk saya

### ✅ Chat Buyer-Seller
- ✅ Mulai chat dari halaman produk
- ✅ Lihat daftar chat
- ✅ Kirim pesan realtime
- ✅ Riwayat percakapan
- ✅ Indikator unread messages

### ✅ Favorit
- ✅ Simpan produk ke favorit
- ✅ Lihat daftar favorit
- ✅ Hapus dari favorit

---

## 🗂️ Struktur Database

### Tables Created:
1. **users** - Data pengguna
2. **products** - Data produk HP bekas
3. **product_photos** - Foto-foto produk
4. **chats** - Sesi chat antara buyer & seller
5. **messages** - Pesan dalam chat
6. **favorites** - Produk favorit user
7. **transactions** - Data transaksi (untuk fase 2)

---

## 🎨 Desain UI

Desain menggunakan **Tailwind CSS** dengan prinsip:
- Simple & clean
- Natural (tidak terlihat "AI-generated")
- Responsive (mobile & desktop)
- User-friendly

---

## 📱 Cara Menggunakan Aplikasi

### Sebagai Penjual:
1. Register/Login
2. Klik "Pasang Iklan"
3. Isi detail produk & upload foto
4. Tunggu pembeli menghubungi via chat

### Sebagai Pembeli:
1. Register/Login
2. Jelajah produk atau gunakan filter pencarian
3. Klik produk untuk lihat detail
4. Klik "Chat Penjual" untuk komunikasi
5. Tambahkan ke Favorit jika tertarik

---

## ⚠️ Catatan Penting

1. **npm** harus terinstall untuk build Tailwind CSS
   - Install Node.js dari: https://nodejs.org/
   
2. **MySQL** harus running dan database sudah dibuat

3. **Storage link** sudah dibuat untuk upload foto

4. Folder **storage/app/public** harus writable

---

## 🔮 Fitur Phase 2 (Belum Dibuat)

- [ ] Sistem Rekber (Rekening Bersama)
- [ ] Verifikasi nomor HP
- [ ] Notifikasi realtime
- [ ] Rating & review penjual
- [ ] Geolocation map untuk lokasi
- [ ] Export data transaksi

---

## 👥 Tim Pengembang

- **Daffa Azaria** (714250006)
- **Rao Azeem Samudra** (714250040)

Proyek 1 - D4 Teknik Informatika

---

## 📞 Troubleshooting

### Error "npm not found"
Install Node.js terlebih dahulu

### Error migration
Jalankan: `php artisan migrate:fresh`

### Gambar tidak muncul
Pastikan sudah jalankan: `php artisan storage:link`

### CSS tidak muncul
Jalankan: `npm run build` atau `npm run dev`
