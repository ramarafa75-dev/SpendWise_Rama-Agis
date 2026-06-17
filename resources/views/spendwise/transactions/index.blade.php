<x-spendwise title="Riwayat Transaksi">
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; }
    .page-header p { font-size:12px; color:#484F58; }
    .btn-primary { background:#6C63FF; color:#fff; border:none; border-radius:8px; padding:9px 16px; font-size:13px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; font-family:'Poppins',sans-serif; }
    .btn-primary:hover { background:#5A52E0; }

    .filter-bar { display:flex; gap:8px; margin-bottom:1rem; }
    .filter-bar select { background:#161B22; border:1px solid #21262D; border-radius:7px; padding:8px 12px; font-size:12px; color:#8B949E; outline:none; cursor:pointer; font-family:'Poppins',sans-serif; }
    .filter-bar select:focus { border-color:#6C63FF; }

    .table-card { background:#161B22; border-radius:10px; border:1px solid #21262D; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.3); }
    table { width:100%; border-collapse:collapse; font-size:13px; }
    thead th { text-align:left; color:#484F58; font-weight:500; padding:0 10px 10px; font-size:11px; border-bottom:1px solid #21262D; }
    tbody td { padding:12px 10px; border-bottom:1px solid #21262D; color:#8B949E; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover td { background:rgba(255,255,255,.02); }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }
    .badge-in { background:rgba(74,222,128,.15); color:#4ADE80; }
    .badge-out { background:rgba(248,113,113,.15); color:#F87171; }
    .trx-icon { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .trx-icon.in { background:rgba(74,222,128,.15); }
    .trx-icon.out { background:rgba(248,113,113,.15); }
    .trx-icon svg { width:16px; height:16px; }
    .btn-delete { background:none; border:none; color:#F87171; font-size:12px; cursor:pointer; padding:4px 8px; border-radius:5px; font-family:'Poppins',sans-serif; }
    .btn-delete:hover { background:rgba(248,113,113,.1); }
    .empty-state { text-align:center; padding:3rem; color:#484F58; font-size:13px; }
</style>

<div class="page-header">
    <p>{{ $transactions->count() }} transaksi ditemukan</p>
    <a href="{{ route('transactions.create') }}" class="btn-primary">+ Tambah Transaksi</a>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('transactions.index') }}" style="display:flex;gap:8px">
        <select name="type" onchange="this.form.submit()">
            <option value="">Semua Jenis</option>
            <option value="pemasukan" {{ request('type')=='pemasukan'?'selected':'' }}>Pemasukan</option>
            <option value="pengeluaran" {{ request('type')=='pengeluaran'?'selected':'' }}>Pengeluaran</option>
        </select>
        <select name="category_id" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="table-card">
    @if($transactions->isEmpty())
        <div class="empty-state">Belum ada transaksi. <a href="{{ route('transactions.create') }}" style="color:#6C63FF">Tambah sekarang</a></div>
    @else
        <table>
            <thead><tr><th></th><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th>Jumlah (Rp)</th><th>USD</th><th>Jenis</th><th></th></tr></thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td>
                        <div class="trx-icon {{ $trx->type==='pemasukan'?'in':'out' }}">
                            @if($trx->type==='pemasukan')
                                <svg fill="none" stroke="#4ADE80" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                            @else
                                <svg fill="none" stroke="#F87171" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
                            @endif
                        </div>
                    </td>
                    <td style="color:#E6EDF3">{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                    <td style="color:#E6EDF3">{{ $trx->category->name??'-' }}</td>
                    <td>{{ $trx->description??'-' }}</td>
                    <td style="font-weight:600;color:{{ $trx->type==='pemasukan'?'#4ADE80':'#F87171' }}">
                        {{ $trx->type==='pemasukan'?'+':'-' }}Rp {{ number_format($trx->amount,0,',','.') }}
                    </td>
                    <td>$ {{ $trx->amount_usd??'0' }}</td>
                    <td><span class="badge {{ $trx->type==='pemasukan'?'badge-in':'badge-out' }}">{{ ucfirst($trx->type) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('transactions.destroy',$trx) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-spendwise>
