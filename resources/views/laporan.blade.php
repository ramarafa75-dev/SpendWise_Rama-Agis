<x-spendwise title="Laporan Bulanan">
<style>
.filter-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.25rem 1.5rem; margin-bottom:1.25rem; box-shadow:var(--shadow); display:flex; align-items:flex-end; gap:12px; flex-wrap:wrap; }
.filter-card h2 { font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:.75rem; width:100%; }
.filter-group { display:flex; flex-direction:column; gap:5px; }
.filter-group label { font-size:11px; color:var(--text-muted); font-weight:500; }
.filter-group select { background:var(--bg-input); border:1px solid var(--border); border-radius:7px; padding:9px 14px; font-size:13px; color:var(--text-primary); outline:none; font-family:'Poppins',sans-serif; }
.btn-show { background:#1B4F8C; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; cursor:pointer; font-weight:500; font-family:'Poppins',sans-serif; }
.btn-print { background:var(--bg-row); color:var(--text-primary); border:1px solid var(--border); border-radius:8px; padding:9px 18px; font-size:13px; cursor:pointer; font-weight:500; font-family:'Poppins',sans-serif; display:flex; align-items:center; gap:7px; }
.btn-print svg { width:14px; height:14px; }
.report-wrap { background:var(--bg-card); border-radius:12px; border:1px solid var(--border); box-shadow:var(--shadow); overflow:hidden; }
.report-paper { background:#fff; color:#111; max-width:720px; margin:0 auto; padding:2rem 2.5rem; ... }
.kop { display:flex; align-items:flex-start; justify-content:space-between; padding-bottom:14px; border-bottom:3px solid #111; margin-bottom:16px; }
.kop-brand { display:flex; align-items:center; gap:10px; }
.kop-icon { width:38px; height:38px; background:#111; border-radius:8px; display:flex; align-items:center; justify-content:center; }
.kop-icon svg { width:20px; height:20px; fill:none; stroke:#fff; stroke-width:2; }
.kop-brand h1 { font-size:18px; font-weight:800; color:#111; }
.kop-brand p  { font-size:10px; color:#555; }
.kop-right { text-align:right; }
.kop-right h2 { font-size:13px; font-weight:700; color:#111; }
.kop-right p  { font-size:10px; color:#555; margin-top:2px; }
.info-tbl { width:100%; border-collapse:collapse; margin-bottom:16px; font-size:11px; }
.info-tbl td { padding:5px 10px; border:1px solid #DDD; }
.info-tbl td:first-child, .info-tbl td:nth-child(3) { background:#F5F5F5; font-weight:600; color:#333; width:130px; }
.sec-title { font-size:11px; font-weight:700; color:#111; text-transform:uppercase; letter-spacing:.8px; background:#EFEFEF; padding:5px 10px; margin:16px 0 10px; border-left:4px solid #111; }
.saldo-tbl { width:100%; border-collapse:collapse; margin-bottom:16px; font-size:12px; }
.saldo-tbl th { background:#222; color:#fff; padding:7px 12px; text-align:left; font-weight:600; font-size:11px; }
.saldo-tbl td { padding:8px 12px; border-bottom:1px solid #E5E5E5; }
.saldo-tbl tr:last-child td { border-bottom:none; font-weight:700; background:#F5F5F5; font-size:13px; }
.td-right { text-align:right; font-weight:600; }
.kat-tbl { width:100%; border-collapse:collapse; margin-bottom:16px; font-size:11.5px; }
.kat-tbl th { background:#444; color:#fff; padding:6px 10px; text-align:left; font-weight:600; font-size:10px; }
.kat-tbl td { padding:7px 10px; border-bottom:1px solid #E5E5E5; }
.kat-tbl tfoot td { font-weight:700; background:#F5F5F5; border-top:2px solid #444; }
.trx-tbl { width:100%; border-collapse:collapse; margin-bottom:18px; font-size:11px; }
.trx-tbl th { background:#333; color:#fff; padding:7px 10px; text-align:left; font-weight:600; font-size:10px; }
.trx-tbl td { padding:7px 10px; border-bottom:1px solid #EBEBEB; color:#222; }
.trx-tbl tr:nth-child(even) td { background:#FAFAFA; }
.trx-tbl tfoot td { background:#F0F0F0; font-weight:700; border-top:2px solid #333; padding:8px 10px; }
.ttd-row { display:grid; grid-template-columns:1fr 1fr; gap:60px; margin-top:32px; }
.ttd-box { text-align:center; font-size:11px; }
.ttd-line { margin:44px 0 6px; border-bottom:1px solid #111; }
.ttd-box p { font-weight:600; }
.report-footer { margin-top:20px; padding-top:10px; border-top:2px solid #111; display:flex; justify-content:space-between; font-size:10px; color:#555; }
@media print {
    /* Sembunyikan semua KECUALI print area */
    .sidebar,
    .main-wrap .topbar,
    .filter-card,
    .main-footer,
    .flash-success,
    .flash-error { display:none !important; }

    /* Reset body & layout */
    html, body {
        margin:0 !important; padding:0 !important;
        width:100% !important; height:auto !important;
        overflow:visible !important;
        display:block !important;
    }

    body { display:block !important; }
    .main-wrap { display:block !important; width:100% !important; }
    .main-content { display:block !important; padding:0 !important; background:#fff !important; overflow:visible !important; }

    /* Print area full width */
    #print-area { display:block !important; width:100% !important; }
    .report-wrap { box-shadow:none !important; border:none !important; border-radius:0 !important; width:100% !important; }
    .report-paper {
        width:100% !important;
        max-width:100% !important;
        padding:0 !important;
        margin:0 !important;
        font-size:9.5px !important;
    }

    table { width:100% !important; table-layout:fixed !important; }
    td, th { word-break:break-word !important; }
    .ttd-row { gap:20px !important; }
    .kop h1 { font-size:15px !important; }

    .sec-title,
    .trx-tbl th, .kat-tbl th, .saldo-tbl th,
    .trx-tbl tr:nth-child(even) td,
    .saldo-tbl tr:last-child td,
    .kat-tbl tfoot td,
    .trx-tbl tfoot td,
    .kop-icon {
        -webkit-print-color-adjust:exact;
        print-color-adjust:exact;
    }

    @page { size:A4 portrait; margin:1.2cm 1.5cm; }
}
</style>
@php
    $userId    = auth()->id();
    $bulan     = request('bulan', now()->month);
    $tahun     = request('tahun', now()->year);
    $namaBulan = \Carbon\Carbon::createFromDate($tahun,$bulan,1)->translatedFormat('F Y');
    $transactions = \App\Models\Transaction::with('category')
        ->where('user_id',$userId)->whereYear('date',$tahun)->whereMonth('date',$bulan)
        ->orderBy('date')->orderBy('created_at')->get();
    $pemasukan   = $transactions->where('type','pemasukan')->values();
    $pengeluaran = $transactions->where('type','pengeluaran')->values();
    $totalMasuk  = $pemasukan->sum('amount');
    $totalKeluar = $pengeluaran->sum('amount');
    $saldoAwal   = \App\Models\Transaction::where('user_id',$userId)
        ->where(fn($q)=>$q->whereYear('date','<',$tahun)->orWhere(fn($q2)=>$q2->whereYear('date',$tahun)->whereMonth('date','<',$bulan)))
        ->selectRaw("SUM(CASE WHEN type='pemasukan' THEN amount ELSE -amount END) as saldo")
        ->value('saldo') ?? 0;
    $saldoAkhir  = $saldoAwal + $totalMasuk - $totalKeluar;
    $perKategori = \App\Models\Category::where('user_id',$userId)
        ->with(['transactions'=>fn($q)=>$q->where('type','pengeluaran')->whereYear('date',$tahun)->whereMonth('date',$bulan)])
        ->get()->filter(fn($c)=>$c->transactions->sum('amount')>0);
    $hariDlmBulan = \Carbon\Carbon::createFromDate($tahun,$bulan,1)->daysInMonth;
@endphp

<div class="filter-card no-print">
    <h2>Pilih Periode Laporan</h2>
    <form method="GET" action="{{ route('laporan') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
        <div class="filter-group">
            <label>Bulan</label>
            <select name="bulan">
                @foreach(range(1,12) as $b)
                    <option value="{{ $b }}" {{ $bulan==$b?'selected':'' }}>{{ \Carbon\Carbon::createFromDate(null,$b,1)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>Tahun</label>
            <select name="tahun">
                @foreach(range(now()->year, now()->year-4) as $t)
                    <option value="{{ $t }}" {{ $tahun==$t?'selected':'' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-show">Tampilkan</button>
        <button type="button" class="btn-print" onclick="window.print()">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Print / Simpan PDF
        </button>
    </form>
</div>

<div id="print-area">
<div class="report-wrap">
<div class="report-paper">

<div class="kop">
    <div class="kop-brand">
        <div class="kop-icon"><svg viewBox="0 0 24 24"><path d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7"/><path d="M3 10h18M7 15h2M7 12h2"/><circle cx="18" cy="18" r="3"/><path d="M18 16v2l1 1"/></svg></div>
        <div><h1>SpendWise</h1><p>Aplikasi Pencatatan Keuangan Pribadi Mahasiswa</p></div>
    </div>
    <div class="kop-right">
        <h2>LAPORAN KEUANGAN BULANAN</h2>
        <p>Periode &nbsp;: {{ $namaBulan }}</p>
        <p>Dicetak &nbsp;: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
    </div>
</div>

<table class="info-tbl">
    <tr>
        <td>Nama Akun</td><td>{{ auth()->user()->name }}</td>
        <td>Periode</td><td>{{ $namaBulan }}</td>
    </tr>
    <tr>
        <td>Email</td><td>{{ auth()->user()->email }}</td>
        <td>Total Transaksi</td><td>{{ $transactions->count() }} ({{ $pemasukan->count() }} pemasukan, {{ $pengeluaran->count() }} pengeluaran)</td>
    </tr>
    <tr>
        <td>Tgl Cetak</td><td>{{ now()->translatedFormat('d F Y') }}</td>
        <td>Rata-rata/Hari</td><td>Rp {{ number_format($hariDlmBulan>0?$totalKeluar/$hariDlmBulan:0,0,',','.') }}</td>
    </tr>
</table>

<div class="sec-title">A. Ringkasan Keuangan</div>
<table class="saldo-tbl">
    <thead><tr><th>Keterangan</th><th style="text-align:right">Jumlah (Rp)</th><th>Catatan</th></tr></thead>
    <tbody>
        <tr>
            <td>Saldo Awal (Per 1 {{ $namaBulan }})</td>
            <td class="td-right">Rp {{ number_format(abs($saldoAwal),0,',','.') }}{{ $saldoAwal<0?' (minus)':'' }}</td>
            <td style="color:#666;font-size:10px">Akumulasi sebelum periode ini</td>
        </tr>
        <tr>
            <td>Total Pemasukan</td>
            <td class="td-right" style="color:#166534">Rp {{ number_format($totalMasuk,0,',','.') }}</td>
            <td style="color:#666;font-size:10px">{{ $pemasukan->count() }} transaksi pemasukan</td>
        </tr>
        <tr>
            <td>Total Pengeluaran</td>
            <td class="td-right" style="color:#991B1B">(Rp {{ number_format($totalKeluar,0,',','.') }})</td>
            <td style="color:#666;font-size:10px">{{ $pengeluaran->count() }} transaksi pengeluaran</td>
        </tr>
        <tr>
            <td><b>Saldo Akhir (Per {{ \Carbon\Carbon::createFromDate($tahun,$bulan,1)->endOfMonth()->format('d') }} {{ $namaBulan }})</b></td>
            <td class="td-right" style="color:{{ $saldoAkhir>=0?'#166534':'#991B1B' }};font-size:14px"><b>Rp {{ number_format(abs($saldoAkhir),0,',','.') }}{{ $saldoAkhir<0?' (minus)':'' }}</b></td>
            <td style="color:#666;font-size:10px">Saldo Awal + Pemasukan − Pengeluaran</td>
        </tr>
    </tbody>
</table>

@if($perKategori->isNotEmpty())
<div class="sec-title">B. Pengeluaran per Kategori</div>
<table class="kat-tbl">
    <thead><tr><th style="width:30px;text-align:center">No</th><th>Nama Kategori</th><th>Budget Maksimal</th><th style="text-align:right">Total Pengeluaran (Rp)</th><th style="text-align:right">% dari Total</th></tr></thead>
    <tbody>
        @foreach($perKategori->values() as $i => $cat)
        @php $catTotal=$cat->transactions->sum('amount'); @endphp
        <tr>
            <td style="text-align:center;color:#888">{{ $i+1 }}</td>
            <td>{{ $cat->name }}</td>
            <td>Rp {{ number_format($cat->max_budget,0,',','.') }}</td>
            <td style="text-align:right;color:#991B1B;font-weight:600">Rp {{ number_format($catTotal,0,',','.') }}</td>
            <td style="text-align:right">{{ $totalKeluar>0?round(($catTotal/$totalKeluar)*100,1):0 }}%</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot><tr><td colspan="3"><b>Total</b></td><td style="text-align:right"><b>Rp {{ number_format($totalKeluar,0,',','.') }}</b></td><td style="text-align:right"><b>100%</b></td></tr></tfoot>
</table>
@endif

@if($pemasukan->isNotEmpty())
<div class="sec-title">C. Rincian Pemasukan</div>
<table class="trx-tbl">
    <thead><tr><th style="width:28px;text-align:center">No</th><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th style="text-align:right">Jumlah (Rp)</th><th style="text-align:right">USD</th></tr></thead>
    <tbody>
        @foreach($pemasukan as $i => $trx)
        <tr>
            <td style="text-align:center;color:#888">{{ $i+1 }}</td>
            <td>{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
            <td>{{ $trx->category->name??'-' }}</td>
            <td>{{ $trx->description??'-' }}</td>
            <td style="text-align:right;font-weight:600;color:#166534">Rp {{ number_format($trx->amount,0,',','.') }}</td>
            <td style="text-align:right;color:#666">$ {{ number_format($trx->amount_usd??0,4,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot><tr><td colspan="4" style="text-align:right">Jumlah Total Pemasukan</td><td style="text-align:right;color:#166534">Rp {{ number_format($totalMasuk,0,',','.') }}</td><td></td></tr></tfoot>
</table>
@endif

@if($pengeluaran->isNotEmpty())
<div class="sec-title">D. Rincian Pengeluaran</div>
<table class="trx-tbl">
    <thead><tr><th style="width:28px;text-align:center">No</th><th>Tanggal</th><th>Kategori</th><th>Deskripsi</th><th style="text-align:right">Jumlah (Rp)</th><th style="text-align:right">USD</th></tr></thead>
    <tbody>
        @foreach($pengeluaran as $i => $trx)
        <tr>
            <td style="text-align:center;color:#888">{{ $i+1 }}</td>
            <td>{{ \Carbon\Carbon::parse($trx->date)->format('d/m/Y') }}</td>
            <td>{{ $trx->category->name??'-' }}</td>
            <td>{{ $trx->description??'-' }}</td>
            <td style="text-align:right;font-weight:600;color:#991B1B">Rp {{ number_format($trx->amount,0,',','.') }}</td>
            <td style="text-align:right;color:#666">$ {{ number_format($trx->amount_usd??0,4,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot><tr><td colspan="4" style="text-align:right">Jumlah Total Pengeluaran</td><td style="text-align:right;color:#991B1B">Rp {{ number_format($totalKeluar,0,',','.') }}</td><td></td></tr></tfoot>
</table>
@endif

@if($transactions->isEmpty())
    <div style="text-align:center;padding:2rem;color:#888">Tidak ada transaksi pada periode {{ $namaBulan }}.</div>
@endif

<div class="ttd-row">
    <div class="ttd-box">
        <div>Dibuat oleh,</div>
        <div class="ttd-line"></div>
        <p>{{ auth()->user()->name }}</p>
        <div style="font-size:10px;color:#666">Pemilik Akun</div>
    </div>
    <div class="ttd-box">
        <div>Dicetak pada,</div>
        <div class="ttd-line"></div>
        <p>{{ now()->translatedFormat('d F Y') }}</p>
        <div style="font-size:10px;color:#666">SpendWise System</div>
    </div>
</div>

<div class="report-footer">
    <span><b>SpendWise</b> — Laporan Keuangan Pribadi · {{ $namaBulan }}</span>
    <span>Dokumen digenerate otomatis oleh sistem SpendWise</span>
    <span>© {{ date('Y') }} <b>{{ auth()->user()->name }}</b></span>
</div>

</div></div></div>
</x-spendwise>
