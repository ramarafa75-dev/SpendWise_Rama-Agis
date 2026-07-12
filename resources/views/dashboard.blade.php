<x-spendwise title="Dashboard">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .alert-boros { background:var(--badge-out-bg); border:1px solid var(--icon-out-bg); border-radius:10px; padding:12px 16px; margin-bottom:1.25rem; display:flex; align-items:flex-start; gap:10px; font-size:13px; color:var(--badge-out-txt); }
    .alert-boros-title { font-weight:600; margin-bottom:2px; }
    .alert-boros-sub { font-size:12px; opacity:.8; }
    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:1.25rem; }
    .stat-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.1rem 1.25rem; box-shadow:var(--shadow); }
    .stat-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
    .stat-icon svg { width:18px; height:18px; }
    .stat-label { font-size:12px; color:var(--text-muted); margin-bottom:4px; }
    .stat-value { font-size:22px; font-weight:700; color:var(--text-primary); }
    .stat-sub { font-size:11px; color:var(--text-muted); margin-top:4px; }
    .charts-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:1.25rem; }
    .chart-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.25rem; box-shadow:var(--shadow); }
    .chart-hd { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .chart-hd h2 { font-size:14px; font-weight:600; color:var(--text-primary); }
    .chart-hd span { font-size:11px; color:var(--text-muted); }
    .chart-wrap { position:relative; height:220px; }
    .budget-list { display:flex; flex-direction:column; gap:8px; }
    .budget-item { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:var(--bg-row); border-radius:8px; border:1px solid var(--border); }
    .budget-left { display:flex; align-items:center; gap:10px; }
    .budget-dot { width:9px; height:9px; border-radius:50%; flex-shrink:0; }
    .budget-name { font-size:13px; font-weight:500; color:var(--text-primary); }
    .budget-used-txt { font-size:11px; color:var(--text-muted); margin-top:2px; }
    .budget-bar { width:100px; height:5px; background:var(--border); border-radius:10px; overflow:hidden; margin-top:4px; }
    .budget-fill { height:100%; border-radius:10px; }
    .table-wrap { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.25rem; box-shadow:var(--shadow); }
    .table-hd { display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .table-hd h2 { font-size:14px; font-weight:600; color:var(--text-primary); }
    .table-hd a { font-size:12px; color:var(--accent); text-decoration:none; }

@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr !important; gap: 10px !important; }
    .charts-grid { grid-template-columns: 1fr !important; gap: 10px !important; }
    .stat-card-value { font-size: 18px !important; }
    .chart-wrap { height: 180px !important; }
}
</style>

@php
    $userId = auth()->id();
    $colors = ['#7C6FFF','#EF4444','#F59E0B','#10B981','#3B82F6','#EC4899','#8B5CF6','#14B8A6'];
    $alertCategories = \App\Models\Category::where('user_id',$userId)
        ->with(['transactions'=>fn($q)=>$q->where('type','pengeluaran')])->get()
        ->filter(fn($c)=>$c->max_budget>0&&$c->transactions->sum('amount')>=$c->max_budget);
    $totalPemasukan   = \App\Models\Transaction::where('user_id',$userId)->where('type','pemasukan')->sum('amount');
    $totalPengeluaran = \App\Models\Transaction::where('user_id',$userId)->where('type','pengeluaran')->sum('amount');
    $saldo            = $totalPemasukan - $totalPengeluaran;
    $categories = \App\Models\Category::where('user_id',$userId)->with(['transactions'=>fn($q)=>$q->where('type','pengeluaran')])->get();
    $pieLabels    = $categories->pluck('name')->toJson();
    $pieData      = $categories->map(fn($c)=>$c->transactions->sum('amount'))->toJson();
    $pieColors    = collect($colors)->take($categories->count())->values()->toJson();
    $months       = collect(range(5,0))->map(fn($i)=>now()->subMonths($i));
    $barLabels    = $months->map(fn($m)=>$m->translatedFormat('M Y'))->toJson();
    $barKeluar    = $months->map(fn($m)=>\App\Models\Transaction::where('user_id',$userId)->where('type','pengeluaran')->whereYear('date',$m->year)->whereMonth('date',$m->month)->sum('amount'))->toJson();
    $barMasuk     = $months->map(fn($m)=>\App\Models\Transaction::where('user_id',$userId)->where('type','pemasukan')->whereYear('date',$m->year)->whereMonth('date',$m->month)->sum('amount'))->toJson();
    $transactions = \App\Models\Transaction::with('category')->where('user_id',$userId)->latest('date')->take(5)->get();
@endphp

@foreach($alertCategories as $ac)
<div class="alert-boros">
    <span style="font-size:18px;flex-shrink:0">⚠️</span>
    <div>
        <div class="alert-boros-title">Batas Budget Tercapai — {{ $ac->name }}</div>
        <div class="alert-boros-sub">Pengeluaran Rp {{ number_format($ac->transactions->sum('amount'),0,',','.') }} mencapai batas Rp {{ number_format($ac->max_budget,0,',','.') }}.</div>
    </div>
</div>
@endforeach

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(108,99,255,.12)">
            <svg fill="none" stroke="var(--accent)" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        </div>
        <div class="stat-label">Total Saldo</div>
        <div class="stat-value" style="color:{{ $saldo>=0?'var(--text-primary)':'var(--danger)' }}">Rp {{ number_format(abs($saldo),0,',','.') }}</div>
        <div class="stat-sub">Pemasukan - Pengeluaran</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--badge-in-bg)">
            <svg fill="none" stroke="var(--success)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 14l4 4 4-4"/></svg>
        </div>
        <div class="stat-label">Total Pemasukan</div>
        <div class="stat-value" style="color:var(--success)">Rp {{ number_format($totalPemasukan,0,',','.') }}</div>
        <div class="stat-sub">Semua waktu</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--badge-out-bg)">
            <svg fill="none" stroke="var(--danger)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16V8M8 10l4-4 4 4"/></svg>
        </div>
        <div class="stat-label">Total Pengeluaran</div>
        <div class="stat-value" style="color:var(--danger)">Rp {{ number_format($totalPengeluaran,0,',','.') }}</div>
        <div class="stat-sub">Semua waktu</div>
    </div>
</div>

<div class="charts-grid">
    <div class="chart-card">
        <div class="chart-hd"><h2>Pengeluaran per Kategori</h2><span>Semua waktu</span></div>
        <div class="chart-wrap"><canvas id="pieChart"></canvas></div>
    </div>
    <div class="chart-card">
        <div class="chart-hd"><h2>Arus Kas Bulanan</h2><span>6 bulan terakhir</span></div>
        <div class="chart-wrap"><canvas id="barChart"></canvas></div>
    </div>
</div>

<div class="chart-card" style="margin-bottom:1.25rem">
    <div class="chart-hd">
        <h2>Status Budget Kategori</h2>
        <a href="{{ route('categories.index') }}" style="font-size:12px;color:var(--accent);text-decoration:none">Kelola →</a>
    </div>
    @if($categories->isEmpty())
        <div class="empty-state">Belum ada kategori.</div>
    @else
        <div class="budget-list">
            @foreach($categories as $i => $cat)
                @php $used=$cat->transactions->sum('amount'); $pct=$cat->max_budget>0?min(100,($used/$cat->max_budget)*100):0; $color=$colors[$i%count($colors)]; $pctColor=$pct>=100?'var(--danger)':($pct>=75?'var(--warning)':'var(--success)'); @endphp
                <div class="budget-item">
                    <div class="budget-left">
                        <span class="budget-dot" style="background:{{ $color }}"></span>
                        <div>
                            <div class="budget-name">{{ $cat->name }}</div>
                            <div class="budget-used-txt">Rp {{ number_format($used,0,',','.') }} / Rp {{ number_format($cat->max_budget,0,',','.') }}</div>
                        </div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:13px;font-weight:600;color:{{ $pctColor }}">{{ round($pct) }}%</div>
                        <div class="budget-bar"><div class="budget-fill" style="width:{{ $pct }}%;background:{{ $pctColor }}"></div></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="table-wrap">
    <div class="table-hd">
        <h2>Transaksi Terbaru</h2>
        <a href="{{ route('transactions.index') }}">Lihat semua →</a>
    </div>
    @if($transactions->isEmpty())
        <div class="empty-state">Belum ada transaksi. <a href="{{ route('transactions.create') }}" style="color:var(--accent)">Tambah sekarang</a></div>
    @else
        <table class="sw-table">
            <thead><tr><th></th><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th>Jumlah (Rp)</th><th>USD</th><th>Jenis</th></tr></thead>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
const isDark = () => document.documentElement.getAttribute('data-theme') === 'dark';
const mutedColor = () => isDark() ? '#484F58' : '#9CA3AF';
const gridColor = () => isDark() ? '#21262D' : '#E2E6F0';
const cardBg = () => isDark() ? '#161B22' : '#ffffff';

const pieChart = new Chart(document.getElementById('pieChart'), {
    type:'doughnut',
    data:{ labels:{!! $pieLabels !!}, datasets:[{ data:{!! $pieData !!}, backgroundColor:{!! $pieColors !!}, borderWidth:2, borderColor:cardBg(), hoverOffset:6 }] },
    options:{ responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ position:'right', labels:{ font:{family:'Poppins',size:11}, padding:12, boxWidth:12, color:mutedColor() } },
        tooltip:{ callbacks:{ label: ctx=>' Rp '+ctx.parsed.toLocaleString('id-ID') } } } }
});

const barChart = new Chart(document.getElementById('barChart'), {
    type:'bar',
    data:{ labels:{!! $barLabels !!}, datasets:[
        { label:'Pemasukan', data:{!! $barMasuk !!}, backgroundColor:'rgba(74,222,128,.15)', borderColor:'#4ADE80', borderWidth:2, borderRadius:6 },
        { label:'Pengeluaran', data:{!! $barKeluar !!}, backgroundColor:'rgba(248,113,113,.15)', borderColor:'#F87171', borderWidth:2, borderRadius:6 }
    ]},
    options:{ responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ labels:{ font:{family:'Poppins',size:11}, padding:12, boxWidth:12, color:mutedColor() } },
        tooltip:{ callbacks:{ label: ctx=>' Rp '+ctx.parsed.y.toLocaleString('id-ID') } } },
        scales:{ x:{ grid:{display:false}, ticks:{font:{family:'Poppins',size:10},color:mutedColor()} },
                 y:{ grid:{color:gridColor()}, ticks:{font:{family:'Poppins',size:10},color:mutedColor(),callback:val=>'Rp '+(val/1000000).toFixed(1)+'jt'} } } }
});

// Update chart warna saat toggle
document.addEventListener('themeChanged', () => {
    pieChart.data.datasets[0].borderColor = cardBg();
    pieChart.options.plugins.legend.labels.color = mutedColor();
    barChart.options.plugins.legend.labels.color = mutedColor();
    barChart.options.scales.x.ticks.color = mutedColor();
    barChart.options.scales.y.ticks.color = mutedColor();
    barChart.options.scales.y.grid.color = gridColor();
    pieChart.update(); barChart.update();
});
</script>
</x-spendwise>
