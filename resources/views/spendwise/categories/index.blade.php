<x-spendwise title="Kategori Anggaran">
<style>
    .period-banner { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1rem 1.25rem; margin-bottom:1.25rem; box-shadow:var(--shadow); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
    .period-info { display:flex; align-items:center; gap:10px; }
    .period-icon { width:36px; height:36px; background:rgba(108,99,255,.1); border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:18px; }
    .period-label { font-size:12px; color:var(--text-muted); margin-bottom:2px; }
    .period-val { font-size:14px; font-weight:600; color:var(--text-primary); }
    .period-days { background:rgba(108,99,255,.1); color:var(--accent); border:1px solid rgba(108,99,255,.2); border-radius:20px; padding:4px 12px; font-size:12px; font-weight:500; }
    .set-payday-link { font-size:12px; color:var(--accent); text-decoration:none; }
    .set-payday-link:hover { text-decoration:underline; }

    .add-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.25rem; margin-bottom:1.25rem; box-shadow:var(--shadow); }
    .add-card h2 { font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:1rem; }
    .form-row { display:grid; grid-template-columns:1fr 1fr auto; gap:10px; align-items:flex-end; }

    .cat-list { display:flex; flex-direction:column; gap:10px; }
    .cat-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1rem 1.25rem; display:flex; align-items:center; justify-content:space-between; box-shadow:var(--shadow); transition:all .15s; }
    .cat-card.over-budget { border-color:rgba(248,113,113,.3); background:rgba(248,113,113,.03); }
    .cat-left { display:flex; align-items:center; gap:12px; }
    .cat-dot { width:11px; height:11px; border-radius:50%; flex-shrink:0; }
    .cat-name { font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:3px; }
    .cat-budget-txt { font-size:12px; color:var(--text-muted); }
    .cat-usage { font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:4px; }
    .progress-bar { width:140px; height:5px; background:var(--border); border-radius:10px; overflow:hidden; }
    .progress-fill { height:100%; border-radius:10px; }
    .status-ok     { font-size:11px; color:var(--success); margin-top:3px; }
    .status-warn   { font-size:11px; color:var(--warning); margin-top:3px; }
    .status-danger { font-size:11px; color:var(--danger); margin-top:3px; }
    .btn-delete { background:none; border:none; color:var(--danger); font-size:12px; cursor:pointer; padding:6px 10px; border-radius:6px; font-family:'Poppins',sans-serif; }
    .btn-delete:hover { background:var(--badge-out-bg); }
    .over-badge { display:inline-flex; align-items:center; gap:4px; background:rgba(248,113,113,.15); color:var(--danger); border:1px solid rgba(248,113,113,.2); border-radius:20px; padding:2px 9px; font-size:10px; font-weight:600; margin-left:8px; }
    .period-note { font-size:10px; color:var(--text-muted); margin-top:2px; }
    .empty-state { text-align:center; padding:3rem; color:var(--text-muted); font-size:13px; background:var(--bg-card); border-radius:10px; border:1px solid var(--border); }
    @php $colors = ['#7C6FFF','#EF4444','#F59E0B','#10B981','#3B82F6','#EC4899','#8B5CF6','#14B8A6']; @endphp
</style>

@php
    $user    = auth()->user();
    $period  = \App\Helpers\PaydayHelper::getCurrentPeriod($user->payday_date);
    $daysLeft = \App\Helpers\PaydayHelper::getDaysUntilPayday($user->payday_date);
@endphp

{{-- Period Banner --}}
<div class="period-banner">
    <div class="period-info">
        <div class="period-icon">📅</div>
        <div>
            <div class="period-label">Periode Aktif {{ $user->payday_date ? '(Tanggal Gajian: '.$user->payday_date.')' : '(Bulanan)' }}</div>
            <div class="period-val">{{ $period['label'] }}</div>
            @if($user->payday_date)
                <div class="period-note">Budget direset otomatis setiap tanggal {{ $user->payday_date }}</div>
            @endif
        </div>
    </div>
    <div style="display:flex;align-items:center;gap:10px">
        @if($daysLeft !== null)
            <span class="period-days">🎯 {{ $daysLeft }} hari lagi gajian</span>
        @endif
        <a href="{{ route('profile') }}" class="set-payday-link">
            {{ $user->payday_date ? '⚙ Ubah tanggal gajian' : '+ Set tanggal gajian' }}
        </a>
    </div>
</div>

{{-- Form Tambah --}}
<div class="add-card">
    <h2>Tambah Kategori Baru</h2>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div class="form-row">
            <div class="sw-form-group">
                <label class="sw-label">Nama Kategori</label>
                <input type="text" name="name" class="sw-input" placeholder="Makanan, Kost, Kuliah..." required value="{{ old('name') }}">
                @error('name')<p class="sw-error">{{ $message }}</p>@enderror
            </div>
            <div class="sw-form-group">
                <label class="sw-label">Maksimal Budget (Rp)</label>
                <input type="number" name="max_budget" class="sw-input" placeholder="0" required value="{{ old('max_budget') }}">
                @error('max_budget')<p class="sw-error">{{ $message }}</p>@enderror
            </div>
            <div class="sw-form-group">
                <button type="submit" class="btn-primary">+ Tambah</button>
            </div>
        </div>
    </form>
</div>

{{-- Stat: total periode --}}
@php
    $totalPeriodKeluar = \App\Models\Transaction::where('user_id', auth()->id())
        ->where('type','pengeluaran')
        ->whereDate('date','>=',$period['start'])
        ->whereDate('date','<=',$period['end'])
        ->sum('amount');
    $totalPeriodMasuk = \App\Models\Transaction::where('user_id', auth()->id())
        ->where('type','pemasukan')
        ->whereDate('date','>=',$period['start'])
        ->whereDate('date','<=',$period['end'])
        ->sum('amount');
@endphp
<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:1.25rem">
    <div style="background:var(--bg-card);border-radius:8px;border:1px solid var(--border);padding:.85rem 1rem;box-shadow:var(--shadow)">
        <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px">Pemasukan Periode Ini</div>
        <div style="font-size:16px;font-weight:700;color:var(--success)">Rp {{ number_format($totalPeriodMasuk,0,',','.') }}</div>
    </div>
    <div style="background:var(--bg-card);border-radius:8px;border:1px solid var(--border);padding:.85rem 1rem;box-shadow:var(--shadow)">
        <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px">Pengeluaran Periode Ini</div>
        <div style="font-size:16px;font-weight:700;color:var(--danger)">Rp {{ number_format($totalPeriodKeluar,0,',','.') }}</div>
    </div>
</div>

{{-- List Kategori --}}
<div style="font-size:12px;color:var(--text-muted);margin-bottom:10px">
    {{ $categories->count() }} kategori · Pengeluaran dihitung dari <b>{{ $period['start']->format('d M Y') }}</b> s/d <b>{{ $period['end']->format('d M Y') }}</b>
</div>

@if($categories->isEmpty())
    <div class="empty-state">Belum ada kategori. Tambahkan di atas untuk mulai mencatat.</div>
@else
    <div class="cat-list">
        @foreach($categories as $i => $cat)
            @php
                $color = $colors[$i % count($colors)];

                // Hitung pengeluaran hanya dalam periode aktif
                $used = $cat->transactions()
                    ->where('type','pengeluaran')
                    ->whereDate('date','>=',$period['start'])
                    ->whereDate('date','<=',$period['end'])
                    ->sum('amount');

                $pct = $cat->max_budget > 0 ? min(100, ($used / $cat->max_budget) * 100) : 0;
                $isOver = $used >= $cat->max_budget && $cat->max_budget > 0;
                $pctColor = $pct >= 100 ? 'var(--danger)' : ($pct >= 75 ? 'var(--warning)' : 'var(--success)');
            @endphp
            <div class="cat-card {{ $isOver ? 'over-budget' : '' }}">
                <div class="cat-left">
                    <span class="cat-dot" style="background:{{ $color }}"></span>
                    <div>
                        <div class="cat-name">
                            {{ $cat->name }}
                            @if($isOver)
                                <span class="over-badge">⚠ Over Budget</span>
                            @endif
                        </div>
                        <div class="cat-budget-txt">Budget: Rp {{ number_format($cat->max_budget,0,',','.') }}</div>
                        <div class="period-note">Reset: {{ $user->payday_date ? 'tgl '.$user->payday_date.' setiap bulan' : 'setiap awal bulan' }}</div>
                    </div>
                </div>
                <div style="text-align:right">
                    <div class="cat-usage">Rp {{ number_format($used,0,',','.') }} terpakai</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width:{{ $pct }}%;background:{{ $pctColor }}"></div>
                    </div>
                    @if($pct >= 100)
                        <div class="status-danger">⚠ Batas budget tercapai!</div>
                    @elseif($pct >= 75)
                        <div class="status-warn">{{ round($pct) }}% terpakai</div>
                    @else
                        <div class="status-ok">✓ Aman ({{ round($pct) }}%)</div>
                    @endif
                </div>
                <form method="POST" action="{{ route('categories.destroy',$cat) }}" style="margin-left:16px" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus</button>
                </form>
            </div>
        @endforeach
    </div>
@endif
</x-spendwise>
