<!DOCTYPE html><html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"><title>@yield('title', 'Blooming Inventory')</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    :root {
        --wine: #572b3b;
        --plum: #351c2a;
        --rose: #e8a5ad;
        --cream: #fff9f2;
        --muted: #d9c5ce;
        --border: rgba(255,255,255,.15);
        --surface: rgba(75,35,53,.78);
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: 'DM Sans', sans-serif;
        color: var(--cream);
        background:
            linear-gradient(120deg, rgba(31,15,25,.94), rgba(65,29,46,.86)),
            url('https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&w=2000&q=85')
            center center / cover fixed;
        min-height: 100vh;
    }

    a { text-decoration: none; }

    .bloom-layout {
        min-height: 100vh;
        display: flex;
    }

    .bloom-sidebar {
        width: 245px;
        flex-shrink: 0;
        min-height: 100vh;
        padding: 30px 18px;
        background: rgba(35,17,28,.83);
        border-right: 1px solid var(--border);
        backdrop-filter: blur(22px);
        -webkit-backdrop-filter: blur(22px);
    }

    .bloom-brand {
        padding: 0 13px 30px;
        border-bottom: 1px solid var(--border);
    }

    .bloom-brand a {
        color: var(--cream);
        font-family: 'Playfair Display', serif;
        font-size: 34px;
    }

    .bloom-brand span {
        display: block;
        margin-top: 3px;
        color: var(--rose);
        font-size: 9px;
        letter-spacing: 3px;
    }

    .nav-caption {
        margin: 25px 12px 10px;
        color: #c7a9b5;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .bloom-nav {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .bloom-nav a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        color: #e7d8df;
        border: 1px solid transparent;
        border-radius: 9px;
        font-size: 12px;
        transition: .2s;
    }

    .bloom-nav a:hover,
    .bloom-nav a.active {
        color: white;
        background: rgba(232,165,173,.15);
        border-color: rgba(232,165,173,.2);
    }

    .nav-icon {
        width: 20px;
        color: var(--rose);
        text-align: center;
        font-size: 16px;
    }

    .sidebar-note {
        margin: 35px 8px 0;
        padding: 16px 12px;
        border: 1px solid var(--border);
        border-radius: 12px;
        color: #e7d8df;
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        line-height: 1.7;
    }

    .sidebar-note small {
        display: block;
        margin-top: 7px;
        color: #c7a9b5;
        font-family: 'DM Sans', sans-serif;
        font-size: 9px;
    }

    .bloom-main {
        min-width: 0;
        flex: 1;
    }

    .bloom-topbar {
        min-height: 67px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 15px 30px;
        background: rgba(39,19,31,.52);
        border-bottom: 1px solid var(--border);
        backdrop-filter: blur(18px);
    }

    .breadcrumb {
        color: #e7d8df;
        font-size: 11px;
    }

    .user-area {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 11px;
    }

    .user-name {
        color: var(--cream);
        font-weight: 600;
    }

    .user-role {
        display: block;
        margin-top: 3px;
        color: var(--rose);
        font-size: 9px;
        text-transform: capitalize;
    }

    .logout-button {
        padding: 9px 12px;
        color: var(--cream);
        border: 1px solid var(--border);
        border-radius: 8px;
        background: rgba(255,255,255,.07);
        cursor: pointer;
        font-family: inherit;
        font-size: 10px;
    }

    .logout-button:hover {
        background: rgba(232,165,173,.18);
    }

    .bloom-content {
        width: 100%;
        max-width: 1600px;
        padding: 30px;
        margin: 0 auto;
    }

    .bloom-content .panel,
    .bloom-content .glass-card {
        background: rgba(65,31,47,.78);
        border: 1px solid var(--border);
        border-radius: 15px;
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .bloom-content h1,
    .bloom-content h2,
    .bloom-content h3 {
        color: var(--cream);
    }

    .bloom-content p,
    .bloom-content small {
        color: #e0ccd5;
    }

    .bloom-content table {
        width: 100%;
        border-collapse: collapse;
    }

    .bloom-content th,
    .bloom-content td {
        padding: 13px 12px;
        border-bottom: 1px solid var(--border);
        text-align: left;
        font-size: 11px;
    }

    .bloom-content th {
        color: var(--rose);
        font-weight: 600;
    }

    .bloom-content td { color: var(--cream); }

    .bloom-content input,
    .bloom-content select,
    .bloom-content textarea {
        max-width: 100%;
        color: #351c2a;
    }

    .bloom-content .btn,
    .bloom-content button.btn {
        cursor: pointer;
    }

    .success-message,
    .error-message {
        padding: 12px 15px;
        margin-bottom: 18px;
        border-radius: 9px;
        font-size: 12px;
    }

    .success-message {
        color: #e8f5e4;
        background: rgba(83,137,76,.22);
        border: 1px solid rgba(153,205,143,.3);
    }

    .error-message {
        color: #ffe0e0;
        background: rgba(160,57,66,.22);
        border: 1px solid rgba(255,160,160,.3);
    }

    @media (max-width: 850px) {
        .bloom-sidebar { width: 190px; padding: 22px 10px; }
        .bloom-content { padding: 20px; }
        .bloom-topbar { padding: 14px 20px; }
    }

    @media (max-width: 600px) {
        .bloom-layout { display: block; }
        .bloom-sidebar {
            width: 100%;
            min-height: auto;
            padding: 15px;
        }
        .bloom-brand { padding-bottom: 12px; }
        .bloom-brand a { font-size: 27px; }
        .bloom-nav {
            flex-direction: row;
            flex-wrap: wrap;
        }
        .nav-caption { margin-top: 16px; }
        .bloom-nav a { padding: 9px; }
        .sidebar-note { display: none; }
        .bloom-topbar { padding: 12px 15px; }
        .bloom-content { padding: 15px; overflow-x: auto; }
        .user-area { gap: 7px; }
    }

    @media print {
        .bloom-sidebar, .bloom-topbar { display: none !important; }
        body { background: white !important; color: black !important; }
        .bloom-content { padding: 0; }
        .bloom-content h1, .bloom-content h2,
        .bloom-content h3, .bloom-content td { color: black !important; }
    }
</style>

</head>
<body>
    <div class="bloom-layout">
        <aside class="bloom-sidebar">
            <div class="bloom-brand">
                <a href="{{ route('dashboard') }}">blooming.</a>
                <span>FLORIST INVENTORY</span>
            </div>        <div class="nav-caption">MAIN MENU</div>
        <nav class="bloom-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">⌂</span> Dashboard
            </a>
        </nav>

        <div class="nav-caption">INVENTORY</div>
        <nav class="bloom-nav">
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <span class="nav-icon">❀</span> Kategori
            </a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <span class="nav-icon">🌷</span> Produk
            </a>
            <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <span class="nav-icon">✿</span> Supplier
            </a>
        </nav>

        <div class="nav-caption">TRANSACTIONS</div>
        <nav class="bloom-nav">
            <a href="{{ route('purchases.index') }}" class="{{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                <span class="nav-icon">↙</span> Pembelian
            </a>
            <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
                <span class="nav-icon">↗</span> Penjualan
            </a>
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <span class="nav-icon">▤</span> Laporan
            </a>
        </nav>

        <div class="sidebar-note">
            Dirangkai dengan cinta.
            <small>Blooming Florist Inventory © {{ date('Y') }}</small>
        </div>
    </aside>

    <div class="bloom-main">
        <header class="bloom-topbar">
            <div class="breadcrumb">
                Blooming / @yield('breadcrumb', 'Dashboard')
            </div>

            @auth
                <div class="user-area">
                    <div>
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->role ?? 'staff' }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-button">Keluar ↗</button>
                    </form>
                </div>
            @endauth
        </header>

        <main class="bloom-content">
            @if (session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

</body>
</html>