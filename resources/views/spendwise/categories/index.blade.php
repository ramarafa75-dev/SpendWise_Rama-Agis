<x-spendwise title="Kategori Anggaran">
<style>
    .add-card { background:#161B22; border-radius:10px; border:1px solid #21262D; padding:1.25rem; margin-bottom:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,.3); }
    .add-card h2 { font-size:13px; font-weight:600; color:#E6EDF3; margin-bottom:1rem; }
    .form-row { display:grid; grid-template-columns:1fr 1fr auto; gap:10px; align-items:flex-end; }
    .form-group label { display:block; font-size:11px; color:#484F58; margin-bottom:5px; font-weight:500; }
    .form-group input { width:100%; background:#0D1117; border:1px solid #21262D; border-radius:7px; padding:9px 12px; font-size:13px; color:#E6EDF3; outline:none; font-family:'Poppins',sans-serif; }
    .form-group input:focus { border-color:#6C63FF; box-shadow:0 0 0 3px rgba(108,99,255,.15); }
    .form-group input::placeholder { color:#484F58; }
    .btn-primary { background:#6C63FF; color:#fff; border:none; border-radius:8px; padding:10px 18px; font-size:13px; cursor:pointer; font-weight:500; font-family:'Poppins',sans-serif; }
    .btn-primary:hover { background:#5A52E0; }
    .error-msg { font-size:11px; color:#F87171; margin-top:4px; }

    .page-sub { font-size:12px; color:#484F58; margin-bottom:1rem; }
    .cat-list { display:flex; flex-direction:column; gap:10px; }
    .cat-card { background:#161B22; border-radius:10px; border:1px solid #21262D; padding:1rem 1.25rem; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 4px rgba(0,0,0,.3); }
    .cat-left { display:flex; align-items:center; gap:12px; }
    .cat-dot { width:11px; height:11px; border-radius:50%; flex-shrink:0; }
    .cat-name { font-size:14px; font-weight:600; color:#E6EDF3; margin-bottom:3px; }
    .cat-budget { font-size:12px; color:#484F58; }
    .cat-usage { font-size:13px; font-weight:600; color:#E6EDF3; margin-bottom:4px; }
    .progress-bar { width:140px; height:5px; background:#21262D; border-radius:10px; overflow:hidden; }
    .progress-fill { height:100%; border-radius:10px; }
    .status-ok { font-size:11px; color:#4ADE80; margin-top:3px; }
    .status-warn { font-size:11px; color:#FBBF24; margin-top:3px; }
    .status-danger { font-size:11px; color:#F87171; margin-top:3px; }
    .btn-delete { background:none; border:none; color:#F87171; font-size:12px; cursor:pointer; padding:6px 10px; border-radius:6px; font-family:'Poppins',sans-serif; }
    .btn-delete:hover { background:rgba(248,113,113,.1); }
    .empty-state { text-align:center; padding:3rem; color:#484F58; font-size:13px; background:#161B22; border-radius:10px; border:1px solid #21262D; }

    @php $colors = ['#7C6FFF','#EF4444','#F59E0B','#10B981','#3B82F6','#EC4899','#8B5CF6','#14B8A6']; @endphp
</style>

<p class="page-sub">{{ $categories->count() }} kategori aktif</p>

<div class="add-card">
    <h2>Tambah Kategori Baru</h2>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" placeholder="Makanan, Kost, Kuliah..." required value="{{ old('name') }}">
                @error('name')<p class="error-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label>Maksimal Budget (Rp)</label>
                <input type="number" name="max_budget" placeholder="0" required value="{{ old('max_budget') }}">
                @error('max_budget')<p class="error-msg">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn-primary">+ Tambah</button>
            </div>
        </div>
    </form>
</div>

@if($categories->isEmpty())
    <div class="empty-state">Belum ada kategori. Tambahkan di atas untuk mulai mencatat.</div>
@else
    <div class="cat-list">
        @foreach($categories as $i => $cat)
            @php
                $color=$colors[$i%count($colors)];
                $used=$cat->transactions->sum('amount');
                $pct=$cat->max_budget>0?min(100,($used/$cat->max_budget)*100):0;
            @endphp
            <div class="cat-card">
                <div class="cat-left">
                    <span class="cat-dot" style="background:{{ $color }}"></span>
                    <div>
                        <div class="cat-name">{{ $cat->name }}</div>
                        <div class="cat-budget">Budget: Rp {{ number_format($cat->max_budget,0,',','.') }}</div>
                    </div>
                </div>
                <div style="text-align:right">
                    <div class="cat-usage">Rp {{ number_format($used,0,',','.') }} terpakai</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width:{{ $pct }}%;background:{{ $color }}"></div>
                    </div>
                    @if($pct>=100) <div class="status-danger">⚠ Batas tercapai!</div>
                    @elseif($pct>=75) <div class="status-warn">{{ round($pct) }}% terpakai</div>
                    @else <div class="status-ok">✓ Aman ({{ round($pct) }}%)</div>
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
