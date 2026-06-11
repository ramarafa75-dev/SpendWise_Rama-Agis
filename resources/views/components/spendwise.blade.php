<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpendWise — {{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { display: flex; height: 100vh; overflow: hidden; font-family: 'Figtree', sans-serif; background: #F0F2F8; }

        /* Sidebar */
        .sidebar { width: 220px; background: #1A2035; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-logo { display: flex; align-items: center; gap: 10px; padding: 1.4rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,.06); }
        .sidebar-logo-icon { width: 34px; height: 34px; background: #6C63FF; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .sidebar-logo-icon svg { width: 18px; height: 18px; fill: none; stroke: #fff; stroke-width: 2; }
        .sidebar-logo span { font-size: 15px; font-weight: 600; color: #fff; letter-spacing: .3px; }
        .sidebar-nav { padding: 1rem 0; flex: 1; }
        .nav-label { font-size: 10px; color: #4A5568; text-transform: uppercase; letter-spacing: 1.2px; padding: 0 1.25rem; margin-bottom: 4px; margin-top: 8px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 1rem; color: #8892A4; font-size: 13px; text-decoration: none; margin: 2px 10px; border-radius: 8px; transition: all .15s; }
        .nav-item:hover { background: rgba(108,99,255,.1); color: #C4C0FF; }
        .nav-item.active { background: rgba(108,99,255,.18); color: #fff; }
        .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
        .sidebar-user { padding: 1rem 1.25rem; border-top: 1px solid rgba(255,255,255,.06); display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: #6C63FF; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: #fff; flex-shrink: 0; }
        .user-info p { font-size: 12px; font-weight: 500; color: #fff; }
        .user-info span { font-size: 11px; color: #6B7280; }

        /* Main */
        .main-wrap { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .topbar { background: #fff; border-bottom: 1px solid #E2E6F0; padding: 14px 1.75rem; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
        .topbar h1 { font-size: 15px; font-weight: 600; color: #1A2035; }
        .topbar-right { font-size: 11px; color: #9CA3AF; }
        .main-content { flex: 1; overflow-y: auto; padding: 1.5rem 1.75rem; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
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
    </nav>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div class="user-info">
            <p>{{ auth()->user()->name }}</p>
            <span>{{ auth()->user()->email }}</span>
        </div>
    </div>
</aside>

{{-- MAIN CONTENT --}}
<div class="main-wrap">
    <div class="topbar">
        <h1>{{ $title ?? 'Dashboard' }}</h1>
        <div class="topbar-right">
            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            &nbsp;|&nbsp;
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               style="color:#EF4444; text-decoration:none;">Keluar</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        </div>
    </div>

    <main class="main-content">
        @if(session('success'))
            <div style="background:#DCFCE7; color:#166534; border:1px solid #BBF7D0; border-radius:8px; padding:10px 14px; margin-bottom:1rem; font-size:13px;">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#FEE2E2; color:#991B1B; border:1px solid #FECACA; border-radius:8px; padding:10px 14px; margin-bottom:1rem; font-size:13px;">
                ✕ {{ session('error') }}
            </div>
        @endif

        {{ $slot }}
    </main>
</div>

</body>
</html>
