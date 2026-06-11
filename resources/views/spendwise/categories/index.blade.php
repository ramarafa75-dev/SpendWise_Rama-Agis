<x-spendwise title="Kategori Anggaran">
<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
    .page-header p { font-size: 13px; color: #9CA3AF; }
    .btn-primary { background: #6C63FF; color: #fff; border: none; border-radius: 8px; padding: 9px 16px; font-size: 13px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
    .btn-primary:hover { background: #5A52E0; }

    .add-card { background: #fff; border-radius: 10px; border: 1px solid #E2E6F0; padding: 1.25rem; margin-bottom: 1.25rem; }
    .add-card h2 { font-size: 13px; font-weight: 600; color: #1A2035; margin-bottom: 1rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; align-items: end; }
    .form-group label { display: block; font-size: 11px; color: #9CA3AF; margin-bottom: 5px; }
    .form-group input { width: 100%; border: 1px solid #E2E6F0; border-radius: 7px; padding: 9px 12px; font-size: 13px; color: #1A2035; outline: none; }
    .form-group input:focus { border-color: #6C63FF; }

    .cat-list { display: flex; flex-direction: column; gap: 10px; }
    .cat-card { background: #fff; border-radius: 10px; border: 1px solid #E2E6F0; padding: 1rem 1.25rem; display: flex; align-items: center; justify-content: space-between; }
    .cat-left { display: flex; align-items: center; gap: 12px; }
    .cat-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
    .cat-name { font-size: 14px; font-weight: 500; color: #1A2035; margin-bottom: 4px; }
    .cat-budget { font-size: 12px; color: #9CA3AF; }
    .cat-right { text-align: right; }
    .cat-usage { font-size: 13px; font-weight: 500; color: #1A2035; margin-bottom: 4px; }
    .progress-bar { width: 140px; height: 5px; background: #F0F2F8; border-radius: 10px; overflow: hidden; }
    .progress-fill { height: 100%; border-radius: 10px; transition: width .3s; }
    .status-ok { font-size: 11px; color: #16A34A; margin-top: 3px; }
    .status-warn { font-size: 11px; color: #F59E0B; margin-top: 3px; }
    .status-danger { font-size: 11px; color: #DC2626; margin-top: 3px; }
    .btn-delete { background: none; border: none; color: #EF4444; font-size: 12px; cursor: pointer; padding: 5px 8px; border-radius: 5px; }
    .btn-delete:hover { background: #FEE2E2; }
    .empty-state { text-align: center; padding: 3rem; color: #9CA3AF; font-size: 13px; background: #fff; border-radius: 10px; border: 1px solid #E2E6F0; }

    @php
        $colors = ['#6C63FF','#EF4444','#F59E0B','#10B981','#3B82F6','#EC4899','#8B5CF6','#14B8A6'];
    @endphp
</style>

<div class="page-header">
    <p>{{ $categories->count() }} kategori aktif</p>
</div>

{{-- Form Tambah --}}
<div class="add-card">
    <h2>Tambah Kategori Baru</h2>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" placeholder="Makanan, Kost, Kuliah..." required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label>Maksimal Budget (Rp)</label>
                <input type="number" name="max_budget" placeholder="0" required value="{{ old('max_budget') }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn-primary">+ Tambah</button>
            </div>
        </div>
        @error('name')<p style="color:#DC2626;font-size:11px;margin-top:4px">{{ $message }}</p>@enderror
        @error('max_budget')<p style="color:#DC2626;font-size:11px;margin-top:4px">{{ $message }}</p>@enderror
    </form>
</div>

{{-- List Kategori --}}
@if($categories->isEmpty())
    <div class="empty-state">
        Belum ada kategori. Tambahkan kategori di atas untuk mulai mencatat transaksi.
    </div>
@else
    <div class="cat-list">
        @foreach($categories as $i => $cat)
            @php
                $color = $colors[$i % count($colors)];
                $totalSpend = $cat->transactions->where('type','pengeluaran')->sum('amount');
                $pct = $cat->max_budget > 0 ? min(100, ($totalSpend / $cat->max_budget) * 100) : 0;
            @endphp
            <div class="cat-card">
                <div class="cat-left">
                    <span class="cat-dot" style="background:{{ $color }}"></span>
                    <div>
                        <div class="cat-name">{{ $cat->name }}</div>
                        <div class="cat-budget">Budget: Rp {{ number_format($cat->max_budget, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="cat-right">
                    <div class="cat-usage">Rp {{ number_format($totalSpend, 0, ',', '.') }} terpakai</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width:{{ $pct }}%; background:{{ $color }}"></div>
                    </div>
                    @if($pct >= 100)
                        <div class="status-danger">⚠ Batas budget tercapai!</div>
                    @elseif($pct >= 75)
                        <div class="status-warn">{{ round($pct) }}% terpakai</div>
                    @else
                        <div class="status-ok">✓ Aman ({{ round($pct) }}% terpakai)</div>
                    @endif
                </div>
                <form method="POST" action="{{ route('categories.destroy', $cat) }}" style="margin-left:16px" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus</button>
                </form>
            </div>
        @endforeach
    </div>
@endif
</x-spendwise>
