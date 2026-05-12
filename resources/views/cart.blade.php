@extends('layouts.app')

@section('title', 'Keranjang - PC Rakit Store')

@section('content')

<style>
  .cart-wrapper {
    max-width: 900px;
    margin: 0 auto;
    padding: 24px 16px 140px;
  }

  .cart-header {
    display: flex; align-items: center; gap: 12px; margin-bottom: 28px;
  }
  .cart-header-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: rgba(0,229,160,0.12); border: 1px solid rgba(0,229,160,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
  }
  .cart-header-title {
    font-family: 'Rajdhani', sans-serif; font-size: 1.8rem;
    font-weight: 700; color: var(--text-primary); line-height: 1;
  }
  .cart-header-sub { font-size: 13px; color: var(--text-muted); margin-top: 3px; }
  .item-count-badge {
    display: inline-flex; align-items: center; justify-content: center;
    background: rgba(0,229,160,0.12); border: 1px solid rgba(0,229,160,0.2);
    color: var(--accent); font-size: 11px; font-weight: 700;
    border-radius: 6px; padding: 2px 7px; margin-left: 6px; vertical-align: middle;
  }

  /* Alerts */
  .alert-box {
    display: flex; align-items: center; gap: 10px;
    border-radius: 10px; padding: 12px 16px; font-size: 14px; margin-bottom: 20px;
  }
  .alert-success { background: rgba(0,229,160,0.08); border: 1px solid rgba(0,229,160,0.25); color: var(--accent); }
  .alert-error   { background: rgba(231,76,60,0.08); border: 1px solid rgba(231,76,60,0.25); color: #e74c3c; }

  /* ===== SELECT ALL BAR ===== */
  .select-all-bar {
    display: flex; align-items: center; justify-content: space-between;
    background: var(--bg-card); border: 1px solid var(--border);
    border-radius: 12px; padding: 12px 16px; margin-bottom: 14px;
    gap: 10px;
  }
  .select-all-left { display: flex; align-items: center; gap: 10px; }
  .select-all-label { font-size: 14px; font-weight: 600; color: var(--text-primary); }
  .selected-count-badge {
    font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 5px;
    background: rgba(0,229,160,0.1); border: 1px solid rgba(0,229,160,0.2);
    color: var(--accent); transition: opacity 0.2s;
  }
  .selected-count-badge.hidden { opacity: 0; pointer-events: none; }

  /* ===== CUSTOM CHECKBOX ===== */
  .custom-check { position: relative; width: 20px; height: 20px; flex-shrink: 0; cursor: pointer; }
  .custom-check input[type="checkbox"] { position: absolute; opacity: 0; width: 0; height: 0; }
  .custom-check .checkmark {
    display: flex; align-items: center; justify-content: center;
    width: 20px; height: 20px; border-radius: 6px;
    border: 2px solid var(--border); background: var(--bg-surface);
    transition: all 0.18s;
  }
  .custom-check input:checked + .checkmark {
    background: var(--accent); border-color: var(--accent);
  }
  .custom-check input:checked + .checkmark::after {
    content: '';
    width: 5px; height: 9px;
    border: 2px solid #0d1a14;
    border-top: none; border-left: none;
    transform: rotate(45deg) translateY(-1px);
  }

  /* ===== CART ITEM CARD ===== */
  .cart-item-card {
    background: var(--bg-card); border: 1px solid var(--border);
    border-radius: 16px; overflow: hidden; margin-bottom: 12px;
    transition: border-color 0.2s, box-shadow 0.2s;
    user-select: none;
  }
  .cart-item-card:hover { border-color: rgba(0,229,160,0.2); }
  .cart-item-card.is-checked {
    border-color: rgba(0,229,160,0.5);
    box-shadow: 0 0 0 3px rgba(0,229,160,0.07);
  }

  .card-inner {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 16px; cursor: pointer;
  }

  /* Thumbnail */
  .item-thumb {
    width: 72px; height: 72px; flex-shrink: 0;
    border-radius: 10px; overflow: hidden;
    background: var(--bg-surface); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
  }
  .item-thumb img { width: 100%; height: 100%; object-fit: cover; }

  @media (max-width: 480px) {
    .item-thumb { width: 52px; height: 52px; font-size: 18px; }
  }

  /* Info */
  .item-info { flex: 1; min-width: 0; }
  .item-badges { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 5px; }
  .item-badge {
    font-size: 10px; padding: 2px 7px; border-radius: 4px;
    background: var(--bg-surface); border: 1px solid var(--border); color: var(--text-muted);
  }
  .item-name {
    font-family: 'Rajdhani', sans-serif; font-size: 1.05rem; font-weight: 700;
    color: var(--text-primary); line-height: 1.3;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;
  }
  .item-sub-list { margin-top: 4px; }
  .item-sub {
    display: flex; justify-content: space-between;
    font-size: 12px; color: var(--text-muted); padding: 2px 0;
  }
  .item-sub-price { color: var(--accent); font-weight: 600; white-space: nowrap; }
  .item-total {
    font-size: 14px; font-weight: 700; color: var(--accent);
    font-family: 'Rajdhani', sans-serif; margin-top: 5px;
  }

  /* Card action (detail link) */
  .item-link {
    display: flex; align-items: center; gap: 5px;
    background: rgba(0,229,160,0.08); border: 1px solid rgba(0,229,160,0.2);
    color: var(--accent); font-size: 12px; font-weight: 600;
    padding: 6px 12px; border-radius: 8px;
    transition: background 0.2s; text-decoration: none; white-space: nowrap;
    flex-shrink: 0;
  }
  .item-link:hover { background: rgba(0,229,160,0.18); }

  /* Empty State */
  .cart-empty { text-align: center; padding: 64px 24px; }
  .cart-empty-icon { font-size: 56px; margin-bottom: 16px; opacity: 0.4; }
  .cart-empty-title {
    font-family: 'Rajdhani', sans-serif; font-size: 1.4rem;
    font-weight: 700; color: var(--text-muted); margin-bottom: 8px;
  }
  .cart-empty-sub { font-size: 14px; color: var(--text-muted); opacity: 0.6; margin-bottom: 24px; }
  .btn-shop {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--accent); color: #0d1a14;
    padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 600;
    text-decoration: none; font-family: 'DM Sans', sans-serif;
    transition: background 0.2s; margin: 4px;
  }
  .btn-shop:hover { background: var(--accent-dim); }
  .btn-shop-outline {
    background: var(--bg-surface); color: var(--text-primary); border: 1px solid var(--border);
  }

  /* ===== STICKY ACTION BAR ===== */
  .action-bar {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: var(--bg-card); border-top: 1px solid var(--border);
    padding: 14px 24px; z-index: 100;
    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    transition: transform 0.3s cubic-bezier(0.34,1.2,0.64,1);
  }
  .action-bar.bar-hidden { transform: translateY(100%); }

  .action-bar-inner {
    max-width: 900px; margin: 0 auto;
    display: flex; align-items: center;
    justify-content: space-between; gap: 14px;
  }

  /* Total info */
  .bar-total-wrap { flex-shrink: 0; }
  .bar-total-label { font-size: 11px; color: var(--text-muted); margin-bottom: 1px; }
  .bar-total-val {
    font-family: 'Rajdhani', sans-serif; font-size: 1.25rem;
    font-weight: 700; color: var(--accent); white-space: nowrap;
  }
  .bar-total-sub { font-size: 11px; color: var(--text-muted); margin-top: 1px; }

  /* Action buttons group */
  .bar-actions { display: flex; gap: 10px; align-items: center; }

  /* Clear all (non-selection) */
  .btn-clear-all {
    display: flex; align-items: center; gap: 6px;
    background: none; border: 1px solid var(--border);
    color: var(--text-muted); padding: 10px 14px;
    border-radius: 10px; font-size: 13px; font-weight: 500;
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    transition: color 0.2s, border-color 0.2s; white-space: nowrap;
  }
  .btn-clear-all:hover { color: #e74c3c; border-color: rgba(231,76,60,0.4); }

  /* Delete selected */
  .btn-delete-selected {
    display: flex; align-items: center; gap: 6px;
    background: rgba(231,76,60,0.1); border: 1px solid rgba(231,76,60,0.3);
    color: #e74c3c; padding: 10px 16px;
    border-radius: 10px; font-size: 13px; font-weight: 600;
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    transition: background 0.2s; white-space: nowrap;
  }
  .btn-delete-selected:hover { background: rgba(231,76,60,0.2); }
  .btn-delete-selected:disabled { opacity: 0.35; cursor: not-allowed; }

  /* Checkout selected */
  .btn-checkout-selected {
    display: flex; align-items: center; gap: 8px;
    background: var(--accent); border: none;
    color: #0d1a14; padding: 10px 20px;
    border-radius: 10px; font-size: 14px; font-weight: 700;
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    transition: background 0.2s; white-space: nowrap;
  }
  .btn-checkout-selected:hover { background: var(--accent-dim); }
  .btn-checkout-selected:disabled { opacity: 0.35; cursor: not-allowed; }

  @media (max-width: 560px) {
    .action-bar { padding: 12px 14px; }
    .bar-total-val { font-size: 1.05rem; }
    .btn-clear-all { display: none; } /* sembunyikan di mobile kecil */
    .btn-delete-selected { padding: 9px 12px; font-size: 12px; }
    .btn-checkout-selected { padding: 9px 14px; font-size: 13px; }
    .cart-header-title { font-size: 1.4rem; }
  }

  /* Confirm dialog overlay */
  .confirm-overlay {
    position: fixed; inset: 0; z-index: 200;
    background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none; transition: opacity 0.2s;
    padding: 16px;
  }
  .confirm-overlay.show { opacity: 1; pointer-events: all; }
  .confirm-box {
    background: var(--bg-card); border: 1px solid var(--border);
    border-radius: 16px; padding: 24px; max-width: 380px; width: 100%;
    transform: scale(0.95); transition: transform 0.2s;
  }
  .confirm-overlay.show .confirm-box { transform: scale(1); }
  .confirm-title {
    font-family: 'Rajdhani', sans-serif; font-size: 1.2rem;
    font-weight: 700; color: var(--text-primary); margin-bottom: 8px;
  }
  .confirm-msg { font-size: 13px; color: var(--text-muted); line-height: 1.6; margin-bottom: 20px; }
  .confirm-actions { display: flex; gap: 10px; }
  .confirm-cancel {
    flex: 1; background: none; border: 1px solid var(--border);
    color: var(--text-muted); padding: 10px; border-radius: 10px;
    font-size: 14px; cursor: pointer; font-family: 'DM Sans', sans-serif;
    transition: border-color 0.2s;
  }
  .confirm-cancel:hover { border-color: rgba(255,255,255,0.2); color: var(--text-primary); }
  .confirm-ok {
    flex: 1; background: rgba(231,76,60,0.9); border: none;
    color: #fff; padding: 10px; border-radius: 10px;
    font-size: 14px; font-weight: 700; cursor: pointer; font-family: 'DM Sans', sans-serif;
    transition: background 0.2s;
  }
  .confirm-ok:hover { background: #e74c3c; }
</style>

<div class="cart-wrapper">

  {{-- HEADER --}}
  <div class="cart-header">
    <div class="cart-header-icon">🛒</div>
    <div>
      <div class="cart-header-title">
        Keranjang
        @php $cartCount = count($cart); @endphp
        @if($cartCount > 0)
          <span class="item-count-badge">{{ $cartCount }} Item</span>
        @endif
      </div>
      <div class="cart-header-sub">Centang item lalu pilih Checkout atau Hapus</div>
    </div>
  </div>

  {{-- ALERTS --}}
  @if(session('success'))
    <div class="alert-box alert-success">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert-box alert-error">❌ {{ session('error') }}</div>
  @endif
  @if(session('cart_added'))
    <div class="alert-box alert-success">🛒 <strong>{{ session('cart_added') }}</strong> berhasil ditambahkan!</div>
  @endif

  @if($cartCount > 0)

  {{-- SELECT ALL BAR --}}
  <div class="select-all-bar">
    <div class="select-all-left">
      <label class="custom-check" title="Pilih Semua">
        <input type="checkbox" id="selectAll">
        <span class="checkmark"></span>
      </label>
      <span class="select-all-label">Pilih Semua</span>
      <span class="selected-count-badge hidden" id="selectedBadge">0 dipilih</span>
    </div>
  </div>

  {{-- ITEM LIST --}}
  @foreach($cart as $index => $entry)
  @php
    $firstName = collect($entry['items'] ?? [])->first()['name'] ?? 'Produk';
    $isMulti   = count($entry['items'] ?? []) > 1;
  @endphp

  <div class="cart-item-card" id="card-{{ $index }}" onclick="toggleCard({{ $index }})">
    <div class="card-inner">

      {{-- Checkbox --}}
      <label class="custom-check" onclick="event.stopPropagation()">
        <input type="checkbox"
               class="item-check"
               data-index="{{ $index }}"
               data-total="{{ $entry['total'] ?? 0 }}"
               onchange="updateBar()">
        <span class="checkmark"></span>
      </label>

      {{-- Thumbnail --}}
      <div class="item-thumb">
        @if(!empty($entry['image']))
          <img src="{{ $entry['image'] }}" alt="{{ $firstName }}">
        @elseif($isMulti) 🖥️
        @else 📦
        @endif
      </div>

      {{-- Info --}}
      <div class="item-info">
        <div class="item-badges">
          @if(!empty($entry['category']))
            <span class="item-badge">🏷 {{ $entry['category'] }}</span>
          @endif
          @if(!empty($entry['brand']))
            <span class="item-badge">🔖 {{ $entry['brand'] }}</span>
          @endif
          @if($isMulti)
            <span class="item-badge" style="color:var(--accent);border-color:rgba(0,229,160,0.2);">🖥️ Build PC</span>
          @endif
        </div>
        <div class="item-name">
          {{ $isMulti ? 'Build PC (' . count($entry['items']) . ' komponen)' : $firstName }}
        </div>
        @if($isMulti)
          <div class="item-sub-list">
            @foreach($entry['items'] as $item)
              <div class="item-sub">
                <span>{{ $item['name'] }}</span>
                <span class="item-sub-price">Rp {{ number_format($item['price']) }}</span>
              </div>
            @endforeach
          </div>
        @endif
        <div class="item-total">Rp {{ number_format($entry['total'] ?? 0) }}</div>
      </div>

      {{-- Detail link --}}
      @if(!$isMulti && !empty($entry['product_id']))
        <a href="/product/{{ $entry['product_id'] }}" class="item-link" onclick="event.stopPropagation()">
          👁 Detail
        </a>
      @endif

    </div>
  </div>
  @endforeach

  @else

  <div class="cart-empty">
    <div class="cart-empty-icon">🛒</div>
    <div class="cart-empty-title">Keranjang Masih Kosong</div>
    <div class="cart-empty-sub">Belum ada produk yang ditambahkan.</div>
    <a href="/products" class="btn-shop">🛍 Lihat Produk</a>
    <a href="/builder" class="btn-shop btn-shop-outline">🔧 Rakit PC</a>
  </div>

  @endif

</div>

{{-- ===== STICKY ACTION BAR ===== --}}
@if($cartCount > 0)
<div class="action-bar bar-hidden" id="actionBar">
  <div class="action-bar-inner">

    {{-- Total --}}
    <div class="bar-total-wrap">
      <div class="bar-total-label">Total Terpilih</div>
      <div class="bar-total-val" id="barTotal">Rp 0</div>
      <div class="bar-total-sub" id="barSub">0 item dipilih</div>
    </div>

    {{-- Buttons --}}
    <div class="bar-actions">

      {{-- Kosongkan semua --}}
      <form method="POST" action="/cart/clear" id="clearAllForm">
        @csrf
        <button type="submit" class="btn-clear-all"
                onclick="return confirm('Kosongkan semua keranjang?')">
          🗑 Kosongkan
        </button>
      </form>

      {{-- Hapus terpilih --}}
      <button class="btn-delete-selected" id="btnDelete" disabled onclick="confirmDelete()">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
          <path d="M11 3L3 11M3 3l8 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
        Hapus
      </button>

      {{-- Checkout terpilih --}}
      <form method="POST" action="/checkout/prepare" id="checkoutForm">
        @csrf
        <div id="checkoutIndexes"></div>
        <button type="submit" class="btn-checkout-selected" id="btnCheckout" disabled>
          💳 Checkout
        </button>
      </form>

    </div>
  </div>
</div>

{{-- Form hapus terpilih (hidden) --}}
<form method="POST" action="/cart/remove-selected" id="deleteForm" style="display:none;">
  @csrf
  <div id="deleteIndexes"></div>
</form>

{{-- Confirm Delete Dialog --}}
<div class="confirm-overlay" id="confirmOverlay">
  <div class="confirm-box">
    <div class="confirm-title">🗑 Hapus Item?</div>
    <div class="confirm-msg" id="confirmMsg">Item yang dipilih akan dihapus dari keranjang.</div>
    <div class="confirm-actions">
      <button class="confirm-cancel" onclick="closeConfirm()">Batal</button>
      <button class="confirm-ok" onclick="doDelete()">Ya, Hapus</button>
    </div>
  </div>
</div>
@endif

<script>
(function () {
  const allChecks   = () => [...document.querySelectorAll('.item-check')];
  const selectAll   = document.getElementById('selectAll');
  const actionBar   = document.getElementById('actionBar');
  const barTotal    = document.getElementById('barTotal');
  const barSub      = document.getElementById('barSub');
  const selectedBadge = document.getElementById('selectedBadge');
  const btnDelete   = document.getElementById('btnDelete');
  const btnCheckout = document.getElementById('btnCheckout');

  // ── Toggle card saat klik area card ──
  window.toggleCard = function (index) {
    const cb = document.querySelector(`.item-check[data-index="${index}"]`);
    if (cb) { cb.checked = !cb.checked; updateBar(); }
  };

  // ── Update sticky bar ──
  window.updateBar = function () {
    let total   = 0;
    let checked = 0;

    allChecks().forEach(cb => {
      if (cb.checked) {
        total   += parseInt(cb.dataset.total) || 0;
        checked++;
      }
    });

    // Tampilan total & info
    barTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
    barSub.textContent   = checked + ' item dipilih';

    // Badge di select-all bar
    if (checked > 0) {
      selectedBadge.textContent = checked + ' dipilih';
      selectedBadge.classList.remove('hidden');
    } else {
      selectedBadge.classList.add('hidden');
    }

    // Highlight card
    allChecks().forEach(cb => {
      const card = document.getElementById('card-' + cb.dataset.index);
      if (card) card.classList.toggle('is-checked', cb.checked);
    });

    // Aktif/nonaktif tombol
    const hasSelected = checked > 0;
    btnDelete.disabled   = !hasSelected;
    btnCheckout.disabled = !hasSelected;

    // Tampilkan/sembunyikan action bar
    if (hasSelected) {
      actionBar.classList.remove('bar-hidden');
    } else {
      actionBar.classList.add('bar-hidden');
    }

    // Sync select all checkbox
    const total_items = allChecks().length;
    selectAll.indeterminate = checked > 0 && checked < total_items;
    selectAll.checked = checked === total_items && total_items > 0;

    // Isi hidden inputs untuk form checkout & delete
    syncForms();
  };

  // ── Sync index ke form checkout & delete ──
  function syncForms() {
    const checkoutContainer = document.getElementById('checkoutIndexes');
    const deleteContainer   = document.getElementById('deleteIndexes');
    if (!checkoutContainer || !deleteContainer) return;

    checkoutContainer.innerHTML = '';
    deleteContainer.innerHTML   = '';

    allChecks().forEach(cb => {
      if (cb.checked) {
        // Checkout
        const i1 = document.createElement('input');
        i1.type = 'hidden'; i1.name = 'selected[]'; i1.value = cb.dataset.index;
        checkoutContainer.appendChild(i1);

        // Delete
        const i2 = document.createElement('input');
        i2.type = 'hidden'; i2.name = 'indexes[]'; i2.value = cb.dataset.index;
        deleteContainer.appendChild(i2);
      }
    });
  }

  // ── Select All ──
  if (selectAll) {
    selectAll.addEventListener('change', function () {
      allChecks().forEach(cb => { cb.checked = this.checked; });
      updateBar();
    });
  }

  // ── Confirm delete dialog ──
  window.confirmDelete = function () {
    const checked = allChecks().filter(cb => cb.checked).length;
    document.getElementById('confirmMsg').textContent =
      checked + ' item yang dipilih akan dihapus dari keranjang. Tindakan ini tidak bisa dibatalkan.';
    document.getElementById('confirmOverlay').classList.add('show');
  };

  window.closeConfirm = function () {
    document.getElementById('confirmOverlay').classList.remove('show');
  };

  window.doDelete = function () {
    document.getElementById('confirmOverlay').classList.remove('show');
    document.getElementById('deleteForm').submit();
  };

  // Tutup overlay saat klik luar box
  document.getElementById('confirmOverlay')?.addEventListener('click', function (e) {
    if (e.target === this) closeConfirm();
  });

  // Init
  updateBar();
})();
</script>

@endsection