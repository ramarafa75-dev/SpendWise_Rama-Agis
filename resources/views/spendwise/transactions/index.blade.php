<x-spendwise title="Riwayat Transaksi">
<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
    .page-header p { font-size: 13px; color: #9CA3AF; }
    .btn-primary { background: #6C63FF; color: #fff; border: none; border-radius: 8px; padding: 9px 16px; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
    .btn-primary:hover { background: #5A52E0; }
    .table-card { background: #fff; border-radius: 10px; border: 1px solid #E2E6F0; padding: 1.25rem; box-shadow: 0 1px 4px rgba(0,0,0,.06), 0 4px 12px rgba(0,0,0,.04); }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    thead th { text-align: left; color: #9CA3AF; font-weight: 500; padding: 0 10px 10px; font-size: 11px; border-bottom: 1px solid #F0F2F8; }
    tbody td { padding: 12px 10px; border-bottom: 1px solid #F8F9FB; color: #374151; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #FAFBFF; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .badge-in { background: #DCFCE7; color: #166534; }
    .badge-out { background: #FEE2E2; color: #991B1B; }
    .btn-delete { background: none; border: none; color: #EF4444; font-size: 12px; cursor: pointer; padding: 4px 8px; border-radius: 5px; }
    .btn-delete:hover { background: #FEE2E2; }
    .empty-state { text-align: center; padding: 3rem; color: #9CA3AF; font-size: 13px; }

    .filter-bar { display: flex; gap: 8px; margin-bottom: 1rem; }
    .filter-bar select { border: 1px solid #E2E6F0; border-radius: 7px; padding: 7px 12px; font-size: 12px; color: #374151; background: #fff; outline: none; cursor: pointer; }
    .filter-bar select:focus { border-color: #6C63FF; }

    .trx-icon {
        width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .trx-icon.in  { background: #DCFCE7; }
    .trx-icon.out { background: #FEE2E2; }
    .trx-icon svg { width: 16px; height: 16px; }
</style>

<div class="page-header">
    <p>{{ $transactions->count() }} transaksi ditemukan</p>
    <a href="{{ route('transactions.create') }}" class="btn-primary">+ Tambah Transaksi</a>
</div>

{{-- Filter --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('transactions.index') }}" style="display:flex;gap:8px">
        <select name="type" onchange="this.form.submit()">
            <option value="">Semua Jenis</option>
            <option value="pemasukan" {{ request('type') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
            <option value="pengeluaran" {{ request('type') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
        </select>
        <select name="category_id" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="table-card">
    @if($transactions->isEmpty())
        <div class="empty-state">
            Belum ada transaksi. <a href="{{ route('transactions.create') }}" style="color:#6C63FF">Tambah sekarang</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah (Rp)</th>
                    <th>Jumlah (USD)</th>
                    <th>Jenis</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td>
                        @if($trx->type === 'pemasukan')
                            <div class="trx-icon in">
                                <svg fill="none" stroke="#16A34A" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M12 19V5M5 12l7-7 7 7"/>
                                </svg>
                            </div>
                        @else
                            <div class="trx-icon out">
                                <svg fill="none" stroke="#DC2626" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M12 5v14M19 12l-7 7-7-7"/>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                    <td>{{ $trx->category->name ?? '-' }}</td>
                    <td style="color:#9CA3AF">{{ $trx->description ?? '-' }}</td>
                    <td style="font-weight:500; color:{{ $trx->type === 'pemasukan' ? '#16A34A' : '#DC2626' }}">
                        {{ $trx->type === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                    <td style="color:#9CA3AF">$ {{ $trx->amount_usd ?? '0' }}</td>
                    <td><span class="badge {{ $trx->type === 'pemasukan' ? 'badge-in' : 'badge-out' }}">{{ ucfirst($trx->type) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('transactions.destroy', $trx) }}" onsubmit="return confirm('Hapus transaksi ini?')">
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
