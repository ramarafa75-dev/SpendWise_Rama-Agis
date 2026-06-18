<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendWise — Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        body {
            font-family:'Poppins',system-ui,sans-serif;
            display:flex; height:100vh; overflow:hidden;
            -webkit-font-smoothing:antialiased;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width:55%;
            background: linear-gradient(135deg, #0D1117 0%, #1A1F35 50%, #0D1117 100%);
            display:flex; flex-direction:column;
            justify-content:space-between;
            padding:2.5rem;
            position:relative;
            overflow:hidden;
        }

        /* Decorative circles */
        .left-panel::before {
            content:'';
            position:absolute; top:-120px; right:-120px;
            width:400px; height:400px;
            border-radius:50%;
            background:rgba(108,99,255,.08);
            pointer-events:none;
        }
        .left-panel::after {
            content:'';
            position:absolute; bottom:-100px; left:-80px;
            width:350px; height:350px;
            border-radius:50%;
            background:rgba(108,99,255,.06);
            pointer-events:none;
        }

        /* Logo area */
        .left-logo { display:flex; align-items:center; gap:10px; z-index:1; position:relative; }
        .left-logo-icon { width:38px; height:38px; background:#6C63FF; border-radius:10px; display:flex; align-items:center; justify-content:center; }
        .left-logo-icon svg { width:20px; height:20px; fill:none; stroke:#fff; stroke-width:2; }
        .left-logo span { font-size:18px; font-weight:700; color:#fff; letter-spacing:-.5px; }

        /* Headline */
        .left-hero { z-index:1; position:relative; }
        .left-hero p { font-size:13px; color:#8B949E; margin-bottom:12px; letter-spacing:.3px; }
        .left-hero h1 { font-size:38px; font-weight:800; color:#fff; line-height:1.15; letter-spacing:-1px; }
        .left-hero h1 span { color:#6C63FF; }
        .left-hero .sub { font-size:14px; color:#8B949E; margin-top:14px; line-height:1.7; max-width:380px; }

        /* Mock dashboard cards */
        .mock-cards { z-index:1; position:relative; display:flex; flex-direction:column; gap:12px; }
        .mock-card { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); border-radius:12px; padding:1rem 1.25rem; backdrop-filter:blur(10px); }
        .mock-card-row { display:flex; align-items:center; justify-content:space-between; }
        .mock-label { font-size:11px; color:#8B949E; margin-bottom:5px; }
        .mock-value { font-size:18px; font-weight:700; color:#fff; }
        .mock-badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }
        .mock-badge.up { background:rgba(74,222,128,.15); color:#4ADE80; }
        .mock-badge.down { background:rgba(248,113,113,.15); color:#F87171; }
        .mock-bars { display:flex; align-items:flex-end; gap:5px; height:40px; }
        .mock-bar { width:10px; border-radius:4px 4px 0 0; background:rgba(108,99,255,.4); }
        .mock-bar.active { background:#6C63FF; }

        /* Left footer */
        .left-footer { font-size:11px; color:#484F58; z-index:1; position:relative; }

        /* ── RIGHT PANEL ── */
        .right-panel {
            width:45%;
            background:#fff;
            display:flex; flex-direction:column;
            justify-content:space-between;
            padding:2.5rem 3.5rem;
        }

        .right-top { display:flex; justify-content:flex-end; }
        .right-top a { font-size:13px; color:#6B7280; text-decoration:none; display:flex; align-items:center; gap:5px; }
        .right-top a:hover { color:#6C63FF; }
        .right-top a svg { width:15px; height:15px; }

        /* Form area */
        .form-area { flex:1; display:flex; flex-direction:column; justify-content:center; max-width:360px; }
        .form-title { font-size:28px; font-weight:700; color:#0F1623; margin-bottom:6px; letter-spacing:-.5px; }
        .form-sub { font-size:13px; color:#9CA3AF; margin-bottom:2rem; }

        .form-group { margin-bottom:1.1rem; }
        .form-label { display:block; font-size:12px; font-weight:500; color:#374151; margin-bottom:6px; }
        .form-input {
            width:100%; border:1.5px solid #E5E7EB; border-radius:9px;
            padding:11px 14px; font-size:13.5px; color:#0F1623;
            outline:none; transition:all .15s; font-family:'Poppins',sans-serif;
            background:#FAFAFA;
        }
        .form-input:focus { border-color:#6C63FF; background:#fff; box-shadow:0 0 0 4px rgba(108,99,255,.1); }
        .form-input::placeholder { color:#9CA3AF; }

        .input-wrap { position:relative; }
        .input-wrap .toggle-pw { position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9CA3AF; padding:4px; }
        .input-wrap .toggle-pw:hover { color:#6C63FF; }
        .input-wrap .toggle-pw svg { width:16px; height:16px; }

        .form-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; }
        .remember-label { display:flex; align-items:center; gap:7px; font-size:12.5px; color:#6B7280; cursor:pointer; }
        .remember-label input { width:15px; height:15px; accent-color:#6C63FF; cursor:pointer; }
        .forgot-link { font-size:12.5px; color:#6C63FF; text-decoration:none; }
        .forgot-link:hover { text-decoration:underline; }

        .btn-login {
            width:100%; background:#6C63FF; color:#fff; border:none; border-radius:9px;
            padding:12px; font-size:14px; font-weight:600; cursor:pointer;
            font-family:'Poppins',sans-serif; transition:all .2s;
            display:flex; align-items:center; justify-content:center; gap:8px;
        }
        .btn-login:hover { background:#5A52E0; box-shadow:0 4px 15px rgba(108,99,255,.4); transform:translateY(-1px); }
        .btn-login:active { transform:translateY(0); }
        .btn-login svg { width:16px; height:16px; }

        .divider { display:flex; align-items:center; gap:12px; margin:1.25rem 0; }
        .divider::before, .divider::after { content:''; flex:1; height:1px; background:#E5E7EB; }
        .divider span { font-size:11px; color:#9CA3AF; }

        .register-link { text-align:center; font-size:13px; color:#6B7280; }
        .register-link a { color:#6C63FF; text-decoration:none; font-weight:500; }
        .register-link a:hover { text-decoration:underline; }

        .error-alert { background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; padding:10px 14px; margin-bottom:1rem; font-size:12.5px; color:#DC2626; }

        /* Right footer */
        .right-footer { font-size:11px; color:#9CA3AF; text-align:center; }
    </style>
</head>
<body>

{{-- LEFT PANEL --}}
<div class="left-panel">
    <div class="left-logo">
        <div class="left-logo-icon">
            <svg viewBox="0 0 24 24"><path d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7"/><path d="M3 10h18M7 15h2M7 12h2"/><circle cx="18" cy="18" r="3"/><path d="M18 16v2l1 1"/></svg>
        </div>
        <span>SpendWise</span>
    </div>

    <div class="left-hero">
        <p>Pencatatan keuangan pribadi mahasiswa</p>
        <h1>Kelola<br>keuanganmu<br><span>lebih cerdas.</span></h1>
        <p class="sub">Catat pemasukan & pengeluaran, pantau anggaran, dan lihat laporan keuanganmu dalam satu tempat.</p>
    </div>

    <div class="left-footer">
        Kelola keuangan pribadi dengan lebih bijak bersama SpendWise.
    </div>
</div>

{{-- RIGHT PANEL --}}
<div class="right-panel">
    <div class="right-top">
        @if (Route::has('register'))
        <a href="{{ route('register') }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            Daftar Akun
        </a>
        @endif
    </div>

    <div class="form-area">
        <div class="form-title">Selamat Datang 👋</div>
        <div class="form-sub">Masuk untuk melanjutkan ke SpendWise</div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="error-alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-input"
                    placeholder="contoh@email.com" required autofocus
                    value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password" class="form-input"
                        placeholder="••••••••" required style="padding-right:42px">
                    <button type="button" class="toggle-pw" onclick="togglePassword()" title="Tampilkan password">
                        <svg id="eye-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="form-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="btn-login">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Masuk ke SpendWise
            </button>

            @if (Route::has('register'))
                <div class="divider"><span>atau</span></div>
                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                </div>
            @endif
        </form>
    </div>

    <div class="right-footer">
        © {{ date('Y') }} SpendWise &nbsp;·&nbsp; Dibuat dengan Laravel {{ app()->version() }}
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="2"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
</script>
</body>
</html>