<x-spendwise title="Tambah Transaksi">
<style>
    .form-card { background:#161B22; border-radius:10px; border:1px solid #21262D; padding:1.5rem; max-width:500px; margin:0 auto; box-shadow:0 1px 4px rgba(0,0,0,.3); }
    .form-card h2 { font-size:14px; font-weight:600; color:#E6EDF3; margin-bottom:1.25rem; padding-bottom:12px; border-bottom:1px solid #21262D; }
    .form-group { margin-bottom:1rem; }
    .form-group label { display:block; font-size:12px; color:#8B949E; margin-bottom:5px; font-weight:500; }
    .form-group input, .form-group select {
        width:100%; background:#0D1117; border:1px solid #21262D; border-radius:8px;
        padding:10px 12px; font-size:13px; color:#E6EDF3; outline:none;
        transition:border .15s; font-family:'Poppins',sans-serif;
    }
    .form-group input:focus, .form-group select:focus { border-color:#6C63FF; box-shadow:0 0 0 3px rgba(108,99,255,.12); }
    .form-group input::placeholder { color:#484F58; }
    .form-group select option { background:#161B22; color:#E6EDF3; }
    .error-msg { font-size:11px; color:#F87171; margin-top:4px; }

    .type-selector { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
    .type-option { position:relative; }
    .type-option input[type="radio"] { position:absolute; opacity:0; }
    .type-option label {
        display:flex; align-items:center; justify-content:center; gap:6px;
        padding:10px; border:1px solid #21262D; border-radius:8px;
        cursor:pointer; font-size:13px; color:#484F58; transition:all .15s; background:#0D1117;
    }
    .type-option input[type="radio"]:checked + label { border-color:#6C63FF; background:rgba(108,99,255,.15); color:#A5B4FC; font-weight:500; }

    .info-box { background:rgba(108,99,255,.1); border:1px solid rgba(108,99,255,.2); border-radius:8px; padding:10px 14px; margin-bottom:1.25rem; font-size:12px; color:#A5B4FC; display:flex; align-items:center; gap:8px; }

    .form-actions { display:flex; gap:10px; margin-top:1.25rem; }
    .btn-primary { background:#6C63FF; color:#fff; border:none; border-radius:8px; padding:10px 20px; font-size:13px; cursor:pointer; font-weight:500; font-family:'Poppins',sans-serif; }
    .btn-primary:hover { background:#5A52E0; }
    .btn-secondary { background:transparent; color:#8B949E; border:1px solid #21262D; border-radius:8px; padding:10px 20px; font-size:13px; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; font-family:'Poppins',sans-serif; }
    .btn-secondary:hover { background:#21262D; color:#E6EDF3; }
</style>

<div class="form-card">
    <h2>Catat Transaksi Baru</h2>

    <div class="info-box">
        💱 Jumlah akan otomatis dikonversi ke USD menggunakan kurs terkini.
    </div>

    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf

        <div class="form-group">
            <label>Kategori</label>
            <select name="category_id" required>
                <option value="">— Pilih Kategori —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Jenis Transaksi</label>
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
            @error('type')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Jumlah (Rp)</label>
            <input type="number" name="amount" placeholder="Contoh: 150000" required min="1" value="{{ old('amount') }}">
            @error('amount')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Deskripsi <span style="color:#484F58">(opsional)</span></label>
            <input type="text" name="description" placeholder="Contoh: Bayar UKT semester 1" value="{{ old('description') }}">
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="date" required value="{{ old('date', date('Y-m-d')) }}">
            @error('date')<p class="error-msg">{{ $message }}</p>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan Transaksi</button>
            <a href="{{ route('transactions.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
</x-spendwise>
