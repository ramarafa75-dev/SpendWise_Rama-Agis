<x-spendwise title="Riwayat Transaksi">
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .page-header p { font-size:12px; color:var(--text-muted); }

    /* Filter & Search bar */
    .filter-wrap { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1rem 1.25rem; margin-bottom:1.25rem; box-shadow:var(--shadow); }
    .filter-top { display:flex; gap:10px; align-items:center; margin-bottom:10px; }
    .search-box { flex:1; position:relative; }
    .search-box svg { position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; color:var(--text-muted); }
    .search-input { width:100%; background:var(--bg-input); border:1px solid var(--border); border-radius:8px; padding:8px 12px 8px 32px; font-size:13px; color:var(--text-primary); outline:none; font-family:'Poppins',sans-serif; }
    .search-input:hover { background:var(--bg-row); border-color:var(--accent);}
    .search-input:focus { border-color:var(--accent); }
    .search-input::placeholder { color:var(--text-muted); }

    .filter-row { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
    .sw-select-sm { background:var(--bg-input); border:1px solid var(--border); border-radius:7px; padding:7px 10px; font-size:12px; color:var(--text-primary); outline:none; font-family:'Poppins',sans-serif; }
    .sw-select-sm:hover { background:var(--bg-row); border-color:var(--accent);}
    .sw-select-sm:focus { border-color:var(--accent); }
    .date-input { background:var(--bg-input); border:1px solid var(--border); border-radius:7px; padding:7px 10px; font-size:12px; color:var(--text-primary); outline:none; font-family:'Poppins',sans-serif; }
    .date-input:hover { background:var(--bg-row); border-color:var(--accent);}
    .date-input:focus { border-color:var(--accent); }
    .filter-label { font-size:11px; color:var(--text-muted); font-weight:500; }
    .btn-filter { background:#1B4F8C; color:#fff; border:none; border-radius:7px; padding:7px 14px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif; font-weight:500; }
    .btn-filter:hover { background:var(--accent); transform: translateY(-1px); }
    .btn-reset { background:var(--bg-row); color:var(--text-secondary); border:1px solid var(--border); border-radius:7px; padding:7px 12px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .btn-reset svg { width:12px; height:12px; }
    .btn-primary { background:#1B4F8C; color:#fff; border:none; border-radius:7px; padding:7px 14px; font-size:12px; cursor:pointer; font-family:'Poppins',sans-serif; font-weight:500; text-decoration:none; display:inline-flex; align-items:center; gap:5px; }
    .btn-primary:hover { background:var(--accent); transform: translateY(-1px); }
    /* Active filters badge */
    .active-filters { display:flex; gap:6px; flex-wrap:wrap; margin-top:8px; }
    .filter-badge { display:inline-flex; align-items:center; gap:5px; background:rgba(108,99,255,.12); color:var(--accent); border:1px solid rgba(108,99,255,.2); border-radius:20px; padding:3px 10px; font-size:11px; font-weight:500; }

    /* Summary bar */
    .summary-bar { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin-bottom:1.25rem; }
    .summary-item { background:var(--bg-card); border-radius:8px; border:1px solid var(--border); padding:.75rem 1rem; box-shadow:var(--shadow); }
    .summary-item-label { font-size:10px; color:var(--text-muted); margin-bottom:3px; text-transform:uppercase; letter-spacing:.3px; }
    .summary-item-val { font-size:15px; font-weight:700; }

    /* Table */
    .table-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.25rem; box-shadow:var(--shadow); }
    .sw-table { width:100%; border-collapse:collapse; font-size:13px; }
    .sw-table thead th { text-align:left; color:var(--text-muted); font-weight:500; padding:0 10px 10px; font-size:11px; border-bottom:1px solid var(--border); }
    .sw-table tbody td { padding:11px 10px; border-bottom:1px solid var(--border); color:var(--text-secondary); }
    .sw-table tbody tr:last-child td { border-bottom:none; }
    .sw-table tbody tr:hover td { background:var(--bg-hover); }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }
    .badge-in  { background:var(--badge-in-bg);  color:var(--badge-in-txt); }
    .badge-out { background:var(--badge-out-bg); color:var(--badge-out-txt); }
    .trx-icon { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .trx-icon.in  { background:var(--icon-in-bg); }
    .trx-icon.out { background:var(--icon-out-bg); }
    .trx-icon svg { width:16px; height:16px; }
    .btn-edit { background:rgba(108,99,255,.1); color:var(--accent); border:1px solid rgba(108,99,255,.2); border-radius:6px; padding:4px 10px; font-size:11px; cursor:pointer; text-decoration:none; font-family:'Poppins',sans-serif; font-weight:500; transition:all .15s; }
    .btn-edit:hover { background:rgba(108,99,255,.2); }
    .btn-delete { background:none; border:none; color:var(--danger); font-size:12px; cursor:pointer; padding:4px 8px; border-radius:5px; font-family:'Poppins',sans-serif; }
    .btn-delete:hover { background:var(--badge-out-bg); }
    .empty-state { text-align:center; padding:3rem; color:var(--text-muted); font-size:13px; }
    .action-group { display:flex; align-items:center; gap:6px; }
</style>

@php
    $totalMasuk  = $transactions->where('type','pemasukan')->sum('amount');
    $totalKeluar = $transactions->where('type','pengeluaran')->sum('amount');
    $hasFilter   = request()->anyFilled(['type','category_id','date_from','date_to','search']);
@endphp

<div class="page-header">
    <p>{{ $transactions->count() }} transaksi ditemukan</p>
    <a href="{{ route('transactions.create') }}" class="btn-primary">+ Tambah Transaksi</a>
</div>

{{-- Filter & Search --}}
<div class="filter-wrap">
    <form method="GET" action="{{ route('transactions.index') }}" id="filter-form">
        <div class="filter-top">
            <div class="search-box">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:var(--text-muted)"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" name="search" class="search-input"
                    placeholder="Cari deskripsi transaksi..."
                    value="{{ request('search') }}"
                    oninput="clearTimeout(this._t); this._t=setTimeout(()=>document.getElementById('filter-form').submit(),500)">
            </div>
        </div>

        <div class="filter-row">
            <span class="filter-label">Filter:</span>

            <select name="type" class="sw-select-sm" onchange="this.form.submit()">
                <option value="">Semua Jenis</option>
                <option value="pemasukan"   {{ request('type')=='pemasukan'  ?'selected':'' }}>Pemasukan</option>
                <option value="pengeluaran" {{ request('type')=='pengeluaran'?'selected':'' }}>Pengeluaran</option>
            </select>

            <select name="category_id" class="sw-select-sm" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <span class="filter-label">Dari:</span>
            <input type="date" name="date_from" class="date-input"
                value="{{ request('date_from') }}" onchange="this.form.submit()">

            <span class="filter-label">Sampai:</span>
            <input type="date" name="date_to" class="date-input"
                value="{{ request('date_to') }}" onchange="this.form.submit()">

            <button type="submit" class="btn-filter">Terapkan</button>

            @if($hasFilter)
                <a href="{{ route('transactions.index') }}" class="btn-reset">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                    Reset
                </a>
            @endif
        </div>

        {{-- Active filter badges --}}
        @if($hasFilter)
        <div class="active-filters">
            @if(request('search'))
                <span class="filter-badge">🔍 "{{ request('search') }}"</span>
            @endif
            @if(request('type'))
                <span class="filter-badge">{{ ucfirst(request('type')) }}</span>
            @endif
            @if(request('category_id'))
                @php $cat = $categories->firstWhere('id', request('category_id')); @endphp
                <span class="filter-badge">{{ $cat?->name }}</span>
            @endif
            @if(request('date_from') || request('date_to'))
                <span class="filter-badge">📅 {{ request('date_from','...') }} → {{ request('date_to','...') }}</span>
            @endif
        </div>
        @endif
    </form>
</div>

{{-- Summary bar --}}
<div class="summary-bar">
    <div class="summary-item">
        <div class="summary-item-label">Total Transaksi</div>
        <div class="summary-item-val" style="color:var(--text-primary)">{{ $transactions->count() }}</div>
    </div>
    <div class="summary-item">
        <div class="summary-item-label">Total Pemasukan</div>
        <div class="summary-item-val" style="color:var(--success)">Rp {{ number_format($totalMasuk,0,',','.') }}</div>
    </div>
    <div class="summary-item">
        <div class="summary-item-label">Total Pengeluaran</div>
        <div class="summary-item-val" style="color:var(--danger)">Rp {{ number_format($totalKeluar,0,',','.') }}</div>
    </div>
</div>

{{-- Table --}}
<div class="table-card">
    @if($transactions->isEmpty())
        <div class="empty-state">
            @if($hasFilter)
                Tidak ada transaksi yang sesuai filter. <a href="{{ route('transactions.index') }}" style="color:var(--accent)">Reset filter</a>
            @else
                Belum ada transaksi. <a href="{{ route('transactions.create') }}" style="color:var(--accent)">Tambah sekarang</a>
            @endif
        </div>
    @else
        <table class="sw-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah (Rp)</th>
                    <th>USD</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
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
                    <td style="font-weight:600;color:{{ $trx->type==='pemasukan'?'var(--success)':'var(--danger)' }}">
                        {{ $trx->type==='pemasukan'?'+':'-' }}Rp {{ number_format($trx->amount,0,',','.') }}
                    </td>
                    <td>$ {{ $trx->amount_usd??'0' }}</td>
                    <td><span class="badge {{ $trx->type==='pemasukan'?'badge-in':'badge-out' }}">{{ ucfirst($trx->type) }}</span></td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('transactions.edit',$trx) }}" class="btn-edit">Edit</a>
                            <form method="POST" action="{{ route('transactions.destroy',$trx) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-spendwise>
