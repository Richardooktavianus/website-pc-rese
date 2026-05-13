@extends('layouts.app')

@section('title', 'Komponen PC')

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
        --border: rgba(255, 255, 255, 0.07);
    }

    /* ── Page layout ── */
    .komponen-page {
        max-width: 1280px;
        margin: 0 auto;
        padding: 20px 16px 48px;
    }

    /* ── Search bar (mobile only, full-width) ── */
    .mobile-search {
        display: none;
        margin-bottom: 16px;
    }

    .mobile-search-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 0 14px;
        height: 42px;
    }

    .mobile-search-wrap input {
        flex: 1;
        background: none;
        border: none;
        outline: none;
        color: var(--text-primary);
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
    }

    .mobile-search-wrap input::placeholder {
        color: var(--text-muted);
    }

    @media (max-width: 768px) {
        .mobile-search {
            display: block;
        }
    }

    /* ── Two-column layout ── */
    .layout {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .layout {
            grid-template-columns: 200px 1fr;
            gap: 14px;
        }
    }

    @media (max-width: 768px) {
        .layout {
            grid-template-columns: 1fr;
        }
    }

    /* ══════════════════════════════
     SIDEBAR
  ══════════════════════════════ */
    .sidebar {
        position: sticky;
        top: 76px;
        /* below navbar */
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .sidebar {
            position: static;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            scrollbar-width: none;
            border-radius: 12px;
            gap: 0;
            background: var(--bg-card);
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-header {
            display: none;
        }

        .sidebar-section-title {
            display: none;
        }

        .sidebar-divider {
            display: none;
        }

        .sidebar-footer {
            display: none;
        }
    }

    .sidebar-header {
        padding: 16px 16px 12px;
        border-bottom: 1px solid var(--border);
    }

    .sidebar-title {
        font-family: 'Rajdhani', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-muted);
    }

    .sidebar-search {
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0 10px;
        height: 34px;
    }

    .sidebar-search input {
        flex: 1;
        background: none;
        border: none;
        outline: none;
        color: var(--text-primary);
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
    }

    .sidebar-search input::placeholder {
        color: var(--text-muted);
    }

    .sidebar-search-icon {
        color: var(--text-muted);
        font-size: 12px;
    }

    .sidebar-section-title {
        padding: 10px 16px 6px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--text-muted);
    }

    .cat-list {
        padding: 0 8px 8px;
    }

    .cat-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
        position: relative;
    }

    .cat-link:hover {
        background: rgba(255, 255, 255, 0.04);
    }

    .cat-link.active {
        background: rgba(0, 229, 160, 0.1);
    }

    .cat-link.active .cat-link-label {
        color: var(--accent);
    }

    .cat-link.active .cat-link-icon-wrap {
        border-color: rgba(0, 229, 160, 0.4);
        background: rgba(0, 229, 160, 0.1);
    }

    .cat-link-icon-wrap {
        width: 30px;
        height: 30px;
        flex-shrink: 0;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg-surface);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: border-color 0.2s, background 0.2s;
    }

    .cat-link-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        flex: 1;
        transition: color 0.15s;
        font-family: 'DM Sans', sans-serif;
    }

    .cat-link-count {
        font-size: 11px;
        color: var(--text-muted);
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1px 7px;
        font-family: 'DM Sans', sans-serif;
    }

    .cat-link.active .cat-link-count {
        background: rgba(0, 229, 160, 0.1);
        border-color: rgba(0, 229, 160, 0.3);
        color: var(--accent);
    }

    /* Active indicator bar */
    .cat-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 6px;
        bottom: 6px;
        width: 3px;
        border-radius: 2px;
        background: var(--accent);
    }

    .sidebar-divider {
        height: 1px;
        background: var(--border);
        margin: 4px 16px;
    }

    .sidebar-footer {
        padding: 12px 16px;
        border-top: 1px solid var(--border);
    }

    .sidebar-footer-link {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--text-muted);
        text-decoration: none;
        padding: 6px 0;
        transition: color 0.2s;
    }

    .sidebar-footer-link:hover {
        color: var(--accent);
    }

    /* Mobile: sidebar becomes horizontal tabs */
    @media (max-width: 768px) {
        .cat-list {
            display: flex;
            padding: 8px;
            gap: 6px;
        }

        .cat-link {
            flex-direction: column;
            gap: 4px;
            padding: 8px 10px;
            min-width: 64px;
            align-items: center;
            text-align: center;
            flex-shrink: 0;
            border-radius: 10px;
            border: 1px solid transparent;
        }

        .cat-link.active {
            border-color: rgba(0, 229, 160, 0.3);
        }

        .cat-link.active::before {
            display: none;
        }

        .cat-link-label {
            font-size: 10px;
            letter-spacing: 0.3px;
        }

        .cat-link-count {
            display: none;
        }

        .cat-link-icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 10px;
        }
    }

    /* ══════════════════════════════
     MAIN CONTENT
  ══════════════════════════════ */
    .content {
        min-width: 0;
    }

    /* ── Page heading ── */
    .page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        gap: 12px;
    }

    .page-heading-left {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .page-heading-title {
        font-family: 'Rajdhani', sans-serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }

    .page-heading-sub {
        font-size: 13px;
        color: var(--text-muted);
    }

    .page-heading-right {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    /* Sort dropdown */
    .sort-select {
        background: var(--bg-surface);
        border: 1px solid var(--border);
        color: var(--text-muted);
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
        border-radius: 8px;
        padding: 7px 10px;
        outline: none;
        cursor: pointer;
    }

    .sort-select:focus {
        border-color: rgba(0, 229, 160, 0.4);
        color: var(--text-primary);
    }

    /* View toggle */
    .view-toggle {
        display: flex;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .view-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 14px;
        transition: background 0.15s, color 0.15s;
    }

    .view-btn.active {
        background: rgba(0, 229, 160, 0.1);
        color: var(--accent);
    }

    /* ── Best Seller ── */
    .section-label {
        font-family: 'Rajdhani', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* Best Seller horizontal scroll */
    .bestseller-track {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        scrollbar-width: none;
        padding-bottom: 4px;
        margin-bottom: 24px;
    }

    .bestseller-track::-webkit-scrollbar {
        display: none;
    }

    .bs-card {
        flex: 0 0 auto;
        width: 200px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        text-decoration: none;
        transition: border-color 0.2s, transform 0.2s;
        position: relative;
    }

    .bs-card:hover {
        border-color: rgba(0, 229, 160, 0.35);
        transform: translateY(-3px);
    }

    .bs-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 2;
        background: linear-gradient(135deg, #ff6b35, #f7931e);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
        font-family: 'Rajdhani', sans-serif;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .bs-img {
        width: 100%;
        aspect-ratio: 1/1;
        background: var(--bg-surface);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: var(--text-muted);
        overflow: hidden;
    }

    .bs-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .bs-info {
        padding: 10px;
    }

    .bs-name {
        font-size: 12px;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 4px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .bs-price {
        font-size: 13px;
        font-weight: 600;
        color: var(--accent);
    }

    /* ── Product Grid ── */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    @media (max-width: 1100px) {
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 640px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* List view override */
    .product-grid.list-view {
        grid-template-columns: 1fr;
    }

    .product-grid.list-view .prod-card {
        flex-direction: row;
        max-height: 110px;
    }

    .product-grid.list-view .prod-img {
        aspect-ratio: unset;
        width: 110px;
        height: 110px;
        flex-shrink: 0;
    }

    .product-grid.list-view .prod-info {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
        padding: 12px 14px;
    }

    .product-grid.list-view .prod-name {
        flex: 1;
        -webkit-line-clamp: 1;
        line-clamp: 1;
    }

    .product-grid.list-view .prod-price {
        white-space: nowrap;
    }

    .prod-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        transition: border-color 0.2s, transform 0.2s;
        animation: fadeUp 0.3s ease both;
    }

    .prod-card:hover {
        border-color: rgba(0, 229, 160, 0.3);
        transform: translateY(-2px);
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .prod-img {
        width: 100%;
        aspect-ratio: 1/1;
        background: var(--bg-surface);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: var(--text-muted);
        overflow: hidden;
        position: relative;
    }

    .prod-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .prod-card:hover .prod-img img {
        transform: scale(1.04);
    }

    .prod-stock-badge {
        position: absolute;
        top: 7px;
        right: 7px;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 4px;
        font-family: 'Rajdhani', sans-serif;
        letter-spacing: 0.5px;
    }

    .prod-stock-badge.in {
        background: rgba(0, 229, 160, 0.15);
        color: var(--accent);
        border: 1px solid rgba(0, 229, 160, 0.3);
    }

    .prod-stock-badge.out {
        background: rgba(231, 76, 60, 0.12);
        color: #ff6b6b;
        border: 1px solid rgba(231, 76, 60, 0.3);
    }

    .prod-info {
        padding: 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .prod-cat-tag {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .prod-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 6px;
        line-height: 1.3;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .prod-price {
        font-size: 13px;
        font-weight: 600;
        color: var(--accent);
        margin-bottom: 8px;
    }

    .prod-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: rgba(0, 229, 160, 0.08);
        border: 1px solid rgba(0, 229, 160, 0.2);
        color: var(--accent);
        font-size: 12px;
        font-weight: 500;
        padding: 7px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .prod-card:hover .prod-btn {
        background: rgba(0, 229, 160, 0.16);
    }

    /* ── Empty state ── */
    .empty-state {
        grid-column: 1/-1;
        padding: 48px 20px;
        text-align: center;
    }

    .empty-state-icon {
        font-size: 40px;
        margin-bottom: 12px;
    }

    .empty-state-title {
        font-family: 'Rajdhani', sans-serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .empty-state-sub {
        font-size: 13px;
        color: var(--text-muted);
    }

    /* ── Load more ── */
    .load-more-wrap {
        margin-top: 20px;
        text-align: center;
    }

    .load-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 28px;
        background: none;
        border: 1px solid var(--border);
        border-radius: 10px;
        color: var(--text-muted);
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: color 0.2s, border-color 0.2s;
    }

    .load-more-btn:hover {
        color: var(--text-primary);
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* ── Results info ── */
    .results-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        gap: 8px;
    }

    .results-count {
        font-size: 13px;
        color: var(--text-muted);
    }

    .results-count span {
        color: var(--text-primary);
        font-weight: 600;
    }

    /* //scroll horizontal category */
    @media (max-width: 768px) {
        .cat-list {
            display: flex;
            padding: 8px;
            gap: 8px;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            cursor: grab;
        }

        .cat-list:active {
            cursor: grabbing;
        }

        .cat-list::-webkit-scrollbar {
            display: none;
        }

        .cat-link {
            flex-shrink: 0;
        }
    }
</style>
@if(request('cat'))
<h2>Kategori: {{ request('cat') }}</h2>
@endif
<div class="komponen-page">

    <!-- MOBILE SEARCH -->
<div class="mobile-search">
    <div class="mobile-search-wrap">
        <span style="color:var(--text-muted);font-size:14px;">🔍</span>
        <input
            type="text"
            id="mobileSearchInput"
            placeholder="Cari komponen..."
            oninput="filterProducts(this.value)">
    </div>
</div>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="sidebar-header">
            <div class="sidebar-title">Kategori</div>

            <div class="sidebar-search">
                <span class="sidebar-search-icon">🔍</span>

                <input
                    type="text"
                    placeholder="Cari kategori..."
                    oninput="filterCategories(this.value)">
            </div>
        </div>

        <div class="sidebar-section-title">
            Semua Komponen
        </div>

        <div class="cat-list" id="catList">

            <!-- ALL -->
            <a href="javascript:void(0)"
                class="cat-link active"
                data-cat="all"
                onclick="selectCategory('all', this)">

                <div class="cat-link-icon-wrap">⚡</div>

                <span class="cat-link-label">
                    Semua
                </span>

                <span class="cat-link-count">
                    {{ $products->count() }}
                </span>

            </a>

            @php
                $catIcons = [
                    'CPU' => '🖥️',
                    'Prosesor' => '🖥️',
                    'RAM' => '💾',
                    'GPU' => '🎮',
                    'VGA' => '🎮',
                    'Storage' => '💿',
                    'SSD' => '💿',
                    'HDD' => '💿',
                    'PSU' => '⚡',
                    'Power Supply' => '⚡',
                    'Cooling' => '❄️',
                    'Pendingin' => '❄️',
                    'Motherboard' => '🔧',
                    'Mobo' => '🔧',
                    'Casing' => '🗄️',
                    'Case' => '🗄️',
                    'Periferal' => '🖱️',
                    'Peripheral' => '🖱️',
                    'Monitor' => '🖥️',
                ];
            @endphp

            @foreach($categories as $cat)

            <a href="javascript:void(0)"
                class="cat-link"
                data-cat="{{ strtolower($cat->slug) }}"
                onclick="selectCategory('{{ strtolower($cat->slug) }}', this)">

                <div class="cat-link-icon-wrap">
                    {{ $catIcons[$cat->name] ?? '📦' }}
                </div>

                <span class="cat-link-label">
                    {{ $cat->name }}
                </span>

                <span class="cat-link-count">
                    {{ $cat->products_count }}
                </span>

            </a>

            @endforeach

        </div>

        <div class="sidebar-divider"></div>

        <div class="sidebar-footer">

            <a href="/builder" class="sidebar-footer-link">
                🔧 <span>PC Builder</span>
            </a>

            <a href="/promo" class="sidebar-footer-link">
                🏷️ <span>Promo Aktif</span>
            </a>

        </div>

    </aside>

    <!-- CONTENT -->
    <div class="content">

        <!-- PAGE HEADER -->
        <div class="page-heading">

            <div class="page-heading-left">

                <div class="page-heading-title" id="pageTitle">
                    Semua Komponen
                </div>

                <div class="page-heading-sub" id="pageSubtitle">
                    Pilih komponen terbaik untuk build kamu
                </div>

            </div>

            <div class="page-heading-right">

                <select class="sort-select"
                    onchange="sortProducts(this.value)">

                    <option value="default">
                        Urutkan
                    </option>

                    <option value="price-asc">
                        Harga: Terendah
                    </option>

                    <option value="price-desc">
                        Harga: Tertinggi
                    </option>

                    <option value="name-asc">
                        Nama: A-Z
                    </option>

                    <option value="name-desc">
                        Nama: Z-A
                    </option>

                </select>

                <div class="view-toggle">

                    <button
                        class="view-btn active"
                        id="gridBtn"
                        onclick="setView('grid')">

                        ⊞
                    </button>

                    <button
                        class="view-btn"
                        id="listBtn"
                        onclick="setView('list')">

                        ☰
                    </button>

                </div>

            </div>

        </div>

        <!-- BEST SELLER -->
        <div class="section-label">
            🔥 Best Seller
        </div>

        <div class="bestseller-track" id="bsTrack">

            @foreach($products->take(6) as $i => $item)

            <a href="/product/{{ $item->id }}"
                class="bs-card"
                data-cat="{{ strtolower($item->category->slug ?? '') }}">

                @if($i < 3)
                <div class="bs-badge">
                    #{{ $i + 1 }} Terlaris
                </div>
                @endif

                <div class="bs-img">

                    @if($item->image)

                    <img
                src="{{ $item->image }}"
                alt="{{ $item->name }}">

                    @else
                    📦
                    @endif

                </div>

                <div class="bs-info">

                    <div class="bs-name">
                        {{ $item->name }}
                    </div>

                    <div class="bs-price">
                        Rp {{ number_format($item->price) }}
                    </div>

                </div>

            </a>

            @endforeach

        </div>

        <!-- RESULT INFO -->
        <div class="results-info">

            <div class="results-count">

                Menampilkan
                <span id="visibleCount">
                    {{ $products->count() }}
                </span>
                produk

            </div>

        </div>

        <!-- PRODUCT GRID -->
        <div class="section-label">
            📦 Semua Produk
        </div>

        <div class="product-grid" id="productGrid">

            @forelse($products as $product)

            <a href="/product/{{ $product->id }}"
                class="prod-card"
                data-cat="{{ strtolower($product->category->slug ?? '') }}"
                data-name="{{ strtolower($product->name) }}"
                data-price="{{ $product->price }}">

                <div class="prod-img">

                    @if($product->image)

<img src="{{ $product->image }}" alt="{{ $product->name }}">

                    @else
                    📦
                    @endif

                    <div class="prod-stock-badge in">
                        Tersedia
                    </div>

                </div>

                <div class="prod-info">

                    <div class="prod-cat-tag">
                        {{ $product->category->name ?? 'Komponen' }}
                    </div>

                    <div class="prod-name">
                        {{ $product->name }}
                    </div>

                    <div class="prod-price">
                        Rp {{ number_format($product->price) }}
                    </div>

                    <div class="prod-btn">
                        👁 Lihat Detail
                    </div>

                </div>

            </a>

            @empty

            <div class="empty-state">

                <div class="empty-state-icon">
                    📦
                </div>

                <div class="empty-state-title">
                    Belum Ada Produk
                </div>

                <div class="empty-state-sub">
                    Produk akan segera tersedia.
                </div>

            </div>

            @endforelse

        </div>

        <!-- LOAD MORE -->
        <div
            class="load-more-wrap"
            id="loadMoreWrap"
            style="display:none;">

            <button
                class="load-more-btn"
                onclick="loadMore()">

                Tampilkan Lebih Banyak ↓

            </button>

        </div>

    </div>

</div><!-- end .layout -->
</div>

<script>

let currentCat = 'all';
let currentSearch = '';
let currentSort = 'default';

const BATCH = 12;
let visibleCount = BATCH;

/* =========================
   HELPERS
========================= */

function allCards() {
    return Array.from(
        document.querySelectorAll('#productGrid .prod-card')
    );
}

function allBsCards() {
    return Array.from(
        document.querySelectorAll('#bsTrack .bs-card')
    );
}

/* =========================
   APPLY FILTER
========================= */

function applyFilters() {

    const cards = allCards();

    let matched = cards.filter(card => {

        const cardCat =
            (card.dataset.cat || '').toLowerCase();

        const cardName =
            (card.dataset.name || '').toLowerCase();

        const catMatch =
            currentCat === 'all' ||
            cardCat === currentCat;

        const searchMatch =
            cardName.includes(currentSearch);

        return catMatch && searchMatch;
    });

    /* SORTING */
    if(currentSort !== 'default') {

        matched.sort((a, b) => {

            const pa =
                parseFloat(a.dataset.price) || 0;

            const pb =
                parseFloat(b.dataset.price) || 0;

            const na =
                a.dataset.name || '';

            const nb =
                b.dataset.name || '';

            switch(currentSort) {

                case 'price-asc':
                    return pa - pb;

                case 'price-desc':
                    return pb - pa;

                case 'name-asc':
                    return na.localeCompare(nb);

                case 'name-desc':
                    return nb.localeCompare(na);

                default:
                    return 0;
            }

        });
    }

    /* RESET */
    cards.forEach(card => {
        card.style.display = 'none';
    });

    /* REORDER DOM */
    const grid =
        document.getElementById('productGrid');

    matched.forEach(card => {
        grid.appendChild(card);
    });

    /* SHOW LIMITED */
    matched.forEach((card, index) => {

        if(index < visibleCount) {
            card.style.display = '';
        }

    });

    /* UPDATE COUNT */
    document.getElementById('visibleCount')
        .textContent = matched.length;

    /* BEST SELLER FILTER */
    allBsCards().forEach(card => {

        const cardCat =
            (card.dataset.cat || '').toLowerCase();

        const show =
            currentCat === 'all' ||
            cardCat === currentCat;

        card.style.display =
            show ? '' : 'none';
    });

    /* LOAD MORE */
    document.getElementById('loadMoreWrap')
        .style.display =
            matched.length > visibleCount
                ? 'block'
                : 'none';

    /* EMPTY STATE */
    let empty =
        document.querySelector('.dynamic-empty');

    if(matched.length === 0) {

        if(!empty) {

            empty = document.createElement('div');

            empty.className =
                'empty-state dynamic-empty';

            empty.innerHTML = `
                <div class="empty-state-icon">
                    🔍
                </div>

                <div class="empty-state-title">
                    Produk Tidak Ditemukan
                </div>

                <div class="empty-state-sub">
                    Coba kata kunci atau kategori lain
                </div>
            `;

            grid.appendChild(empty);
        }

    } else {

        if(empty) {
            empty.remove();
        }
    }
}

/* =========================
   CATEGORY
========================= */

function selectCategory(cat, el) {

    currentCat = cat.toLowerCase();

    visibleCount = BATCH;

    document.querySelectorAll('.cat-link')
        .forEach(link => {
            link.classList.remove('active');
        });

    el.classList.add('active');

    document.getElementById('pageTitle')
        .textContent =
            cat === 'all'
                ? 'Semua Komponen'
                : cat.toUpperCase();

    document.getElementById('pageSubtitle')
        .textContent =
            cat === 'all'
                ? 'Pilih komponen terbaik untuk build kamu'
                : `Menampilkan kategori ${cat}`;

    applyFilters();
}

/* =========================
   SEARCH PRODUCT
========================= */

function filterProducts(val) {

    currentSearch =
        val.toLowerCase();

    visibleCount = BATCH;

    applyFilters();
}

/* =========================
   SORT PRODUCT
========================= */

function sortProducts(val) {

    currentSort = val;

    applyFilters();
}

/* =========================
   VIEW MODE
========================= */

function setView(view) {

    const grid =
        document.getElementById('productGrid');

    if(view === 'list') {

        grid.classList.add('list-view');

        document.getElementById('listBtn')
            .classList.add('active');

        document.getElementById('gridBtn')
            .classList.remove('active');

    } else {

        grid.classList.remove('list-view');

        document.getElementById('gridBtn')
            .classList.add('active');

        document.getElementById('listBtn')
            .classList.remove('active');
    }
}

/* =========================
   LOAD MORE
========================= */

function loadMore() {

    visibleCount += BATCH;

    applyFilters();
}

/* =========================
   FILTER CATEGORY
========================= */

function filterCategories(val) {

    val = val.toLowerCase();

    document.querySelectorAll('.cat-link')
        .forEach(link => {

            const cat =
                (link.dataset.cat || '')
                .toLowerCase();

            if(cat === 'all') {
                link.style.display = '';
                return;
            }

            link.style.display =
                cat.includes(val)
                    ? ''
                    : 'none';
        });
}

/* =========================
   URL PARAM
========================= */

(function () {

    const params =
        new URLSearchParams(window.location.search);

    const catParam =
        params.get('cat');

    const searchParam =
        params.get('search');

    /* SEARCH */
    if(searchParam) {

        currentSearch =
            searchParam.toLowerCase();

        const mobileInput =
            document.getElementById(
                'mobileSearchInput'
            );

        if(mobileInput) {
            mobileInput.value = searchParam;
        }
    }

    /* CATEGORY */
    if(catParam) {

        const links =
            document.querySelectorAll('.cat-link');

        let matched = null;

        links.forEach(link => {

            const cat =
                (link.dataset.cat || '')
                .toLowerCase();

            if(cat === catParam.toLowerCase()) {
                matched = link;
            }

        });

        if(matched) {

            selectCategory(
                catParam.toLowerCase(),
                matched
            );

            matched.scrollIntoView({
                behavior: 'smooth',
                inline: 'center'
            });
        }
    }

    applyFilters();

})();

/* =========================
   DRAG SCROLL MOBILE
========================= */

const catList =
    document.getElementById('catList');

let isDown = false;
let startX;
let scrollLeft;

catList.addEventListener('mousedown', e => {

    isDown = true;

    startX =
        e.pageX - catList.offsetLeft;

    scrollLeft =
        catList.scrollLeft;
});

catList.addEventListener('mouseleave', () => {
    isDown = false;
});

catList.addEventListener('mouseup', () => {
    isDown = false;
});

catList.addEventListener('mousemove', e => {

    if(!isDown) return;

    e.preventDefault();

    const x =
        e.pageX - catList.offsetLeft;

    const walk =
        (x - startX) * 1.5;

    catList.scrollLeft =
        scrollLeft - walk;
});

/* TOUCH MOBILE */
/* karena manusia suka geser kategori pakai jempol. Evolusi milyaran tahun dipakai buat scroll komponen VGA. */

let touchStartX = 0;
let touchScrollLeft = 0;

catList.addEventListener('touchstart', e => {

    touchStartX =
        e.touches[0].pageX;

    touchScrollLeft =
        catList.scrollLeft;
});

catList.addEventListener('touchmove', e => {

    const x =
        e.touches[0].pageX;

    const walk =
        (x - touchStartX) * 1.5;

    catList.scrollLeft =
        touchScrollLeft - walk;
});

</script>

@endsection