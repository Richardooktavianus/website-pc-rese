<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PC Rakit Store</title>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<style>
  :root {
    --accent: #00E5A0;
    --accent-dim: #00b87c;
    --bg-main: #0d0f14;
    --bg-card: #161a24;
    --bg-surface: #1c2130;
    --text-primary: #f0f2f8;
    --text-muted: #7a859e;
    --border: rgba(255,255,255,0.07);
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    background: var(--bg-main);
    color: var(--text-primary);
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    line-height: 1.5;
    overflow-x: hidden;
  }
  h1,h2,h3,.logo { font-family: 'Rajdhani', sans-serif; }

  /* NAVBAR */
  .navbar {
    position: sticky; top: 0; z-index: 100;
    background: rgba(13,15,20,0.9);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    padding: 0 1rem;
    height: 60px;
    display: flex; align-items: center; gap: 12px;
  }
  .logo { font-size: 1.4rem; font-weight: 700; color: var(--accent); letter-spacing: 1px; white-space: nowrap; }
  .search-bar {
    flex: 1;
    display: flex; align-items: center;
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 0 12px; gap: 8px; height: 38px;
  }
  .search-bar input {
    background: none; border: none; outline: none;
    color: var(--text-primary); font-size: 14px; width: 100%;
  }
  .search-bar input::placeholder { color: var(--text-muted); }
  .search-icon { color: var(--text-muted); font-size: 14px; flex-shrink: 0; }
  .nav-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
  .cart-btn {
    position: relative; background: var(--bg-surface);
    border: 1px solid var(--border); border-radius: 8px;
    width: 38px; height: 38px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; text-decoration: none; font-size: 16px;
  }
  .cart-badge {
    position: absolute; top: -5px; right: -5px;
    background: #e74c3c; color: #fff; font-size: 10px;
    font-weight: 600; min-width: 18px; height: 18px;
    border-radius: 9px; display: flex; align-items: center; justify-content: center;
    font-family: 'DM Sans', sans-serif;
  }
  .btn-login {
    background: none; border: 1px solid var(--border);
    color: var(--text-muted); padding: 0 14px; height: 36px;
    border-radius: 8px; font-size: 13px; cursor: pointer;
    white-space: nowrap; font-family: 'DM Sans', sans-serif;
    text-decoration: none; display: flex; align-items: center;
    transition: color 0.2s, border-color 0.2s;
  }
  .btn-login:hover { color: var(--text-primary); border-color: rgba(255,255,255,0.2); }
  .btn-register {
    background: var(--accent); border: none;
    color: #0d1a14; padding: 0 14px; height: 36px;
    border-radius: 8px; font-size: 13px; font-weight: 600;
    cursor: pointer; white-space: nowrap;
    font-family: 'DM Sans', sans-serif; text-decoration: none;
    display: flex; align-items: center; transition: background 0.2s;
  }
  .btn-register:hover { background: var(--accent-dim); }

  /* SECONDARY NAV */
  .subnav {
    background: var(--bg-card);
    border-bottom: 1px solid var(--border);
    padding: 0 1rem;
    display: flex; gap: 4px;
    overflow-x: auto; scrollbar-width: none;
  }
  .subnav::-webkit-scrollbar { display: none; }
  .subnav a {
    color: var(--text-muted); text-decoration: none;
    font-size: 13px; font-weight: 500;
    padding: 10px 14px; white-space: nowrap;
    border-bottom: 2px solid transparent;
    transition: color 0.2s, border-color 0.2s;
  }
  .subnav a:hover, .subnav a.active {
    color: var(--accent); border-bottom-color: var(--accent);
  }

  /* MAIN CONTENT */
  main { max-width: 1200px; margin: 0 auto; padding: 16px; }

  /* SUCCESS NOTIF */
  .notif-success {
    background: rgba(0,229,160,0.1); border: 1px solid rgba(0,229,160,0.3);
    color: var(--accent); border-radius: 8px; padding: 10px 14px;
    margin-bottom: 16px; font-size: 14px;
  }

  /* BANNER SLIDER */
  .banner-wrap { position: relative; border-radius: 16px; overflow: hidden; margin-bottom: 20px; background: var(--bg-surface); }
  .banner-track { display: flex; transition: transform 0.5s cubic-bezier(0.4,0,0.2,1); }
  .banner-slide {
    min-width: 100%; height: 180px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Rajdhani', sans-serif; font-size: 1.2rem; color: var(--text-muted);
  }
  .banner-slide.b1 { background: linear-gradient(135deg, #0d2b1e 0%, #0d1a2e 100%); }
  .banner-slide.b2 { background: linear-gradient(135deg, #1a1a0d 0%, #2b1a0d 100%); }
  .banner-slide.b3 { background: linear-gradient(135deg, #1a0d2b 0%, #0d1a2b 100%); }
  .banner-slide .banner-content { text-align: center; }
  .banner-slide .banner-title { font-size: clamp(1.3rem, 4vw, 2rem); font-weight: 700; color: var(--text-primary); }
  .banner-slide .banner-sub { font-size: 14px; color: var(--text-muted); font-family: 'DM Sans', sans-serif; margin-top: 4px; }
  .banner-slide .banner-tag {
    display: inline-block; background: var(--accent); color: #0d1a14;
    font-size: 12px; font-weight: 700; border-radius: 4px; padding: 2px 10px; margin-top: 10px;
    font-family: 'DM Sans', sans-serif;
  }
  .banner-btn {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(0,0,0,0.5); border: 1px solid var(--border);
    color: var(--text-primary); width: 32px; height: 32px;
    border-radius: 8px; display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 18px; transition: background 0.2s;
  }
  .banner-btn:hover { background: rgba(0,229,160,0.2); }
  .banner-btn.prev { left: 10px; }
  .banner-btn.next { right: 10px; }
  .banner-dots {
    position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);
    display: flex; gap: 6px;
  }
  .dot { width: 6px; height: 6px; border-radius: 3px; background: rgba(255,255,255,0.3); transition: all 0.3s; cursor: pointer; }
  .dot.active { background: var(--accent); width: 20px; }

  /* CATEGORY */
  .section-title {
    font-family: 'Rajdhani', sans-serif;
    font-size: 1rem; font-weight: 600;
    color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 1.5px; margin-bottom: 12px;
    display: flex; align-items: center; justify-content: space-between;
  }
  .section-title a { font-family: 'DM Sans', sans-serif; font-size: 12px; color: var(--accent); font-weight: 500; text-transform: none; letter-spacing: 0; }
  .category-scroll { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 4px; scrollbar-width: none; margin-bottom: 20px; }
  .category-scroll::-webkit-scrollbar { display: none; }
  .cat-item { display: flex; flex-direction: column; align-items: center; gap: 6px; cursor: pointer; flex-shrink: 0; }
  .cat-icon {
    width: 56px; height: 56px; border-radius: 14px;
    background: var(--bg-surface); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; transition: border-color 0.2s, background 0.2s;
  }
  .cat-item:hover .cat-icon { border-color: var(--accent); background: rgba(0,229,160,0.08); }
  .cat-label { font-size: 11px; color: var(--text-muted); text-align: center; }

  /* TOP BRAND TICKER */
  .brand-bar {
    background: var(--bg-card); border: 1px solid var(--border);
    border-radius: 10px; padding: 12px 16px;
    margin-bottom: 20px; overflow: hidden;
    display: flex; align-items: center; gap: 12px;
  }
  .brand-label { font-size: 11px; color: var(--accent); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; white-space: nowrap; }
  .brand-scroll { display: flex; gap: 24px; overflow: hidden; flex: 1; }
  .brand-name { font-family: 'Rajdhani', sans-serif; font-size: 14px; font-weight: 600; color: var(--text-muted); white-space: nowrap; }

  /* BUILDER BUTTON */
  .builder-btn-wrap { margin-bottom: 20px; }
  .builder-btn {
    display: flex; align-items: center; justify-content: center; gap: 10px;
    background: linear-gradient(135deg, rgba(0,229,160,0.15) 0%, rgba(0,229,160,0.05) 100%);
    border: 1px solid rgba(0,229,160,0.3); border-radius: 12px;
    padding: 14px 20px; cursor: pointer; text-decoration: none;
    transition: background 0.2s, border-color 0.2s;
  }
  .builder-btn:hover { background: rgba(0,229,160,0.2); border-color: rgba(0,229,160,0.5); }
  .builder-btn-icon { font-size: 20px; }
  .builder-btn-text { font-family: 'Rajdhani', sans-serif; font-size: 1.1rem; font-weight: 700; color: var(--accent); }
  .builder-btn-sub { font-size: 12px; color: var(--text-muted); }

  /* PRODUCT GRID */
  .product-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px; }
  @media(min-width: 640px) { .product-grid { grid-template-columns: repeat(3, 1fr); } }
  @media(min-width: 900px) { .product-grid { grid-template-columns: repeat(4, 1fr); } }

  .product-card {
    background: var(--bg-card); border: 1px solid var(--border);
    border-radius: 14px; overflow: hidden;
    transition: border-color 0.2s, transform 0.2s;
    cursor: pointer; text-decoration: none; display: block;
  }
  .product-card:hover { border-color: rgba(0,229,160,0.3); transform: translateY(-2px); }
  .product-img {
    width: 100%; aspect-ratio: 1/1; object-fit: cover;
    background: var(--bg-surface); display: flex; align-items: center; justify-content: center;
    color: var(--text-muted); font-size: 12px; overflow: hidden;
  }
  .product-img img { width: 100%; height: 100%; object-fit: cover; }
  .product-img.placeholder { aspect-ratio: 1/1; }
  .product-info { padding: 10px; }
  .product-name { font-size: 13px; font-weight: 500; color: var(--text-primary); margin-bottom: 4px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .product-price { font-size: 13px; font-weight: 600; color: var(--accent); margin-bottom: 8px; }
  .product-view {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    background: rgba(0,229,160,0.1); border: 1px solid rgba(0,229,160,0.2);
    color: var(--accent); font-size: 12px; font-weight: 500;
    padding: 7px 10px; border-radius: 8px;
    transition: background 0.2s;
  }
  .product-card:hover .product-view { background: rgba(0,229,160,0.2); }

  /* SPECIAL OFFER */
  .offers-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px; }
  @media(min-width: 640px) { .offers-grid { grid-template-columns: repeat(4, 1fr); } }
  .offer-card {
    background: var(--bg-card); border: 1px solid var(--border);
    border-radius: 14px; overflow: hidden; cursor: pointer;
    transition: border-color 0.2s; text-decoration: none; display: block;
  }
  .offer-card:hover { border-color: rgba(255,180,0,0.4); }
  .offer-img {
    width: 100%; aspect-ratio: 4/3; background: var(--bg-surface);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-muted); font-size: 12px;
  }
  .offer-badge {
    margin: 0 10px 10px; display: inline-flex; align-items: center; gap: 4px;
    background: rgba(255,180,0,0.12); border: 1px solid rgba(255,180,0,0.3);
    color: #ffb400; font-size: 11px; font-weight: 600;
    padding: 4px 8px; border-radius: 6px; margin-top: 8px;
  }

  /* LOAD MORE */
  .load-more-btn {
    display: block; width: 100%; padding: 12px;
    background: none; border: 1px solid var(--border);
    color: var(--text-muted); border-radius: 10px;
    font-size: 14px; font-family: 'DM Sans', sans-serif;
    cursor: pointer; transition: color 0.2s, border-color 0.2s;
    text-align: center; margin-bottom: 20px;
  }
  .load-more-btn:hover { color: var(--text-primary); border-color: rgba(255,255,255,0.2); }

  /* PROMO BANNER BOTTOM */
  .promo-banner {
    border-radius: 16px; padding: 28px 24px;
    background: linear-gradient(135deg, #0d2b1e 0%, #0f1d30 100%);
    border: 1px solid rgba(0,229,160,0.15);
    display: flex; flex-direction: column; gap: 8px;
    margin-bottom: 20px; position: relative; overflow: hidden;
  }
  .promo-banner::after {
    content: ''; position: absolute; right: -30px; top: -30px;
    width: 140px; height: 140px; border-radius: 50%;
    background: rgba(0,229,160,0.06);
  }
  .promo-title { font-family: 'Rajdhani', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--text-primary); }
  .promo-sub { font-size: 13px; color: var(--text-muted); }
  .promo-cta {
    margin-top: 8px; display: inline-flex; align-items: center; gap: 6px;
    background: var(--accent); color: #0d1a14;
    padding: 9px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
    width: fit-content; cursor: pointer; text-decoration: none;
    font-family: 'DM Sans', sans-serif;
  }

  /* FOOTER */
  footer {
    background: var(--bg-card); border-top: 1px solid var(--border);
    padding: 24px 16px; text-align: center;
    color: var(--text-muted); font-size: 13px;
  }
  footer .footer-links { display: flex; justify-content: center; gap: 20px; margin-bottom: 12px; flex-wrap: wrap; }
  footer .footer-links a { color: var(--text-muted); text-decoration: none; font-size: 13px; transition: color 0.2s; }
  footer .footer-links a:hover { color: var(--accent); }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="/" class="logo">⚡ PC<span style="color:var(--text-primary)">Rakit</span></a>
  <div class="search-bar">
    <span class="search-icon">🔍</span>
    <input type="text" placeholder="Cari komponen, produk...">
  </div>
  <div class="nav-actions">
    <a href="/cart" class="cart-btn">
      🛒
      <span class="cart-badge">3</span>
    </a>
    <a href="/login" class="btn-login">Login</a>
    <a href="/register" class="btn-register">Daftar</a>
  </div>
</nav>

<!-- SECONDARY NAV -->
<div class="subnav">
  <a href="/komponen" class="active">Komponen</a>
  <a href="/transaksi">Cek Transaksi</a>
  <a href="/kompatibilitas">Cek Kompatibilitas</a>
  <a href="/keranjang">Keranjang</a>
  <a href="/promo">Promo</a>
</div>

<main>

  <!-- BANNER SLIDER -->
  <div class="banner-wrap">
    <div class="banner-track" id="bannerTrack">
      <div class="banner-slide b1">
        <div class="banner-content">
          <div class="banner-sub">Spesial Bulan Ini</div>
          <div class="banner-title">Rakit PC Impianmu</div>
          <div class="banner-tag">Mulai dari Rp 5 Juta</div>
        </div>
      </div>
      <div class="banner-slide b2">
        <div class="banner-content">
          <div class="banner-sub">Komponen Terbaru</div>
          <div class="banner-title">GPU RTX Series 50</div>
          <div class="banner-tag">Stok Terbatas!</div>
        </div>
      </div>
      <div class="banner-slide b3">
        <div class="banner-content">
          <div class="banner-sub">Garansi Resmi</div>
          <div class="banner-title">Prosesor AMD Ryzen 9</div>
          <div class="banner-tag">Diskon 15%</div>
        </div>
      </div>
    </div>
    <button class="banner-btn prev" onclick="prevSlide()">‹</button>
    <button class="banner-btn next" onclick="nextSlide()">›</button>
    <div class="banner-dots" id="bannerDots">
      <div class="dot active" onclick="goSlide(0)"></div>
      <div class="dot" onclick="goSlide(1)"></div>
      <div class="dot" onclick="goSlide(2)"></div>
    </div>
  </div>

  <!-- CATEGORY -->
  <div class="section-title">Kategori <a href="/komponen">Lihat Semua →</a></div>
  <div class="category-scroll">
    <div class="cat-item"><div class="cat-icon">🖥️</div><div class="cat-label">CPU</div></div>
    <div class="cat-item"><div class="cat-icon">🧠</div><div class="cat-label">RAM</div></div>
    <div class="cat-item"><div class="cat-icon">🎮</div><div class="cat-label">GPU</div></div>
    <div class="cat-item"><div class="cat-icon">💾</div><div class="cat-label">Storage</div></div>
    <div class="cat-item"><div class="cat-icon">🔌</div><div class="cat-label">PSU</div></div>
    <div class="cat-item"><div class="cat-icon">❄️</div><div class="cat-label">Cooling</div></div>
    <div class="cat-item"><div class="cat-icon">📟</div><div class="cat-label">Mobo</div></div>
    <div class="cat-item"><div class="cat-icon">🖱️</div><div class="cat-label">Periferal</div></div>
    <div class="cat-item"><div class="cat-icon">📦</div><div class="cat-label">Casing</div></div>
  </div>

  <!-- TOP BRAND -->
  <div class="brand-bar">
    <div class="brand-label">TOP BRAND</div>
    <div class="brand-scroll">
      <span class="brand-name">ASUS</span>
      <span class="brand-name">MSI</span>
      <span class="brand-name">GIGABYTE</span>
      <span class="brand-name">CORSAIR</span>
      <span class="brand-name">AMD</span>
      <span class="brand-name">INTEL</span>
      <span class="brand-name">NVIDIA</span>
      <span class="brand-name">NZXT</span>
    </div>
  </div>

  <!-- BUILDER BUTTON -->
  <div class="builder-btn-wrap">
    <a href="/builder" class="builder-btn">
      <span class="builder-btn-icon">🔧</span>
      <div>
        <div class="builder-btn-text">Rakit PC Sekarang</div>
        <div class="builder-btn-sub">Pilih komponen & cek kompatibilitas otomatis</div>
      </div>
    </a>
  </div>

  <!-- POPULAR PRODUCTS -->
<div class="section-title">Popular Product <a href="/komponen">Semua →</a></div>
<div class="product-grid">

    @forelse($products as $product)
    <a href="/product/{{ $product->id }}" class="product-card">

        {{-- IMAGE --}}
        <div class="product-img">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
            @else
                <div class="product-img placeholder" style="display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:13px;">
                    No Image
                </div>
            @endif
        </div>

        <div class="product-info">
            <div class="product-name">{{ $product->name }}</div>
            <div class="product-price">Rp {{ number_format($product->price) }}</div>
            <div class="product-view">👁 Lihat Produk</div>
        </div>

    </a>
    @empty
        <p style="color:var(--text-muted); font-size:14px; grid-column: 1/-1;">
            Tidak ada produk tersedia.
        </p>
    @endforelse

</div>

  <!-- SPECIAL OFFER -->
  <div class="section-title">Special Offer <a href="/promo">Semua Promo →</a></div>
  <div class="offers-grid">
    <a href="/product/9" class="offer-card">
      <div class="offer-img" style="font-size:28px;">🎮</div>
      <div style="padding:8px 10px 10px;">
        <div style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:4px;">MSI Gaming Bundle</div>
        <div class="offer-badge">🔥 Hemat 20%</div>
      </div>
    </a>
    <a href="/product/10" class="offer-card">
      <div class="offer-img" style="font-size:28px;">🖥️</div>
      <div style="padding:8px 10px 10px;">
        <div style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:4px;">Intel Core i9 Bundle</div>
        <div class="offer-badge">⚡ Flash Sale</div>
      </div>
    </a>
    <a href="/product/11" class="offer-card">
      <div class="offer-img" style="font-size:28px;">❄️</div>
      <div style="padding:8px 10px 10px;">
        <div style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:4px;">Cooling Bundle Set</div>
        <div class="offer-badge">🏷️ Hemat 15%</div>
      </div>
    </a>
    <a href="/product/12" class="offer-card">
      <div class="offer-img" style="font-size:28px;">🧠</div>
      <div style="padding:8px 10px 10px;">
        <div style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:4px;">RAM + SSD Paket</div>
        <div class="offer-badge">💰 Hemat 25%</div>
      </div>
    </a>
  </div>

  <!-- LOAD MORE -->
  <button class="load-more-btn">Tampilkan Lebih Banyak ↓</button>

  <!-- PROMO BANNER BOTTOM -->
  <div class="promo-banner">
    <div class="promo-sub">Program Referral</div>
    <div class="promo-title">Ajak Teman, Dapatkan<br>Cashback Rp 100.000</div>
    <div class="promo-sub">Berlaku untuk setiap teman yang berhasil melakukan pembelian pertama.</div>
    <a href="/referral" class="promo-cta">Ikut Sekarang →</a>
  </div>

</main>

<!-- FOOTER -->
<footer>
  <div class="footer-links">
    <a href="/tentang">Tentang Kami</a>
    <a href="/faq">FAQ</a>
    <a href="/kontak">Hubungi Kami</a>
    <a href="/kebijakan">Kebijakan Privasi</a>
  </div>
  <div>© 2026 PC Rakit Store · Bandung, Indonesia</div>
</footer>

<script>
  let current = 0;
  const track = document.getElementById('bannerTrack');
  const dotsEl = document.querySelectorAll('.dot');
  const total = 3;

  function goSlide(i) {
    current = i;
    track.style.transform = `translateX(-${current * 100}%)`;
    dotsEl.forEach((d, idx) => d.classList.toggle('active', idx === current));
  }
  function nextSlide() { goSlide((current + 1) % total); }
  function prevSlide() { goSlide((current - 1 + total) % total); }

  setInterval(nextSlide, 3500);
</script>
</body>
</html>