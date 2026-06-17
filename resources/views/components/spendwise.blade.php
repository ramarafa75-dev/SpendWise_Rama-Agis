<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendWise — {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            display: flex; height: 100vh; overflow: hidden;
            font-family: 'Poppins', system-ui, sans-serif;
            font-size: 13.5px; line-height: 1.6;
            background: #0D1117;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Sidebar ── */
        .sidebar { width: 220px; background: #161B22; display: flex; flex-direction: column; flex-shrink: 0; border-right: 1px solid #21262D; }
        .sidebar-logo { display: flex; align-items: center; gap: 10px; padding: 1.4rem 1.25rem; border-bottom: 1px solid #21262D; }
        .sidebar-logo-icon { width: 34px; height: 34px; background: #6C63FF; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sidebar-logo-icon svg { width: 18px; height: 18px; fill: none; stroke: #fff; stroke-width: 2; }
        .sidebar-logo span { font-size: 15px; font-weight: 700; color: #E6EDF3; letter-spacing: -.3px; }
        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .nav-label { font-size: 10px; color: #484F58; text-transform: uppercase; letter-spacing: 1.2px; padding: 0 1.25rem; margin-bottom: 4px; margin-top: 8px; font-weight: 500; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 1rem; color: #8B949E; font-size: 13px; text-decoration: none; margin: 2px 10px; border-radius: 8px; transition: all .15s; }
        .nav-item:hover { background: rgba(108,99,255,.12); color: #C4C0FF; }
        .nav-item.active { background: rgba(108,99,255,.2); color: #fff; }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .sidebar-user { padding: 1rem 1.25rem; border-top: 1px solid #21262D; display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: #6C63FF; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: #fff; flex-shrink: 0; }
        .user-info p { font-size: 12px; font-weight: 500; color: #E6EDF3; }
        .user-info span { font-size: 11px; color: #484F58; }

        /* ── Main ── */
        .main-wrap { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .topbar { background: #161B22; border-bottom: 1px solid #21262D; padding: 14px 1.75rem; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .topbar h1 { font-size: 15px; font-weight: 600; color: #E6EDF3; }
        .topbar-right { font-size: 11px; color: #484F58; }
        .main-content { flex: 1; overflow-y: auto; padding: 1.5rem 1.75rem; background: #0D1117; display: flex; flex-direction: column; }

        /* ── Flash messages ── */
        .flash-success { background: rgba(22,163,74,.12); color: #4ADE80; border: 1px solid rgba(22,163,74,.25); border-radius: 8px; padding: 10px 14px; margin-bottom: 1rem; font-size: 13px; }
        .flash-error { background: rgba(220,38,38,.12); color: #F87171; border: 1px solid rgba(220,38,38,.25); border-radius: 8px; padding: 10px 14px; margin-bottom: 1rem; font-size: 13px; }

        /* ── Footer ── */
        .main-footer { padding: 14px 1.75rem; border-top: 1px solid #21262D; background: transparent; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 11px; color: #484F58; margin-top: 2rem; }
        .main-footer a { color: #484F58; text-decoration: none; }
        .main-footer a:hover { color: #8B949E; }
        .main-footer span { color: #21262D; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0D1117; }
        ::-webkit-scrollbar-thumb { background: #21262D; border-radius: 10px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <svg viewBox="0 0 24 24"><path d="M21 12V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7"/><path d="M3 10h18M7 15h2M7 12h2"/><circle cx="18" cy="18" r="3"/><path d="M18 16v2l1 1"/></svg>
        </div>
        <span>SpendWise</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <a href="{{ route('categories.index') }}" class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><circle cx="7" cy="7" r="1"/></svg>
            Kategori
        </a>
        <a href="{{ route('transactions.index') }}" class="nav-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg>
            Transaksi
        </a>
        <a href="{{ route('transactions.create') }}" class="nav-item {{ request()->routeIs('transactions.create') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
            Tambah Transaksi
        </a>
        @if(Route::has('laporan'))
        <a href="{{ route('laporan') }}" class="nav-item {{ request()->routeIs('laporan') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Laporan
        </a>
        @endif
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div class="user-info">
            <p>{{ auth()->user()->name }}</p>
            <span>{{ auth()->user()->email }}</span>
        </div>
    </div>
</aside>

<div class="main-wrap">
    <div class="topbar">
        <h1>{{ $title ?? 'Dashboard' }}</h1>
        <div class="topbar-right">
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            &nbsp;|&nbsp;
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:#F87171;text-decoration:none;">Keluar</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
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

</body>
</html>
