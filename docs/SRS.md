# Software Requirement Specification (SRS)
## Sistem Kuota Wisuda

Dokumen ini dibuat berdasarkan analisis kode aplikasi yang sudah berjalan
(bukan spekulasi kebutuhan), sehingga mencerminkan behavior aktual sekaligus
menandai bagian yang belum lengkap.

---

## 1. Pendahuluan

### 1.1 Tujuan
Mendeskripsikan kebutuhan fungsional dan non-fungsional dari aplikasi
**Kuota Wisuda**, yaitu sistem untuk mengelola kuota peserta wisuda per
gelombang dan per program studi (prodi).

### 1.2 Ruang Lingkup
Sistem mencakup pengelolaan data master (Jurusan, Program Studi), data
transaksi (Gelombang Wisuda), dan alokasi kuota peserta wisuda ke tiap
program studi untuk setiap gelombang. Sistem berbentuk aplikasi web
berbasis Laravel dengan antarmuka admin (tanpa antarmuka publik untuk
peserta/mahasiswa).

### 1.3 Definisi & Istilah

| Istilah | Definisi |
|---|---|
| **Wisuda** | Acara kelulusan mahasiswa. |
| **Gelombang** | Satu periode/batch penyelenggaraan wisuda (mis. "Wisuda Ke-3"), memiliki tanggal, jenis, dan total kuota. |
| **Jurusan** | Unit akademik yang menaungi satu atau lebih Program Studi. |
| **Prodi (Program Studi)** | Program pendidikan di bawah satu Jurusan, memiliki jenjang (D3/D4/S2). |
| **Kuota** | Jumlah maksimum peserta yang boleh mengikuti wisuda pada suatu gelombang, atau alokasinya per prodi. |
| **Kuota Prodi** | Alokasi sebagian dari kuota gelombang untuk satu prodi tertentu. |
| **Current Kuota** | Sisa kuota gelombang yang belum dialokasikan ke prodi manapun. |

### 1.4 Referensi
Kode sumber aplikasi: `app/Models`, `app/Http/Controllers`,
`database/migrations`, `routes/web.php`, `resources/views/pages`.

---

## 2. Deskripsi Umum Sistem

### 2.1 Perspektif Produk
Aplikasi berdiri sendiri (bukan bagian dari sistem akademik yang lebih
besar), dibangun dengan Laravel 10, MySQL, dan tema admin berbasis
Bootstrap (Metronic-like) dengan interaksi AJAX (jQuery + DataTables +
SweetAlert2).

### 2.2 Aktor Pengguna

| Aktor | Deskripsi |
|---|---|
| **Admin** | Pengguna yang mengelola data Jurusan, Prodi, Gelombang Wisuda, dan alokasi Kuota Prodi. |

> ⚠️ **Catatan penting**: Saat ini seluruh route (`routes/web.php`) **tidak
> dilindungi middleware autentikasi apapun**. Secara teknis siapa pun yang
> mengakses URL aplikasi berperan sebagai "Admin". Layout
> `resources/views/layouts/auth.blade.php` tersedia di codebase namun tidak
> digunakan oleh route manapun — kemungkinan sisa scaffolding Laravel yang
> belum diaktifkan. Ini didokumentasikan sebagai **gap**, lihat bagian 5.3.

### 2.3 Asumsi & Ketergantungan
- Satu Prodi hanya berada di bawah satu Jurusan (relasi 1—N).
- Satu Gelombang dapat mengalokasikan kuota ke banyak Prodi, dan satu Prodi
  bisa mendapat alokasi di banyak Gelombang (relasi N—N via tabel pivot
  `gelombang_prodis`).
- Sistem berjalan di lingkungan dengan satu database MySQL/MariaDB.
- Tidak ada integrasi dengan sistem eksternal (SIAKAD, dsb.) pada versi
  ini — seluruh data diinput manual oleh Admin.

---

## 3. Kebutuhan Fungsional

Kode requirement: `SRS-F-<modul>-<nomor>`.

### 3.1 Modul Wisuda (Gelombang)
Sumber: `WisudaController`, model `Gelombang`.

| ID | Kebutuhan |
|---|---|
| SRS-F-WIS-01 | Sistem harus menampilkan daftar seluruh gelombang wisuda, diurutkan dari yang terbaru, lengkap dengan nomor gelombang, jenis, tanggal, kuota yang diset, dan sisa kuota (`current_kuota`). |
| SRS-F-WIS-02 | Sistem harus dapat menambahkan gelombang wisuda baru dengan input: jenis wisuda (OFFLINE/ONLINE), tanggal wisuda, dan kuota total. Nomor gelombang (`nama`) di-generate otomatis (jumlah gelombang existing + 1). |
| SRS-F-WIS-03 | Saat gelombang baru dibuat, `current_kuota` diinisialisasi sama dengan `kuota` yang diinput. |
| SRS-F-WIS-04 | Sistem harus dapat mengedit data gelombang (jenis, tanggal, kuota) melalui halaman edit khusus. |
| SRS-F-WIS-05 | Jika nilai `kuota` gelombang diubah pada proses edit, sistem harus mereset `current_kuota` menjadi sama dengan `kuota` baru **dan** mereset seluruh alokasi kuota prodi (`gelombang_prodi.kuota`) pada gelombang tersebut menjadi 0. |
| SRS-F-WIS-06 | Proses update dilakukan dalam database transaction; jika terjadi error, perubahan di-rollback dan pesan error ditampilkan ke pengguna. |
| SRS-F-WIS-07 | Sistem harus menyediakan navigasi dari daftar gelombang menuju halaman "Kuota Prodi" gelombang terkait. |
| ❌ SRS-F-WIS-08 | *(belum diimplementasikan)* Sistem seharusnya dapat menghapus data gelombang wisuda — method `destroy()` ada namun kosong, dan tidak ada aksi hapus di UI. |

### 3.2 Modul Jurusan
Sumber: `JurusanController`, model `Jurusan`.

| ID | Kebutuhan |
|---|---|
| SRS-F-JUR-01 | Sistem harus menampilkan daftar seluruh jurusan (ID dan nama) dalam tabel dengan fitur pencarian/sorting (DataTables). |
| SRS-F-JUR-02 | Sistem harus dapat menambahkan jurusan baru melalui modal form dengan input nama (wajib diisi). Nama disimpan dalam huruf kapital (uppercase) secara otomatis. |
| SRS-F-JUR-03 | Sistem harus dapat mengedit nama jurusan melalui modal form yang di-load datanya via AJAX (`GET jurusan/{id}/edit` mengembalikan JSON). |
| SRS-F-JUR-04 | Sistem harus menyediakan navigasi dari daftar jurusan menuju halaman "Prodi" milik jurusan tersebut. |
| ❌ SRS-F-JUR-05 | *(belum diimplementasikan)* Tombol "Hapus" tersedia di UI (`href="#"`) namun tidak terhubung ke route/aksi apapun; method `destroy()` di controller kosong. |

### 3.3 Modul Program Studi (Prodi)
Sumber: `ProdiController`, model `Prodi`.

| ID | Kebutuhan |
|---|---|
| SRS-F-PRD-01 | Sistem harus menampilkan daftar prodi yang difilter berdasarkan `jurusan_id` (parameter query), termasuk nama jurusan pada judul halaman. |
| SRS-F-PRD-02 | Sistem harus dapat menambahkan prodi baru dengan input: jenjang (D3/D4/S2) dan nama prodi (wajib diisi keduanya). Nama akhir yang disimpan adalah gabungan `"{jenjang} {nama}"` dalam huruf kapital. |
| SRS-F-PRD-03 | Sistem harus dapat mengedit jenjang dan nama prodi melalui modal form yang di-load datanya via AJAX (`GET prodi/{id}/edit` mengembalikan JSON, dengan nama jenjang dihapus dari string nama untuk ditampilkan terpisah di form). |
| ❌ SRS-F-PRD-04 | *(belum diimplementasikan)* Tombol "Hapus" ada di UI namun `href="#"`, method `destroy()` kosong. |

### 3.4 Modul Kuota Prodi
Sumber: `KuotaProdiController`, model `gelombang_prodi`.

| ID | Kebutuhan |
|---|---|
| SRS-F-KTP-01 | Sistem harus menampilkan daftar seluruh prodi beserta kuota yang sudah dialokasikan untuk gelombang tertentu (parameter `gelombang_id`), termasuk info total kuota gelombang dan sisa kuota (`current_kuota`). |
| SRS-F-KTP-02 | Sistem harus dapat men-set/mengubah kuota untuk satu prodi pada satu gelombang melalui modal form. |
| SRS-F-KTP-03 | Sistem harus memvalidasi bahwa kuota baru yang diinput **tidak melebihi sisa kuota gelombang** (`current_kuota - kuota_input < 0` ⇒ ditolak dengan pesan error, tidak disimpan). |
| SRS-F-KTP-04 | Jika alokasi untuk pasangan (gelombang, prodi) belum ada, sistem membuat record baru; jika sudah ada, sistem meng-update kuota yang lama (bukan menambah/mengurangi, melainkan menimpa nilai). |
| SRS-F-KTP-05 | Setelah kuota prodi disimpan, sistem harus menghitung ulang `current_kuota` gelombang = `kuota gelombang − total seluruh kuota prodi yang sudah dialokasikan pada gelombang itu`. |
| SRS-F-KTP-06 | Seluruh proses set kuota dijalankan dalam database transaction; error apapun akan di-rollback. |

---

## 4. Kebutuhan Data (Ringkasan Entitas)

| Entitas (tabel) | Atribut kunci | Relasi |
|---|---|---|
| `jurusans` | `id`, `nama` | 1—N ke `prodis` |
| `prodis` | `id`, `jurusan_id`, `jenjang`, `nama` | N—1 ke `jurusans`; N—N ke `gelombangs` via `gelombang_prodis` |
| `gelombangs` | `id`, `nama` (nomor urut), `tanggal_wisuda`, `jenis` (OFFLINE/ONLINE), `kuota`, `current_kuota` | N—N ke `prodis` via `gelombang_prodis` |
| `gelombang_prodis` | `id`, `gelombang_id`, `prodi_id`, `kuota` | Pivot antara `gelombangs` dan `prodis` |

Detail lengkap ada di `docs/FLOWMAP.md` bagian ER Diagram.

---

## 5. Kebutuhan Non-Fungsional

### 5.1 Usability
- Antarmuka menggunakan tema admin responsif (grid Bootstrap), dapat
  diakses dari desktop maupun tablet.
- Notifikasi hasil aksi (sukses/gagal) ditampilkan via SweetAlert2
  (`realrashid/sweet-alert`) dan flash message Laravel (`session('success')`,
  `withErrors`).
- Tabel data memakai DataTables untuk pencarian dan sorting sisi klien.

### 5.2 Performance
- Operasi CRUD bersifat sinkron (tidak ada queue/job), sesuai untuk skala
  data akademik (jumlah jurusan/prodi/gelombang relatif kecil).
- Query index (`Prodi::all()`, `Gelombang::all()`) tidak dipaginasi — cukup
  aman untuk skala saat ini namun perlu diwaspadai jika jumlah data
  bertambah signifikan.

### 5.3 Security ⚠️ *(gap signifikan)*
- **Tidak ada autentikasi/login** aktif di seluruh route. Siapa pun yang
  memiliki akses ke URL dapat melakukan CRUD data akademik.
- **Tidak ada otorisasi berbasis role** — tidak ada pembedaan antar level
  admin.
- CSRF protection sudah aktif secara default (bawaan Laravel, `@csrf` pada
  seluruh form).
- Validasi input dasar sudah diterapkan pada `store`/`update` (required,
  string), namun belum ada validasi keunikan (`unique`) pada nama
  jurusan/prodi — berpotensi duplikasi data.

### 5.4 Compatibility
- Membutuhkan PHP ≥ 8.1, ekstensi standar Laravel (mbstring, PDO, dsb.).
- Database: MySQL/MariaDB (ditentukan lewat `DB_CONNECTION` di `.env`).
- Front-end memakai jQuery + Bootstrap (bukan SPA), sehingga kompatibel
  dengan browser modern tanpa kebutuhan build tooling khusus di sisi klien
  selain Vite untuk asset (`app.css`, `app.js`).

### 5.5 Maintainability
- Struktur mengikuti konvensi Laravel (MVC, Eloquent, resource routing),
  memudahkan pengembang baru memahami alur.
- Satu penyimpangan konvensi: nama model `gelombang_prodi` (snake_case)
  seharusnya `GelombangProdi` (PascalCase) mengikuti standar Eloquent.

---

## 6. Batasan Sistem & Known Gaps

| # | Gap / Batasan | Dampak |
|---|---|---|
| 1 | Tidak ada autentikasi & role admin | Risiko keamanan tinggi bila di-deploy publik |
| 2 | Fitur hapus (Wisuda, Jurusan, Prodi) belum diimplementasikan | Data tidak bisa dihapus, hanya bisa ditambah/edit |
| 3 | Tidak ada validasi unique pada nama Jurusan/Prodi | Berpotensi data duplikat |
| 4 | Tidak ada locking saat menghitung `current_kuota` | Berpotensi race condition bila diakses concurrent |
| 5 | Tidak ada API (hanya web/blade) | Tidak bisa diintegrasikan ke sistem lain tanpa scraping HTML |
| 6 | Tidak ada automated test khusus bisnis proses | Regresi sulit terdeteksi otomatis |

Rekomendasi perbaikan untuk gap-gap di atas dijelaskan terpisah oleh
asisten pada saat dokumen ini dibuat (lihat riwayat percakapan / catatan
rilis), dan dapat ditambahkan sebagai lampiran bila diperlukan.
