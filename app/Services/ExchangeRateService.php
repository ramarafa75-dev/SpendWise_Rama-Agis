<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    public function convertToUSD(float $amountIDR): float
    {
        try {
            $apiKey = env('EXCHANGE_RATE_API_KEY');

            // Gunakan kurs yang di-cache agar tidak hit API setiap transaksi
            $rate = Cache::remember('idr_usd_rate', 3600, function () use ($apiKey) {
                $response = Http::timeout(5) // timeout 5 detik saja
                    ->get("https://v6.exchangerate-api.com/v6/{$apiKey}/pair/IDR/USD");

                if ($response->successful()) {
                    return $response->json()['conversion_rate'];
                }

                return null;
            });

            // Kalau rate tidak dapat, pakai kurs fallback
            if (!$rate) {
                $rate = 0.000062; // fallback ~1 USD = 16.100 IDR
            }

            return round($amountIDR * $rate, 4);

        } catch (\Exception $e) {
            Log::warning('Exchange rate API error: ' . $e->getMessage());

            // Kalau error apapun, pakai kurs fallback agar transaksi tetap bisa disimpan
            $fallbackRate = 0.000062;
            return round($amountIDR * $fallbackRate, 4);
        }
    }
}