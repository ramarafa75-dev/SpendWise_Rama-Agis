<x-spendwise title="Dashboard">
<style>
    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 1.5rem; }
    .stat-card { background: #fff; border-radius: 10px; border: 1px solid #E2E6F0; padding: 1.1rem 1.25rem; }
    .stat-card-icon { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
    .stat-card-icon svg { width: 18px; height: 18px; }
    .stat-card-label { font-size: 12px; color: #9CA3AF; margin-bottom: 4px; }
    .stat-card-value { font-size: 22px; font-weight: 600; color: #1A2035; }
    .stat-card-sub { font-size: 11px; color: #9CA3AF; margin-top: 4px; }
    .table-card { background: #fff; border-radius: 10px; border: 1px solid #E2E6F0; padding: 1.25rem; }
    .table-card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
    .table-card-header h2 { font-size: 14px; font-weight: 600; color: #1A2035; }
    .table-card-header a { font-size: 12px; color: #6C63FF; text-decoration: none; }
    table { width: 100%; border-collapse: collapse; font-size: 13px; }
    thead th { text-align: left; color: #9CA3AF; font-weight: 500; padding: 0 10px 10px; font-size: 11px; border-bottom: 1px solid #F0F2F8; }
    tbody td { padding: 11px 10px; border-bottom: 1px solid #F8F9FB; color: #374151; }
    tbody tr:last-child td { border-bottom: none; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .badge-in { background: #DCFCE7; color: #166534; }
    .badge-out { background: #FEE2E2; color: #991B1B; }
    .empty-state { text-align: center; padding: 2rem; color: #9CA3AF; font-size: 13px; }
</style>

{{-- Stat Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#EEF2FF">
            <svg fill="none" stroke="#6C63FF" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        </div>
        <div class="stat-card-label">Total Saldo</div>
        <div class="stat-card-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
        <div class="stat-card-sub">Pemasukan - Pengeluaran</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#DCFCE7">
            <svg fill="none" stroke="#16A34A" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 14l4 4 4-4"/></svg>
        </div>
        <div class="stat-card-label">Total Pemasukan</div>
        <div class="stat-card-value" style="color:#16A34A">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
        <div class="stat-card-sub">{{ $jumlahPemasukan }} transaksi</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FEE2E2">
            <svg fill="none" stroke="#DC2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16V8M8 10l4-4 4 4"/></svg>
        </div>
        <div class="stat-card-label">Total Pengeluaran</div>
        <div class="stat-card-value" style="color:#DC2626">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        <div class="stat-card-sub">{{ $jumlahPengeluaran }} transaksi</div>
    </div>
</div>

{{-- Tabel Transaksi Terbaru --}}
<div class="table-card">
    <div class="table-card-header">
        <h2>Transaksi Terbaru</h2>
        <a href="{{ route('transactions.index') }}">Lihat semua →</a>
    </div>

    @if($transactions->isEmpty())
        <div class="empty-state">
            Belum ada transaksi. <a href="{{ route('transactions.create') }}" style="color:#6C63FF">Tambah sekarang</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah (Rp)</th>
                    <th>Jumlah (USD)</th>
                    <th>Jenis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                    <td>{{ $trx->category->name ?? '-' }}</td>
                    <td style="color:#9CA3AF">{{ $trx->description ?? '-' }}</td>
                    <td style="color:{{ $trx->type === 'pemasukan' ? '#16A34A' : '#DC2626' }}; font-weight:500">
                        {{ $trx->type === 'pemasukan' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                    </td>
                    <td style="color:#9CA3AF">$ {{ $trx->amount_usd }}</td>
                    <td><span class="badge {{ $trx->type === 'pemasukan' ? 'badge-in' : 'badge-out' }}">{{ ucfirst($trx->type) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</x-spendwise>
