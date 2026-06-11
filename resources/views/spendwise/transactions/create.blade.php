<x-spendwise title="Tambah Transaksi">
<style>
    .form-card { background: #fff; border-radius: 10px; border: 1px solid #E2E6F0; padding: 1.5rem; max-width: 480px; }
    .form-card h2 { font-size: 14px; font-weight: 600; color: #1A2035; margin-bottom: 1.25rem; padding-bottom: 12px; border-bottom: 1px solid #F0F2F8; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: 12px; color: #6B7280; margin-bottom: 5px; font-weight: 500; }
    .form-group input, .form-group select, .form-group textarea {
        width: 100%; border: 1px solid #E2E6F0; border-radius: 8px;
        padding: 10px 12px; font-size: 13px; color: #1A2035;
        background: #fff; outline: none; transition: border .15s;
    }
    .form-group input:focus, .form-group select:focus { border-color: #6C63FF; box-shadow: 0 0 0 3px rgba(108,99,255,.08); }
    .form-group .error { font-size: 11px; color: #DC2626; margin-top: 4px; }

    .type-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .type-option { position: relative; }
    .type-option input[type="radio"] { position: absolute; opacity: 0; }
    .type-option label {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        padding: 10px; border: 1px solid #E2E6F0; border-radius: 8px;
        cursor: pointer; font-size: 13px; color: #6B7280; transition: all .15s;
    }
    .type-option input[type="radio"]:checked + label { border-color: #6C63FF; background: #F5F3FF; color: #6C63FF; font-weight: 500; }

    .form-actions { display: flex; gap: 10px; margin-top: 1.25rem; }
    .btn-primary { background: #6C63FF; color: #fff; border: none; border-radius: 8px; padding: 10px 20px; font-size: 13px; cursor: pointer; font-weight: 500; }
    .btn-primary:hover { background: #5A52E0; }
    .btn-secondary { background: #fff; color: #6B7280; border: 1px solid #E2E6F0; border-radius: 8px; padding: 10px 20px; font-size: 13px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; }
    .btn-secondary:hover { background: #F9FAFB; }

    .info-box { background: #F5F3FF; border: 1px solid #DDD6FE; border-radius: 8px; padding: 10px 14px; margin-bottom: 1.25rem; font-size: 12px; color: #5B21B6; display: flex; align-items: center; gap: 8px; }
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
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Jenis Transaksi</label>
            <div class="type-selector">
                <div class="type-option">
                    <input type="radio" name="type" id="pemasukan" value="pemasukan" {{ old('type','pengeluaran') == 'pemasukan' ? 'checked' : '' }}>
                    <label for="pemasukan">↓ Pemasukan</label>
                </div>
                <div class="type-option">
                    <input type="radio" name="type" id="pengeluaran" value="pengeluaran" {{ old('type','pengeluaran') == 'pengeluaran' ? 'checked' : '' }}>
                    <label for="pengeluaran">↑ Pengeluaran</label>
                </div>
            </div>
            @error('type')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Jumlah (Rp)</label>
            <input type="number" name="amount" placeholder="Contoh: 150000" required min="1" value="{{ old('amount') }}">
            @error('amount')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Deskripsi <span style="color:#9CA3AF">(opsional)</span></label>
            <input type="text" name="description" placeholder="Contoh: Bayar UKT semester 1" value="{{ old('description') }}">
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="date" required value="{{ old('date', date('Y-m-d')) }}">
            @error('date')<p class="error">{{ $message }}</p>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan Transaksi</button>
            <a href="{{ route('transactions.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
</x-spendwise>
