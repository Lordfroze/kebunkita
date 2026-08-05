# Konfigurasi Notifikasi Telegram

Aplikasi mengirim notifikasi ke Telegram setiap ada aktivitas CRUD (Perikanan, Perdagangan, Keuangan). Semua pengaturan bot & grup ada di file `.env`:

```
TELEGRAM_BOT_TOKEN=<token-bot>
TELEGRAM_CHAT_ID=<chat-id-grup>
```

## Membuat Bot Baru

1. Buka Telegram, cari **@BotFather**.
2. Ketik `/newbot` dan ikuti instruksinya.
3. Salin **token** yang diberikan (format: `123456789:AA...`).

## Membuat Grup Baru

1. Buat grup baru di Telegram.
2. Tambahkan bot Anda sebagai member (member biasa sudah bisa menerima pesan).
3. Catat **chat id** grup:
   - **Cara termudah:** tambahkan bot **@RawDataBot** ke grup → ia akan membalas dengan `"id": -100xxxxxxxxxx` → catat angka negatif tersebut → hapus RawDataBot.
   - **Cara lain:** minta bantuan developer untuk mengambilnya dari `getUpdates`.

## Memasukkan ke `.env`

Edit file `.env` (lokal, jangan di-commit):

```
TELEGRAM_BOT_TOKEN=<token-baru>
TELEGRAM_CHAT_ID=-100xxxxxxxxxx
```

## Bersihkan Cache Config

Jalankan jika pernah melakukan `php artisan config:cache`:

```bash
php artisan config:clear
```

## Tes Kirim Notifikasi

```bash
php artisan tinker --execute="var_dump(\App\Services\TelegramNotifier::send('Test'));"
```

Jika output `bool(true)`, notifikasi berhasil terkirim ke grup baru.

## Catatan Penting

- Jangan pernah menaruh token asli di `.env.example` — biarkan `TELEGRAM_BOT_TOKEN=` kosong sebagai template.
- `.env` sudah ter-ignore oleh git, sehingga token tidak akan pernah ter-commit.
- Bot harus menjadi member grup target, jika tidak `sendMessage` akan gagal.
- Seluruh modul (Perikanan, Perdagangan, Keuangan) otomatis mengikuti `TELEGRAM_BOT_TOKEN` & `TELEGRAM_CHAT_ID` dari `.env`.
