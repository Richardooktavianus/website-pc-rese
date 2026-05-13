@extends('layouts.app')

@section('title', $product->name)

@section('content')

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

  .detail-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 16px 48px;
  }

  /* ── Breadcrumb ── */
  .breadcrumb {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--text-muted);
    margin-bottom: 20px; flex-wrap: wrap;
  }
  .breadcrumb a {
    color: var(--text-muted); text-decoration: none;
    transition: color 0.2s;
  }
  .breadcrumb a:hover { color: var(--accent); }
  .breadcrumb-sep { color: rgba(255,255,255,0.2); }
  .breadcrumb-cur { color: var(--text-primary); }

  /* ── Main detail grid ── */
  .detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    margin-bottom: 48px;
  }

  @media (max-width: 768px) {
    .detail-grid { grid-template-columns: 1fr; gap: 20px; }
  }

  /* ── Image panel ── */
  .img-panel {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 18px; overflow: hidden;
    position: sticky; top: 76px;
    align-self: start;
  }

  .img-main {
    width: 100%; aspect-ratio: 1/1;
    background: var(--bg-surface);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; position: relative;
  }
  .img-main img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
  }
  .img-main:hover img { transform: scale(1.06); }

  .img-main-placeholder {
    font-size: 64px; color: var(--text-muted);
  }

  /* Zoom hint */
  .img-zoom-hint {
    position: absolute; bottom: 10px; right: 10px;
    background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
    border: 1px solid var(--border); border-radius: 6px;
    padding: 4px 10px; font-size: 11px; color: var(--text-muted);
  }

  /* Thumbnails */
  .img-thumbs {
    display: flex; gap: 8px; padding: 12px;
    border-top: 1px solid var(--border);
    overflow-x: auto; scrollbar-width: none;
  }
  .img-thumbs::-webkit-scrollbar { display: none; }

  .thumb {
    width: 56px; height: 56px; flex-shrink: 0;
    border-radius: 8px; overflow: hidden;
    border: 1.5px solid var(--border); cursor: pointer;
    background: var(--bg-surface);
    display: flex; align-items: center; justify-content: center;
    transition: border-color 0.2s;
  }
  .thumb.active { border-color: var(--accent); }
  .thumb img { width: 100%; height: 100%; object-fit: cover; }

  /* ── Info panel ── */
  .info-panel {
    display: flex; flex-direction: column; gap: 0;
  }

  /* Category tag */
  .prod-category-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(0,229,160,0.08); border: 1px solid rgba(0,229,160,0.2);
    color: var(--accent); font-size: 11px; font-weight: 700;
    letter-spacing: 1px; text-transform: uppercase;
    padding: 4px 10px; border-radius: 6px;
    margin-bottom: 12px; width: fit-content;
    font-family: 'Rajdhani', sans-serif;
  }

  /* Product name */
  .prod-detail-name {
    font-family: 'Rajdhani', sans-serif;
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 700; line-height: 1.15;
    color: var(--text-primary); margin-bottom: 12px;
  }

  /* Rating row */
  .rating-row {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 16px;
  }
  .stars { color: #f1c40f; font-size: 14px; letter-spacing: 2px; }
  .rating-count { font-size: 13px; color: var(--text-muted); }

  /* Price block */
  .price-block {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px; padding: 16px;
    margin-bottom: 20px;
  }

  .price-label { font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }

  .price-main {
    font-family: 'Rajdhani', sans-serif;
    font-size: 2rem; font-weight: 700;
    color: var(--accent); line-height: 1;
    margin-bottom: 8px;
  }

  .price-orig {
    font-size: 14px; color: var(--text-muted);
    text-decoration: line-through; margin-right: 8px;
  }

  .price-discount {
    display: inline-block;
    background: rgba(231,76,60,0.12); border: 1px solid rgba(231,76,60,0.3);
    color: #ff6b6b; font-size: 12px; font-weight: 700;
    padding: 2px 8px; border-radius: 4px;
    font-family: 'Rajdhani', sans-serif;
  }

  .price-stock {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; margin-top: 10px;
  }
  .stock-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--accent);
    box-shadow: 0 0 6px rgba(0,229,160,0.6);
    flex-shrink: 0;
  }
  .stock-dot.out { background: #ff6b6b; box-shadow: 0 0 6px rgba(255,107,107,0.5); }
  .stock-label { color: var(--accent); font-weight: 500; }
  .stock-label.out { color: #ff6b6b; }

  /* Quantity selector */
  .qty-row {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 16px;
  }
  .qty-label { font-size: 13px; color: var(--text-muted); }
  .qty-control {
    display: flex; align-items: center;
    background: var(--bg-surface);
    border: 1px solid var(--border); border-radius: 10px;
    overflow: hidden;
  }
  .qty-btn {
    width: 36px; height: 36px;
    background: none; border: none; cursor: pointer;
    color: var(--text-muted); font-size: 18px; font-weight: 300;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s, color 0.15s;
  }
  .qty-btn:hover { background: rgba(255,255,255,0.06); color: var(--text-primary); }
  .qty-val {
    min-width: 44px; text-align: center;
    font-size: 15px; font-weight: 600; color: var(--text-primary);
    font-family: 'Rajdhani', sans-serif;
  }

  /* Action buttons */
  .action-row {
    display: flex; gap: 10px; margin-bottom: 20px;
  }

  .btn-cart {
    flex: 1; height: 50px;
    background: var(--accent); border: none; border-radius: 12px;
    color: #0b1c14; font-family: 'Rajdhani', sans-serif;
    font-size: 1rem; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    position: relative; overflow: hidden;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
  }
  .btn-cart::before {
    content: '';
    position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
    transition: left 0.4s;
  }
  .btn-cart:hover { background: var(--accent-dim); box-shadow: 0 6px 20px rgba(0,229,160,0.3); transform: translateY(-1px); }
  .btn-cart:hover::before { left: 100%; }
  .btn-cart:active { transform: translateY(0); }

  .btn-wishlist {
    width: 50px; height: 50px;
    background: var(--bg-surface); border: 1px solid var(--border);
    border-radius: 12px; cursor: pointer; font-size: 20px;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s, border-color 0.2s;
    flex-shrink: 0;
  }
  .btn-wishlist:hover { background: rgba(255,107,107,0.1); border-color: rgba(255,107,107,0.3); }

  .btn-builder {
    width: 100%; height: 42px;
    background: none; border: 1px solid rgba(0,229,160,0.25);
    border-radius: 10px; color: var(--accent);
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: background 0.2s, border-color 0.2s;
    text-decoration: none; margin-bottom: 20px;
  }
  .btn-builder:hover { background: rgba(0,229,160,0.08); border-color: rgba(0,229,160,0.4); }

  /* Spec highlights */
  .spec-highlights {
    display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
    margin-bottom: 20px;
  }
  .spec-item {
    background: var(--bg-surface);
    border: 1px solid var(--border);
    border-radius: 10px; padding: 10px 12px;
  }
  .spec-key { font-size: 11px; color: var(--text-muted); margin-bottom: 3px; }
  .spec-val { font-size: 13px; font-weight: 600; color: var(--text-primary); font-family: 'Rajdhani', sans-serif; }

  /* Guarantee strip */
  .guarantee-strip {
    display: flex; gap: 0;
    border: 1px solid var(--border); border-radius: 10px; overflow: hidden;
  }
  .g-item {
    flex: 1; display: flex; flex-direction: column; align-items: center;
    padding: 10px 8px; gap: 4px;
    border-right: 1px solid var(--border);
    text-align: center;
  }
  .g-item:last-child { border-right: none; }
  .g-icon { font-size: 18px; }
  .g-label { font-size: 11px; color: var(--text-muted); line-height: 1.3; }

  /* ── Tabs ── */
  .tabs-wrap { margin-bottom: 48px; }

  .tab-nav {
    display: flex; gap: 0;
    border-bottom: 1px solid var(--border); margin-bottom: 20px;
    overflow-x: auto; scrollbar-width: none;
  }
  .tab-nav::-webkit-scrollbar { display: none; }

  .tab-btn {
    padding: 10px 18px; background: none; border: none;
    color: var(--text-muted); font-size: 13px; font-weight: 500;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    border-bottom: 2px solid transparent; white-space: nowrap;
    transition: color 0.2s, border-color 0.2s;
    margin-bottom: -1px;
  }
  .tab-btn:hover { color: var(--text-primary); }
  .tab-btn.active { color: var(--accent); border-bottom-color: var(--accent); }

  .tab-panel { display: none; }
  .tab-panel.active { display: block; }

  /* Description */
  .desc-text {
    font-size: 14px; color: var(--text-muted); line-height: 1.75;
    white-space: pre-line;
  }

  /* Spec table */
  .spec-table { width: 100%; border-collapse: collapse; }
  .spec-table tr { border-bottom: 1px solid var(--border); }
  .spec-table tr:last-child { border-bottom: none; }
  .spec-table td {
    padding: 10px 12px; font-size: 13px;
  }
  .spec-table td:first-child { color: var(--text-muted); width: 35%; }
  .spec-table td:last-child  { color: var(--text-primary); font-weight: 500; }
  .spec-table tr:hover td { background: rgba(255,255,255,0.02); }

  /* ── Recommended ── */
  .rec-section { }

  .section-label {
    font-family: 'Rajdhani', sans-serif;
    font-size: 11px; font-weight: 700;
    letter-spacing: 2.5px; text-transform: uppercase;
    color: var(--text-muted); margin-bottom: 14px;
    display: flex; align-items: center; gap: 10px;
  }
  .section-label::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }

  .rec-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
  }
  @media (max-width: 900px) { .rec-grid { grid-template-columns: repeat(3, 1fr); } }
  @media (max-width: 600px) { .rec-grid { grid-template-columns: repeat(2, 1fr); } }

  .rec-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px; overflow: hidden;
    text-decoration: none;
    transition: border-color 0.2s, transform 0.2s;
  }
  .rec-card:hover { border-color: rgba(0,229,160,0.3); transform: translateY(-2px); }
  .rec-card.hidden { display: none; }

  .rec-img {
    width: 100%; aspect-ratio: 1/1;
    background: var(--bg-surface);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; color: var(--text-muted); overflow: hidden;
  }
  .rec-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
  .rec-card:hover .rec-img img { transform: scale(1.05); }

  .rec-info { padding: 10px; }
  .rec-name {
    font-size: 13px; font-weight: 500; color: var(--text-primary);
    margin-bottom: 4px; line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2; line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
  }
  .rec-price { font-size: 13px; font-weight: 600; color: var(--accent); margin-bottom: 8px; }
  .rec-btn {
    display: flex; align-items: center; justify-content: center;
    background: rgba(0,229,160,0.08); border: 1px solid rgba(0,229,160,0.2);
    color: var(--accent); font-size: 12px; font-weight: 500;
    padding: 6px; border-radius: 8px; transition: background 0.2s;
  }
  .rec-card:hover .rec-btn { background: rgba(0,229,160,0.16); }

  /* Load more */
  .load-more-wrap { margin-top: 20px; text-align: center; }
  .load-more-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 28px; background: none;
    border: 1px solid var(--border); border-radius: 10px;
    color: var(--text-muted); font-size: 14px;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: color 0.2s, border-color 0.2s;
  }
  .load-more-btn:hover { color: var(--text-primary); border-color: rgba(255,255,255,0.2); }

  /* ── Toast ── */
  .toast {
    position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%) translateY(80px);
    background: var(--bg-card); border: 1px solid rgba(0,229,160,0.35);
    color: var(--accent); padding: 12px 24px; border-radius: 12px;
    font-size: 14px; font-weight: 500;
    box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    z-index: 999; transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
    white-space: nowrap; display: flex; align-items: center; gap: 8px;
  }
  .toast.show { transform: translateX(-50%) translateY(0); }
</style>

<div class="detail-page">

  <!-- Breadcrumb -->
  <nav class="breadcrumb">
    <a href="/">Home</a>
    <span class="breadcrumb-sep">›</span>
    <a href="/komponen">Komponen</a>
    @if($product->category)
      <span class="breadcrumb-sep">›</span>
      <a href="/komponen?cat={{ $product->category->name }}">{{ $product->category->name }}</a>
    @endif
    <span class="breadcrumb-sep">›</span>
    <span class="breadcrumb-cur">{{ Str::limit($product->name, 40) }}</span>
  </nav>

  <!-- Detail Grid -->
  <div class="detail-grid">

    <!-- Image Panel -->
    <div class="img-panel">
      <div class="img-main" id="imgMain">
        @if($product->image)
          <img src="{{ $product->image }}" alt="{{ $product->name }}">
          <div class="img-zoom-hint">🔍 Hover untuk zoom</div>
        @else
          <div class="img-main-placeholder">📦</div>
        @endif
      </div>
      {{-- Thumbnail strip (single image for now, can extend later) --}}
      @if($product->image)
        <div class="img-thumbs">
          <div class="thumb active">
            <img src="{{ asset('storage/'.$product->image) }}" alt="">
          </div>
        </div>
      @endif
    </div>

    <!-- Info Panel -->
    <div class="info-panel">

      <!-- Category tag -->
      @if($product->category)
        <div class="prod-category-tag">
          📦 {{ $product->category->name }}
        </div>
      @endif

      <!-- Name -->
      <h1 class="prod-detail-name">{{ $product->name }}</h1>

      <!-- Rating -->
      <div class="rating-row">
        <div class="stars">★★★★☆</div>
        <div class="rating-count">4.2 · 128 ulasan</div>
      </div>

      <!-- Price block -->
      <div class="price-block">
        <div class="price-label">Harga</div>
        <div class="price-main">Rp {{ number_format($product->price) }}</div>
        <div class="price-stock">
          <div class="stock-dot"></div>
          <span class="stock-label">Stok Tersedia</span>
        </div>
      </div>

      <!-- Quantity -->
      <div class="qty-row">
        <span class="qty-label">Jumlah:</span>
        <div class="qty-control">
          <button class="qty-btn" onclick="changeQty(-1)">−</button>
          <div class="qty-val" id="qtyVal">1</div>
          <button class="qty-btn" onclick="changeQty(1)">+</button>
        </div>
      </div>

      <!-- Action buttons -->
      <form method="POST" action="/cart/add" id="cartForm">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" id="qtyInput" value="1">
        <div class="action-row">
          <button type="submit" class="btn-cart" onclick="showToast()">
            🛒 Tambah ke Keranjang
          </button>
          <button type="button" class="btn-wishlist" title="Simpan ke wishlist">🤍</button>
        </div>
      </form>

      <!-- Add to builder -->
      <a href="/builder?add={{ $product->id }}" class="btn-builder">
        🔧 Tambahkan ke PC Builder
      </a>

      <!-- Spec highlights -->
      <div class="spec-highlights">
        @if($product->category)
          <div class="spec-item">
            <div class="spec-key">Kategori</div>
            <div class="spec-val">{{ $product->category->name }}</div>
          </div>
        @endif
        <div class="spec-item">
          <div class="spec-key">Kondisi</div>
          <div class="spec-val">Baru</div>
        </div>
        <div class="spec-item">
          <div class="spec-key">Garansi</div>
          <div class="spec-val">1 Tahun</div>
        </div>
        <div class="spec-item">
          <div class="spec-key">SKU</div>
          <div class="spec-val">PCR-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</div>
        </div>
      </div>

      <!-- Guarantee strip -->
      <div class="guarantee-strip">
        <div class="g-item">
          <div class="g-icon">🛡️</div>
          <div class="g-label">Garansi Resmi</div>
        </div>
        <div class="g-item">
          <div class="g-icon">🚚</div>
          <div class="g-label">Gratis Ongkir</div>
        </div>
        <div class="g-item">
          <div class="g-icon">↩️</div>
          <div class="g-label">Retur 7 Hari</div>
        </div>
        <div class="g-item">
          <div class="g-icon">🔒</div>
          <div class="g-label">Bayar Aman</div>
        </div>
      </div>

    </div><!-- end info-panel -->
  </div><!-- end detail-grid -->

  <!-- ── Tabs: Deskripsi & Spesifikasi ── -->
  <div class="tabs-wrap">
    <div class="tab-nav">
      <button class="tab-btn active" onclick="switchTab('desc', this)">Deskripsi</button>
      <button class="tab-btn" onclick="switchTab('spec', this)">Spesifikasi</button>
      <button class="tab-btn" onclick="switchTab('review', this)">Ulasan (128)</button>
    </div>

    <div class="tab-panel active" id="tab-desc">
      <div class="desc-text">{{ $product->description ?? 'Tidak ada deskripsi tersedia untuk produk ini.' }}</div>
    </div>

    <div class="tab-panel" id="tab-spec">
      <table class="spec-table">
        <tr><td>Nama Produk</td><td>{{ $product->name }}</td></tr>
        @if($product->category)
          <tr><td>Kategori</td><td>{{ $product->category->name }}</td></tr>
        @endif
        <tr><td>Kondisi</td><td>Baru (New)</td></tr>
        <tr><td>Garansi</td><td>1 Tahun Garansi Resmi</td></tr>
        <tr><td>SKU</td><td>PCR-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</td></tr>
        <tr><td>Harga</td><td>Rp {{ number_format($product->price) }}</td></tr>
      </table>
    </div>

    <div class="tab-panel" id="tab-review">
      <div style="padding:24px 0; text-align:center; color:var(--text-muted); font-size:14px;">
        <div style="font-size:36px;margin-bottom:8px;">⭐</div>
        Ulasan akan segera tersedia.
      </div>
    </div>
  </div>

  <!-- ── Rekomendasi ── -->
  <div class="rec-section">
    <div class="section-label">✨ Produk Rekomendasi</div>

    <div class="rec-grid" id="recGrid">
      @foreach($recommended as $index => $item)
        <a href="/product/{{ $item->id }}"
           class="rec-card {{ $index >= 8 ? 'hidden' : '' }}">
          <div class="rec-img">
            @if($item->image)
              <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}">
            @else
              📦
            @endif
          </div>
          <div class="rec-info">
            <div class="rec-name">{{ $item->name }}</div>
            <div class="rec-price">Rp {{ number_format($item->price) }}</div>
            <div class="rec-btn">👁 Lihat Produk</div>
          </div>
        </a>
      @endforeach
    </div>

    @if($recommended->count() > 8)
      <div class="load-more-wrap" id="loadMoreWrap">
        <button class="load-more-btn" onclick="loadMore()">
          Tampilkan Lebih Banyak ↓
        </button>
      </div>
    @endif
  </div>

</div><!-- end .detail-page -->

<!-- Toast notification -->
<div class="toast" id="toast">✓ Produk ditambahkan ke keranjang</div>

<script>
  /* ── Quantity ── */
  let qty = 1;

  function changeQty(delta) {
    qty = Math.max(1, qty + delta);
    document.getElementById('qtyVal').textContent = qty;
    document.getElementById('qtyInput').value = qty;
  }

  /* ── Toast ── */
  function showToast() {
    const t = document.getElementById('toast');
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
  }

  /* ── Tabs ── */
  function switchTab(id, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + id).classList.add('active');
    btn.classList.add('active');
  }

  /* ── Wishlist toggle ── */
  document.querySelector('.btn-wishlist').addEventListener('click', function() {
    const isWished = this.textContent === '❤️';
    this.textContent = isWished ? '🤍' : '❤️';
    this.style.background = isWished ? '' : 'rgba(255,107,107,0.1)';
  });

  /* ── Load more recommended ── */
  let recVisible = 8;

  function loadMore() {
    const cards = document.querySelectorAll('.rec-card.hidden');
    let count = 0;
    cards.forEach(c => {
      if (count < 8) { c.classList.remove('hidden'); count++; }
    });
    recVisible += count;
    if (document.querySelectorAll('.rec-card.hidden').length === 0) {
      document.getElementById('loadMoreWrap').style.display = 'none';
    }
  }
</script>

@endsection