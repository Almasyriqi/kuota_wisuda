# Flow Map — Kuota Wisuda

Diagram dibuat dengan sintaks [Mermaid](https://mermaid.js.org/) yang
dirender otomatis oleh GitHub. Semua alur diringkas dari logika aktual di
controller (`app/Http/Controllers`), bukan asumsi.

---

## 1. Site Map / Navigasi Umum

```mermaid
graph TD
    Home["/ (Home)"] --> Wisuda["/wisuda — Daftar Gelombang Wisuda"]
    Home --> Jurusan["/jurusan — Daftar Jurusan"]

    Wisuda -->|Tambah| WisudaModal[["Modal: Tambah Gelombang"]]
    Wisuda -->|Edit| WisudaEdit["/wisuda/{id}/edit"]
    Wisuda -->|Kuota Prodi| KuotaProdi["/kuota_prodi?gelombang_id={id}"]

    Jurusan -->|Tambah| JurusanModal[["Modal: Tambah Jurusan"]]
    Jurusan -->|Edit| JurusanModal2[["Modal: Edit Jurusan"]]
    Jurusan -->|Lihat Prodi| Prodi["/prodi?jurusan_id={id}"]

    Prodi -->|Tambah| ProdiModal[["Modal: Tambah Prodi"]]
    Prodi -->|Edit| ProdiModal2[["Modal: Edit Prodi"]]

    KuotaProdi -->|Set Kuota| KuotaModal[["Modal: Set Kuota Prodi"]]
```

> Catatan: tidak ada halaman login pada site map ini karena memang belum
> ada autentikasi aktif di aplikasi (lihat `docs/SRS.md` §2.2 dan §5.3).

---

## 2. Flow: Kelola Gelombang Wisuda (Tambah & Edit)

```mermaid
flowchart TD
    A([Admin buka /wisuda]) --> B[Lihat daftar gelombang]
    B --> C{Aksi?}

    C -->|Tambah| D[Isi form: jenis, tanggal, kuota]
    D --> E[Submit POST /wisuda]
    E --> F["Sistem set nama = jumlah gelombang existing + 1"]
    F --> G["current_kuota = kuota"]
    G --> H[Simpan gelombang baru]
    H --> I[Redirect ke /wisuda + pesan sukses]

    C -->|Edit| J["Buka /wisuda/{id}/edit"]
    J --> K[Ubah jenis / tanggal / kuota]
    K --> L["Submit PUT /wisuda/{id}"]
    L --> M{Mulai transaction}
    M --> N{"kuota baru != kuota lama?"}
    N -->|Ya| O["current_kuota = kuota baru"]
    O --> P["Reset semua gelombang_prodi.kuota = 0 untuk gelombang ini"]
    P --> Q[Simpan perubahan]
    N -->|Tidak| Q
    Q --> R{Berhasil?}
    R -->|Ya| S[Commit transaction]
    S --> T[Redirect ke /wisuda + pesan sukses]
    R -->|Tidak, exception| U[Rollback transaction]
    U --> V[Kembali ke form + pesan error]

    C -->|Kuota Prodi| W["Lanjut ke Flow #4 (Set Kuota Prodi)"]
```

**Poin penting**: mengubah `kuota` gelombang adalah operasi destruktif
terhadap alokasi yang sudah ada — semua kuota prodi pada gelombang tsb
di-reset ke 0. Admin perlu menyadari ini sebelum mengubah kuota gelombang
yang sudah punya alokasi.

---

## 3. Flow: Kelola Jurusan

```mermaid
flowchart TD
    A([Admin buka /jurusan]) --> B[Lihat daftar jurusan]
    B --> C{Aksi?}

    C -->|Tambah| D["Isi nama jurusan (modal)"]
    D --> E["Submit POST /jurusan"]
    E --> F{Validasi required?}
    F -->|Gagal| G[Kembali ke form + error]
    F -->|Lolos| H["Simpan nama (UPPERCASE)"]
    H --> I[Redirect + pesan sukses]

    C -->|Edit| J["Klik Edit → AJAX GET /jurusan/{id}/edit"]
    J --> K["Modal terisi data existing"]
    K --> L["Submit PUT /jurusan/{id}"]
    L --> M{Validasi required?}
    M -->|Gagal| N[Kembali + error]
    M -->|Lolos| O["Update nama (UPPERCASE)"]
    O --> P[Redirect + pesan sukses]

    C -->|Lihat Prodi| Q["Lanjut ke Flow #4 (Kelola Prodi)"]

    C -->|Hapus| R["❌ Tidak terhubung — href='#'"]
```

---

## 4. Flow: Kelola Program Studi (Prodi)

```mermaid
flowchart TD
    A(["Admin buka /prodi?jurusan_id={id}"]) --> B["Lihat daftar prodi milik jurusan tsb"]
    B --> C{Aksi?}

    C -->|Tambah| D["Pilih jenjang (D3/D4/S2) + isi nama (modal)"]
    D --> E["Submit POST /prodi"]
    E --> F{"Validasi nama & jenjang required?"}
    F -->|Gagal| G[Kembali ke form + error]
    F -->|Lolos| H["Simpan nama = UPPERCASE('{jenjang} {nama}')"]
    H --> I[Redirect ke /prodi?jurusan_id={id} + sukses]

    C -->|Edit| J["Klik Edit → AJAX GET /prodi/{id}/edit"]
    J --> K["Modal terisi: nama (tanpa prefix jenjang) + jenjang"]
    K --> L["Submit PUT /prodi/{id}"]
    L --> M{Validasi?}
    M -->|Gagal| N[Kembali + error]
    M -->|Lolos| O["Update nama = UPPERCASE('{jenjang} {nama}')"]
    O --> P[Redirect + sukses]

    C -->|Hapus| Q["❌ Tidak diimplementasikan"]
```

---

## 5. Flow: Set Kuota Prodi per Gelombang

```mermaid
flowchart TD
    A(["Admin buka /kuota_prodi?gelombang_id={id}"]) --> B["Lihat semua prodi + kuota existing pada gelombang ini"]
    B --> C["Klik 'Set Kuota' pada satu prodi"]
    C --> D["Modal terisi: nama prodi + kuota existing"]
    D --> E["Admin isi kuota baru"]
    E --> F["Submit POST /kuota_prodi"]
    F --> G{Mulai transaction}
    G --> H["Hitung: current_kuota_baru = current_kuota_sekarang - kuota_input"]
    H --> I{"current_kuota_baru < 0?"}
    I -->|Ya| J["Rollback implicit / batal simpan"]
    J --> K["Kembali ke halaman + pesan error: kuota melebihi batas"]
    I -->|Tidak| L{"Alokasi (gelombang_id, prodi_id) sudah ada?"}
    L -->|Belum| M["Buat record gelombang_prodi baru"]
    L -->|Sudah| N["Ambil record existing"]
    M --> O["Set kuota = kuota_input"]
    N --> O
    O --> P["Simpan gelombang_prodi"]
    P --> Q["Hitung ulang: gelombang.current_kuota = gelombang.kuota - SUM(semua gelombang_prodi.kuota)"]
    Q --> R["Simpan gelombang"]
    R --> S[Commit transaction]
    S --> T["Redirect ke /kuota_prodi?gelombang_id={id} + pesan sukses"]
```

**Aturan bisnis kunci** (`SRS-F-KTP-03`): total kuota yang dialokasikan ke
seluruh prodi pada satu gelombang tidak boleh melebihi `kuota` gelombang
tersebut. Validasi dilakukan terhadap **sisa kuota saat ini**
(`current_kuota`), bukan menjumlah ulang seluruh alokasi sebelum
validasi — sehingga urutan operasi (validasi dulu, baru simpan) penting
untuk menjaga konsistensi data.

---

## 6. Entity Relationship Diagram

```mermaid
erDiagram
    JURUSAN ||--o{ PRODI : "memiliki"
    GELOMBANG ||--o{ GELOMBANG_PRODI : "mengalokasikan"
    PRODI ||--o{ GELOMBANG_PRODI : "menerima alokasi"

    JURUSAN {
        bigint id PK
        string nama
    }

    PRODI {
        bigint id PK
        bigint jurusan_id FK
        string jenjang
        string nama
    }

    GELOMBANG {
        bigint id PK
        int nama "nomor urut gelombang"
        date tanggal_wisuda
        string jenis "OFFLINE / ONLINE"
        int kuota "total kuota gelombang"
        int current_kuota "sisa kuota belum teralokasi"
    }

    GELOMBANG_PRODI {
        bigint id PK
        bigint gelombang_id FK
        bigint prodi_id FK
        int kuota "kuota yang dialokasikan ke prodi ini"
    }
```
