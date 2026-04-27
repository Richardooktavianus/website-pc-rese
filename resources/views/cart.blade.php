@extends('layouts.app')

@section('title', 'Keranjang - PC Rakit Store')

@section('content')

<style>
  /* ===== CART PAGE STYLES ===== */
  .cart-wrapper {
    max-width: 860px;
    margin: 0 auto;
    padding: 24px 16px 48px;
  }

  /* Page Header */
  .cart-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 28px;
  }

  .cart-header-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(0, 229, 160, 0.12);
    border: 1px solid rgba(0, 229, 160, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
  }

  .cart-header-title {
    font-family: 'Rajdhani', sans-serif;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
  }

  .cart-header-sub {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 3px;
  }

  /* Alert */
  .alert-success {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(0, 229, 160, 0.08);
    border: 1px solid rgba(0, 229, 160, 0.25);
    color: var(--accent);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    margin-bottom: 20px;
  }

  /* Build Card */
  .build-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 16px;
    transition: border-color 0.2s;
  }

  .build-card:hover {
    border-color: rgba(0, 229, 160, 0.2);
  }

  .build-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--bg-surface);
  }

  .build-card-title {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .build-number {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: rgba(0, 229, 160, 0.12);
    border: 1px solid rgba(0, 229, 160, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Rajdhani', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: var(--accent);
  }

  .build-label {
    font-family: 'Rajdhani', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: 0.5px;
  }

  .btn-hapus {
    display: flex;
    align-items: center;
    gap: 6px;
    background: rgba(231, 76, 60, 0.1);
    border: 1px solid rgba(231, 76, 60, 0.25);
    color: #e74c3c;
    font-size: 12px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.2s, border-color 0.2s;
  }

  .btn-hapus:hover {
    background: rgba(231, 76, 60, 0.2);
    border-color: rgba(231, 76, 60, 0.4);
  }

  /* Item List */
  .build-items {
    padding: 8px 20px;
  }

  .build-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--border);
    gap: 12px;
  }

  .build-item:last-child {
    border-bottom: none;
  }

  .item-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(0, 229, 160, 0.4);
    flex-shrink: 0;
  }

  .item-name {
    flex: 1;
    font-size: 13px;
    color: var(--text-primary);
    line-height: 1.3;
  }

  .item-price {
    font-size: 13px;
    font-weight: 600;
    color: var(--accent);
    white-space: nowrap;
  }

  /* Total Row */
  .build-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: rgba(0, 229, 160, 0.04);
    border-top: 1px solid var(--border);
  }

  .build-total-label {
    font-size: 13px;
    color: var(--text-muted);
  }

  .build-total-price {
    font-family: 'Rajdhani', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--accent);
  }

  /* Empty State */
  .cart-empty {
    text-align: center;
    padding: 64px 24px;
  }

  .cart-empty-icon {
    font-size: 56px;
    margin-bottom: 16px;
    opacity: 0.4;
  }

  .cart-empty-title {
    font-family: 'Rajdhani', sans-serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--text-muted);
    margin-bottom: 8px;
  }

  .cart-empty-sub {
    font-size: 14px;
    color: var(--text-muted);
    opacity: 0.6;
    margin-bottom: 24px;
  }

  .btn-shop {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--accent);
    color: #0d1a14;
    padding: 10px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.2s;
  }

  .btn-shop:hover {
    background: var(--accent-dim);
  }

  /* Summary Bar */
  .cart-summary {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 20px;
    margin-top: 8px;
    position: sticky;
    bottom: 16px;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
  }

  .summary-label {
    font-size: 14px;
    color: var(--text-muted);
  }

  .summary-count {
    font-family: 'Rajdhani', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
  }

  .summary-actions {
    display: flex;
    gap: 10px;
  }

  @media (max-width: 480px) {
    .summary-actions {
      flex-direction: column;
    }
  }

  .btn-clear {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex: 1;
    background: none;
    border: 1px solid var(--border);
    color: var(--text-muted);
    padding: 11px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: color 0.2s, border-color 0.2s;
    white-space: nowrap;
  }

  .btn-clear:hover {
    color: #e74c3c;
    border-color: rgba(231, 76, 60, 0.4);
  }

  .btn-checkout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex: 2;
    background: var(--accent);
    border: none;
    color: #0d1a14;
    padding: 11px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: background 0.2s;
    white-space: nowrap;
  }

  .btn-checkout:hover {
    background: var(--accent-dim);
  }

  /* Item count badge */
  .item-count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 229, 160, 0.12);
    border: 1px solid rgba(0, 229, 160, 0.2);
    color: var(--accent);
    font-size: 11px;
    font-weight: 700;
    border-radius: 6px;
    padding: 2px 7px;
    font-family: 'DM Sans', sans-serif;
    margin-left: 6px;
  }
</style>

<div class="cart-wrapper">

  {{-- HEADER --}}
  <div class="cart-header">
    <div class="cart-header-icon">🛒</div>
    <div>
      <div class="cart-header-title">
        Keranjang
        @if(count(session('cart', [])) > 0)
        <span class="item-count-badge">{{ count(session('cart', [])) }} Build</span>
        @endif
      </div>
      <div class="cart-header-sub">Daftar rakitan PC yang siap di-checkout</div>
    </div>
  </div>

  {{-- ALERT SUCCESS --}}
  @if(session('success'))
  <div class="alert-success">
    ✅ {{ session('success') }}
  </div>
  @endif

  {{-- BUILD LIST --}}
  @forelse(session('cart', []) as $index => $build)

  <div class="build-card">

    {{-- Card Header --}}
    <div class="build-card-header">
      <div class="build-card-title">
        <div class="build-number">{{ $index + 1 }}</div>
        <div class="build-label">Build PC #{{ $index + 1 }}</div>
      </div>

      <form method="POST" action="/cart/remove">
        @csrf
        <input type="hidden" name="index" value="{{ $index }}">
        <button type="submit" class="btn-hapus">
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M9 3L3 9M3 3l6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
          </svg>
          Hapus
        </button>
      </form>
    </div>

    {{-- Item List --}}
    <div class="build-items">
      @foreach($build['items'] as $item)
      <div class="build-item">
        <div class="item-dot"></div>
        <span class="item-name">{{ $item['name'] }}</span>
        <span class="item-price">Rp {{ number_format($item['price']) }}</span>
      </div>
      @endforeach
    </div>

    {{-- Total --}}
    <div class="build-total">
      <span class="build-total-label">Total Build</span>
      <span class="build-total-price">Rp {{ number_format($build['total']) }}</span>
    </div>

  </div>

  @empty

  {{-- Empty State --}}
  <div class="cart-empty">
    <div class="cart-empty-icon">🛒</div>
    <div class="cart-empty-title">Keranjang Masih Kosong</div>
    <div class="cart-empty-sub">Belum ada rakitan PC yang ditambahkan.</div>
    <a href="/builder" class="btn-shop">
      🔧 Mulai Rakit PC
    </a>
  </div>

  @endforelse

  {{-- SUMMARY & ACTION --}}
  @if(count(session('cart', [])) > 0)
  <div class="cart-summary">
    <div class="summary-row">
      <span class="summary-label">Total Keseluruhan</span>
      <span class="summary-count">
        Rp {{ number_format(collect(session('cart', []))->sum('total')) }}
      </span>
    </div>
    <div class="summary-actions">

      <form method="POST" action="/cart/clear">
        @csrf
        <button type="submit" class="btn-clear">
          🗑 Kosongkan
        </button>
      </form>

      <form method="POST" action="/transaksi" style="flex:2;">
        @csrf
        <a href="/transaksi" class="btn-checkout" style="flex:2; text-decoration:none;">
          💳 Checkout Sekarang
        </a>
      </form>

    </div>
  </div>
  @endif

</div>

@endsection