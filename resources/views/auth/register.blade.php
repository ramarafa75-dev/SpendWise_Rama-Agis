<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendWise — Daftar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'Poppins',system-ui,sans-serif; display:flex; height:100vh; overflow:hidden; -webkit-font-smoothing:antialiased; }

        .left-panel {
            width:45%; background:linear-gradient(135deg,#0D1117 0%,#1A1F35 50%,#0D1117 100%);
            display:flex; flex-direction:column; justify-content:space-between; padding:2.5rem; position:relative; overflow:hidden;
        }
        .left-panel::before { content:''; position:absolute; top:-120px; right:-120px; width:400px; height:400px; border-radius:50%; background:rgba(108,99,255,.08); }
        .left-panel::after { content:''; position:absolute; bottom:-100px; left:-80px; width:350px; height:350px; border-radius:50%; background:rgba(108,99,255,.06); }
        .left-logo { display:flex; align-items:center; gap:10px; z-index:1; position:relative; }
        .left-logo-icon { width:38px; height:38px; background:#6C63FF; border-radius:10px; display:flex; align-items:center; justify-content:center; }
        .left-logo-icon svg { width:20px; height:20px; fill:none; stroke:#fff; stroke-width:2; }
        .left-logo span { font-size:18px; font-weight:700; color:#fff; letter-spacing:-.5px; }
        .left-hero { z-index:1; position:relative; }
        .left-hero p { font-size:13px; color:#8B949E; margin-bottom:12px; }
        .left-hero h1 { font-size:34px; font-weight:800; color:#fff; line-height:1.2; letter-spacing:-1px; }
        .left-hero h1 span { color:#6C63FF; }
        .left-hero .sub { font-size:13px; color:#8B949E; margin-top:14px; line-height:1.7; }

        .features { z-index:1; position:relative; display:flex; flex-direction:column; gap:12px; }
        .feature-item { display:flex; align-items:center; gap:12px; }
        .feature-icon { width:36px; height:36px; background:rgba(108,99,255,.15); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .feature-icon svg { width:16px; height:16px; fill:none; stroke:#7C6FFF; stroke-width:2; }
        .feature-text p { font-size:13px; font-weight:500; color:#E6EDF3; }
        .feature-text span { font-size:11px; color:#8B949E; }
        .left-footer { font-size:11px; color:#484F58; z-index:1; position:relative; }

        /* RIGHT */
        .right-panel { width:55%; background:#fff; display:flex; flex-direction:column; justify-content:space-between; padding:2.5rem 3.5rem; overflow-y:auto; }
        .right-top { display:flex; justify-content:flex-end; }
        .right-top a { font-size:13px; color:#6B7280; text-decoration:none; display:flex; align-items:center; gap:5px; }
        .right-top a:hover { color:#6C63FF; }
        .right-top a svg { width:15px; height:15px; }
        .form-area { flex:1; display:flex; flex-direction:column; justify-content:center; max-width:400px; }
        .form-title { font-size:26px; font-weight:700; color:#0F1623; margin-bottom:6px; letter-spacing:-.5px; }
        .form-sub { font-size:13px; color:#9CA3AF; margin-bottom:1.75rem; }
        .form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .form-group { margin-bottom:1rem; }
        .form-label { display:block; font-size:12px; font-weight:500; color:#374151; margin-bottom:6px; }
        .form-input { width:100%; border:1.5px solid #E5E7EB; border-radius:9px; padding:11px 14px; font-size:13.5px; color:#0F1623; outline:none; transition:all .15s; font-family:'Poppins',sans-serif; background:#FAFAFA; }
        .form-input:focus { border-color:#6C63FF; background:#fff; box-shadow:0 0 0 4px rgba(108,99,255,.1); }
        .form-input::placeholder { color:#9CA3AF; }
        .btn-register { width:100%; background:#6C63FF; color:#fff; border:none; border-radius:9px; padding:12px; font-size:14px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; transition:all .2s; display:flex; align-items:center; justify-content:center; gap:8px; margin-top:1.25rem; }
        .btn-register:hover { background:#5A52E0; box-shadow:0 4px 15px rgba(108,99,255,.4); transform:translateY(-1px); }
        .btn-register svg { width:16px; height:16px; }
        .login-link { text-align:center; font-size:13px; color:#6B7280; margin-top:1rem; }
        .login-link a { color:#6C63FF; text-decoration:none; font-weight:500; }
        .error-alert { background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; padding:10px 14px; margin-bottom:1rem; font-size:12.5px; color:#DC2626; }
        .right-footer { font-size:11px; color:#9CA3AF; text-align:center; margin-top:1.5rem; }
    </style>
</head>
<body>

<div class="left-panel">
    <div class="left-logo">
        <div class="left-logo-icon">
            <svg viewBox="0 0 24 24"><path d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7"/><path d="M3 10h18M7 15h2M7 12h2"/><circle cx="18" cy="18" r="3"/><path d="M18 16v2l1 1"/></svg>
        </div>
        <span>SpendWise</span>
    </div>

    <div class="left-hero">
        <p>Mulai perjalanan finansialmu</p>
        <h1>Daftar &<br>mulai <span>catat</span><br>keuanganmu.</h1>
        <p class="sub">Gratis selamanya. Tidak perlu kartu kredit. Mulai dalam 1 menit.</p>
    </div>

    <div class="features">
        <div class="feature-item">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="feature-text">
                <p>Catat Pemasukan & Pengeluaran</p>
                <span>Kelola semua transaksi dalam satu tempat</span>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div class="feature-text">
                <p>Statistik & Grafik Visual</p>
                <span>Lihat pola pengeluaran dengan chart interaktif</span>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
            </div>
            <div class="feature-text">
                <p>Laporan Bulanan & Print</p>
                <span>Ekspor laporan keuangan kapan saja</span>
            </div>
        </div>
    </div>

    <div class="left-footer">© {{ date('Y') }} SpendWise — Pencatatan Keuangan Pribadi</div>
</div>

<div class="right-panel">
    <div class="right-top">
        <a href="{{ route('login') }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            Sudah punya akun
        </a>
    </div>

    <div class="form-area">
        <div class="form-title">Buat Akun Baru</div>
        <div class="form-sub">Isi data di bawah untuk mulai menggunakan SpendWise</div>

        @if ($errors->any())
            <div class="error-alert">
                @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-input" placeholder="contoh@email.com" required value="{{ old('email') }}">
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Min. 8 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Buat Akun SpendWise
            </button>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </form>
    </div>

    <div class="right-footer">
        © {{ date('Y') }} SpendWise &nbsp;·&nbsp; Dibuat dengan Laravel {{ app()->version() }}
    </div>
</div>

</body>
</html>