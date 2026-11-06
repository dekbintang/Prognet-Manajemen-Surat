# Manajemen Surat — SuratFlow

Aplikasi manajemen persuratan dan disposisi perkantoran. Menangani pencatatan surat masuk, pengelolaan surat keluar, pelacakan disposisi pimpinan, dan penjadwalan agenda kegiatan.

## Tech Stack

- **Framework:** Laravel 12
- **Frontend:** Blade, Tailwind CSS
- **Auth:** Laravel Breeze
- **Database:** MySQL

## Fitur

- CRUD surat masuk dan surat keluar dengan pengkategorian
- Disposisi digital berjenjang dari pimpinan ke staf
- Kalender agenda kegiatan dinas
- Hak akses berbasis role (Admin, Operator, Pimpinan, Viewer)

## Role

| Role | Akses |
| :--- | :--- |
| Admin | Seluruh sistem termasuk master data |
| Operator | Kelola surat masuk dan keluar |
| Pimpinan | Buat disposisi dan atur agenda |
| User | Lihat arsip surat dan agenda (read-only) |

## Setup

```bash
git clone https://github.com/dekbintang/Prognet-Manajemen-Surat.git
cd Prognet-Manajemen-Surat
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database di `.env`, lalu:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

## Demo Accounts

Password: `password`

| Role | Email |
| :--- | :--- |
| Admin | `admin@mail.com` |
| Operator | `operator@mail.com` |
| Pimpinan | `pimpinan@mail.com` |
| Viewer | `user@mail.com` |

## Lisensi

[MIT](LICENSE)
