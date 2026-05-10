@extends('layouts.app')

@section('title', $product->name . ' - PC Rakit Store')

@section('content')

<style>
    /* ===== PRODUCT DETAIL PAGE ===== */
    .detail-wrapper {
        max-width: 1100px;
        margin: 0 auto;
        padding: 24px 16px 48px;
    }

    /* Back Link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--text-muted);
        font-size: 13px;
        text-decoration: none;
        margin-bottom: 24px;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: var(--text-primary);
    }

    /* ===== PRODUCT DETAIL GRID ===== */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
        margin-bottom: 48px;
    }

    @media (max-width: 680px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    /* Image Box */
    .product-image-box {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 1/1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-surface);
    }

    .product-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-image-placeholder {
        color: var(--text-muted);
        font-size: 13px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        opacity: 0.5;
    }

    /* Info Box */
    .product-info-box {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 20px;
    }

    .product-detail-name {
        font-family: 'Rajdhani', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
        margin-bottom: 10px;
    }

    .product-detail-price {
        font-family: 'Rajdhani', sans-serif;
        font-size: 1.7rem;
        font-weight: 700;
        color: var(--accent);
        margin-bottom: 14px;
    }

    .product-detail-desc {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.7;
    }

    /* Meta badges */
    .product-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .meta-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        color: var(--text-muted);
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 6px;
    }

    /* Add to Cart Button */
    .btn-add-cart {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        background: var(--accent);
        color: #0d1a14;
        border: none;
        padding: 14px 24px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
    }

    .btn-add-cart:hover {
        background: var(--accent-dim);
        transform: translateY(-1px);
    }

    .btn-add-cart:active {
        transform: translateY(0);
    }

    /* ===== RECOMMENDATION SECTION ===== */

    .recom-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .recom-title {
        font-family: 'Rajdhani', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .recom-count {
        font-size: 12px;
        color: var(--text-muted);
        background: var(--bg-surface);
        border: 1px solid var(--border);
        padding: 3px 10px;
        border-radius: 6px;
    }

    /* Recommendation Grid */
    .recom-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 14px;
    }

    @media (max-width: 768px) {
        .recom-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 500px) {
        .recom-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Product Card */
    .rec-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        text-decoration: none;
        display: block;
        transition: border-color 0.2s, transform 0.2s;
    }

    .rec-card:hover {
        border-color: rgba(0, 229, 160, 0.3);
        transform: translateY(-2px);
    }

    .rec-card.hidden-rec {
        display: none;
    }

    .rec-img {
        width: 100%;
        aspect-ratio: 1/1;
        background: var(--bg-surface);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 12px;
        overflow: hidden;
    }

    .rec-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rec-info {
        padding: 10px;
    }

    .rec-name {
        font-size: 13px;
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

    .rec-price {
        font-size: 13px;
        font-weight: 600;
        color: var(--accent);
        margin-bottom: 8px;
    }

    .rec-view {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        background: rgba(0, 229, 160, 0.08);
        border: 1px solid rgba(0, 229, 160, 0.18);
        color: var(--accent);
        font-size: 12px;
        padding: 6px 8px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .rec-card:hover .rec-view {
        background: rgba(0, 229, 160, 0.18);
    }

    /* Show More Button */
    .show-more-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 11px;
        background: none;
        border: 1px solid var(--border);
        color: var(--text-muted);
        border-radius: 10px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: color 0.2s, border-color 0.2s;
        margin-top: 4px;
    }

    .show-more-btn:hover {
        color: var(--text-primary);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .show-more-btn.all-shown {
        color: var(--accent);
        border-color: rgba(0, 229, 160, 0.25);
    }

    .show-more-btn svg {
        transition: transform 0.3s;
    }

    .show-more-btn.expanded svg {
        transform: rotate(180deg);
    }
</style>

<div class="detail-wrapper">

    {{-- BACK LINK --}}
    <a href="javascript:history.back()" class="back-link">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M10 12L6 8l4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        Kembali
    </a>

    {{-- PRODUCT DETAIL --}}
    <div class="detail-grid">

        {{-- IMAGE --}}
        <div class="product-image-box">
            @if($product->image)
            <img src="{{$product->image }}" alt="{{ $product->name }}">
            @else
            <div class="product-image-placeholder">
                <span style="font-size:40px;opacity:0.3;">📦</span>
                <span>Tidak ada gambar</span>
            </div>
            @endif
        </div>

        {{-- INFO --}}
        <div class="product-info-box">
            <div>
                {{-- Meta badges --}}
                <div class="product-meta">
                    {{-- Meta badges --}}
                    <div class="product-meta">
                        @if($product->category)
                        <span class="meta-badge">🏷 {{ $product->category->name ?? $product->category }}</span>
                        @endif
                        @if($product->brand)
                        <span class="meta-badge">🔖 {{ $product->brand->name ?? $product->brand }}</span>
                        @endif
                        @if($product->stock > 0)
                        <span class="meta-badge" style="color:var(--accent);border-color:rgba(0,229,160,0.2);">✅ Stok Tersedia</span>
                        @else
                        <span class="meta-badge" style="color:#e74c3c;border-color:rgba(231,76,60,0.2);">❌ Stok Habis</span>
                        @endif
                    </div>

                    <h1 class="product-detail-name">{{ $product->name }}</h1>
                    <div class="product-detail-price">Rp {{ number_format($product->price) }}</div>
                    <p class="product-detail-desc">{{ $product->description ?? 'Tidak ada deskripsi tersedia.' }}</p>
                </div>

                {{-- ADD TO CART --}}
                <form method="POST" action="/cart/add">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn-add-cart">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M2 2h2l2.4 9.6a1 1 0 0 0 1 .8h7a1 1 0 0 0 1-.76L17 6H5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="7" cy="15.5" r="1" fill="currentColor" />
                            <circle cx="13" cy="15.5" r="1" fill="currentColor" />
                        </svg>
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>

        </div>
    </div>
    {{-- REKOMENDASI --}}
    <div class="recom-section">
        <div class="recom-header">
            <span class="recom-title">Produk Rekomendasi</span>
            <span class="recom-count">{{ $recommended->count() }} Produk</span>
        </div>

        <div class="recom-grid" id="recomGrid">
            @foreach($recommended as $index => $item)
            <a href="/product/{{ $item->id }}"
                class="rec-card{{ $index >= 8 ? ' hidden-rec' : '' }}"
                data-index="{{ $index }}">

                <div class="rec-img">
                    @if($item->image)
                    <img src="{{ $product->image }}" alt="{{ $item->name }}">
                    @else
                    <span>No Image</span>
                    @endif
                </div>

                <div class="rec-info">
                    <div class="rec-name">{{ $item->name }}</div>
                    <div class="rec-price">Rp {{ number_format($item->price) }}</div>
                    <div class="rec-view">👁 Lihat Produk</div>
                </div>

            </a>
            @endforeach
        </div>

        {{-- SHOW MORE BUTTON --}}
        @if($recommended->count() > 8)
        <button class="show-more-btn" id="showMoreRecom" onclick="toggleRecom()">
            <span id="showMoreRecomLabel">Selengkapnya</span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        @endif

    </div>

    <script>
        (function() {
            // Hitung jumlah kolom berdasarkan lebar layar
            function getCols() {
                return window.innerWidth >= 768 ? 4 :
                    window.innerWidth >= 500 ? 3 :
                    2;
            }

            // Awal: tampilkan 2 baris sesuai kolom
            let visibleUntil = getCols() * 2;

            function initRecom() {
                const cards = document.querySelectorAll('#recomGrid .rec-card');
                const btn = document.getElementById('showMoreRecom');
                visibleUntil = getCols() * 2;

                cards.forEach((card, i) => {
                    card.classList.toggle('hidden-rec', i >= visibleUntil);
                });

                if (btn) {
                    const anyHidden = Array.from(cards).some(c => c.classList.contains('hidden-rec'));
                    btn.style.display = anyHidden ? 'flex' : 'none';
                    btn.classList.remove('expanded', 'all-shown');
                    document.getElementById('showMoreRecomLabel').textContent = 'Selengkapnya';
                }
            }

            function toggleRecom() {
                const cards = Array.from(document.querySelectorAll('#recomGrid .rec-card'));
                const btn = document.getElementById('showMoreRecom');
                const label = document.getElementById('showMoreRecomLabel');
                const step = getCols() * 2;

                const anyHidden = cards.some(c => c.classList.contains('hidden-rec'));

                if (anyHidden) {
                    // Tampilkan 2 baris lagi
                    visibleUntil += step;
                    cards.forEach((card, i) => {
                        card.classList.toggle('hidden-rec', i >= visibleUntil);
                    });

                    const stillHidden = cards.some(c => c.classList.contains('hidden-rec'));
                    if (!stillHidden) {
                        label.textContent = 'Sembunyikan';
                        btn.classList.add('expanded', 'all-shown');
                    }
                } else {
                    // Collapse kembali ke 2 baris
                    visibleUntil = step;
                    cards.forEach((card, i) => {
                        card.classList.toggle('hidden-rec', i >= visibleUntil);
                    });
                    label.textContent = 'Selengkapnya';
                    btn.classList.remove('expanded', 'all-shown');
                    document.querySelector('.recom-section').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }

            window.toggleRecom = toggleRecom;

            window.addEventListener('load', initRecom);
            window.addEventListener('resize', initRecom);
        })();
    </script>

    @endsection