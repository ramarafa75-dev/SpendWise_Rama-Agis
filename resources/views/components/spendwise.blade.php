<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendWise — {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* ══════════════════════════════════
           CSS VARIABLES — DARK (default)
        ══════════════════════════════════ */
        :root, [data-theme="dark"] {
            --bg-body:      #0D1117;
            --bg-sidebar:   #161B22;
            --bg-topbar:    #161B22;
            --bg-card:      #161B22;
            --bg-input:     #0D1117;
            --bg-row:       #0D1117;
            --bg-hover:     rgba(255,255,255,.02);
            --border:       #21262D;
            --text-primary: #E6EDF3;
            --text-secondary:#8B949E;
            --text-muted:   #484F58;
            --accent:       #1B4F8C;
            --success:      #4ADE80;
            --danger:       #F87171;
            --warning:      #FBBF24;
            --badge-in-bg:  rgba(74,222,128,.15);
            --badge-in-txt: #4ADE80;
            --badge-out-bg: rgba(248,113,113,.15);
            --badge-out-txt:#F87171;
            --icon-in-bg:   rgba(74,222,128,.15);
            --icon-out-bg:  rgba(248,113,113,.15);
            --shadow:       0 1px 4px rgba(0,0,0,.4);
            --nav-active:   rgba(108,99,255,.2);
            --nav-hover:    rgba(108,99,255,.12);
        }

        /* ══════════════════════════════════
           CSS VARIABLES — LIGHT
        ══════════════════════════════════ */
        [data-theme="light"] {
            --bg-body:      #EAECF0;
            --bg-sidebar:   #1A2035;
            --bg-topbar:    #ffffff;
            --bg-card:      #ffffff;
            --bg-input:     #ffffff;
            --bg-row:       #F9FAFB;
            --bg-hover:     #FAFBFF;
            --border:       #E2E6F0;
            --text-primary: #1A2035;
            --text-secondary:#6B7280;
            --text-muted:   #9CA3AF;
            --accent:       #1B4F8C;
            --success:      #16A34A;
            --danger:       #DC2626;
            --warning:      #F59E0B;
            --badge-in-bg:  #DCFCE7;
            --badge-in-txt: #166534;
            --badge-out-bg: #FEE2E2;
            --badge-out-txt:#991B1B;
            --icon-in-bg:   #DCFCE7;
            --icon-out-bg:  #FEE2E2;
            --shadow:       0 1px 4px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.04);
            --nav-active:   rgba(108,99,255,.18);
            --nav-hover:    rgba(108,99,255,.1);
        }

        /* ══════════════════════════════════
           GLOBAL SHARED CSS
        ══════════════════════════════════ */
        * { box-sizing:border-box; margin:0; padding:0; }
        body {
            display:flex; height:100vh; overflow:hidden;
            font-family:'Poppins',system-ui,sans-serif;
            font-size:13.5px; line-height:1.6;
            background:var(--bg-body);
            -webkit-font-smoothing:antialiased;
            transition:background .2s;
            position:relative;
        }

        /* Shared card */
        .sw-card {
            background:var(--bg-card); border-radius:10px;
            border:1px solid var(--border); box-shadow:var(--shadow);
        }

        /* Shared table */
        .sw-table { width:100%; border-collapse:collapse; font-size:13px; }
        .sw-table thead th { text-align:left; color:var(--text-muted); font-weight:500; padding:0 10px 10px; font-size:11px; border-bottom:1px solid var(--border); }
        .sw-table tbody td { padding:11px 10px; border-bottom:1px solid var(--border); color:var(--text-secondary); }
        .sw-table tbody tr:last-child td { border-bottom:none; }
        .sw-table tbody tr:hover td { background:var(--bg-hover); }

        /* Shared badge */
        .badge { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }
        .badge-in  { background:var(--badge-in-bg);  color:var(--badge-in-txt); }
        .badge-out { background:var(--badge-out-bg); color:var(--badge-out-txt); }

        /* Shared trx icon */
        .trx-icon { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .trx-icon.in  { background:var(--icon-in-bg); }
        .trx-icon.out { background:var(--icon-out-bg); }
        .trx-icon svg { width:16px; height:16px; }

        /* Shared btn */
        .btn-primary { background:var(--accent); color:#fff; border:none; border-radius:8px; padding:9px 16px; font-size:13px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; text-decoration:none; font-family:'Poppins',sans-serif; font-weight:500; }
        .btn-primary:hover { opacity:.9; }
        .btn-secondary { background:transparent; color:var(--text-secondary); border:1px solid var(--border); border-radius:8px; padding:9px 16px; font-size:13px; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; font-family:'Poppins',sans-serif; }
        .btn-secondary:hover { background:var(--bg-hover); }
        .btn-danger { background:none; border:none; color:var(--danger); font-size:12px; cursor:pointer; padding:4px 8px; border-radius:5px; font-family:'Poppins',sans-serif; }
        .btn-danger:hover { background:var(--badge-out-bg); }

        /* Shared form */
        .sw-input, .sw-select {
            width:100%; background:var(--bg-input); border:1px solid var(--border);
            border-radius:8px; padding:9px 12px; font-size:13px; color:var(--text-primary);
            outline:none; font-family:'Poppins',sans-serif; transition:border .15s;
        }
        .sw-input:focus, .sw-select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(108,99,255,.12); }
        .sw-input::placeholder { color:var(--text-muted); }
        .sw-select option { background:var(--bg-card); color:var(--text-primary); }
        .sw-label { display:block; font-size:12px; color:var(--text-secondary); margin-bottom:5px; font-weight:500; }
        .sw-error { font-size:11px; color:var(--danger); margin-top:4px; }
        .sw-form-group { margin-bottom:1rem; }

        /* Shared empty state */
        .empty-state { text-align:center; padding:2.5rem; color:var(--text-muted); font-size:13px; }

        /* Flash */
        .flash-success { background:var(--badge-in-bg); color:var(--badge-in-txt); border:1px solid var(--icon-in-bg); border-radius:8px; padding:10px 14px; margin-bottom:1rem; font-size:13px; }
        .flash-error { background:var(--badge-out-bg); color:var(--badge-out-txt); border:1px solid var(--icon-out-bg); border-radius:8px; padding:10px 14px; margin-bottom:1rem; font-size:13px; }

        /* ══════════════════════════════════
           SIDEBAR
        ══════════════════════════════════ */
        .sidebar-wrap {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 100;
        }
        .sidebar {
            width: 52px;
            background: #ffffff60;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 20px;
            border: 1px solid #E5E7EB;
            box-shadow: 0 8px 32px rgba(0,0,0,.12), 0 2px 8px rgba(0,0,0,.06);
            height: auto;
            overflow: visible;
            padding: 12px 0;
            gap: 2px;
            opacity: 0.8;
            transition: opacity .25s;
        }
        .sidebar:hover { opacity: 1;}
        /* Logo */
        .sidebar-logo {
            display: flex; align-items: center; justify-content: center;
            padding: 0 0 12px;
            border-bottom: 1px solid #F0F0F0;
            width: 100%; margin-bottom: 6px;
        }
        .sidebar-logo-icon {
            width: 32px; height: 32px;
            background:linear-gradient(145deg,#4FA8E8,#2E72B5 55%,#1B4F8C); border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-logo-icon svg { width: 16px; height: 16px; fill: none; stroke: #fff; stroke-width: 2; }
        .sidebar-logo span { display: none; }
        /* Nav */
        .sidebar-nav {
            display: flex; flex-direction: column;
            align-items: center; gap: 2px;
            width: 100%; padding: 0 8px;
        }
        .nav-label { display: none; }
        .nav-item {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            color: #9CA3AF;
            text-decoration: none;
            border-radius: 10px;
            transition: all .15s;
            position: relative;
        }
        .nav-item:hover { background: #F3F4F6; color: #1B4F8C; }
        .nav-item.active { background: #EEF2FF; color: #1B4F8C; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        /* Tooltip saat hover */
        .nav-item::after {
            content: attr(data-tooltip);
            position: absolute; left: calc(100% + 14px);
            background: #1A2035; color: #fff;
            font-size: 11px; font-weight: 500;
            padding: 5px 10px; border-radius: 7px;
            white-space: nowrap; pointer-events: none;
            opacity: 0; transform: translateX(-6px);
            transition: all .15s;
            z-index: 999;
            font-family: 'Poppins', sans-serif;
        }
        .nav-item:hover::after { opacity:1; transform:translateX(0); }
        /* Divider sebelum profile */
        .sidebar-divider {
            width: 32px; height: 1px;
            background: #F0F0F0;
            margin: 4px 0;
        }

        /* ══════════════════════════════════
           MAIN
        ══════════════════════════════════ */
        .main-wrap { flex:1; display:flex; flex-direction:column; overflow:hidden; background:var(--bg-body);}
        /* Floating Topbar */
        .topbar-wrap { padding:14px 1.5rem 0; background:var(--bg-body); flex-shrink:0; transition:background .2s; }
        .topbar {
            background:var(--bg-topbar);
            border:1px solid var(--border);
            border-radius:14px;
            padding:12px 1.25rem;
            display:flex; align-items:center; justify-content:space-between;
            box-shadow:0 4px 20px rgba(0,0,0,.08), 0 1px 4px rgba(0,0,0,.04);
            transition:all .2s;
        }
        .topbar h1 { font-size:15px; font-weight:600; color:var(--text-primary); }
        .topbar-right { display:flex; align-items:center; gap:10px; font-size:11px; color:var(--text-muted); }
        .main-content { flex:1; overflow-y:auto; padding:1rem 1.5rem 1.5rem; background:var(--bg-body); display:flex; flex-direction:column; transition:background .2s; }

        /* Floating Profile di topbar */
        .topbar-profile { display:flex; align-items:center; gap:8px; text-decoration:none; background:var(--bg-row); border:1px solid var(--border); border-radius:30px; padding:5px 12px 5px 5px; transition:all .15s; }
        .topbar-profile:hover { border-color:var(--accent); }
        .topbar-avatar { width:28px; height:28px; border-radius:50%; background:var(--accent); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#fff; flex-shrink:0; overflow:hidden; }
        .topbar-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
        .topbar-profile-name { font-size:12px; font-weight:500; color:var(--text-primary); }
        .main-footer { padding:14px 1.75rem; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:center; gap:8px; font-size:11px; color:var(--text-muted); margin-top:2rem; }
        .main-footer a { color:var(--text-muted); text-decoration:none; }
        .main-footer a:hover { color:var(--text-secondary); }
        .main-footer span { color:var(--border); }

        /* ══════════════════════════════════
           THEME TOGGLE BUTTON
        ══════════════════════════════════ */
        .theme-toggle {
            width:34px; height:34px; border-radius:8px; border:1px solid var(--border);
            background:var(--bg-card); cursor:pointer; display:flex; align-items:center;
            justify-content:center; transition:all .2s; flex-shrink:0;
        }
        .theme-toggle:hover { border-color:var(--accent); background:var(--bg-hover); }
        .theme-toggle svg { width:16px; height:16px; }
        .icon-sun { display:none; }
        .icon-moon { display:block; }
        [data-theme="light"] .icon-sun { display:block; }
        [data-theme="light"] .icon-moon { display:none; }

        /* Scrollbar */
        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-track { background:var(--bg-body); }
        ::-webkit-scrollbar-thumb { background:var(--border); border-radius:10px; }

        /* ══════════════════════════════════
           TOP LOADING BAR
        ══════════════════════════════════ */
        #sw-loadbar { position:fixed; top:0; left:0; height:3px; width:0%; background:linear-gradient(90deg,#6C63FF,#9C8CFF,#6C63FF); z-index:99999; opacity:0; box-shadow:0 0 10px rgba(108,99,255,.7); transition:width .4s cubic-bezier(.16,.84,.44,1), opacity .25s ease; }
        #sw-loadbar.is-active { opacity:1; }
        #sw-loadbar.is-loading { width:78%; }

        /* ══════════════════════════════════
           PAGE ENTRANCE ANIMATION (tiap load halaman)
        ══════════════════════════════════ */
        @keyframes swFadeDown { from{opacity:0; transform:translateY(-14px);} to{opacity:1; transform:translateY(0);} }
        @keyframes swFadeLeft { from{opacity:0; transform:translateX(-24px);} to{opacity:1; transform:translateX(0);} }
        @keyframes swFadeUp   { from{opacity:0; transform:translateY(18px);} to{opacity:1; transform:translateY(0);} }

        .sidebar      { animation:swFadeLeft .55s cubic-bezier(.16,.84,.44,1) both; }
        .topbar       { animation:swFadeDown .5s  cubic-bezier(.16,.84,.44,1) both; }
        .main-content { animation:swFadeUp   .55s cubic-bezier(.16,.84,.44,1) .08s both; }
        .nav-item     { opacity:0; animation:swFadeLeft .45s cubic-bezier(.16,.84,.44,1) both; }
        .nav-item:nth-of-type(1){ animation-delay:.10s }
        .nav-item:nth-of-type(2){ animation-delay:.15s }
        .nav-item:nth-of-type(3){ animation-delay:.20s }
        .nav-item:nth-of-type(4){ animation-delay:.25s }
        .nav-item:nth-of-type(5){ animation-delay:.30s }

        /* ══════════════════════════════════
           SCROLL REVEAL (turun ke bawah / geser kiri-kanan)
        ══════════════════════════════════ */
        [data-reveal] {
            opacity:0; transition:opacity .65s cubic-bezier(.16,.84,.44,1), transform .65s cubic-bezier(.16,.84,.44,1);
            transition-delay:var(--reveal-delay,0ms); will-change:opacity,transform;
        }
        [data-reveal="up"]    { transform:translateY(32px); }
        [data-reveal="left"]  { transform:translateX(-38px); }
        [data-reveal="right"] { transform:translateX(38px); }
        [data-reveal="row"]   { transform:translateY(10px); }
        [data-reveal].is-visible { opacity:1; transform:none; }

        @media (prefers-reduced-motion: reduce) {
            .sidebar, .topbar, .main-content, .nav-item, [data-reveal] { animation:none !important; transition:none !important; opacity:1 !important; transform:none !important; }
        }
    </style>

    {{-- Terapkan tema SEBELUM render untuk cegah flash --}}
    <script>
        (function() {
            const t = localStorage.getItem('sw-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>

<div id="sw-loadbar"></div>
<div class="sidebar-wrap">
<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <svg viewBox="0 0 24 24"><path d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7"/><path d="M3 10h18M7 15h2M7 12h2"/><circle cx="18" cy="18" r="3"/><path d="M18 16v2l1 1"/></svg>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}"
           class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
           data-tooltip="Dashboard">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
        </a>

        <a href="{{ route('categories.index') }}"
           class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}"
           data-tooltip="Kategori">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><circle cx="7" cy="7" r="1"/></svg>
        </a>

        <a href="{{ route('transactions.index') }}"
           class="nav-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}"
           data-tooltip="Transaksi">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
        </a>

        <a href="{{ route('transactions.create') }}"
           class="nav-item {{ request()->routeIs('transactions.create') ? 'active' : '' }}"
           data-tooltip="Tambah Transaksi">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
        </a>

        @if(Route::has('laporan'))
        <a href="{{ route('laporan') }}"
           class="nav-item {{ request()->routeIs('laporan') ? 'active' : '' }}"
           data-tooltip="Laporan">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </a>
        @endif
    </nav>
</aside>
</div>

<div class="main-wrap">
    <div class="topbar-wrap">
        <div class="topbar">
            <h1>{{ $title ?? 'Dashboard' }}</h1>
            <div class="topbar-right">
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                &nbsp;|&nbsp;

                {{-- Theme Toggle --}}
                <button class="theme-toggle" onclick="toggleTheme()" title="Ganti tema">
                    <svg class="icon-moon" fill="none" stroke="#8B949E" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
                    </svg>
                    <svg class="icon-sun" fill="none" stroke="#6B7280" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="5"/>
                        <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                </button>

                &nbsp;|&nbsp;

                {{-- Floating Profile --}}
                <a href="{{ route('profile') }}" class="topbar-profile">
                    <div class="topbar-avatar">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="avatar">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="topbar-profile-name">{{ auth()->user()->name }}</span>
                </a>

                &nbsp;|&nbsp;
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   style="color:#EF4444;text-decoration:none;">Keluar</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
            </div>
        </div>
    </div>

    <main class="main-content">
        @if(session('success'))
            <div class="flash-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash-error">✕ {{ session('error') }}</div>
        @endif

        <div style="flex:1">{{ $slot }}</div>

        <footer class="main-footer">
            © {{ date('Y') }} SpendWise <span>|</span>
            <a href="#">Lisensi</a> <span>|</span>
            <a href="#">Rama - Agistia</a> <span>|</span>
            Dibuat dengan Laravel {{ app()->version() }}
        </footer>
    </main>
</div>

<script>
function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('sw-theme', next);
    document.dispatchEvent(new Event('themeChanged'));
}

(function() {
    /* ===== TOP LOADING BAR — muncul saat pindah halaman ===== */
    const bar = document.getElementById('sw-loadbar');
    function startBar() {
        bar.classList.add('is-active');
        requestAnimationFrame(() => bar.classList.add('is-loading'));
    }
    document.addEventListener('click', function(e) {
        const a = e.target.closest('a[href]');
        if (!a) return;
        const href = a.getAttribute('href') || '';
        if (href.startsWith('#') || href.startsWith('javascript:')) return;
        if (a.target === '_blank' || a.hasAttribute('download')) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey) return;
        startBar();
    });
    document.addEventListener('submit', function() { startBar(); });

    /* ===== SCROLL REVEAL — konten muncul turun / geser kiri-kanan saat di-scroll ===== */
    function setupReveal() {
        const groups = [
            { sel: '.stats-grid > *',                              dir: i => ['left', 'up', 'right'][i % 3] },
            { sel: '.charts-grid > *',                              dir: i => (i % 2 === 0 ? 'left' : 'right') },
            { sel: '.budget-item',                                  dir: i => (i % 2 === 0 ? 'left' : 'right') },
            { sel: '.cat-card',                                     dir: i => (i % 2 === 0 ? 'left' : 'right') },
            { sel: '.alert-boros, .info-box',                       dir: () => 'up' },
            { sel: '.table-wrap, .table-card, .form-card, .add-card, .chart-card', dir: () => 'up' },
        ];
        groups.forEach(({ sel, dir }) => {
            document.querySelectorAll(sel).forEach((el, i) => {
                if (el.hasAttribute('data-reveal')) return;
                el.setAttribute('data-reveal', dir(i));
                el.style.setProperty('--reveal-delay', Math.min(i * 70, 420) + 'ms');
            });
        });
        document.querySelectorAll('.sw-table tbody tr').forEach((tr, i) => {
            if (tr.hasAttribute('data-reveal')) return;
            tr.setAttribute('data-reveal', 'row');
            tr.style.setProperty('--reveal-delay', Math.min(i * 50, 400) + 'ms');
        });

        const obs = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });

        document.querySelectorAll('[data-reveal]:not(.is-visible)').forEach((el) => obs.observe(el));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupReveal);
    } else {
        setupReveal();
    }
})();
</script>
</body>
</html>
