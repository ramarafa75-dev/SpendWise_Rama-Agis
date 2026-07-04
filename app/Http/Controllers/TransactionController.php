<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Services\ExchangeRateService;
use Illuminate\Http\Request;

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
            ->where('user_id', auth()->id());

        // Filter by jenis
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // Filter by kategori
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by rentang tanggal
        if ($request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Pencarian by deskripsi
        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->latest('date')->get();
        $categories   = Category::where('user_id', auth()->id())->get();

        return view('spendwise.transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('user_id', auth()->id())->get();
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

        $amountUSD = $this->exchangeService->convertToUSD($request->amount);

        Transaction::create([
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
            'type'        => $request->type,
            'amount'      => $request->amount,
            'amount_usd'  => $amountUSD,
            'description' => $request->description,
            'date'        => $request->date,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function edit(Transaction $transaction)
    {
        abort_if($transaction->user_id !== auth()->id(), 403);
        $categories = Category::where('user_id', auth()->id())->get();
        return view('spendwise.transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        abort_if($transaction->user_id !== auth()->id(), 403);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|in:pemasukan,pengeluaran',
            'amount'      => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'date'        => 'required|date',
        ]);

        $amountUSD = $this->exchangeService->convertToUSD($request->amount);

        $transaction->update([
            'category_id' => $request->category_id,
            'type'        => $request->type,
            'amount'      => $request->amount,
            'amount_usd'  => $amountUSD,
            'description' => $request->description,
            'date'        => $request->date,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        abort_if($transaction->user_id !== auth()->id(), 403);
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
