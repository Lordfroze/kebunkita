# Todo - Perbaikan Keamanan Autentikasi

## Prioritas Tinggi (Kritis)
- [ ] Tambahkan throttle/rate-limit pada login dan register
  - `routes/web.php:16-22` — tambahkan middleware `throttle:5,1` pada POST login & register
- [ ] Perbaiki validasi password pada register: `min:8` (saat ini hanya `required|confirmed`)
  - `app/Http/Controllers/AuthController.php:46-49`

## Prioritas Sedang
- [ ] Enable `SESSION_SECURE_COOKIE=true` dan paksa HTTPS di production
  - `config/session.php:172`
- [ ] Pastikan `APP_DEBUG=false` dan `APP_KEY` tidak di-commit di production
  - `config/app.php:42`
- [ ] Pertimbangkan verifikasi email (`email_verified_at` sudah ada tapi belum dipakai)
  - `app/Http/Controllers/AuthController.php:44`

## Prioritas Rendah
- [ ] Panggil `$request->session()->regenerate()` setelah `Auth::attempt` sukses (anti session fixation)
  - `app/Http/Controllers/AuthController.php:25-27`
- [ ] Ubah logout dari GET jadi POST + `@csrf` (anti CSRF forced-logout)
  - `routes/web.php:18`

# DONE - API Keuangan via Sanctum (Akses Android)

## Instalasi & Setup
- [x] Install `laravel/sanctum` (^4.3) via composer
- [x] Publish config: `config/sanctum.php` + migrasi `personal_access_tokens` (`php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`)
- [x] Jalankan migrasi tabel `personal_access_tokens`

## Konfigurasi
- [x] Daftarkan routing `api` di `bootstrap/app.php` (`withRouting(api: ...)`)
- [x] Alias middleware `abilities` => `Laravel\Sanctum\Http\Middleware\CheckAbilities` di `bootstrap/app.php` (Sanctum 4.x tidak auto-register)
- [x] Tambah trait `HasApiTokens` di `app/Models/User.php`

## Controller Baru
- [x] `app/Http/Controllers/Api/ApiAuthController.php` — login (createToken dengan ability `keuangan:read`, kedaluwarsa 30 hari) + logout (hapus token)
- [x] `app/Http/Controllers/Api/KeuanganApiController.php` — read-only: index (filter `active=true` + range tanggal + total), show, chart (bulanan)

## Route API (`routes/api.php`)
- [x] `POST api/login` — throttle `5,1`
- [x] `POST api/logout` — `auth:sanctum`
- [x] `GET api/keuangan` — `auth:sanctum` + `abilities:keuangan:read`
- [x] `GET api/keuangan/{id}` — `auth:sanctum` + `abilities:keuangan:read`
- [x] `GET api/keuangan/chart?tahun=` — `auth:sanctum` + `abilities:keuangan:read`

## Catatan Verifikasi
- [x] Tanpa token → 401 JSON (bukan redirect login)
- [x] Multi-user scoping jalan otomatis lewat `UserDataScope` (admin lihat semua, user lihat datanya sendiri)
- [x] Token mati setelah logout
- [x] `php artisan pint` sudah dijalankan (semua file diformat)

## Catatan
- `Tests/Feature/ExampleTest` gagal (pre-existing): route `/` redirect 302 ke login, tidak terkait perubahan ini.
- Android cukup kirim header `Authorization: Bearer <token>` (tanpa CORS karena bukan browser).

## Cara Test di Postman
1. Jalankan server: `php artisan serve` (base URL `http://127.0.0.1:8000`)
2. **Login** → `POST /api/login`, Body `raw` JSON:
   ```json
   { "email": "akun@mail.com", "password": "password" }
   ```
   Balik `token` (format `1|xxxx`). Salin nilainya.
3. **Akses data** → `GET /api/keuangan`, tambah header:
   - `Accept: application/json`
   - `Authorization: Bearer <token>`
   - Opsional filter via Params: `start_date` & `end_date` (`YYYY-MM-DD`)
4. Endpoint lain: `GET /api/keuangan/{id}`, `GET /api/keuangan/chart?tahun=2026`, `POST /api/logout`
5. Tanpa token → `401 {"message":"Unauthenticated."}`
