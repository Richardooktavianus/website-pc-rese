@extends('layouts.app')

@section('title', 'PC Rakit Store - Home')

@section('content')

<style>
  /* ========== BANNER SLIDER ========== */
  .banner-wrap {
    position: relative; border-radius: 16px; overflow: hidden;
    margin-bottom: 20px; background: var(--bg-surface);
  }
  .banner-track { display: flex; transition: transform 0.5s cubic-bezier(0.4,0,0.2,1); }
  .banner-slide {
    min-width: 100%; height: 180px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Rajdhani', sans-serif; color: var(--text-muted);
  }
  .banner-slide.b1 { background: linear-gradient(135deg, #0d2b1e 0%, #0d1a2e 100%); }
  .banner-slide.b2 { background: linear-gradient(135deg, #1a1a0d 0%, #2b1a0d 100%); }
  .banner-slide.b3 { background: linear-gradient(135deg, #1a0d2b 0%, #0d1a2b 100%); }
  .banner-slide .banner-content { text-align: center; }
  .banner-slide .banner-title { font-size: clamp(1.3rem, 4vw, 2rem); font-weight: 700; color: var(--text-primary); }
  .banner-slide .banner-sub { font-size: 14px; color: var(--text-muted); font-family: 'DM Sans', sans-serif; margin-top: 4px; }
  .banner-slide .banner-tag {
    display: inline-block; background: var(--accent); color: #0d1a14;
    font-size: 12px; font-weight: 700; border-radius: 4px;
    padding: 2px 10px; margin-top: 10px; font-family: 'DM Sans', sans-serif;
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

  /* ========== CATEGORY ========== */
  .cat-section { padding: 0; margin-bottom: 20px; }
  .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
  .section-title-text {
    font-family: 'Rajdhani', sans-serif; font-size: 1rem; font-weight: 700;
    color: var(--text-muted); letter-spacing: 2px; text-transform: uppercase;
  }
  .section-link { font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 600; transition: opacity 0.2s; }
  .section-link:hover { opacity: 0.7; }
  .section-title {
    font-family: 'Rajdhani', sans-serif; font-size: 1rem; font-weight: 700;
    color: var(--text-muted); letter-spacing: 2px; text-transform: uppercase;
    margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;
  }
  .section-title a { font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 600; }

  .category-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; justify-items: center; }
  .cat-item { display: flex; flex-direction: column; align-items: center; gap: 8px; cursor: pointer; width: 100%; max-width: 80px; text-decoration: none; }
  .cat-icon-wrap {
    width: 60px; height: 60px; border-radius: 16px;
    background: var(--bg-card); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    transition: border-color 0.25s, transform 0.2s; position: relative; overflow: hidden;
  }
  .cat-icon-wrap::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(circle at center, rgba(0,229,160,0) 0%, transparent 70%);
    transition: background 0.3s; border-radius: 16px;
  }
  .cat-item:hover .cat-icon-wrap { border-color: rgba(0,229,160,0.4); transform: translateY(-3px); }
  .cat-item:hover .cat-icon-wrap::before { background: radial-gradient(circle at center, rgba(0,229,160,0.1) 0%, transparent 70%); }
  .cat-svg { width: 28px; height: 28px; display: block; }
  .cat-label {
    font-family: 'Rajdhani', sans-serif; font-size: 11px; font-weight: 600;
    color: var(--text-muted); text-align: center; letter-spacing: 0.5px;
    text-transform: uppercase; transition: color 0.2s;
  }
  .cat-item:hover .cat-label { color: var(--text-primary); }

  @media (max-width: 640px) {
    .category-grid { grid-template-columns: repeat(5, 1fr); gap: 8px; }
    .cat-icon-wrap { width: 52px; height: 52px; border-radius: 14px; }
  }
  @media (max-width: 400px) {
    .category-grid { display: flex; flex-wrap: nowrap; overflow-x: auto; justify-content: flex-start; gap: 10px; padding-bottom: 6px; scrollbar-width: none; }
    .category-grid::-webkit-scrollbar { display: none; }
    .cat-item { flex: 0 0 auto; width: 60px; }
  }

  /* ========== BRAND TICKER ========== */
  .brand-bar {
    position: relative; border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px; padding: 18px 20px; margin-bottom: 20px;
    overflow: hidden; display: flex; align-items: center; gap: 16px;
    background-color: #111;
    background-image: linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size: 36px 36px;
    box-shadow: 0 0 0 1px rgba(255,255,255,0.04), inset 0 1px 0 rgba(255,255,255,0.06);
  }
  .brand-bar::before, .brand-bar::after { content: ''; position: absolute; top: 0; bottom: 0; width: 80px; z-index: 2; pointer-events: none; }
  .brand-bar::before { left: 0; background: linear-gradient(to right, #111 0%, transparent 100%); }
  .brand-bar::after  { right: 0; background: linear-gradient(to left, #111 0%, transparent 100%); }
  .brand-label {
    font-family: 'Orbitron', sans-serif; font-size: 9px; color: #76b900; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; white-space: nowrap;
    position: relative; z-index: 3; padding-right: 16px;
    border-right: 1px solid rgba(118,185,0,0.3); text-shadow: 0 0 8px rgba(118,185,0,0.5);
  }
  .brand-scroll-wrapper { flex: 1; overflow: hidden; position: relative; }
  .brand-track { display: flex; width: max-content; animation: marquee 20s linear infinite; }
  .brand-track:hover { animation-play-state: paused; }
  @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
  .brand-item { display: flex; align-items: center; justify-content: center; padding: 6px 32px; border-right: 1px solid rgba(255,255,255,0.06); cursor: default; }
  .brand-name { font-family: 'Rajdhani', sans-serif; font-size: 15px; font-weight: 700; color: rgba(255,255,255,0.35); white-space: nowrap; letter-spacing: 1.5px; text-transform: uppercase; transition: all 0.3s ease; }
  .brand-item:hover .brand-name { color: #fff; text-shadow: 0 0 12px rgba(255,255,255,0.4); }
  .brand-item[data-brand="NVIDIA"]:hover   .brand-name { color: #76b900; text-shadow: 0 0 12px rgba(118,185,0,0.5); }
  .brand-item[data-brand="INTEL"]:hover    .brand-name { color: #0071c5; text-shadow: 0 0 12px rgba(0,113,197,0.5); }
  .brand-item[data-brand="ASUS"]:hover     .brand-name { color: #1a9bd7; text-shadow: 0 0 12px rgba(26,155,215,0.5); }
  .brand-item[data-brand="MSI"]:hover      .brand-name { color: #e31e24; text-shadow: 0 0 12px rgba(227,30,36,0.5); }
  .brand-item[data-brand="CORSAIR"]:hover  .brand-name { color: #ffd700; text-shadow: 0 0 12px rgba(255,215,0,0.5); }
  .brand-item[data-brand="AMD"]:hover      .brand-name { color: #ed1c24; text-shadow: 0 0 12px rgba(237,28,36,0.5); }
  .brand-item[data-brand="GIGABYTE"]:hover .brand-name { color: #e7792b; text-shadow: 0 0 12px rgba(231,121,43,0.5); }

  /* ========== BUILDER BUTTON ========== */
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

  /* ========== PRODUCT GRID ========== */
  .product-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 12px; }
  @media (min-width: 640px) { .product-grid { grid-template-columns: repeat(3, 1fr); } }
  @media (min-width: 900px) { .product-grid { grid-template-columns: repeat(4, 1fr); } }

  .product-card {
    background: var(--bg-card); border: 1px solid var(--border); border-radius: 14px;
    overflow: hidden; transition: border-color 0.2s, transform 0.2s;
    cursor: pointer; text-decoration: none; display: block;
  }
  .product-card:hover { border-color: rgba(0,229,160,0.3); transform: translateY(-2px); }
  .product-img { width: 100%; aspect-ratio: 1/1; background: var(--bg-surface); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 12px; overflow: hidden; }
  .product-img img { width: 100%; height: 100%; object-fit: cover; }
  .product-info { padding: 10px; }
  .product-name {
    font-size: 13px; font-weight: 500; color: var(--text-primary);
    margin-bottom: 4px; line-height: 1.3;
    display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
  }
  .product-price { font-size: 13px; font-weight: 600; color: var(--accent); margin-bottom: 8px; }
  .product-view {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    background: rgba(0,229,160,0.1); border: 1px solid rgba(0,229,160,0.2);
    color: var(--accent); font-size: 12px; font-weight: 500;
    padding: 7px 10px; border-radius: 8px; transition: background 0.2s;
  }
  .product-card:hover .product-view { background: rgba(0,229,160,0.2); }

  /* ========== SHOW MORE ========== */
  .show-more-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px; background: none; border: 1px solid var(--border);
    color: var(--text-muted); border-radius: 10px; font-size: 14px;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: color 0.2s, border-color 0.2s; margin-bottom: 20px;
  }
  .show-more-btn:hover { color: var(--text-primary); border-color: rgba(255,255,255,0.2); }
  .show-more-btn svg { transition: transform 0.3s; }
  .show-more-btn.expanded svg { transform: rotate(180deg); }

  /* ========== SPECIAL OFFER ========== */
  .offers-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px; }
  @media (min-width: 640px) { .offers-grid { grid-template-columns: repeat(4, 1fr); } }
  .offer-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; cursor: pointer; transition: border-color 0.2s; text-decoration: none; display: block; }
  .offer-card:hover { border-color: rgba(255,180,0,0.4); }
  .offer-img { width: 100%; aspect-ratio: 4/3; background: var(--bg-surface); display: flex; align-items: center; justify-content: center; font-size: 28px; }
  .offer-badge { margin: 8px 10px 10px; display: inline-flex; align-items: center; gap: 4px; background: rgba(255,180,0,0.12); border: 1px solid rgba(255,180,0,0.3); color: #ffb400; font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 6px; }

  /* ========== LOAD MORE ========== */
  .load-more-btn {
    display: block; width: 100%; padding: 12px; background: none;
    border: 1px solid var(--border); color: var(--text-muted); border-radius: 10px;
    font-size: 14px; font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: color 0.2s, border-color 0.2s; text-align: center; margin-bottom: 20px;
  }
  .load-more-btn:hover { color: var(--text-primary); border-color: rgba(255,255,255,0.2); }

  /* ========== PROMO BANNER ========== */
  .promo-banner {
    border-radius: 16px; padding: 28px 24px;
    background: linear-gradient(135deg, #0d2b1e 0%, #0f1d30 100%);
    border: 1px solid rgba(0,229,160,0.15);
    display: flex; flex-direction: column; gap: 8px;
    margin-bottom: 20px; position: relative; overflow: hidden;
  }
  .promo-banner::after { content: ''; position: absolute; right: -30px; top: -30px; width: 140px; height: 140px; border-radius: 50%; background: rgba(0,229,160,0.06); }
  .promo-title { font-family: 'Rajdhani', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--text-primary); }
  .promo-sub { font-size: 13px; color: var(--text-muted); }
  .promo-cta {
    margin-top: 8px; display: inline-flex; align-items: center; gap: 6px;
    background: var(--accent); color: #0d1a14; padding: 9px 20px; border-radius: 8px;
    font-size: 13px; font-weight: 600; width: fit-content; cursor: pointer;
    text-decoration: none; font-family: 'DM Sans', sans-serif;
  }
</style>

{{-- BANNER SLIDER --}}
<div class="banner-wrap">
  <div class="banner-track" id="bannerTrack">

    {{-- Slide 1 --}}
    <div class="banner-slide">
      <img src="{{ asset('images/banner/banner1.png') }}" alt="Rakit PC Impianmu" class="banner-img">
      <div class="banner-overlay"></div>
    </div>

    {{-- Slide 2 --}}
    <div class="banner-slide">
      <img src="{{ asset('images/banner/banner2.png') }}" alt="GPU RTX Series 50" class="banner-img">
      <div class="banner-overlay"></div>
    </div>

    {{-- Slide 3 --}}
    <div class="banner-slide">
      <img src="{{ asset('images/banner/banner3.png') }}" alt="Prosesor AMD Ryzen 9" class="banner-img">
      <div class="banner-overlay"></div>
    </div>

  </div>

  <button class="banner-btn prev" onclick="prevSlide()">&#8249;</button>
  <button class="banner-btn next" onclick="nextSlide()">&#8250;</button>

  <div class="banner-dots" id="bannerDots">
    <div class="dot active" onclick="goSlide(0)"></div>
    <div class="dot" onclick="goSlide(1)"></div>
    <div class="dot" onclick="goSlide(2)"></div>
  </div>
</div>

{{-- CATEGORY --}}
@php
$categories = [
  ['label'=>'CPU',      'db'=>'Processor',  'icon'=>'cpu'],
  ['label'=>'RAM',      'db'=>'RAM',         'icon'=>'ram'],
  ['label'=>'GPU',      'db'=>'VGA / GPU',   'icon'=>'gpu'],
  ['label'=>'Storage',  'db'=>'SSD',         'icon'=>'storage'],
  ['label'=>'PSU',      'db'=>'PSU',         'icon'=>'psu'],
  ['label'=>'Cooling',  'db'=>'Cooling',     'icon'=>'cooling'],
  ['label'=>'Mobo',     'db'=>'MotherBoard', 'icon'=>'mobo'],
  ['label'=>'Periferal','db'=>'Fan',         'icon'=>'periferal'],
  ['label'=>'Casing',   'db'=>'Casing',      'icon'=>'casing'],
];
@endphp

<div class="cat-section">
  <div class="section-header">
    <span class="section-title-text">Kategori</span>
    <a href="/komponen" class="section-link">Lihat Semua →</a>
  </div>
  <div class="category-grid">
    @foreach($categories as $cat)
    <a href="/komponen?cat={{ urlencode($cat['db']) }}" class="cat-item">
      <div class="cat-icon-wrap">
        @if($cat['icon'] == 'cpu')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <rect x="4" y="6" width="20" height="13" rx="2" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" fill="none"/>
            <rect x="7" y="9" width="14" height="7" rx="1" fill="rgba(0,229,160,0.12)" stroke="rgba(0,229,160,0.4)" stroke-width="1"/>
            <line x1="11" y1="19" x2="17" y2="19" stroke="rgba(0,229,160,0.8)" stroke-width="1.5"/>
            <line x1="14" y1="19" x2="14" y2="22" stroke="rgba(0,229,160,0.8)" stroke-width="1.5"/>
            <line x1="10" y1="22" x2="18" y2="22" stroke="rgba(0,229,160,0.8)" stroke-width="1.5"/>
          </svg>
        @elseif($cat['icon'] == 'ram')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <rect x="5" y="9" width="18" height="10" rx="1.5" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" fill="none"/>
            <rect x="8" y="12" width="4" height="4" rx="0.5" fill="rgba(0,229,160,0.15)" stroke="rgba(0,229,160,0.5)" stroke-width="1"/>
            <rect x="14" y="12" width="4" height="4" rx="0.5" fill="rgba(0,229,160,0.15)" stroke="rgba(0,229,160,0.5)" stroke-width="1"/>
            <line x1="8"  y1="9" x2="8"  y2="7" stroke="rgba(0,229,160,0.5)" stroke-width="1.5"/>
            <line x1="11" y1="9" x2="11" y2="7" stroke="rgba(0,229,160,0.5)" stroke-width="1.5"/>
            <line x1="14" y1="9" x2="14" y2="7" stroke="rgba(0,229,160,0.5)" stroke-width="1.5"/>
            <line x1="17" y1="9" x2="17" y2="7" stroke="rgba(0,229,160,0.5)" stroke-width="1.5"/>
            <line x1="8"  y1="19" x2="8"  y2="21" stroke="rgba(0,229,160,0.5)" stroke-width="1.5"/>
            <line x1="11" y1="19" x2="11" y2="21" stroke="rgba(0,229,160,0.5)" stroke-width="1.5"/>
            <line x1="14" y1="19" x2="14" y2="21" stroke="rgba(0,229,160,0.5)" stroke-width="1.5"/>
            <line x1="17" y1="19" x2="17" y2="21" stroke="rgba(0,229,160,0.5)" stroke-width="1.5"/>
          </svg>
        @elseif($cat['icon'] == 'gpu')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <rect x="4" y="8" width="20" height="12" rx="2" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" fill="none"/>
            <rect x="7" y="11" width="8" height="6" rx="1" fill="rgba(0,229,160,0.12)" stroke="rgba(0,229,160,0.4)" stroke-width="1"/>
            <circle cx="20" cy="14" r="2.5" stroke="rgba(0,229,160,0.7)" stroke-width="1.2" fill="none"/>
            <circle cx="20" cy="14" r="1" fill="rgba(0,229,160,0.5)"/>
            <line x1="24" y1="8" x2="24" y2="20" stroke="rgba(0,229,160,0.3)" stroke-width="1"/>
          </svg>
        @elseif($cat['icon'] == 'storage')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <rect x="6" y="6" width="16" height="16" rx="2" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" fill="none"/>
            <circle cx="14" cy="14" r="4" stroke="rgba(0,229,160,0.6)" stroke-width="1.2" fill="none"/>
            <circle cx="14" cy="14" r="1.5" fill="rgba(0,229,160,0.6)"/>
            <line x1="14" y1="6"  x2="14" y2="10" stroke="rgba(0,229,160,0.3)" stroke-width="1"/>
            <line x1="14" y1="18" x2="14" y2="22" stroke="rgba(0,229,160,0.3)" stroke-width="1"/>
            <line x1="6"  y1="14" x2="10" y2="14" stroke="rgba(0,229,160,0.3)" stroke-width="1"/>
            <line x1="18" y1="14" x2="22" y2="14" stroke="rgba(0,229,160,0.3)" stroke-width="1"/>
          </svg>
        @elseif($cat['icon'] == 'psu')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <rect x="7" y="5" width="14" height="18" rx="2" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" fill="none"/>
            <rect x="10" y="8" width="8" height="5" rx="1" fill="rgba(0,229,160,0.12)" stroke="rgba(0,229,160,0.4)" stroke-width="1"/>
            <line x1="10" y1="16"   x2="18" y2="16"   stroke="rgba(0,229,160,0.4)"  stroke-width="1"/>
            <line x1="10" y1="18.5" x2="15" y2="18.5" stroke="rgba(0,229,160,0.25)" stroke-width="1"/>
            <line x1="14" y1="5" x2="14" y2="3" stroke="rgba(0,229,160,0.6)" stroke-width="1.5"/>
            <line x1="17" y1="5" x2="17" y2="3" stroke="rgba(0,229,160,0.6)" stroke-width="1.5"/>
          </svg>
        @elseif($cat['icon'] == 'cooling')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <path d="M14 5 L14 14 M10 7.5 L14 5 L18 7.5" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" stroke-linejoin="round" fill="none"/>
            <circle cx="14" cy="17" r="5" stroke="rgba(0,229,160,0.7)" stroke-width="1.5" fill="none"/>
            <circle cx="14" cy="17" r="2" fill="rgba(0,229,160,0.15)" stroke="rgba(0,229,160,0.5)" stroke-width="1"/>
            <line x1="14" y1="12" x2="14" y2="15" stroke="rgba(0,229,160,0.4)" stroke-width="1"/>
          </svg>
        @elseif($cat['icon'] == 'mobo')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <rect x="4"  y="7" width="20" height="14" rx="2" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" fill="none"/>
            <rect x="7"  y="10" width="6" height="4" rx="0.5" fill="rgba(0,229,160,0.12)" stroke="rgba(0,229,160,0.4)" stroke-width="1"/>
            <rect x="15" y="10" width="3" height="4" rx="0.5" fill="rgba(0,229,160,0.08)" stroke="rgba(0,229,160,0.3)" stroke-width="1"/>
            <line x1="7" y1="16.5" x2="21" y2="16.5" stroke="rgba(0,229,160,0.2)" stroke-width="1"/>
            <circle cx="20" cy="11" r="1.5" fill="rgba(0,229,160,0.4)"/>
          </svg>
        @elseif($cat['icon'] == 'periferal')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <ellipse cx="12" cy="16" rx="7" ry="5" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" fill="none"/>
            <path d="M12 11 C14 8 18 8 20 10 L21 13 C19 12 17 13 16 14" stroke="rgba(0,229,160,0.6)" stroke-width="1.2" fill="none"/>
            <circle cx="10" cy="16" r="1.5" fill="rgba(0,229,160,0.5)"/>
            <line x1="19" y1="13" x2="22" y2="11" stroke="rgba(0,229,160,0.5)" stroke-width="1.2"/>
            <circle cx="22" cy="10.5" r="1" fill="rgba(0,229,160,0.4)"/>
          </svg>
        @elseif($cat['icon'] == 'casing')
          <svg class="cat-svg" viewBox="0 0 28 28" fill="none">
            <rect x="6" y="5" width="16" height="18" rx="2" stroke="rgba(0,229,160,0.8)" stroke-width="1.5" fill="none"/>
            <line x1="6" y1="9" x2="22" y2="9" stroke="rgba(0,229,160,0.4)" stroke-width="1"/>
            <rect x="9" y="12" width="4" height="6" rx="0.5" fill="rgba(0,229,160,0.08)" stroke="rgba(0,229,160,0.3)" stroke-width="1"/>
            <line x1="15" y1="12"   x2="19" y2="12"   stroke="rgba(0,229,160,0.3)" stroke-width="1"/>
            <line x1="15" y1="14.5" x2="19" y2="14.5" stroke="rgba(0,229,160,0.2)" stroke-width="1"/>
            <circle cx="19" cy="7" r="1" fill="rgba(0,229,160,0.5)"/>
          </svg>
        @endif
      </div>
      <span class="cat-label">{{ $cat['label'] }}</span>
    </a>
    @endforeach
  </div>
</div>

{{-- BRAND TICKER --}}
<div class="brand-bar">
  <div class="brand-label">TOP BRAND</div>
  <div class="brand-scroll-wrapper">
    <div class="brand-track">
      <div class="brand-item" data-brand="NVIDIA"><span class="brand-name">NVIDIA</span></div>
      <div class="brand-item" data-brand="INTEL"><span class="brand-name">INTEL</span></div>
      <div class="brand-item" data-brand="ASUS"><span class="brand-name">ASUS</span></div>
      <div class="brand-item" data-brand="MSI"><span class="brand-name">MSI</span></div>
      <div class="brand-item" data-brand="KLEVV"><span class="brand-name">KLEVV</span></div>
      <div class="brand-item" data-brand="CORSAIR"><span class="brand-name">CORSAIR</span></div>
      <div class="brand-item" data-brand="AMD"><span class="brand-name">AMD</span></div>
      <div class="brand-item" data-brand="GIGABYTE"><span class="brand-name">GIGABYTE</span></div>
      <div class="brand-item" data-brand="NZXT"><span class="brand-name">NZXT</span></div>
      {{-- Duplikat untuk seamless loop --}}
      <div class="brand-item" data-brand="NVIDIA"><span class="brand-name">NVIDIA</span></div>
      <div class="brand-item" data-brand="INTEL"><span class="brand-name">INTEL</span></div>
      <div class="brand-item" data-brand="ASUS"><span class="brand-name">ASUS</span></div>
      <div class="brand-item" data-brand="MSI"><span class="brand-name">MSI</span></div>
      <div class="brand-item" data-brand="KLEVV"><span class="brand-name">KLEVV</span></div>
      <div class="brand-item" data-brand="CORSAIR"><span class="brand-name">CORSAIR</span></div>
      <div class="brand-item" data-brand="AMD"><span class="brand-name">AMD</span></div>
      <div class="brand-item" data-brand="GIGABYTE"><span class="brand-name">GIGABYTE</span></div>
      <div class="brand-item" data-brand="NZXT"><span class="brand-name">NZXT</span></div>
    </div>
  </div>
</div>

{{-- BUILDER BUTTON --}}
<div class="builder-btn-wrap">
  <a href="/builder" class="builder-btn">
    <span class="builder-btn-icon">🔧</span>
    <div>
      <div class="builder-btn-text">Rakit PC Sekarang</div>
      <div class="builder-btn-sub">Pilih komponen & cek kompatibilitas otomatis</div>
    </div>
  </a>
</div>

{{-- POPULAR PRODUCTS --}}
<div class="section-title">
  Popular Product <a href="/komponen">Semua →</a>
</div>

<div class="product-grid" id="productGrid">
  @forelse($products as $index => $product)
  <a href="/product/{{ $product->id }}" class="product-card" data-index="{{ $index }}">
    <div class="product-img">
      @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
      @else
        <div style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;color:var(--text-muted);font-size:13px;">No Image</div>
      @endif
    </div>
    <div class="product-info">
      <div class="product-name">{{ $product->name }}</div>
      <div class="product-price">Rp {{ number_format($product->price) }}</div>
      <div class="product-view">👁 Lihat Produk</div>
    </div>
  </a>
  @empty
    <p style="color:var(--text-muted); font-size:14px; grid-column: 1/-1;">Tidak ada produk tersedia.</p>
  @endforelse
</div>

<button class="show-more-btn" id="showMoreBtn" onclick="toggleProducts()">
  <span id="showMoreLabel">Lihat Lebih Banyak</span>
  <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>
</button>

{{-- SPECIAL OFFER --}}
<div class="section-title">Special Offer <a href="/promo">Semua Promo →</a></div>
<div class="offers-grid">
  <a href="/product/9" class="offer-card">
    <div class="offer-img">🎮</div>
    <div style="padding:8px 10px 10px;">
      <div style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:4px;">MSI Gaming Bundle</div>
      <div class="offer-badge">🔥 Hemat 20%</div>
    </div>
  </a>
  <a href="/product/10" class="offer-card">
    <div class="offer-img">🖥️</div>
    <div style="padding:8px 10px 10px;">
      <div style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:4px;">Intel Core i9 Bundle</div>
      <div class="offer-badge">⚡ Flash Sale</div>
    </div>
  </a>
  <a href="/product/11" class="offer-card">
    <div class="offer-img">❄️</div>
    <div style="padding:8px 10px 10px;">
      <div style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:4px;">Cooling Bundle Set</div>
      <div class="offer-badge">🏷️ Hemat 15%</div>
    </div>
  </a>
  <a href="/product/12" class="offer-card">
    <div class="offer-img">🧠</div>
    <div style="padding:8px 10px 10px;">
      <div style="font-size:13px;font-weight:500;color:var(--text-primary);margin-bottom:4px;">RAM + SSD Paket</div>
      <div class="offer-badge">💰 Hemat 25%</div>
    </div>
  </a>
</div>

{{-- PROMO BANNER --}}
<div class="promo-banner">
  <div class="promo-sub">Program Referral</div>
  <div class="promo-title">Ajak Teman, Dapatkan<br>Cashback Rp 100.000</div>
  <div class="promo-sub">Berlaku untuk setiap teman yang berhasil melakukan pembelian pertama.</div>
  <a href="/referral" class="promo-cta">Ikut Sekarang →</a>
</div>

@endsection

@section('scripts')
<script>
(function () {
  /* ===== BANNER SLIDER ===== */
  let current = 0;
  const track = document.getElementById('bannerTrack');
  const dots  = document.querySelectorAll('.dot');
  const total = 3;

  function goSlide(i) {
    current = i;
    track.style.transform = `translateX(-${current * 100}%)`;
    dots.forEach((d, idx) => d.classList.toggle('active', idx === current));
  }

  document.querySelector('.banner-btn.prev').addEventListener('click', () => goSlide((current - 1 + total) % total));
  document.querySelector('.banner-btn.next').addEventListener('click', () => goSlide((current + 1) % total));
  dots.forEach((dot, i) => dot.addEventListener('click', () => goSlide(i)));
  setInterval(() => goSlide((current + 1) % total), 3500);

  /* ===== SHOW MORE PRODUCTS ===== */
  function getCols() {
    return window.innerWidth >= 900 ? 4 : window.innerWidth >= 640 ? 3 : 2;
  }

  let visibleUntil = 0;

  function initProductGrid() {
    const grid  = document.getElementById('productGrid');
    const btn   = document.getElementById('showMoreBtn');
    const label = document.getElementById('showMoreLabel');
    if (!grid || !btn) return;

    const allCards = Array.from(grid.querySelectorAll('.product-card'));
    visibleUntil = getCols() * 2;
    allCards.forEach((card, i) => { card.style.display = i < visibleUntil ? '' : 'none'; });
    label.textContent = 'Lihat Lebih Banyak';
    btn.classList.remove('expanded');
    btn.style.display = allCards.some((_, i) => i >= visibleUntil) ? 'flex' : 'none';
  }

  function toggleProducts() {
    const grid  = document.getElementById('productGrid');
    const btn   = document.getElementById('showMoreBtn');
    const label = document.getElementById('showMoreLabel');
    if (!grid) return;

    const allCards  = Array.from(grid.querySelectorAll('.product-card'));
    const step      = getCols() * 2;
    const anyHidden = allCards.some(c => c.style.display === 'none');

    if (!anyHidden) {
      visibleUntil = step;
      allCards.forEach((card, i) => { card.style.display = i < visibleUntil ? '' : 'none'; });
      label.textContent = 'Lihat Lebih Banyak';
      btn.classList.remove('expanded');
      grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
      visibleUntil += step;
      allCards.forEach((card, i) => { card.style.display = i < visibleUntil ? '' : 'none'; });
      if (!allCards.some(c => c.style.display === 'none')) {
        label.textContent = 'Sembunyikan';
        btn.classList.add('expanded');
      }
    }
  }

  window.toggleProducts = toggleProducts;
  window.addEventListener('load', initProductGrid);
  window.addEventListener('resize', initProductGrid);
})();
</script>
@endsection