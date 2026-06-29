<x-spendwise title="Kategori Anggaran">
<style>
    .add-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.25rem; margin-bottom:1.25rem; box-shadow:var(--shadow); }
    .add-card h2 { font-size:13px; font-weight:600; color:#1B4F8C; margin-bottom:1rem; }
    .form-row { display:grid; grid-template-columns:1fr 1fr auto; gap:10px; align-items:flex-end; }
    .cat-list { display:flex; flex-direction:column; gap:10px; }
    .cat-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1rem 1.25rem; display:flex; align-items:center; justify-content:space-between; box-shadow:var(--shadow); }
    .cat-left { display:flex; align-items:center; gap:12px; }
    .cat-dot { width:11px; height:11px; border-radius:50%; flex-shrink:0; }
    .cat-name { font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:3px; }
    .cat-budget-txt { font-size:12px; color:var(--text-muted); }
    .cat-usage { font-size:13px; font-weight:600; color:var(--text-primary); margin-bottom:4px; }
    .progress-bar { width:140px; height:5px; background:var(--border); border-radius:10px; overflow:hidden; }
    .progress-fill { height:100%; border-radius:10px; }
    .page-sub { font-size:12px; color:var(--text-muted); margin-bottom:1rem; }
    .btn-primary { background:#1B4F8C; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; cursor:pointer; font-weight:500; font-family:'Poppins',sans-serif; }

    @php $colors = ['#7C6FFF','#EF4444','#F59E0B','#10B981','#3B82F6','#EC4899','#8B5CF6','#14B8A6']; @endphp
</style>

<p class="page-sub">{{ $categories->count() }} kategori aktif</p>

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

@if($categories->isEmpty())
    <div class="empty-state" style="background:var(--bg-card);border-radius:10px;border:1px solid var(--border)">Belum ada kategori. Tambahkan di atas untuk mulai mencatat.</div>
@else
    <div class="cat-list">
        @foreach($categories as $i => $cat)
            @php
                $color=$colors[$i%count($colors)];
                $used=$cat->transactions->sum('amount');
                $pct=$cat->max_budget>0?min(100,($used/$cat->max_budget)*100):0;
                $pctColor=$pct>=100?'var(--danger)':($pct>=75?'var(--warning)':'var(--success)');
            @endphp
            <div class="cat-card">
                <div class="cat-left">
                    <span class="cat-dot" style="background:{{ $color }}"></span>
                    <div>
                        <div class="cat-name">{{ $cat->name }}</div>
                        <div class="cat-budget-txt">Budget: Rp {{ number_format($cat->max_budget,0,',','.') }}</div>
                    </div>
                </div>
                <div style="text-align:right">
                    <div class="cat-usage">Rp {{ number_format($used,0,',','.') }} terpakai</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width:{{ $pct }}%;background:{{ $color }}"></div>
                    </div>
                    @if($pct>=100) <div style="font-size:11px;color:var(--danger);margin-top:3px">⚠ Batas tercapai!</div>
                    @elseif($pct>=75) <div style="font-size:11px;color:var(--warning);margin-top:3px">{{ round($pct) }}% terpakai</div>
                    @else <div style="font-size:11px;color:var(--success);margin-top:3px">✓ Aman ({{ round($pct) }}%)</div>
                    @endif
                </div>
                <form method="POST" action="{{ route('categories.destroy',$cat) }}" style="margin-left:16px" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger">Hapus</button>
                </form>
            </div>
        @endforeach
    </div>
@endif
</x-spendwise>
