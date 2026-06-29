<x-spendwise title="Tambah Transaksi">
<style>
    .form-card { background:var(--bg-card); border-radius:10px; border:1px solid var(--border); padding:1.5rem; max-width:500px; margin:0 auto; box-shadow:var(--shadow); }
    .form-card h2 { font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:1.25rem; padding-bottom:12px; border-bottom:1px solid var(--border); }
    .info-box { background:rgba(108,99,255,.1); border:1px solid rgba(108,99,255,.2); border-radius:8px; padding:10px 14px; margin-bottom:1.25rem; font-size:12px; color:#A5B4FC; display:flex; align-items:center; gap:8px; }
    .type-selector { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
    .type-option { position:relative; }
    .type-option input[type="radio"] { position:absolute; opacity:0; }
    .type-option label { display:flex; align-items:center; justify-content:center; gap:6px; padding:10px; border:1px solid var(--border); border-radius:8px; cursor:pointer; font-size:13px; color:var(--text-muted); transition:all .15s; background:var(--bg-input); }
    .type-option input[type="radio"]:checked + label { border-color:var(--accent); background:rgba(108,99,255,.12); color:#A5B4FC; font-weight:500; }
    .form-actions { display:flex; gap:10px; margin-top:1.25rem; }
    .btn-primary { background:#1B4F8C; color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; cursor:pointer; font-weight:500; font-family:'Poppins',sans-serif; }
    .btn-primary:hover { background:var(--accent); transform: translateY(1px);}
    .btn-secondary:hover { background:var(--bg-row); border-color:var(--accent);}

</style>

<div class="form-card">
    <h2>Catat Transaksi Baru</h2>

    <div class="info-box">
        💱 Jumlah akan otomatis dikonversi ke USD menggunakan kurs terkini.
    </div>

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf

        <div class="sw-form-group">
            <label class="sw-label">Kategori</label>
            <select name="category_id" class="sw-select" required>
                <option value="">— Pilih Kategori —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="sw-error">{{ $message }}</p>@enderror
        </div>

        <div class="sw-form-group">
            <label class="sw-label">Jenis Transaksi</label>
            <div class="type-selector">
                <div class="type-option">
                    <input type="radio" name="type" id="pemasukan" value="pemasukan" {{ old('type','pengeluaran')=='pemasukan'?'checked':'' }}>
                    <label for="pemasukan">↓ Pemasukan</label>
                </div>
                <div class="type-option">
                    <input type="radio" name="type" id="pengeluaran" value="pengeluaran" {{ old('type','pengeluaran')=='pengeluaran'?'checked':'' }}>
                    <label for="pengeluaran">↑ Pengeluaran</label>
                </div>
            </div>
            @error('type')<p class="sw-error">{{ $message }}</p>@enderror
        </div>

        <div class="sw-form-group">
            <label class="sw-label">Jumlah (Rp)</label>
            <input type="number" name="amount" class="sw-input" placeholder="Contoh: 150000" required min="1" value="{{ old('amount') }}">
            @error('amount')<p class="sw-error">{{ $message }}</p>@enderror
        </div>

        <div class="sw-form-group">
            <label class="sw-label">Deskripsi <span style="color:var(--text-muted)">(opsional)</span></label>
            <input type="text" name="description" class="sw-input" placeholder="Contoh: Bayar UKT semester 1" value="{{ old('description') }}">
        </div>

        <div class="sw-form-group">
            <label class="sw-label">Tanggal</label>
            <input type="date" name="date" class="sw-input" required value="{{ old('date', date('Y-m-d')) }}">
            @error('date')<p class="sw-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan Transaksi</button>
            <a href="{{ route('transactions.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
</x-spendwise>
