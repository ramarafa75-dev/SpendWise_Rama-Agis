<?php

namespace App\Helpers;

use Carbon\Carbon;

class PaydayHelper
{
    /**
     * Hitung tanggal mulai & akhir periode berdasarkan tanggal gajian user.
     * Kalau payday_date null, gunakan periode bulanan biasa (1 - akhir bulan).
     *
     * Contoh: payday_date = 25
     *   - Sekarang 10 Agustus → periode: 25 Juli s/d 24 Agustus
     *   - Sekarang 28 Agustus → periode: 25 Agustus s/d 24 September
     */
    public static function getCurrentPeriod(?int $paydayDate): array
    {
        $today = Carbon::today();

        if (!$paydayDate) {
            // Tidak ada tanggal gajian → periode bulanan biasa
            return [
                'start' => $today->copy()->startOfMonth(),
                'end'   => $today->copy()->endOfMonth(),
                'label' => $today->translatedFormat('F Y'),
            ];
        }

        // Kalau hari ini >= tanggal gajian → periode mulai bulan ini
        if ($today->day >= $paydayDate) {
            $start = $today->copy()->setDay($paydayDate);
            $end   = $today->copy()->addMonth()->setDay($paydayDate)->subDay();
        } else {
            // Hari ini < tanggal gajian → periode mulai bulan lalu
            $start = $today->copy()->subMonth()->setDay($paydayDate);
            $end   = $today->copy()->setDay($paydayDate)->subDay();
        }

        return [
            'start' => $start,
            'end'   => $end,
            'label' => $start->translatedFormat('d M') . ' — ' . $end->translatedFormat('d M Y'),
        ];
    }

    /**
     * Hitung berapa hari tersisa sampai gajian berikutnya.
     */
    public static function getDaysUntilPayday(?int $paydayDate): ?int
    {
        if (!$paydayDate) return null;

        $today  = Carbon::today();
        $period = self::getCurrentPeriod($paydayDate);
        $next   = $period['end']->copy()->addDay(); // hari gajian berikutnya

        return $today->diffInDays($next);
    }
}
