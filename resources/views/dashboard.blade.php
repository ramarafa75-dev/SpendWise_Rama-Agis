<x-spendwise title="Dashboard">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* Cards */
    .card { background:#161B22; border-radius:10px; border:1px solid #21262D; box-shadow:0 1px 4px rgba(0,0,0,.3); }
    .alert-danger { background:rgba(220,38,38,.1); border:1px solid rgba(220,38,38,.25); border-radius:10px; padding:12px 16px; margin-bottom:1.25rem; display:flex; align-items:flex-start; gap:10px; font-size:13px; color:#F87171; }
    .alert-danger-title { font-weight:600; margin-bottom:2px; }
    .alert-danger-sub { font-size:12px; color:#FCA5A5; }

    /* Stat Cards */
    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:1.25rem; }
    .stat-card { background:#161B22; border-radius:10px; border:1px solid #21262D; padding:1.1rem 1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.3); }
    .stat-card-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
    .stat-card-icon svg { width:18px; height:18px; }
    .stat-card-label { font-size:12px; color:#484F58; margin-bottom:4px; }
    .stat-card-value { font-size:22px; font-weight:700; color:#E6EDF3; }
    .stat-card-sub { font-size:11px; color:#484F58; margin-top:4px; }

    /* Charts */
    .charts-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:1.25rem; }
    .chart-card { background:#161B22; border-radius:10px; border:1px solid #21262D; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.3); }
    .chart-card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .chart-card-header h2 { font-size:14px; font-weight:600; color:#E6EDF3; }
    .chart-card-header span { font-size:11px; color:#484F58; }
    .chart-wrap { position:relative; height:220px; }

    /* Budget */
    .budget-list { display:flex; flex-direction:column; gap:8px; }
    .budget-item { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:#0D1117; border-radius:8px; border:1px solid #21262D; }
    .budget-item-left { display:flex; align-items:center; gap:10px; }
    .budget-dot { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
    .budget-name { font-size:13px; font-weight:500; color:#E6EDF3; }
    .budget-used { font-size:11px; color:#484F58; margin-top:2px; }
    .budget-pct { font-size:13px; font-weight:600; }
    .budget-bar { width:100px; height:5px; background:#21262D; border-radius:10px; overflow:hidden; margin-top:4px; }
    .budget-fill { height:100%; border-radius:10px; }

    /* Table */
    .table-card { background:#161B22; border-radius:10px; border:1px solid #21262D; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.3); }
    .table-card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .table-card-header h2 { font-size:14px; font-weight:600; color:#E6EDF3; }
    .table-card-header a { font-size:12px; color:#6C63FF; text-decoration:none; }
    table { width:100%; border-collapse:collapse; font-size:13px; }
    thead th { text-align:left; color:#484F58; font-weight:500; padding:0 10px 10px; font-size:11px; border-bottom:1px solid #21262D; }
    tbody td { padding:11px 10px; border-bottom:1px solid #21262D; color:#8B949E; }
    tbody tr:last-child td { border-bottom:none; }
    tbody tr:hover td { background:rgba(255,255,255,.02); }
    .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }
    .badge-in { background:rgba(22,163,74,.15); color:#4ADE80; }
    .badge-out { background:rgba(220,38,38,.15); color:#F87171; }
    .trx-icon { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .trx-icon.in { background:rgba(22,163,74,.15); }
    .trx-icon.out { background:rgba(220,38,38,.15); }
    .trx-icon svg { width:16px; height:16px; }
    .empty-state { text-align:center; padding:2.5rem; color:#484F58; font-size:13px; }
</style>

@php
    $userId = auth()->id();
    $colors = ['#7C6FFF','#EF4444','#F59E0B','#10B981','#3B82F6','#EC4899','#8B5CF6','#14B8A6'];

    $alertCategories = \App\Models\Category::where('user_id',$userId)
        ->with(['transactions'=>fn($q)=>$q->where('type','pengeluaran')])
        ->get()->filter(fn($c)=>$c->max_budget>0 && $c->transactions->sum('amount')>=$c->max_budget);

    $totalPemasukan   = \App\Models\Transaction::where('user_id',$userId)->where('type','pemasukan')->sum('amount');
    $totalPengeluaran = \App\Models\Transaction::where('user_id',$userId)->where('type','pengeluaran')->sum('amount');
    $saldo            = $totalPemasukan - $totalPengeluaran;

    $categories = \App\Models\Category::where('user_id',$userId)
        ->with(['transactions'=>fn($q)=>$q->where('type','pengeluaran')])->get();

    $pieLabels        = $categories->pluck('name')->toJson();
    $pieData          = $categories->map(fn($c)=>$c->transactions->sum('amount'))->toJson();
    $pieColors        = collect($colors)->take($categories->count())->values()->toJson();

    $months           = collect(range(5,0))->map(fn($i)=>now()->subMonths($i));
    $barLabels        = $months->map(fn($m)=>$m->translatedFormat('M Y'))->toJson();
    $barData          = $months->map(fn($m)=>\App\Models\Transaction::where('user_id',$userId)->where('type','pengeluaran')->whereYear('date',$m->year)->whereMonth('date',$m->month)->sum('amount'))->toJson();
    $barDataMasuk     = $months->map(fn($m)=>\App\Models\Transaction::where('user_id',$userId)->where('type','pemasukan')->whereYear('date',$m->year)->whereMonth('date',$m->month)->sum('amount'))->toJson();

    $transactions = \App\Models\Transaction::with('category')->where('user_id',$userId)->latest('date')->take(5)->get();
@endphp

@if($alertCategories->isNotEmpty())
    @foreach($alertCategories as $ac)
        <div class="alert-danger">
            <span style="font-size:18px;flex-shrink:0">⚠️</span>
            <div>
                <div class="alert-danger-title">Batas Budget Tercapai — {{ $ac->name }}</div>
                <div class="alert-danger-sub">Pengeluaran Rp {{ number_format($ac->transactions->sum('amount'),0,',','.') }} telah mencapai batas Rp {{ number_format($ac->max_budget,0,',','.') }}.</div>
            </div>
        </div>
    @endforeach
@endif

{{-- Stat Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(108,99,255,.15)">
            <svg fill="none" stroke="#7C6FFF" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        </div>
        <div class="stat-card-label">Total Saldo</div>
        <div class="stat-card-value" style="color:{{ $saldo>=0?'#E6EDF3':'#F87171' }}">Rp {{ number_format(abs($saldo),0,',','.') }}</div>
        <div class="stat-card-sub">Pemasukan - Pengeluaran</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(22,163,74,.15)">
            <svg fill="none" stroke="#4ADE80" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 14l4 4 4-4"/></svg>
        </div>
        <div class="stat-card-label">Total Pemasukan</div>
        <div class="stat-card-value" style="color:#4ADE80">Rp {{ number_format($totalPemasukan,0,',','.') }}</div>
        <div class="stat-card-sub">Semua waktu</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:rgba(220,38,38,.15)">
            <svg fill="none" stroke="#F87171" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16V8M8 10l4-4 4 4"/></svg>
        </div>
        <div class="stat-card-label">Total Pengeluaran</div>
        <div class="stat-card-value" style="color:#F87171">Rp {{ number_format($totalPengeluaran,0,',','.') }}</div>
        <div class="stat-card-sub">Semua waktu</div>
    </div>
</div>

{{-- Charts --}}
<div class="charts-grid">
    <div class="chart-card">
        <div class="chart-card-header"><h2>Pengeluaran per Kategori</h2><span>Semua waktu</span></div>
        <div class="chart-wrap"><canvas id="pieChart"></canvas></div>
    </div>
    <div class="chart-card">
        <div class="chart-card-header"><h2>Arus Kas Bulanan</h2><span>6 bulan terakhir</span></div>
        <div class="chart-wrap"><canvas id="barChart"></canvas></div>
    </div>
</div>

{{-- Budget Status --}}
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
                    $used=$cat->transactions->sum('amount');
                    $pct=$cat->max_budget>0?min(100,($used/$cat->max_budget)*100):0;
                    $color=$colors[$i%count($colors)];
                    $pctColor=$pct>=100?'#F87171':($pct>=75?'#FBBF24':'#4ADE80');
                @endphp
                <div class="budget-item">
                    <div class="budget-item-left">
                        <span class="budget-dot" style="background:{{ $color }}"></span>
                        <div>
                            <div class="budget-name">{{ $cat->name }}</div>
                            <div class="budget-used">Rp {{ number_format($used,0,',','.') }} / Rp {{ number_format($cat->max_budget,0,',','.') }}</div>
                        </div>
                    </div>
                    <div style="text-align:right">
                        <div class="budget-pct" style="color:{{ $pctColor }}">{{ round($pct) }}%</div>
                        <div class="budget-bar"><div class="budget-fill" style="width:{{ $pct }}%;background:{{ $pctColor }}"></div></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Transaksi Terbaru --}}
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
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
Chart.defaults.color = '#484F58';
Chart.defaults.borderColor = '#21262D';

new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: {!! $pieLabels !!},
        datasets: [{ data: {!! $pieData !!}, backgroundColor: {!! $pieColors !!}, borderWidth: 2, borderColor: '#161B22', hoverOffset: 6 }]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins: {
            legend: { position:'right', labels:{ font:{family:'Poppins',size:11}, padding:12, boxWidth:12, color:'#8B949E' } },
            tooltip: { callbacks:{ label: ctx=>' Rp '+ctx.parsed.toLocaleString('id-ID') } }
        }
    }
});

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: {!! $barLabels !!},
        datasets: [
            { label:'Pemasukan', data:{!! $barDataMasuk !!}, backgroundColor:'rgba(74,222,128,.15)', borderColor:'#4ADE80', borderWidth:2, borderRadius:6 },
            { label:'Pengeluaran', data:{!! $barData !!}, backgroundColor:'rgba(248,113,113,.15)', borderColor:'#F87171', borderWidth:2, borderRadius:6 }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins: {
            legend:{ labels:{ font:{family:'Poppins',size:11}, padding:12, boxWidth:12, color:'#8B949E' } },
            tooltip:{ callbacks:{ label: ctx=>' Rp '+ctx.parsed.y.toLocaleString('id-ID') } }
        },
        scales: {
            x:{ grid:{display:false}, ticks:{font:{family:'Poppins',size:10},color:'#484F58'} },
            y:{ grid:{color:'#21262D'}, ticks:{font:{family:'Poppins',size:10},color:'#484F58',callback:val=>'Rp '+(val/1000000).toFixed(1)+'jt'} }
        }
    }
});
</script>
</x-spendwise>
