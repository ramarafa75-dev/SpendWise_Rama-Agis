{{-- TRANSACTIONS INDEX --}}
{{-- Simpan file ini sebagai resources/views/transactions/index.blade.php --}}
<x-spendwise title="Riwayat Transaksi">
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; }
    .page-header p { font-size:12px; color:var(--text-muted); }
    .filter-bar { display:flex; gap:8px; margin-bottom:1rem; }
    .table-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.25rem; box-shadow:var(--shadow); }
    .btn-primary { background:#1B4F8C; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; cursor:pointer; font-weight:500; font-family:'Poppins',sans-serif; }
    .btn-primary:hover { background:var(--accent); transform: translateY(1px); }
    .sw-select { background:var(--bg-input); border:1px solid var(--border); border-radius:7px; padding:9px 14px; font-size:13px; color:var(--text-primary); outline:none; font-family:'Poppins',sans-serif; }
    .sw-select:hover { border-color:var(--accent); }
</style>

<div class="page-header">
    <p>{{ $transactions->count() }} transaksi ditemukan</p>
    <a href="{{ route('transactions.create') }}" class="btn-primary">+ Tambah Transaksi</a>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('transactions.index') }}" style="display:flex;gap:8px">
        <select name="type" class="sw-select" style="width:auto" onchange="this.form.submit()">
            <option value="">Semua Jenis</option>
            <option value="pemasukan" {{ request('type')=='pemasukan'?'selected':'' }}>Pemasukan</option>
            <option value="pengeluaran" {{ request('type')=='pengeluaran'?'selected':'' }}>Pengeluaran</option>
        </select>
        <select name="category_id" class="sw-select" style="width:auto" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="table-card">
    @if($transactions->isEmpty())
        <div class="empty-state">Belum ada transaksi. <a href="{{ route('transactions.create') }}" style="color:var(--accent)">Tambah sekarang</a></div>
    @else
        <table class="sw-table">
            <thead><tr><th></th><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th>Jumlah (Rp)</th><th>USD</th><th>Jenis</th><th></th></tr></thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td>
                        <div class="trx-icon {{ $trx->type==='pemasukan'?'in':'out' }}">
                            @if($trx->type==='pemasukan')
                                <svg fill="none" stroke="var(--success)" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                            @else
                                <svg fill="none" stroke="var(--danger)" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
                            @endif
                        </div>
                    </td>
                    <td style="color:var(--text-primary)">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                    <td style="color:var(--text-primary)">{{ $trx->category->name??'-' }}</td>
                    <td>{{ $trx->description??'-' }}</td>
                    <td style="font-weight:600;color:{{ $trx->type==='pemasukan'?'var(--success)':'var(--danger)' }}">{{ $trx->type==='pemasukan'?'+':'-' }}Rp {{ number_format($trx->amount,0,',','.') }}</td>
                    <td>$ {{ $trx->amount_usd??'0' }}</td>
                    <td><span class="badge {{ $trx->type==='pemasukan'?'badge-in':'badge-out' }}">{{ ucfirst($trx->type) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('transactions.destroy',$trx) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-spendwise>
