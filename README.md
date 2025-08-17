# 🚀 Sistem Point of Sale (POS) Modern

[![Lisensi MIT](https://img.shields.io/badge/Lisensi-MIT-blue.svg)](LICENSE)

## Ikhtisar

Sistem POS (Point of Sale) yang lengkap, responsif, dan mudah digunakan yang dibangun dengan **Laravel Jetstream** dan **Tailwind CSS**. Proyek ini menyediakan solusi komprehensif untuk mengelola inventaris, memproses transaksi, dan memantau kinerja bisnis dengan antarmuka yang modern dan intuitif.

![Cuplikan Layar Dasbor](https://raw.githubusercontent.com/hbiiiii2/pos-system/main/public/images/auth-image.jpg)

## ✨ Fitur Utama

* **Manajemen Produk & Kategori:** Tambah, edit, dan hapus produk dan kategori dengan mudah. Kelola stok, harga, dan satuan untuk setiap produk.
* **Antarmuka Kasir Intuitif:** Proses transaksi dengan cepat dan efisien. Tambahkan produk ke keranjang, kelola jumlah, dan terima berbagai metode pembayaran (Tunai, QRIS, Transfer).
* **Manajemen Transaksi:** Lihat riwayat transaksi terperinci. Cetak ulang struk atau ekspor data untuk analisis lebih lanjut.
* **Laporan Komprehensif:** Dapatkan wawasan berharga dengan laporan harian, mingguan, dan bulanan. Pantau total penjualan, jumlah transaksi, dan produk terlaris.
* **Manajemen Pengguna Berbasis Peran:** Sistem ini dilengkapi dengan tiga peran pengguna yang telah ditentukan sebelumnya:
    * **Admin:** Memiliki akses penuh ke semua fitur, termasuk manajemen produk dan kategori.
    * **Kasir:** Dapat mengakses antarmuka POS untuk memproses transaksi.
    * **Pemilik:** Dapat melihat laporan dan dasbor untuk memantau kinerja bisnis.
* **Antarmuka Responsif & Modern:** Dibangun dengan Tailwind CSS, antarmuka pengguna dapat beradaptasi dengan berbagai ukuran layar, dari desktop hingga perangkat seluler.

## 🛠️ Tumpukan Teknologi

* **Backend:** Laravel 11, Laravel Jetstream
* **Frontend:** Livewire, Tailwind CSS, Alpine.js
* **Database:** MySQL (dapat disesuaikan)
* **Lainnya:**
    * `barryvdh/laravel-dompdf`: Untuk menghasilkan struk PDF.
    * `mike42/escpos-php`: Untuk pencetakan struk termal (opsional).

## 🚀 Memulai

### Prasyarat

* PHP 8.2 atau lebih tinggi
* Composer
* Node.js & NPM
* Server Database (misalnya, MySQL, MariaDB)

### Langkah-langkah Instalasi

1.  **Kloning Repositori:**
    ```bash
    git clone [https://github.com/hbiiiii2/pos-system.git](https://github.com/hbiiiii2/pos-system.git)
    cd pos-system
    ```

2.  **Instal Dependensi:**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan:**
    * Salin `.env.example` ke `.env`: `cp .env.example .env`
    * Buat kunci aplikasi: `php artisan key:generate`
    * Konfigurasikan koneksi database Anda di file `.env`:
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=pos_system
        DB_USERNAME=root
        DB_PASSWORD=
        ```

4.  **Migrasi dan Seeding Database:**
    Jalankan migrasi untuk membuat tabel database dan seeder untuk mengisi data awal (termasuk pengguna demo dan kategori).
    ```bash
    php artisan migrate --seed
    ```

5.  **Kompilasi Aset Frontend:**
    ```bash
    npm run dev
    ```

6.  **Jalankan Server Pengembangan:**
    ```bash
    php artisan serve
    ```
    Aplikasi Anda sekarang akan berjalan di `http://127.0.0.1:8000`.

### Akun Demo

Setelah menjalankan seeder, Anda dapat masuk dengan akun-akun berikut:

* **Admin:**
    * **Email:** `admin@pos.com`
    * **Kata Sandi:** `password`
* **Kasir:**
    * **Email:** `kasir@pos.com`
    * **Kata Sandi:** `password`
* **Pemilik:**
    * **Email:** `owner@pos.com`
    * **Kata Sandi:** `password`

## 🤝 Berkontribusi

Kontribusi dalam bentuk *pull request*, laporan bug, atau permintaan fitur sangat kami hargai. Silakan buka *issue* baru untuk mendiskusikan perubahan yang ingin Anda buat.

## 📄 Lisensi

Proyek ini dilisensikan di bawah **Lisensi MIT**. Lihat file [LICENSE](LICENSE) untuk detailnya.
