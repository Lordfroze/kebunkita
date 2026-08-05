<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotifier
{
    public static function send(string $text, ?string $chatId = null): bool
    {
        $token = config('services.telegram.bot_token');

        if (!$token) {
            Log::warning('Telegram notification skipped: TELEGRAM_BOT_TOKEN is not set');

            return false;
        }

        $chatId = $chatId ?? config('services.telegram.chat_id');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'html',
        ]);

        if (!$response->successful()) {
            Log::error('Telegram notification failed', ['response' => $response->body()]);

            return false;
        }

        return true;
    }
}
