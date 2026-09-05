# Kuota Wisuda

Aplikasi berbasis web untuk mengelola kuota peserta wisuda per gelombang dan program studi. Dibangun dengan [Laravel](https://laravel.com).

## Fitur

- **Wisuda (Gelombang)** — membuat dan mengelola gelombang wisuda beserta tanggal pelaksanaan, jenis wisuda, dan total kuota per gelombang.
- **Jurusan** — mengelola data jurusan.
- **Program Studi (Prodi)** — mengelola data program studi yang terhubung ke sebuah jurusan, lengkap dengan jenjang pendidikan (D3, D4, S1, dst).
- **Kuota Prodi** — mengalokasikan kuota peserta wisuda ke tiap program studi untuk suatu gelombang wisuda tertentu. Sistem otomatis memvalidasi agar total kuota yang dialokasikan tidak melebihi kuota gelombang.

## Tech Stack

- PHP 8.1+
- Laravel 10
- MySQL
- Vite (build asset front-end)
- Bootstrap admin theme + [SweetAlert2](https://github.com/realrashid/laravel-sweetalert) untuk notifikasi

## Persyaratan

Pastikan tools berikut sudah terpasang di komputer kamu:

- PHP >= 8.1 beserta ekstensi yang dibutuhkan Laravel (mbstring, openssl, pdo, tokenizer, xml, ctype, json, bcmath)
- [Composer](https://getcomposer.org/)
- Node.js & npm
- Server database (MySQL/MariaDB)

## Langkah-Langkah Menjalankan Project

1. **Clone repository**

   ```bash
   git clone https://github.com/almasyriqi/kuota_wisuda.git
   cd kuota_wisuda
   ```

2. **Install dependency PHP**

   ```bash
   composer install
   ```

3. **Install dependency Node.js**

   ```bash
   npm install
   ```

4. **Salin file environment**

   ```bash
   cp .env.example .env
   ```

5. **Generate application key**

   ```bash
   php artisan key:generate
   ```

6. **Konfigurasi database**

   Buat database baru (misalnya `kuota_wisuda`), lalu sesuaikan kredensial database di file `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kuota_wisuda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Jalankan migrasi dan seeder**

   ```bash
   php artisan migrate --seed
   ```

8. **Buat symbolic link storage** (agar file yang diunggah bisa diakses publik)

   ```bash
   php artisan storage:link
   ```

9. **Build asset front-end**

   Untuk mode pengembangan (auto-reload saat ada perubahan):

   ```bash
   npm run dev
   ```

   Atau build untuk production:

   ```bash
   npm run build
   ```

10. **Jalankan development server**

    Di terminal baru (biarkan `npm run dev` tetap berjalan jika digunakan):

    ```bash
    php artisan serve
    ```

11. **Buka aplikasi**

    Akses aplikasi melalui browser di [http://localhost:8000](http://localhost:8000).

## Menjalankan Test

```bash
php artisan test
```

## Struktur Data Utama

| Model | Deskripsi |
|---|---|
| `Jurusan` | Data jurusan |
| `Prodi` | Data program studi, terhubung ke `Jurusan` |
| `Gelombang` | Data gelombang wisuda (tanggal, jenis, total kuota) |
| `gelombang_prodi` | Tabel pivot alokasi kuota tiap `Prodi` pada suatu `Gelombang` |

## Lisensi

Project ini menggunakan framework Laravel yang open-sourced dengan lisensi [MIT](https://opensource.org/licenses/MIT).
