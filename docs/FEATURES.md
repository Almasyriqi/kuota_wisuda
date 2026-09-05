# Daftar Fitur — Kuota Wisuda

Status diverifikasi langsung dari kode (`app/Http/Controllers`,
`resources/views/pages`), bukan dari spesifikasi awal, sehingga tabel ini
mencerminkan kondisi aplikasi yang sebenarnya berjalan saat ini.

Legenda status:
- ✅ **Implemented** — berfungsi penuh
- ⚠️ **Partial** — sebagian jalan / ada catatan
- ❌ **Not Implemented** — UI ada tapi backend belum, atau belum ada sama sekali

---

## 1. Modul Wisuda (Gelombang)

| Fitur | Deskripsi | Aktor | Status |
|---|---|---|---|
| Lihat daftar gelombang wisuda | Menampilkan seluruh gelombang, diurutkan terbaru, dengan info jenis, tanggal, kuota, dan sisa kuota | Admin | ✅ |
| Tambah gelombang wisuda | Modal form: jenis (OFFLINE/ONLINE), tanggal, kuota. Nomor gelombang otomatis | Admin | ✅ |
| Edit gelombang wisuda | Halaman terpisah untuk ubah jenis, tanggal, kuota | Admin | ✅ |
| Reset alokasi saat kuota berubah | Jika kuota gelombang diedit, seluruh alokasi kuota prodi pada gelombang tsb otomatis di-reset ke 0 | Sistem (otomatis) | ✅ |
| Navigasi ke Kuota Prodi | Tombol aksi menuju halaman alokasi kuota per prodi untuk gelombang terkait | Admin | ✅ |
| Hapus gelombang wisuda | — | Admin | ❌ Method `destroy()` kosong, tidak ada tombol di UI |

## 2. Modul Jurusan

| Fitur | Deskripsi | Aktor | Status |
|---|---|---|---|
| Lihat daftar jurusan | Tabel ID + nama, dengan search/sort (DataTables) | Admin | ✅ |
| Tambah jurusan | Modal form, nama disimpan uppercase otomatis | Admin | ✅ |
| Edit jurusan | Modal form, data di-load via AJAX (`GET jurusan/{id}/edit`) | Admin | ✅ |
| Navigasi ke Prodi | Tombol "Lihat Prodi" menuju daftar prodi milik jurusan tsb | Admin | ✅ |
| Hapus jurusan | Tombol "Hapus" ada di UI tapi `href="#"` (tidak wired) | Admin | ❌ UI stub, backend kosong |

## 3. Modul Program Studi (Prodi)

| Fitur | Deskripsi | Aktor | Status |
|---|---|---|---|
| Lihat daftar prodi per jurusan | Difilter via query `jurusan_id`, judul halaman menampilkan nama jurusan | Admin | ✅ |
| Tambah prodi | Modal form: jenjang (D3/D4/S2) + nama; hasil akhir digabung & uppercase | Admin | ✅ |
| Edit prodi | Modal form, data di-load via AJAX (`GET prodi/{id}/edit`), jenjang dipisah dari nama untuk ditampilkan di form | Admin | ✅ |
| Hapus prodi | — | Admin | ❌ Method `destroy()` kosong, tidak ada tombol di UI |

## 4. Modul Kuota Prodi

| Fitur | Deskripsi | Aktor | Status |
|---|---|---|---|
| Lihat alokasi kuota per gelombang | Daftar seluruh prodi + kuota yang sudah dialokasikan untuk satu gelombang, plus info total & sisa kuota | Admin | ✅ |
| Set/ubah kuota prodi | Modal "Set Kuota" per baris prodi, prefill nilai kuota saat ini | Admin | ✅ |
| Validasi batas kuota | Menolak input bila `current_kuota - kuota_baru < 0` (melebihi sisa kuota gelombang) | Sistem (otomatis) | ✅ |
| Rekalkulasi sisa kuota | `current_kuota` gelombang dihitung ulang otomatis setiap kali kuota prodi disimpan | Sistem (otomatis) | ✅ |

## 5. Fitur Umum / Cross-cutting

| Fitur | Deskripsi | Status |
|---|---|---|
| Notifikasi sukses/gagal | SweetAlert2 + flash session Laravel | ✅ |
| Validasi form dasar | `required`, `string` pada input utama | ✅ |
| Validasi keunikan nama | Nama jurusan/prodi belum dicek duplikat | ❌ |
| Proteksi CSRF | Token `@csrf` di semua form | ✅ |
| Autentikasi login | Tidak ada middleware `auth` di route manapun | ❌ |
| Role/permission admin | Belum ada pembedaan level akses | ❌ |
| REST API | Aplikasi hanya web (blade), tidak ada endpoint API | ❌ |
| Automated test bisnis proses | Hanya ada `ExampleTest` bawaan skeleton Laravel | ❌ |

---

## Ringkasan Backlog dari Gap di Atas

Prioritas yang disarankan (detail alasan ada di `docs/SRS.md` §6 dan
jawaban rekomendasi terpisah):

1. Autentikasi & otorisasi admin
2. Implementasi fitur Hapus (Wisuda, Jurusan, Prodi) atau sembunyikan
   tombolnya sampai siap
3. Validasi unique untuk nama Jurusan/Prodi
4. Locking pada perhitungan `current_kuota` agar aman dari race condition
5. Automated test untuk aturan bisnis kuota
