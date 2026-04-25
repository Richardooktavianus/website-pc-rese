<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'PC Rakit Store')</title>

  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=DM+Sans:wght@400;500;600&family=Orbitron:wght@700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* ========== GLOBAL THEME (YANG KAMU LUPA) ========== */
    :root {
      --accent: #00E5A0;
      --accent-dim: #00b87c;
      --bg-main: #0d0f14;
      --bg-card: #161a24;
      --bg-surface: #1c2130;
      --text-primary: #f0f2f8;
      --text-muted: #7a859e;
      --border: rgba(255, 255, 255, 0.07);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: var(--bg-main);
      color: var(--text-primary);
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      line-height: 1.5;
    }

    h1,
    h2,
    h3,
    .logo {
      font-family: 'Rajdhani', sans-serif;
    }

    /* ========== NAVBAR ========== */
    .navbar {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(13, 15, 20, 0.9);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--border);
      padding: 0 1rem;
      height: 60px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo {
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--accent);
      letter-spacing: 1px;
      text-decoration: none;
      white-space: nowrap;
    }

    .search-bar {
      flex: 1;
      display: flex;
      align-items: center;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 0 12px;
      height: 38px;
      gap: 8px;
    }

    .search-bar input {
      width: 100%;
      background: none;
      border: none;
      outline: none;
      color: var(--text-primary);
    }

    .search-icon {
      color: var(--text-muted);
    }

    .nav-actions {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .cart-btn {
      position: relative;
      width: 38px;
      height: 38px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 8px;
      text-decoration: none;
    }

    .cart-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: #e74c3c;
      color: white;
      font-size: 10px;
      border-radius: 10px;
      min-width: 18px;
      height: 18px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .btn-login,
    .btn-register {
      height: 36px;
      padding: 0 14px;
      border-radius: 8px;
      font-size: 13px;
      display: flex;
      align-items: center;
      text-decoration: none;
    }

    .btn-login {
      border: 1px solid var(--border);
      color: var(--text-muted);
    }

    .btn-register {
      background: var(--accent);
      color: #0d1a14;
      font-weight: 600;
    }

    /* ========== SUBNAV ========== */
    .subnav {
      background: var(--bg-card);
      border-bottom: 1px solid var(--border);
      padding: 0 1rem;
      display: flex;
      gap: 10px;
      overflow-x: auto;
    }

    .subnav a {
      color: var(--text-muted);
      text-decoration: none;
      font-size: 13px;
      padding: 10px 12px;
      white-space: nowrap;
    }

    .subnav a.active,
    .subnav a:hover {
      color: var(--accent);
      border-bottom: 2px solid var(--accent);
    }

    /* ========== MAIN ========== */
    main {
      max-width: 1200px;
      margin: 0 auto;
      padding: 16px;
    }

    /* ========== FOOTER (YANG KAMU KOSONGKAN) ========== */
    footer {
      background: var(--bg-card);
      border-top: 1px solid var(--border);
      padding: 24px;
      text-align: center;
      color: var(--text-muted);
      font-size: 13px;
    }

    .footer-links {
      display: flex;
      justify-content: center;
      gap: 16px;
      margin-bottom: 10px;
      flex-wrap: wrap;
    }

    .footer-links a {
      color: var(--text-muted);
      text-decoration: none;
    }

    .footer-links a:hover {
      color: var(--accent);
    }

    .btn-profile {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 0 12px 0 6px;
      height: 36px;
      text-decoration: none;
      transition: border-color 0.2s;
    }

    .btn-profile:hover {
      border-color: rgba(0, 229, 160, 0.4);
    }

    .profile-avatar {
      width: 26px;
      height: 26px;
      border-radius: 6px;
      background: var(--accent);
      color: #0d1a14;
      font-size: 12px;
      font-weight: 700;
      font-family: 'Rajdhani', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .profile-name {
      font-size: 13px;
      color: var(--text-primary);
      font-weight: 500;
      max-width: 80px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar">
    <a href="/" class="logo">⚡ PC<span style="color:white">Rakit</span></a>

    <div class="search-bar">
      <span class="search-icon">🔍</span>
      <input type="text" placeholder="Cari komponen...">
    </div>

    <div class="nav-actions">
      <a href="/cart" class="cart-btn">🛒
        <span class="cart-badge">3</span>
      </a>
      @auth
      <a href="/profile" class="btn-profile">
        <span class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        <span class="profile-name">{{ auth()->user()->name }}</span>
      </a>
      @else
      <a href="/login" class="btn-login">Login</a>
      <a href="/register" class="btn-register">Daftar</a>
      @endauth
    </div>
  </nav>

  <!-- SUBNAV -->
  <!-- SUBNAV -->
  <div class="subnav">
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>

    <a href="{{ url('/transaksi') }}" class="{{ request()->is('transaksi*') ? 'active' : '' }}">Transaksi</a>

    <a href="{{ url('/builder') }}" class="{{ request()->is('builder*') ? 'active' : '' }}">Builder</a>

    <a href="{{ url('/cart') }}" class="{{ request()->is('cart*') ? 'active' : '' }}">Keranjang</a>

    <a href="{{ url('/promo') }}" class="{{ request()->is('promo*') ? 'active' : '' }}">Promo</a>
  </div>

  <!-- CONTENT -->
  <main>
    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer>
    <div class="footer-links">
      <a href="/tentang">Tentang</a>
      <a href="/faq">FAQ</a>
      <a href="/kontak">Kontak</a>
      <a href="/privacy">Privasi</a>
    </div>
    <div>© 2026 PC Rakit Store</div>
  </footer>
  @yield('scripts')
</body>

</html>