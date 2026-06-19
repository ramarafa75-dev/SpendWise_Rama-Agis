<x-spendwise title="Profil Saya">
<style>
    .profile-grid { display:grid; grid-template-columns:300px 1fr; gap:20px; }

    /* Left card - avatar */
    .avatar-card { background:var(--bg-card); border-radius:12px; border:1px solid var(--border); padding:2rem; box-shadow:var(--shadow); display:flex; flex-direction:column; align-items:center; text-align:center; }
    .avatar-wrap { position:relative; width:110px; height:110px; margin-bottom:1.25rem; }
    .avatar-img { width:110px; height:110px; border-radius:50%; object-fit:cover; border:3px solid var(--accent); }
    .avatar-placeholder { width:110px; height:110px; border-radius:50%; background:var(--accent); display:flex; align-items:center; justify-content:center; font-size:36px; font-weight:700; color:#fff; border:3px solid var(--accent); }
    .avatar-edit-btn { position:absolute; bottom:4px; right:4px; width:30px; height:30px; background:var(--accent); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; border:2px solid var(--bg-card); }
    .avatar-edit-btn svg { width:13px; height:13px; fill:none; stroke:#fff; stroke-width:2.5; }
    .avatar-name { font-size:16px; font-weight:700; color:var(--text-primary); margin-bottom:4px; }
    .avatar-email { font-size:12px; color:var(--text-muted); margin-bottom:1rem; }
    .avatar-joined { font-size:11px; color:var(--text-muted); background:var(--bg-row); border:1px solid var(--border); border-radius:20px; padding:4px 12px; }

    .avatar-stats { width:100%; margin-top:1.5rem; display:flex; flex-direction:column; gap:10px; }
    .avatar-stat { display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:var(--bg-row); border-radius:8px; border:1px solid var(--border); }
    .avatar-stat-label { font-size:12px; color:var(--text-muted); }
    .avatar-stat-val { font-size:13px; font-weight:600; color:var(--text-primary); }

    /* Right cards - form */
    .right-col { display:flex; flex-direction:column; gap:16px; }
    .form-card { background:var(--bg-card); border-radius:12px; border:1px solid var(--border); padding:1.5rem; box-shadow:var(--shadow); }
    .form-card-title { font-size:14px; font-weight:600; color:var(--text-primary); margin-bottom:4px; }
    .form-card-sub { font-size:12px; color:var(--text-muted); margin-bottom:1.25rem; padding-bottom:1rem; border-bottom:1px solid var(--border); }
    .form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

    /* Upload area */
    .upload-area { border:2px dashed var(--border); border-radius:10px; padding:1.5rem; text-align:center; cursor:pointer; transition:all .2s; margin-bottom:1rem; }
    .upload-area:hover { border-color:var(--accent); background:rgba(108,99,255,.05); }
    .upload-area svg { width:28px; height:28px; margin:0 auto 8px; display:block; }
    .upload-area p { font-size:13px; color:var(--text-secondary); }
    .upload-area span { font-size:11px; color:var(--text-muted); }
    #avatar-preview { display:none; width:80px; height:80px; border-radius:50%; object-fit:cover; margin:0 auto 8px; border:2px solid var(--accent); }

    .divider-section { border:none; border-top:1px solid var(--border); margin:1.25rem 0; }
    .danger-zone { border-color:rgba(248,113,113,.3) !important; }
    .danger-zone .form-card-title { color:var(--danger); }
</style>

@php
    $user = auth()->user();
    $totalTrx = \App\Models\Transaction::where('user_id',$user->id)->count();
    $totalKat = \App\Models\Category::where('user_id',$user->id)->count();
@endphp

<div class="profile-grid">

    {{-- LEFT: Avatar Card --}}
    <div>
        <div class="avatar-card">
            <div class="avatar-wrap">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" class="avatar-img" alt="Avatar">
                @else
                    <div class="avatar-placeholder">{{ strtoupper(substr($user->name,0,1)) }}</div>
                @endif
                <label for="avatar-quick" class="avatar-edit-btn" title="Ganti foto">
                    <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                </label>
            </div>
            <div class="avatar-name">{{ $user->name }}</div>
            <div class="avatar-email">{{ $user->email }}</div>
            <div class="avatar-joined">Bergabung {{ $user->created_at->translatedFormat('F Y') }}</div>

            <div class="avatar-stats">
                <div class="avatar-stat">
                    <span class="avatar-stat-label">Total Transaksi</span>
                    <span class="avatar-stat-val">{{ $totalTrx }}</span>
                </div>
                <div class="avatar-stat">
                    <span class="avatar-stat-label">Total Kategori</span>
                    <span class="avatar-stat-val">{{ $totalKat }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: Forms --}}
    <div class="right-col">

        {{-- Form Update Profil --}}
        <div class="form-card">
            <div class="form-card-title">Informasi Profil</div>
            <div class="form-card-sub">Perbarui nama, email, dan foto profilmu</div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf

                {{-- Upload Area --}}
                <div class="upload-area" onclick="document.getElementById('avatar-quick').click()">
                    <img id="avatar-preview" alt="Preview">
                    <svg viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <p>Klik untuk upload foto profil</p>
                    <span>JPG, PNG, WEBP — Maks. 2MB</span>
                </div>
                <input type="file" id="avatar-quick" name="avatar" accept="image/*" style="display:none" onchange="previewAvatar(this)">

                <div class="form-row-2">
                    <div class="sw-form-group">
                        <label class="sw-label">Nama Lengkap</label>
                        <input type="text" name="name" class="sw-input" value="{{ old('name', $user->name) }}" required>
                        @error('name')<p class="sw-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="sw-form-group">
                        <label class="sw-label">Alamat Email</label>
                        <input type="email" name="email" class="sw-input" value="{{ old('email', $user->email) }}" required>
                        @error('email')<p class="sw-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- Form Ganti Password --}}
        <div class="form-card">
            <div class="form-card-title">Keamanan Akun</div>
            <div class="form-card-sub">Ganti password untuk menjaga keamanan akunmu</div>

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf

                <div class="sw-form-group">
                    <label class="sw-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="sw-input" placeholder="Masukkan password saat ini" required>
                    @error('current_password')<p class="sw-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-row-2">
                    <div class="sw-form-group">
                        <label class="sw-label">Password Baru</label>
                        <input type="password" name="password" class="sw-input" placeholder="Min. 8 karakter" required>
                        @error('password')<p class="sw-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="sw-form-group">
                        <label class="sw-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="sw-input" placeholder="Ulangi password baru" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="background:var(--bg-row);color:var(--text-primary);border:1px solid var(--border)">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
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
