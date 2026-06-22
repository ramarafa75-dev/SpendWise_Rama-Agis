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
        html,body { height:100%; }
        body {
            font-family:'Poppins',system-ui,sans-serif;
            -webkit-font-smoothing:antialiased;
            min-height:100vh;
            display:flex; align-items:center; justify-content:center;
            padding:2.5rem 1.5rem;
            background:linear-gradient(135deg,#5B6FE8 0%,#7C6FE0 35%,#8B5FC8 65%,#6A4FB8 100%);
            position:relative; overflow-x:hidden;
        }

        .blob { position:fixed; border-radius:50%; filter:blur(60px); pointer-events:none; z-index:0; }
        .blob-1 { width:380px; height:380px; top:-100px; left:-100px; background:rgba(255,255,255,.12); animation:floatBlob 9s ease-in-out infinite; }
        .blob-2 { width:420px; height:420px; bottom:-140px; right:-120px; background:rgba(108,99,255,.18); animation:floatBlob 11s ease-in-out infinite reverse; }
        .blob-3 { width:260px; height:260px; top:40%; right:10%; background:rgba(255,255,255,.08); animation:floatBlob 7.5s ease-in-out infinite; }
        @keyframes floatBlob {
            0%,100% { transform:translate(0,0) scale(1); }
            50% { transform:translate(20px,-25px) scale(1.08); }
        }

        .page-wrap { position:relative; z-index:1; display:flex; flex-direction:column; align-items:center; width:100%; max-width:440px; }

        .brand-block {
            display:flex; flex-direction:column; align-items:center; margin-bottom:1.6rem;
            opacity:0; animation:fadeSlideDown .6s cubic-bezier(.16,.84,.44,1) .05s forwards;
        }
        .wallet-logo { position:relative; width:84px; height:84px; margin-bottom:14px; }
        .wallet-badge {
            width:84px; height:84px; border-radius:24px;
            background:linear-gradient(145deg,#7C9BFF,#6C63FF 55%,#9B6FFF);
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 12px 30px rgba(40,20,90,.35), inset 0 1px 0 rgba(255,255,255,.25);
            animation:walletPulse 2.4s ease-in-out infinite;
            position:relative; overflow:visible;
        }
        .wallet-badge svg { width:42px; height:42px; }
        @keyframes walletPulse {
            0%,55% { box-shadow:0 12px 30px rgba(40,20,90,.35), inset 0 1px 0 rgba(255,255,255,.25); }
            65% { box-shadow:0 12px 30px rgba(40,20,90,.35), inset 0 1px 0 rgba(255,255,255,.25), 0 0 0 10px rgba(255,214,107,.18); }
            75%,100% { box-shadow:0 12px 30px rgba(40,20,90,.35), inset 0 1px 0 rgba(255,255,255,.25); }
        }
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

        .auth-card {
            width:100%; background:rgba(255,255,255,.97);
            border:1px solid rgba(255,255,255,.5);
            backdrop-filter:blur(20px);
            border-radius:22px; padding:2.25rem 2rem 2rem;
            box-shadow:0 30px 70px rgba(30,15,70,.35);
            opacity:0; animation:cardPop .55s cubic-bezier(.16,.84,.44,1) .18s forwards;
        }
        @keyframes cardPop { from{opacity:0; transform:translateY(22px) scale(.97);} to{opacity:1; transform:translateY(0) scale(1);} }
        @keyframes fadeSlideDown { from{opacity:0; transform:translateY(-16px);} to{opacity:1; transform:translateY(0);} }

        .card-title { font-size:22px; font-weight:700; color:#1A1B2E; text-align:center; margin-bottom:4px; letter-spacing:-.4px; }
        .card-sub { font-size:13px; color:#9499AC; text-align:center; margin-bottom:1.6rem; }

        .anim-field { opacity:0; animation:fieldIn .5s cubic-bezier(.16,.84,.44,1) forwards; }
        @keyframes fieldIn { from{opacity:0; transform:translateY(14px);} to{opacity:1; transform:translateY(0);} }
        .af-1 { animation-delay:.26s; } .af-2 { animation-delay:.33s; } .af-3 { animation-delay:.40s; }
        .af-4 { animation-delay:.47s; } .af-5 { animation-delay:.54s; }

        .form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .form-group { margin-bottom:1rem; }
        .form-label { display:block; font-size:12px; font-weight:500; color:#374151; margin-bottom:6px; }
        .form-input {
            width:100%; border:1.5px solid #E5E7EB; border-radius:11px;
            padding:11px 14px; font-size:13.5px; color:#0F1623;
            outline:none; transition:all .15s; font-family:'Poppins',sans-serif;
            background:#F8F8FB;
        }
        .form-input:focus { border-color:#6C63FF; background:#fff; box-shadow:0 0 0 4px rgba(108,99,255,.12); }
        .form-input::placeholder { color:#AEB2C2; }

        .btn-register {
            width:100%; background:linear-gradient(120deg,#6C63FF,#5B8DEF 60%,#4FC3D9);
            color:#fff; border:none; border-radius:11px;
            padding:12.5px; font-size:14px; font-weight:600; cursor:pointer;
            font-family:'Poppins',sans-serif; transition:all .2s;
            display:flex; align-items:center; justify-content:center; gap:8px; margin-top:.4rem;
        }
        .btn-register:hover { box-shadow:0 8px 22px rgba(108,99,255,.45); transform:translateY(-1px); }
        .btn-register svg { width:16px; height:16px; }

        .login-link { text-align:center; font-size:13px; color:#6B7280; margin-top:1.3rem; }
        .login-link a { color:#6C63FF; text-decoration:none; font-weight:600; }
        .login-link a:hover { text-decoration:underline; }

        .error-alert { background:#FEF2F2; border:1px solid #FECACA; border-radius:10px; padding:10px 14px; margin-bottom:1rem; font-size:12.5px; color:#DC2626; }

        .page-footer { color:rgba(255,255,255,.75); font-size:11.5px; margin-top:1.6rem; text-align:center; opacity:0; animation:fadeSlideDown .6s ease .7s forwards; }

        @media (prefers-reduced-motion: reduce) {
            .brand-block,.auth-card,.anim-field,.page-footer,.blob,.wallet-badge,.coin { animation:none !important; opacity:1 !important; transform:none !important; }
        }
    </style>
</head>
<body>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>
<div class="blob blob-3"></div>

<div class="page-wrap">

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
        <div class="brand-tagline">Mulai perjalanan finansialmu</div>
    </div>

    <div class="auth-card">
        <div class="card-title">Buat Akun Baru</div>
        <div class="card-sub">Gratis selamanya. Mulai dalam 1 menit.</div>

        @if ($errors->any())
            <div class="error-alert">
                @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group anim-field af-1">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}">
            </div>

            <div class="form-group anim-field af-2">
                <label class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-input" placeholder="contoh@email.com" required value="{{ old('email') }}">
            </div>

            <div class="form-row-2 anim-field af-3">
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Min. 8 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                </div>
            </div>

            <div class="anim-field af-4">
                <button type="submit" class="btn-register">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    Buat Akun SpendWise
                </button>
            </div>

            <div class="login-link anim-field af-5">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </form>
    </div>

    <div class="page-footer">
        © {{ date('Y') }} SpendWise &nbsp;·&nbsp; Dibuat dengan Laravel {{ app()->version() }}
    </div>
</div>

</body>
</html>