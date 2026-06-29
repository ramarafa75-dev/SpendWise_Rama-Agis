<x-spendwise title="Profil Saya">
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 20px;
        align-items: start;
    }

    /* ── Avatar Card ── */
    .avatar-card {
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 2rem 1.5rem;
        box-shadow: var(--shadow);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .avatar-wrap {
        position: relative;
        width: 100px;
        height: 100px;
        margin-bottom: 1.25rem;
    }
    .avatar-img {
        width: 100px; height: 100px;
        border-radius: 50%; object-fit: cover;
        border: 3px solid var(--accent);
    }
    .avatar-placeholder {
        width: 100px; height: 100px;
        border-radius: 50%;
        background: var(--accent);
        display: flex; align-items: center; justify-content: center;
        font-size: 32px; font-weight: 700; color: #fff;
        border: 3px solid var(--accent);
    }
    .avatar-edit-btn {
        position: absolute; bottom: 2px; right: 2px;
        width: 28px; height: 28px;
        background: var(--accent); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; border: 2px solid var(--bg-card);
        transition: transform .15s;
    }
    .avatar-edit-btn:hover { transform: scale(1.1); }
    .avatar-edit-btn svg { width: 12px; height: 12px; fill: none; stroke: #fff; stroke-width: 2.5; }

    .avatar-name  { font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
    .avatar-email { font-size: 11px; color: var(--text-muted); margin-bottom: 1rem; }
    .avatar-badge {
        font-size: 11px; color: var(--text-muted);
        background: var(--bg-row); border: 1px solid var(--border);
        border-radius: 20px; padding: 4px 12px; margin-bottom: 1.5rem;
    }

    .stat-list { width: 100%; display: flex; flex-direction: column; gap: 8px; }
    .stat-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 9px 12px; background: var(--bg-row);
        border-radius: 8px; border: 1px solid var(--border);
    }
    .stat-row-label { font-size: 11px; color: var(--text-muted); }
    .stat-row-val   { font-size: 13px; font-weight: 600; color: var(--text-primary); }

    /* ── Right Column ── */
    .right-col { display: flex; flex-direction: column; gap: 16px; }

    .form-card {
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 1.5rem;
        box-shadow: var(--shadow);
    }
    .form-card-hd { margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border); }
    .form-card-hd h2 { font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 3px; }
    .form-card-hd p  { font-size: 12px; color: var(--text-muted); }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* Upload area */
    .upload-zone {
        border: 2px dashed var(--border); border-radius: 10px;
        padding: 1.25rem; text-align: center;
        cursor: pointer; transition: all .2s;
        margin-bottom: 1rem;
    }
    .upload-zone:hover { border-color: var(--accent); background: rgba(108,99,255,.05); }
    .upload-zone p    { font-size: 12.5px; color: var(--text-secondary); margin-top: 6px; }
    .upload-zone span { font-size: 11px; color: var(--text-muted); }
    .upload-zone svg  { width: 26px; height: 26px; margin: 0 auto; display: block; }
    #avatar-preview   {
        display: none; width: 70px; height: 70px;
        border-radius: 50%; object-fit: cover;
        margin: 0 auto 8px; border: 2px solid var(--accent);
    }

    /* Btn variants */
    .btn-save {
        background: var(--accent); color: #fff; border: none;
        border-radius: 8px; padding: 10px 20px; font-size: 13px;
        cursor: pointer; font-weight: 500; font-family: 'Poppins', sans-serif;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all .2s;
    }
    .btn-save:hover { opacity: .9; transform: translateY(-1px); }
    .btn-save svg { width: 14px; height: 14px; }

    .btn-pw {
        background: var(--bg-row); color: var(--text-primary);
        border: 1px solid var(--border); border-radius: 8px;
        padding: 10px 20px; font-size: 13px; cursor: pointer;
        font-weight: 500; font-family: 'Poppins', sans-serif;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all .2s;
    }
    .btn-pw:hover { border-color: var(--accent); color: var(--accent); }
    .btn-pw svg { width: 14px; height: 14px; }
</style>

<div class="profile-grid">

    {{-- ── LEFT: Avatar & Stats ── --}}
    <div class="avatar-card">
        <div class="avatar-wrap">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/'.auth()->user()->avatar) }}"
                    class="avatar-img" alt="Foto Profil"
                    onerror="this.style.display='none'">
            @else
                <div class="avatar-placeholder">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <label for="avatar-input" class="avatar-edit-btn" title="Ganti foto">
                <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
            </label>
        </div>

        <div class="avatar-name">{{ $user->name }}</div>
        <div class="avatar-email">{{ $user->email }}</div>
        <div class="avatar-badge">Bergabung {{ $user->created_at->translatedFormat('F Y') }}</div>

        <div class="stat-list">
            <div class="stat-row">
                <span class="stat-row-label">Total Transaksi</span>
                <span class="stat-row-val">{{ $totalTrx }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-row-label">Total Kategori</span>
                <span class="stat-row-val">{{ $totalKat }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-row-label">Total Pemasukan</span>
                <span class="stat-row-val" style="color:var(--success)">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-row-label">Total Pengeluaran</span>
                <span class="stat-row-val" style="color:var(--danger)">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Forms ── --}}
    <div class="right-col">

        {{-- Form Info Profil --}}
        <div class="form-card">
            <div class="form-card-hd">
                <h2>Informasi Profil</h2>
                <p>Perbarui nama, email, dan foto profilmu</p>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Upload Zone --}}
                <div class="upload-zone" onclick="document.getElementById('avatar-input').click()">
                    <img id="avatar-preview" alt="Preview">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    <p>Klik untuk upload foto profil baru</p>
                    <span>JPG, PNG, WEBP — Maksimal 2MB</span>
                </div>
                <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display:none" onchange="previewAvatar(this)">

                <div class="grid-2">
                    <div class="sw-form-group">
                        <label class="sw-label">Nama Lengkap</label>
                        <input type="text" name="name" class="sw-input"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name')<p class="sw-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="sw-form-group">
                        <label class="sw-label">Alamat Email</label>
                        <input type="email" name="email" class="sw-input"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')<p class="sw-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <button type="submit" class="btn-save">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- Form Ganti Password --}}
        <div class="form-card">
            <div class="form-card-hd">
                <h2>Keamanan Akun</h2>
                <p>Ganti password untuk menjaga keamanan akunmu</p>
            </div>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf

                <div class="sw-form-group">
                    <label class="sw-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="sw-input"
                        placeholder="Masukkan password saat ini" required>
                    @error('current_password')<p class="sw-error">{{ $message }}</p>@enderror
                </div>

                <div class="grid-2">
                    <div class="sw-form-group">
                        <label class="sw-label">Password Baru</label>
                        <input type="password" name="password" class="sw-input"
                            placeholder="Minimal 8 karakter" required>
                        @error('password')<p class="sw-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="sw-form-group">
                        <label class="sw-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="sw-input"
                            placeholder="Ulangi password baru" required>
                    </div>
                </div>

                <button type="submit" class="btn-pw">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                    Ubah Password
                </button>
            </form>
        </div>

    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatar-preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</x-spendwise>
