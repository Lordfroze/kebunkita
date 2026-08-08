# KebunKita — Agribusiness Management

Dashboard manajemen agribisnis modern untuk mengelola kebun, perikanan, perdagangan, keuangan, stok, dan aktivitas perawatan.

## Tech Stack

**Frontend**

| Komponen | Versi | Keterangan |
|---|---|---|
| Tailwind CSS | v3.4 (PostCSS) | Theme custom (emerald/brand) + font Inter & Plus Jakarta Sans |
| Vite | v5 + laravel-vite-plugin | Build `kebunkita.css/js` dan `app.css/js` |
| DataTables | v3 (`datatables.net`) | Search, sort, pagination, i18n Bahasa Indonesia |
| Chart.js | v4.5 | Grafik dashboard, kolam, keuangan |
| Lucide Icons | v1.30 | Ikon UI |
| Vanilla JS (ESM) | — | Modul `resources/js/kebunkita/*` + global `window.KebunKita` |
| Blade Components | — | `x-stat-card`, `x-action-menu`, `x-alert`, layout `layouts.auth` |

**Backend**

| Komponen | Versi | Keterangan |
|---|---|---|
| Laravel | 13 (PHP 8.4) | Framework |
| Laravel Octane | ^2.6 | Opsional, untuk performa |
| maatwebsite/excel | ^4.0 | Export data kolam (Excel) |
| barryvdh/laravel-dompdf | ^3.1 | Download PDF kalkulator |
| TelegramNotifier | — | Notifikasi CRUD ke grup Telegram |

**Struktur UI**

- `resources/views/layouts/app.blade.php` — layout dashboard aktif (sidebar + topbar)
- `resources/views/layouts/auth.blade.php` — layout halaman login/register
- `resources/views/layouts/adminlte.blade.php` — layout lama (tidak terpakai, untuk rollback)
- `resources/js/kebunkita/*` — modul JS (icons, dataTable, charts, toast, modal, dropdown)

## Setup Lokal

**Prasyarat**

- PHP 8.3+ & Composer
- Node.js 18+ & npm
- MySQL (dikoneksikan lewat `.env`)

**Installasi**

```bash
# 1. Install dependency
composer install
npm install

# 2. Siapkan environment
cp .env.example .env
php artisan key:generate
# sesuaikan kredensial DB di .env

# 3. Migrasi database
php artisan migrate

# 4. Jalankan dev server
npm run dev        # terminal 1 — Vite
php artisan serve  # terminal 2 — Laravel
```

Akses aplikasi di `http://localhost:8000`, halaman login di `/login`.

**Build produksi lokal**

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Deploy ke VPS

Langkah setelah perubahan di-push ke GitHub dan VPS yang berisi versi lama:

```bash
# 1. Masuk VPS & tarik perubahan
ssh user@vps-ip
cd /path/ke/project-kebunkita
git pull origin main

# 2. Install dependency PHP
composer install --no-dev --optimize-autoloader

# 3. Build asset (WAJIB — public/build tidak ikut ter-commit)
npm install
npm run build

# 4. Pastikan .env & migrasi
#    .env di server sudah ada; jika belum, buat dari .env.example
php artisan migrate --force

# 5. Hapus & bangun ulang cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Link storage & permission
php artisan storage:link
chown -R www-data:www-data storage bootstrap/cache   # sesuaikan user web server
chmod -R 775 storage bootstrap/cache

# 7. Restart service web
#    Jika memakai Laravel Octane:
php artisan octane:reload
#    atau restart service-nya, misal:
#    sudo supervisorctl restart kebunkita-octane
#    Jika memakai php-fpm biasa:
#    sudo systemctl restart php8.x-fpm nginx

# 8. Verifikasi
#    - Buka /login -> tampilan tema baru
#    - Buka /dashboard -> sidebar, card, chart tampil, console bersih
#    - Cek log: tail -f storage/logs/laravel.log
```

> **Catatan:** Langkah `npm run build` di server sangat penting karena folder `public/build` tidak disimpan di Git — tanpa build ulang, halaman akan memakai asset lama.

> **Catatan OPcache:** Setelah perubahan yang menyentuh `bootstrap/app.php`, `routes/`, atau `composer.json` (mis. menambah routing/middleware baru seperti Sanctum), selain rebuild cache **WAJIB restart php-fpm**. Di aaPanel (PHP 8.4): `systemctl restart php-fpm-84 && nginx -s reload`. Tanpa restart, OPcache (`opcache.validate_timestamps=0`) masih memakai versi kode lama.
>
> Nginx di aaPanel sudah menangani `/api/*` via `try_files $uri $uri/ /index.php` di `location /` — tidak perlu konfigurasi tambahan.

## Catatan

- Folder `resources/views/layouts/adminlte/` disimpan sebagai referensi/rollback layout lama dan tidak lagi dipakai.
- Data weather diambil dari API BMKG (endpoint `adm4=35.19.01.2012`).
- Perubahan di working directory tidak otomatis ter-commit — selalu review dengan `git status` dan `git diff` sebelum `git add`/`git commit`/`git push`.

## Lisensi

Proyek ini dikembangkan untuk keperluan manajemen agribisnis KebunKita.
