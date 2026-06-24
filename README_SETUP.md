# GadgetHub - Setup & Running Guide

## ✅ SUDAH SELESAI!

Website GadgetHub sudah bisa dijalankan dengan fitur lengkap!

---

## 🚀 Cara Menjalankan

```bash
php artisan serve
```

Akses: **http://localhost:8000**

---

## 🔐 Login Admin

- URL: **http://localhost:8000/admin**
- Email: `admin@gadgethub.com`
- Password: `admin123`

---

## 📋 Fitur yang Sudah Dibuat

### User Biasa
✅ Registrasi & Login  
✅ Manajemen Profil (edit, upload foto)  
✅ Pasang Iklan HP (1-8 foto, validasi harga)  
✅ Edit & Hapus Iklan  
✅ Pencarian & Filter (keyword, lokasi, harga, brand, kondisi)  
✅ Chat dengan Penjual (realtime)  
✅ Favorit Produk  

### Admin Panel
✅ Dashboard dengan Statistik (total users, products, chats)  
✅ Kelola Semua Produk (lihat & hapus)  
✅ Kelola User (lihat & hapus)  
✅ Protected dengan middleware (hanya admin bisa akses)  

---

## 💰 Perbaikan Harga

✅ Tidak bisa input harga minus  
✅ Bisa input harga desimal (contoh: 3000000.50)  
✅ Validasi minimal Rp 0.01  
✅ Format: `min="0.01" step="0.01"`  

---

## 🗂️ Database

Tables yang sudah dibuat:
- `users` (dengan kolom is_admin)
- `products`
- `product_photos`
- `chats`
- `messages`
- `favorites`
- `transactions`

---

## 📱 Cara Pakai

### Sebagai User:
1. Daftar akun baru
2. Pasang iklan HP bekas
3. Chat dengan pembeli
4. Tandai favorit produk menarik

### Sebagai Admin:
1. Login dengan akun admin
2. Akses `/admin`
3. Monitor statistik
4. Kelola produk & user

---

## 📝 Catatan Teknis

- ✅ Migrations sudah running
- ✅ Storage link sudah dibuat
- ✅ Admin seeder sudah jalan
- ✅ Validasi form lengkap
- ✅ Authorization (Policy) untuk edit/delete
- ✅ Middleware admin untuk protect admin panel

---

## ⚠️ Yang Perlu Dicek

1. **npm install & npm run build** - untuk compile Tailwind CSS
2. **XAMPP MySQL** - pastikan sudah running
3. **Database `gadgethub`** - pastikan sudah dibuat

---

## 👥 Tim

- Daffa Azaria (714250006)
- Rao Azeem Samudra (714250040)

Proyek 1 - D4 Teknik Informatika
