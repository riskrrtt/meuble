# Meuble – Laravel E-Commerce Furniture

## Nama Proyek
**Meuble** adalah aplikasi e-commerce berbasis Laravel untuk penjualan produk furniture secara online.

## Fitur Utama
- **Register & Login** untuk user dan admin
- **Manajemen Produk (CRUD)**: tambah, edit, hapus, dan lihat produk (admin)
- **Pencarian Produk** (user)
- **Keranjang Belanja** (user)
- **Transaksi/Pembelian** (user & admin monitoring)
- **Edit Profil User** (user)
- **Notifikasi Sukses & Validasi Form**
- **Dashboard/beranda** setelah login
- **Desain modern, responsif, dan user-friendly**

## Instruksi Instalasi
1. Clone repository:
   ```bash
   git clone https://github.com/username/meuble.git
   cd meuble
   ```
2. Install dependency:
   ```bash
   composer install
   npm install && npm run build
   ```
3. Copy file `.env.example` menjadi `.env` dan atur konfigurasi database.
4. Generate application key:
   ```bash
   php artisan key:generate
   ```
5. Migrasi dan seed database:
   ```bash
   php artisan migrate --seed
   ```
6. Jalankan server lokal:
   ```bash
   php artisan serve
   ```

Aplikasi siap dijalankan di `http://localhost:8000`.
