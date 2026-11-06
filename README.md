<div align="center">

# 📬 SuratFlow — Sistem Manajemen Surat & Disposisi
### *Enterprise Correspondence, Archiving & Disposition Tracking System*

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](LICENSE)

<p align="center">
  Aplikasi manajemen persuratan dan administrasi perkantoran modern berbasis web. Mempermudah pencatatan surat masuk, pengelolaan surat keluar, pelacakan lembar disposisi pimpinan, dan penjadwalan agenda kegiatan dinas secara terstruktur dan terotomatisasi.
</p>

</div>

---

## 📌 Latar Belakang & Solusi

Sistem administrasi persuratan fisik pada instansi maupun organisasi sering kali mengalami kendala seperti surat tercecer, lambatnya alur birokrasi penyerahan disposisi ke pimpinan, dan sulitnya melacak riwayat surat terdahulu.

**SuratFlow** dirancang untuk mendigitalkan birokrasi persuratan perkantoran dengan keunggulan:
* **Digital Correspondence Archiving:** Seluruh surat masuk dan keluar terindeks rapi berdasarkan nomor surat, tanggal, pengirim, dan kategori.
* **Hierarchical Letter Disposition:** Disposisi surat dapat langsung dibuat oleh pimpinan, diteruskan ke staf terkait, dan dipantau status tindak lanjutnya.
* **Granular Role-Based Permissions:** Memisahkan wewenang antara Administrator, Operator Tata Usaha, Pimpinan, dan Staf umum (*Viewer*).
* **Agenda Dinas Terpadu:** Pengelolaan jadwal kegiatan dan rapat internal yang terintegrasi langsung dengan kalender dinas.

---

## 🌟 Fitur Unggulan

```
                                  ┌────────────────────────┐
                                  │      SURAT MASUK       │
                                  └───────────┬────────────┘
                                              │
                      ┌───────────────────────┴───────────────────────┐
                      ▼                                               ▼
          ┌───────────────────────┐                       ┌───────────────────────┐
          │   Operator Input &    │                       │  Disposisi Pimpinan   │
          │   Verifikasi Berkas   │                       │   (Instruksi & Sifat) │
          └───────────┬───────────┘                       └───────────┬───────────┘
                      │                                               │
                      └───────────────────────┬───────────────────────┘
                                              │
                                              ▼
                                ┌───────────────────────────┐
                                │   Tindak Lanjut Pegawai   │
                                │   & Riwayat Pengarsipan   │
                                └───────────────────────────┘
```

### 1. 📥 Modul Surat Masuk & Berkas Lampiran
* Pencatatan nomor agenda, nomor surat, instansi pengirim, perihal, dan tanggal penerimaan.
* Pengkategorian otomatis (Dinas, Undangan, Rahasia, Edaran, dll).

### 2. 📤 Modul Surat Keluar
* Penomoran surat resmi organisasi secara terstandar.
* Pencatatan tujuan surat, tanggal kirim, dan riwayat dokumen yang telah disetujui.

### 3. 📝 Modul Disposisi Elektronik
* Pembuatan lembar disposisi digital oleh **Pimpinan**.
* Instruksi tindak lanjut bertingkat (Sangat Segera, Segera, Rahasia, Biasa).
* Fitur *Scope Bindings* di Laravel untuk memastikan disposisi selalu terikat valid dengan surat masuk yang bersangkutan.

### 4. 📅 Kalender Agenda Kegiatan
* Penjadwalan agenda rapat, kunjungan dinas, dan kegiatan operasional.
* Kategori agenda untuk memfilter kegiatan prioritas tinggi.

### 5. 👥 Hak Akses Bertingkat (RBAC)
* Pembagian hak akses jelas:
  * **Admin:** Akses menyeluruh, manajemen master data (kategori surat & jenis agenda).
  * **Operator:** Input, edit, dan hapus berkas surat masuk serta surat keluar.
  * **Pimpinan:** Memberikan instruksi disposisi dan menetapkan agenda dinas.
  * **User / Viewer:** Melihat daftar surat dan agenda secara *read-only*.

---

## 👥 Matriks Hak Akses Pengguna

| Fitur / Modul | Admin | Operator | Pimpinan | User (Viewer) |
| :--- | :---: | :---: | :---: | :---: |
| Lihat Daftar Surat & Detail | ✅ | ✅ | ✅ | ✅ |
| Tambah / Edit / Hapus Surat | ✅ | ✅ | ❌ | ❌ |
| Buat & Edit Lembar Disposisi | ✅ | ❌ | ✅ | ❌ |
| Kelola Agenda Kegiatan Dinas | ✅ | ❌ | ✅ | ❌ |
| Master Kategori & Jenis Agenda | ✅ | ❌ | ❌ | ❌ |

---

## 🛠️ Tech Stack

* **Backend Framework:** [Laravel 12](https://laravel.com/)
* **Frontend:** [Blade Templates](https://laravel.com/docs/blade), [Tailwind CSS](https://tailwindcss.com/)
* **Autentikasi:** Laravel Breeze
* **Database:** MySQL 8.0 / MariaDB
* **Build Engine:** Vite

---

## ⚡ Panduan Setup Lokal

### Prasyarat
* PHP >= 8.2
* Composer >= 2.5
* Node.js & NPM
* Database MySQL

### Langkah Instalasi

1. **Clone Repositori:**
   ```bash
   git clone https://github.com/dekbintang/Prognet-Manajemen-Surat.git
   cd Prognet-Manajemen-Surat
   ```

2. **Instal Dependensi:**
   ```bash
   composer install
   npm install
   ```

3. **Setup Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Pastikan parameter database di file `.env` sudah sesuai:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=manajemen_surat
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi & Database Seeder:**
   ```bash
   php artisan migrate --seed
   ```
   *Seeder akan membuat akun demo, master kategori, data surat contoh, serta riwayat disposisi.*

5. **Kompilasi Aset & Jalankan Aplikasi:**
   ```bash
   npm run build
   php artisan serve
   ```
   Buka alamat: `http://localhost:8000`

---

## 🔑 Akun Uji Coba (Demo Accounts)

Setiap akun uji coba menggunakan password: `password`

| Role | Email Login | Hak Akses |
| :--- | :--- | :--- |
| **Administrator** | `admin@mail.com` | Penuh (Master Data, Pengguna, Surat, Agenda) |
| **Operator** | `operator@mail.com` | Pengelolaan Surat Masuk & Keluar |
| **Pimpinan** | `pimpinan@mail.com` | Pembuatan Disposisi & Penetapan Agenda |
| **Staf (Viewer)** | `user@mail.com` | Melihat Arsip & Agenda (*Read-Only*) |

---

## 👨‍💻 Pengembang

**I Kadek Bintang Adi Bimantara**  
*Program Studi Teknologi Informasi — Universitas Udayana*  
* [GitHub Profile](https://github.com/dekbintang)
* [Instagram](https://instagram.com/ikadek_bintang)

---

## 📄 Lisensi
Proyek ini dilisensikan di bawah [Lisensi MIT](LICENSE).
