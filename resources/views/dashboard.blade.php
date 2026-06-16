<x-spendwise title="Dashboard">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .alert-danger { background:#FEF2F2; border:1px solid #FECACA; border-radius:10px; padding:12px 16px; margin-bottom:1.25rem; display:flex; align-items:flex-start; gap:10px; font-size:13px; color:#991B1B; }
    .alert-danger-icon { font-size:18px; flex-shrink:0; }
    .alert-danger-title { font-weight:600; margin-bottom:2px; }
    .alert-danger-sub { font-size:12px; color:#B91C1C; }
    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:1.25rem; }
    .stat-card { background:#fff; border-radius:10px; border:1px solid #E2E6F0; padding:1.1rem 1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.04); }
    .stat-card-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
    .stat-card-icon svg { width:18px; height:18px; }
    .stat-card-label { font-size:12px; color:#9CA3AF; margin-bottom:4px; }
    .stat-card-value { font-size:22px; font-weight:600; color:#1A2035; }
    .stat-card-sub { font-size:11px; color:#9CA3AF; margin-top:4px; }
    .charts-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:1.25rem; }
    .chart-card { background:#fff; border-radius:10px; border:1px solid #E2E6F0; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.04); }
    .chart-card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .chart-card-header h2 { font-size:14px; font-weight:600; color:#1A2035; }
    .chart-card-header span { font-size:11px; color:#9CA3AF; }
    .chart-wrap { position:relative; height:220px; }
    .budget-list { display:flex; flex-direction:column; gap:10px; }
    .budget-item { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#F9FAFB; border-radius:8px; }
    .budget-item-left { display:flex; align-items:center; gap:10px; }
    .budget-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
    .budget-name { font-size:13px; font-weight:500; color:#1A2035; }
    .budget-used { font-size:11px; color:#9CA3AF; margin-top:2px; }
    .budget-right { text-align:right; }
    .budget-pct { font-size:13px; font-weight:600; }
    .budget-bar { width:100px; height:5px; background:#F0F2F8; border-radius:10px; overflow:hidden; margin-top:4px; }
    .budget-fill { height:100%; border-radius:10px; }
    .table-card { background:#fff; border-radius:10px; border:1px solid #E2E6F0; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.04); }
    .table-card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .table-card-header h2 { font-size:14px; font-weight:600; color:#1A2035; }
    .table-card-header a { font-size:12px; color:#6C63FF; text-decoration:none; }
    table { width:100%; border-collapse:collapse; font-size:13px; }
    thead th { text-align:left; color:#9CA3AF; font-weight:500; padding:0 10px 10px; font-size:11px; border-bottom:1px solid #F0F2F8; }
    tbody td { padding:11px 10px; border-bottom:1px solid #F8F9FB; color:#374151; }
    tbody tr:last-child td { border-bottom:none; }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }
    .badge-in { background:#DCFCE7; color:#166534; }
    .badge-out { background:#FEE2E2; color:#991B1B; }
    .trx-icon { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; }
    .trx-icon.in { background:#DCFCE7; }
    .trx-icon.out { background:#FEE2E2; }
    .trx-icon svg { width:16px; height:16px; }
    .empty-state { text-align:center; padding:2rem; color:#9CA3AF; font-size:13px; }
</style>

@php
    $userId = auth()->id();
    $colors = ['#6C63FF','#EF4444','#F59E0B','#10B981','#3B82F6','#EC4899','#8B5CF6','#14B8A6'];

    $alertCategories = \App\Models\Category::where('user_id', $userId)
        ->with(['transactions' => fn($q) => $q->where('type','pengeluaran')])
        ->get()
        ->filter(fn($cat) => $cat->max_budget > 0 && $cat->transactions->sum('amount') >= $cat->max_budget);

    $totalPemasukan   = \App\Models\Transaction::where('user_id',$userId)->where('type','pemasukan')->sum('amount');
    $totalPengeluaran = \App\Models\Transaction::where('user_id',$userId)->where('type','pengeluaran')->sum('amount');
    $saldo            = $totalPemasukan - $totalPengeluaran;

    $categories = \App\Models\Category::where('user_id',$userId)
        ->with(['transactions' => fn($q) => $q->where('type','pengeluaran')])
        ->get();

    $pieLabels        = $categories->pluck('name')->toJson();
    $pieData          = $categories->map(fn($c) => $c->transactions->sum('amount'))->toJson();
    $pieColors        = collect($colors)->take($categories->count())->values()->toJson();

    $months           = collect(range(5,0))->map(fn($i) => now()->subMonths($i));
    $barLabels        = $months->map(fn($m) => $m->translatedFormat('M Y'))->toJson();
    $barData          = $months->map(fn($m) => \App\Models\Transaction::where('user_id',$userId)->where('type','pengeluaran')->whereYear('date',$m->year)->whereMonth('date',$m->month)->sum('amount'))->toJson();
    $barDataPemasukan = $months->map(fn($m) => \App\Models\Transaction::where('user_id',$userId)->where('type','pemasukan')->whereYear('date',$m->year)->whereMonth('date',$m->month)->sum('amount'))->toJson();

    $transactions = \App\Models\Transaction::with('category')->where('user_id',$userId)->latest('date')->take(5)->get();
@endphp

@if($alertCategories->isNotEmpty())
    @foreach($alertCategories as $alertCat)
        @php $usedAmt = $alertCat->transactions->sum('amount'); @endphp
        <div class="alert-danger">
            <div class="alert-danger-icon">⚠️</div>
            <div>
                <div class="alert-danger-title">Batas Budget Tercapai — {{ $alertCat->name }}</div>
                <div class="alert-danger-sub">Pengeluaran Rp {{ number_format($usedAmt,0,',','.') }} telah mencapai batas Rp {{ number_format($alertCat->max_budget,0,',','.') }}.</div>
            </div>
        </div>
    @endforeach
@endif

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#EEF2FF">
            <svg fill="none" stroke="#6C63FF" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        </div>
        <div class="stat-card-label">Total Saldo</div>
        <div class="stat-card-value" style="color:{{ $saldo >= 0 ? '#1A2035' : '#DC2626' }}">Rp {{ number_format(abs($saldo),0,',','.') }}</div>
        <div class="stat-card-sub">Pemasukan - Pengeluaran</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#DCFCE7">
            <svg fill="none" stroke="#16A34A" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 14l4 4 4-4"/></svg>
        </div>
        <div class="stat-card-label">Total Pemasukan</div>
        <div class="stat-card-value" style="color:#16A34A">Rp {{ number_format($totalPemasukan,0,',','.') }}</div>
        <div class="stat-card-sub">Semua waktu</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FEE2E2">
            <svg fill="none" stroke="#DC2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16V8M8 10l4-4 4 4"/></svg>
        </div>
        <div class="stat-card-label">Total Pengeluaran</div>
        <div class="stat-card-value" style="color:#DC2626">Rp {{ number_format($totalPengeluaran,0,',','.') }}</div>
        <div class="stat-card-sub">Semua waktu</div>
    </div>
</div>

<div class="charts-grid">
    <div class="chart-card">
        <div class="chart-card-header">
            <h2>Pengeluaran per Kategori</h2>
            <span>Semua waktu</span>
        </div>
        <div class="chart-wrap"><canvas id="pieChart"></canvas></div>
    </div>
    <div class="chart-card">
        <div class="chart-card-header">
            <h2>Arus Kas Bulanan</h2>
            <span>6 bulan terakhir</span>
        </div>
        <div class="chart-wrap"><canvas id="barChart"></canvas></div>
    </div>
</div>

<div class="chart-card" style="margin-bottom:1.25rem">
    <div class="chart-card-header">
        <h2>Status Budget Kategori</h2>
        <a href="{{ route('categories.index') }}" style="font-size:12px;color:#6C63FF;text-decoration:none">Kelola →</a>
    </div>
    @if($categories->isEmpty())
        <div class="empty-state">Belum ada kategori.</div>
    @else
        <div class="budget-list">
            @foreach($categories as $i => $cat)
                @php
                    $used = $cat->transactions->sum('amount');
                    $pct  = $cat->max_budget > 0 ? min(100, ($used / $cat->max_budget) * 100) : 0;
                    $color = $colors[$i % count($colors)];
                    $pctColor = $pct >= 100 ? '#DC2626' : ($pct >= 75 ? '#F59E0B' : '#16A34A');
                @endphp
                <div class="budget-item">
                    <div class="budget-item-left">
                        <span class="budget-dot" style="background:{{ $color }}"></span>
                        <div>
                            <div class="budget-name">{{ $cat->name }}</div>
                            <div class="budget-used">Rp {{ number_format($used,0,',','.') }} / Rp {{ number_format($cat->max_budget,0,',','.') }}</div>
                        </div>
                    </div>
                    <div class="budget-right">
                        <div class="budget-pct" style="color:{{ $pctColor }}">{{ round($pct) }}%</div>
                        <div class="budget-bar"><div class="budget-fill" style="width:{{ $pct }}%;background:{{ $pctColor }}"></div></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="table-card">
    <div class="table-card-header">
        <h2>Transaksi Terbaru</h2>
        <a href="{{ route('transactions.index') }}">Lihat semua →</a>
    </div>
    @if($transactions->isEmpty())
        <div class="empty-state">Belum ada transaksi. <a href="{{ route('transactions.create') }}" style="color:#6C63FF">Tambah sekarang</a></div>
    @else
        <table>
            <thead><tr><th></th><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th>Jumlah (Rp)</th><th>USD</th><th>Jenis</th></tr></thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td>
                        <div class="trx-icon {{ $trx->type==='pemasukan'?'in':'out' }}">
                            @if($trx->type==='pemasukan')
                                <svg fill="none" stroke="#16A34A" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
                            @else
                                <svg fill="none" stroke="#DC2626" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
                            @endif
                        </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($trx->date)->format('d M Y') }}</td>
                    <td>{{ $trx->category->name ?? '-' }}</td>
                    <td style="color:#9CA3AF">{{ $trx->description ?? '-' }}</td>
                    <td style="font-weight:500;color:{{ $trx->type==='pemasukan'?'#16A34A':'#DC2626' }}">{{ $trx->type==='pemasukan'?'+':'-' }}Rp {{ number_format($trx->amount,0,',','.') }}</td>
                    <td style="color:#9CA3AF">$ {{ $trx->amount_usd ?? '0' }}</td>
                    <td><span class="badge {{ $trx->type==='pemasukan'?'badge-in':'badge-out' }}">{{ ucfirst($trx->type) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: {!! $pieLabels !!},
        datasets: [{ data: {!! $pieData !!}, backgroundColor: {!! $pieColors !!}, borderWidth: 2, borderColor: '#fff', hoverOffset: 6 }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { position: 'right', labels: { font: { family: 'Poppins', size: 11 }, padding: 12, boxWidth: 12 } },
            tooltip: { callbacks: { label: ctx => ' Rp ' + ctx.parsed.toLocaleString('id-ID') } }
        }
    }
});
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: {!! $barLabels !!},
        datasets: [
            { label: 'Pemasukan', data: {!! $barDataPemasukan !!}, backgroundColor: 'rgba(22,163,74,0.15)', borderColor: '#16A34A', borderWidth: 2, borderRadius: 6 },
            { label: 'Pengeluaran', data: {!! $barData !!}, backgroundColor: 'rgba(220,38,38,0.12)', borderColor: '#DC2626', borderWidth: 2, borderRadius: 6 }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
            legend: { labels: { font: { family: 'Poppins', size: 11 }, padding: 12, boxWidth: 12 } },
            tooltip: { callbacks: { label: ctx => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID') } }
        },
        scales: {
            x: { grid: { display: false }, ticks: { font: { family: 'Poppins', size: 10 } } },
            y: { grid: { color: '#F0F2F8' }, ticks: { font: { family: 'Poppins', size: 10 }, callback: val => 'Rp ' + (val/1000000).toFixed(1) + 'jt' } }
        }
    }
});
</script>

</x-spendwise>