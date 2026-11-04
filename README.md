# Laundry Express

Laundry Express adalah aplikasi web laundry berbasis Laravel. Pelanggan dapat melihat layanan dan membuat pesanan, sedangkan admin dapat mengelola layanan serta memperbarui status pesanan.

## Tools dan teknologi

- **PHP 8.3 atau lebih baru** dan **Composer** untuk backend Laravel.
- **Node.js dan npm** untuk mengelola aset frontend.
- **SQLite** sebagai database lokal bawaan; konfigurasi koneksi ada di `.env`.
- **Laravel 13**, Eloquent ORM, Blade, Vite, dan Tailwind CSS.
- **Laravel Breeze** untuk fitur autentikasi.
- Editor kode seperti **Visual Studio Code** dan browser untuk menjalankan aplikasi.

## Menyiapkan aplikasi

Jalankan perintah berikut dari folder project:

```bash
composer setup
```

Script tersebut memasang dependency, membuat `.env` jika belum ada, membuat application key, menjalankan migrasi database, memasang dependency frontend, dan membangun aset. Konfigurasi awal menggunakan SQLite. Jika memakai database lain, atur koneksi dan kredensial di `.env` sebelum menjalankan migrasi.

Isi database dengan data contoh:

```bash
php artisan db:seed
```

Seeder menambahkan layanan contoh, akun demo, dan admin untuk kebutuhan pengembangan lokal. Periksa `database/seeders/DatabaseSeeder.php` dan `database/seeders/CustomerSeeder.php` untuk detail akun. Jangan gunakan akun atau password seeder di production.

Aktifkan penyimpanan publik agar gambar layanan dapat ditampilkan:

```bash
php artisan storage:link
```

## Menjalankan aplikasi

Buka dua terminal dari folder project.

Terminal pertama:

```bash
php artisan serve
```

Terminal kedua:

```bash
npm run dev
```

Buka alamat yang ditampilkan oleh `php artisan serve` (biasanya `http://127.0.0.1:8000`). Halaman utama pemesanan pelanggan tersedia di `/customer`. Admin dapat masuk melalui `/login`, lalu membuka `/dashboard`.

## Alur pengembangan Laundry Express

Ikuti urutan ini saat memahami atau mengembangkan fitur aplikasi:

1. **Siapkan autentikasi dan peran pengguna.** Laravel Breeze menyediakan halaman login, registrasi, dan profil. Akses admin dibatasi menggunakan gate `admin`; lihat `app/Providers/AppServiceProvider.php` dan `routes/web.php`.
2. **Kelola katalog layanan.** Model dan migrasi layanan menyimpan nama, kategori, harga per satuan, unit, deskripsi, dan gambar. CRUD admin ditangani oleh `app/Http/Controllers/ServicesController.php` dengan tampilan di `resources/views/admin/services/`.
3. **Buat pemesanan pelanggan.** Form pelanggan berada di `resources/views/customer/index.blade.php`. `app/Http/Controllers/OrderController.php` memvalidasi data, menghitung subtotal dan total, lalu menyimpan pesanan beserta detailnya dalam transaksi database.
4. **Kelola proses laundry.** Dashboard admin menampilkan pesanan dan layanan yang dipesan. Admin dapat mengubah status menjadi `Antrean`, `Dicuci`, atau `Selesai`.
5. **Perbarui tampilan dan aset.** Template Blade ada di `resources/views/`; aset frontend dikelola oleh Vite. Jalankan `npm run dev` saat mengembangkan dan `npm run build` untuk membangun aset.
6. **Uji perubahan.** Tambahkan atau perbarui pengujian pada `tests/Feature/` untuk alur pemesanan, autentikasi, hak akses, dan pengelolaan layanan.

### Struktur data utama

- `services`: katalog layanan laundry.
- `orders`: data pelanggan, nomor WhatsApp, total harga, dan status pesanan.
- `order_details`: layanan, jumlah, dan subtotal untuk setiap pesanan.
- `users`: akun pelanggan dan admin, termasuk peran.

Migrasi berada di `database/migrations/`; model dan relasi Eloquent berada di `app/Models/`.

## Perintah yang sering digunakan

```bash
# Menjalankan migrasi yang belum diterapkan
php artisan migrate

# Mengisi atau memperbarui data contoh
php artisan db:seed

# Menjalankan seluruh test
php artisan test

# Membangun aset frontend
npm run build
```

> **Perhatian:** `php artisan migrate:fresh` menghapus seluruh tabel database sebelum menjalankan ulang migrasi. Gunakan hanya pada database lokal yang datanya boleh dihapus.

## Sebelum deploy

- Atur `APP_ENV=production` dan `APP_DEBUG=false`.
- Gunakan database dan kredensial khusus production; jangan memakai akun demo dari seeder.
- Pastikan konfigurasi email, URL aplikasi, dan penyimpanan file sudah sesuai lingkungan production.
- Jangan memasukkan `.env` atau kredensial ke repository.
