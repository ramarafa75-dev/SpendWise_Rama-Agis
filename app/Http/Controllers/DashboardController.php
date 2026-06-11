<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $userId = Auth::id();

        $totalPemasukan   = Transaction::where('user_id', $userId)->where('type', 'pemasukan')->sum('amount');
        $totalPengeluaran = Transaction::where('user_id', $userId)->where('type', 'pengeluaran')->sum('amount');
        $jumlahPemasukan  = Transaction::where('user_id', $userId)->where('type', 'pemasukan')->count();
        $jumlahPengeluaran= Transaction::where('user_id', $userId)->where('type', 'pengeluaran')->count();
        $saldo            = $totalPemasukan - $totalPengeluaran;

        $transactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->latest('date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'saldo','totalPemasukan','totalPengeluaran',
            'jumlahPemasukan','jumlahPengeluaran','transactions'
        ));
    }

}
