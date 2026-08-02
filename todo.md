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
