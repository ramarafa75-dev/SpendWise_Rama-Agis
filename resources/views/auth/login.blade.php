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
        html,body { height:100%; }
        body {
            font-family:'Poppins',system-ui,sans-serif;
            -webkit-font-smoothing:antialiased;
            min-height:100vh;
            display:flex; align-items:center; justify-content:center;
            padding:3.5rem 1.5rem;
            background:linear-gradient(180deg,#1B4F8C 0%,#2E72B5 35%,#4F9BD4 65%,#8FD0F5 100%);
            position:relative; overflow-x:hidden;
        }

        /* ── Ambient blurred blobs ── */
        .blob { position:fixed; border-radius:50%; filter:blur(60px); pointer-events:none; z-index:0; }
        .blob-1 { width:380px; height:380px; top:-100px; left:-100px; background:rgba(255,255,255,.12); animation:floatBlob 9s ease-in-out infinite; }
        .blob-2 { width:420px; height:420px; bottom:-140px; right:-120px; background:rgba(60,140,220,.18); animation:floatBlob 11s ease-in-out infinite reverse; }
        .blob-3 { width:260px; height:260px; top:40%; right:10%; background:rgba(255,255,255,.08); animation:floatBlob 7.5s ease-in-out infinite; }
        @keyframes floatBlob {
            0%,100% { transform:translate(0,0) scale(1); }
            50% { transform:translate(20px,-25px) scale(1.08); }
        }

        .page-wrap { position:relative; z-index:1; display:flex; flex-direction:column; align-items:center; width:100%; max-width:380px; perspective:1700px; }

        /* ── BRAND / LOGO BLOCK ── */
        .brand-block {
            display:flex; flex-direction:column; align-items:center; margin-bottom:1.75rem;
            opacity:0; animation:fadeSlideDown .6s cubic-bezier(.16,.84,.44,1) .05s forwards;
        }
        .wallet-logo { position:relative; width:84px; height:84px; margin-bottom:14px; }
        .wallet-badge {
            width:84px; height:84px; border-radius:24px;
            background:linear-gradient(145deg,#4FA8E8,#2E72B5 55%,#1B4F8C);
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 12px 30px rgba(20,45,90,.35), inset 0 1px 0 rgba(255,255,255,.25);
            animation:walletPulse 2.4s ease-in-out infinite;
            position:relative; overflow:visible;
        }
        .wallet-badge svg { width:42px; height:42px; }
        @keyframes walletPulse {
            0%,55% { box-shadow:0 12px 30px rgba(20,45,90,.35), inset 0 1px 0 rgba(255,255,255,.25); }
            65% { box-shadow:0 12px 30px rgba(20,45,90,.35), inset 0 1px 0 rgba(255,255,255,.25), 0 0 0 10px rgba(255,214,107,.18); }
            75%,100% { box-shadow:0 12px 30px rgba(20,45,90,.35), inset 0 1px 0 rgba(255,255,255,.25); }
        }
        /* Falling coins — uang masuk ke dompet */
        .coin {
            position:absolute; top:-26px; left:50%;
            width:15px; height:15px; border-radius:50%;
            background:radial-gradient(circle at 35% 30%, #FFF3C4, #FFD66B 55%, #E8A93E);
            box-shadow:0 0 0 2px rgba(232,169,62,.4), 0 2px 6px rgba(0,0,0,.25);
            opacity:0;
            animation:coinDrop 2.2s cubic-bezier(.5,0,.6,1) infinite;
        }
        .coin::after { content:'$'; position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:8px; font-weight:800; color:#9C6B12; }
        .coin-1 { margin-left:-12px; animation-delay:0s; }
        .coin-2 { margin-left:0px;   animation-delay:.7s; }
        .coin-3 { margin-left:10px; animation-delay:1.4s; }
        @keyframes coinDrop {
            0%   { opacity:0; transform:translateY(0) scale(.5) rotate(0deg); }
            12%  { opacity:1; transform:translateY(8px) scale(1) rotate(40deg); }
            45%  { opacity:1; transform:translateY(34px) scale(.95) rotate(160deg); }
            58%  { opacity:.85; transform:translateY(42px) scale(.7) rotate(190deg); }
            68%  { opacity:0; transform:translateY(46px) scale(.3) rotate(210deg); }
            100% { opacity:0; transform:translateY(46px) scale(.3) rotate(210deg); }
        }
        .brand-name { color:#fff; font-size:23px; font-weight:800; letter-spacing:-.5px; text-shadow:0 2px 12px rgba(0,0,0,.15); }
        .brand-tagline { color:rgba(255,255,255,.82); font-size:12.5px; margin-top:3px; letter-spacing:.2px; }

        /* ── AUTH CARD ── */
        .auth-card {
            width:100%; background:rgba(255,255,255,.97);
            border:1px solid rgba(255,255,255,.5);
            backdrop-filter:blur(20px);
            border-radius:22px; padding:2rem 1.85rem 1.85rem;
            box-shadow:0 30px 70px rgba(30,15,70,.35);
            opacity:0; transform-style:preserve-3d; backface-visibility:hidden;
            animation:cardFlipIn .6s cubic-bezier(.22,.61,.36,1) .18s forwards;
        }
        /* Kartu "dibalik" masuk saat halaman terbuka */
        @keyframes cardFlipIn {
            0%   { opacity:0; transform:rotateY(-110deg) scale(.92); }
            60%  { opacity:1; }
            100% { opacity:1; transform:rotateY(0deg) scale(1); }
        }
        /* Kartu "dibalik" keluar saat pindah ke login/register lain */
        .auth-card.flip-out {
            animation:cardFlipOut .42s cubic-bezier(.4,0,.2,1) forwards !important;
        }
        @keyframes cardFlipOut {
            0%   { opacity:1; transform:rotateY(0deg) scale(1); }
            100% { opacity:0; transform:rotateY(110deg) scale(.92); }
        }
        @keyframes fadeSlideDown { from{opacity:0; transform:translateY(-16px);} to{opacity:1; transform:translateY(0);} }

        .card-title { font-size:23px; font-weight:700; color:#1A1B2E; text-align:center; margin-bottom:4px; letter-spacing:-.4px; }
        .card-sub { font-size:13px; color:#9499AC; text-align:center; margin-bottom:1.6rem; }

        /* Staggered field entrance */
        .anim-field { opacity:0; animation:fieldIn .5s cubic-bezier(.16,.84,.44,1) forwards; }
        @keyframes fieldIn { from{opacity:0; transform:translateY(14px);} to{opacity:1; transform:translateY(0);} }
        .af-1 { animation-delay:.28s; } .af-2 { animation-delay:.36s; } .af-3 { animation-delay:.44s; }
        .af-4 { animation-delay:.52s; } .af-5 { animation-delay:.60s; } .af-6 { animation-delay:.68s; }

        .form-group { margin-bottom:1.05rem; }
        .form-label { display:block; font-size:12px; font-weight:500; color:#374151; margin-bottom:6px; }
        .form-input {
            width:100%; border:1.5px solid #E5E7EB; border-radius:11px;
            padding:11px 14px; font-size:13.5px; color:#0F1623;
            outline:none; transition:all .15s; font-family:'Poppins',sans-serif;
            background:#F8F8FB;
        }
        .form-input:focus { border-color:#6C63FF; background:#fff; box-shadow:0 0 0 4px rgba(108,99,255,.12); }
        .form-input::placeholder { color:#AEB2C2; }

        .input-wrap { position:relative; }
        .input-wrap .toggle-pw { position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#AEB2C2; padding:4px; }
        .input-wrap .toggle-pw:hover { color:#6C63FF; }
        .input-wrap .toggle-pw svg { width:16px; height:16px; }

        .form-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:1.4rem; }
        .remember-label { display:flex; align-items:center; gap:7px; font-size:12.5px; color:#6B7280; cursor:pointer; }
        .remember-label input { width:15px; height:15px; accent-color:#6C63FF; cursor:pointer; }
        .forgot-link { font-size:12.5px; color:#6C63FF; text-decoration:none; font-weight:500; }
        .forgot-link:hover { text-decoration:underline; }

        .btn-login {
            width:100%; background:linear-gradient(120deg,#1B4F8C,#2E72B5 55%,#4FA8E8);
            color:#fff; border:none; border-radius:11px;
            padding:12.5px; font-size:14px; font-weight:600; cursor:pointer;
            font-family:'Poppins',sans-serif; transition:all .2s;
            display:flex; align-items:center; justify-content:center; gap:8px;
        }
        .btn-login:hover { box-shadow:0 8px 22px rgba(46,114,181,.45); transform:translateY(-1px); }
        .btn-login:active { transform:translateY(0); }
        .btn-login svg { width:16px; height:16px; }

        .divider { display:flex; align-items:center; gap:12px; margin:1.4rem 0; }
        .divider::before, .divider::after { content:''; flex:1; height:1px; background:#E5E7EB; }
        .divider span { font-size:11px; color:#9CA3AF; }

        .social-row { display:flex; gap:10px; }
        .btn-social {
            flex:1; display:flex; align-items:center; justify-content:center; gap:7px;
            border:1.5px solid #E5E7EB; border-radius:10px; background:#fff;
            padding:9px; font-size:12.5px; font-weight:500; color:#374151;
            cursor:pointer; font-family:'Poppins',sans-serif; transition:all .15s;
        }
        .btn-social:hover { border-color:#6C63FF; background:#FAFAFF; }
        .btn-social svg { width:16px; height:16px; }

        .register-link { text-align:center; font-size:13px; color:#6B7280; margin-top:1.3rem; }
        .register-link a { color:#6C63FF; text-decoration:none; font-weight:600; }
        .register-link a:hover { text-decoration:underline; }

        .error-alert { background:#FEF2F2; border:1px solid #FECACA; border-radius:10px; padding:10px 14px; margin-bottom:1rem; font-size:12.5px; color:#DC2626; }

        .page-footer { color:rgba(255,255,255,.75); font-size:11.5px; margin-top:1.6rem; text-align:center; opacity:0; animation:fadeSlideDown .6s ease .75s forwards; }

        .toast {
            position:fixed; bottom:24px; left:50%; transform:translateX(-50%) translateY(20px);
            background:#1A1B2E; color:#fff; padding:10px 18px; border-radius:10px; font-size:12.5px;
            opacity:0; pointer-events:none; transition:all .25s ease; z-index:999;
        }
        .toast.show { opacity:1; transform:translateX(-50%) translateY(0); }

        @media (prefers-reduced-motion: reduce) {
            .brand-block,.auth-card,.auth-card.flip-out,.anim-field,.page-footer,.blob,.wallet-badge,.coin { animation:none !important; opacity:1 !important; transform:none !important; }
        }
    </style>
</head>
<body>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>
<div class="blob blob-3"></div>

<div class="page-wrap">

    {{-- BRAND + WALLET LOGO + ANIMASI UANG MASUK --}}
    <div class="brand-block">
        <div class="wallet-logo">
            <div class="wallet-badge">
                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7"/>
                    <path d="M3 10h18"/>
                    <circle cx="18" cy="17" r="3.2" fill="#FFD66B" stroke="none"/>
                    <path d="M18 15.3v1.7l1 1" stroke="#9C6B12" stroke-width="1.4"/>
                </svg>
            </div>
            <div class="coin coin-1"></div>
            <div class="coin coin-2"></div>
            <div class="coin coin-3"></div>
        </div>
        <div class="brand-name">SpendWise</div>
        <div class="brand-tagline">Kelola keuanganmu lebih cerdas</div>
    </div>

    {{-- AUTH CARD --}}
    <div class="auth-card">
        <div class="card-title">Selamat Datang Kembali</div>
        <div class="card-sub">Masuk ke akun SpendWise kamu</div>

        @if ($errors->any())
            <div class="error-alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group anim-field af-1">
                <label class="form-label" for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-input"
                    placeholder="contoh@email.com" required autofocus
                    value="{{ old('email') }}">
            </div>

            <div class="form-group anim-field af-2">
                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password" class="form-input"
                        placeholder="••••••••" required style="padding-right:42px">
                    <button type="button" class="toggle-pw" onclick="togglePassword()" title="Tampilkan password">
                        <svg id="eye-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="form-row anim-field af-3">
                <label class="remember-label">
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                @endif
            </div>

            <div class="anim-field af-4">
                <button type="submit" class="btn-login">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk ke SpendWise
                </button>
            </div>

            <div class="anim-field af-5">
                <div class="divider"><span>atau lanjutkan dengan</span></div>
                <div class="social-row">
                    <button type="button" class="btn-social" onclick="showToast('Login Google segera hadir 🚀')">
                        <svg viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        Google
                    </button>
                </div>
            </div>

            @if (Route::has('register'))
                <div class="register-link anim-field af-6">
                    Belum punya akun? <a href="{{ route('register') }}" class="js-flip-link">Daftar sekarang</a>
                </div>
            @endif
        </form>
    </div>

    <div class="page-footer">
        © {{ date('Y') }} SpendWise &nbsp;·&nbsp; Dibuat dengan Laravel {{ app()->version() }}
    </div>
</div>

<div class="toast" id="toast"></div>

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
let toastTimer;
function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => t.classList.remove('show'), 2200);
}

/* ── Animasi kartu dibalik saat pindah login <-> register ── */
(function() {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    document.querySelectorAll('.js-flip-link').forEach(function (link) {
        link.addEventListener('click', function (e) {
            const card = document.querySelector('.auth-card');
            const href = this.getAttribute('href');
            if (!card || reduceMotion) return; // biarkan navigasi normal
            e.preventDefault();
            if (card.classList.contains('flip-out')) return; // cegah klik ganda
            card.classList.add('flip-out');
            setTimeout(function () { window.location.href = href; }, 380);
        });
    });
})();
</script>
</body>
</html>