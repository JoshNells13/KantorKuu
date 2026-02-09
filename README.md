# Sistem Peminjaman Peralatan (Tool Inventory System)

Aplikasi berbasis web yang dibangun menggunakan **Laravel 12** untuk mengelola peminjaman peralatan. Sistem ini memfasilitasi proses peminjaman mulai dari pengajuan oleh peminjam, persetujuan oleh petugas/admin, hingga pengembalian barang, serta mencakup manajemen inventaris dan pelaporan.

## 🚀 Fitur Utama

Sistem ini memiliki 3 hak akses (Role) dengan fitur yang berbeda:

### 1. Admin
Memiliki akses penuh terhadap sistem.
* **Dashboard Admin:** Ringkasan statistik sistem.
* **Manajemen User:** CRUD (Create, Read, Update, Delete) data pengguna.
* **Manajemen Inventaris:**
    * Kelola Kategori Barang (`Categories`).
    * Kelola Data Alat/Barang (`Tools`).
* **Manajemen Transaksi:**
    * Melihat daftar peminjaman (`Borrowings`).
    * Menyetujui peminjaman (`Approve`).
    * Memproses pengembalian barang (`Return Tools`).
* **Laporan & Log:**
    * Melihat riwayat aktivitas sistem (`Activity Logs`).
    * Mencetak/melihat laporan (`Reports`).

### 2. Petugas
Bertugas membantu operasional peminjaman sehari-hari.
* **Dashboard Petugas.**
* **Manajemen Peminjaman:** Melihat daftar peminjaman masuk.
* **Persetujuan:** Menyetujui status peminjaman (`Approve`).
* **Pengembalian:** Memproses pengembalian barang dari peminjam.

### 3. Peminjam (User)
Pengguna umum yang akan meminjam barang.
* **Dashboard Peminjam.**
* **Katalog Alat:** Melihat daftar alat yang tersedia.
* **Peminjaman:** Mengajukan permohonan peminjaman alat.
* **Pengembalian:** Melakukan prosedur pengembalian alat.
* **Riwayat:** Melihat status peminjaman pribadi.

## 🛠️ Teknologi yang Digunakan

* **Framework:** Laravel
* **Bahasa:** PHP
* **Database:** MySQL
* **Frontend:** Blade Templating (Tailwind - *sesuaikan dengan project anda*)

## 📦 Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/username/repo-anda.git](https://github.com/username/repo-anda.git)
    cd repo-anda
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment**
    Duplikat file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi database:
    ```ini
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database & Seeder**
    ```bash
    php artisan migrate --seed
    ```
    *(Pastikan Anda sudah membuat database di MySQL sebelum menjalankan perintah ini)*

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```

Buka browser dan akses: `http://127.0.0.1:8000`


Daftarkan Role Middleware Di Kernel Php

protected $middlewareAliases = [
    // Middleware bawaan Laravel lainnya...
    'auth' => \App\Http\Middleware\Authenticate::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    
    // --- TAMBAHKAN BARIS INI ---
    'role' => \App\Http\Middleware\CheckRole::class, 
];



// bootstrap/app.php (Hanya untuk Laravel 11)
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Daftarkan alias di sini
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
