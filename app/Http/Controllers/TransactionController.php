<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected $exchangeService;

    public function __construct(ExchangeRateService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }

    public function index(Request $request)
    {
        $query = Transaction::with('category')
        ->where('user_id', Auth::id());

    if ($request->type) {
        $query->where('type', $request->type);
    }
    if ($request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    $transactions = $query->latest('date')->get();
    $categories   = Category::where('user_id', Auth::id())->get();

    return view('spendwise.transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('spendwise.transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|in:pemasukan,pengeluaran',
            'amount'      => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'date'        => 'required|date',
        ]);

        // Konversi ke USD via API
        $amountUSD = $this->exchangeService->convertToUSD($request->amount);

        Transaction::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'type'        => $request->type,
            'amount'      => $request->amount,
            'amount_usd'  => $amountUSD,
            'description' => $request->description,
            'date'        => $request->date,
        ]);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaksi berhasil disimpan!');
    }

    public function destroy(Transaction $transaction)
    {
        Transaction::destroy($transaction->id);
        return redirect()->route('transactions.index')
                         ->with('success', 'Transaksi berhasil dihapus!');
    }
}