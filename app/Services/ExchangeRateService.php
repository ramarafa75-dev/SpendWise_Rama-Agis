<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    public function convertToUSD(float $amountIDR): float
    {
        $apiKey = env('EXCHANGE_RATE_API_KEY');

        $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/pair/IDR/USD");

        if ($response->successful()) {
            $rate = $response->json()['conversion_rate'];
            return round($amountIDR * $rate, 4);
        }

        return 0;
    }
}