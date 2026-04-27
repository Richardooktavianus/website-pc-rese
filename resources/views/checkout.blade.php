@extends('layouts.app')

@section('title', 'Checkout - PC Rakit Store')

@section('content')

<style>
    /* ===== CHECKOUT PAGE ===== */
    .checkout-wrapper {
        max-width: 960px;
        margin: 0 auto;
        padding: 24px 16px 60px;
    }

    /* Page Header */
    .checkout-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
    }

    .checkout-header-icon {
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

    .checkout-header-title {
        font-family: 'Rajdhani', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }

    .checkout-header-sub {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 3px;
    }

    /* Step indicator */
    .steps {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 28px;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .steps::-webkit-scrollbar {
        display: none;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .step-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        font-family: 'Rajdhani', sans-serif;
        transition: all 0.3s;
    }

    .step.active .step-num {
        background: var(--accent);
        border-color: var(--accent);
        color: #0d1a14;
    }

    .step.done .step-num {
        background: rgba(0, 229, 160, 0.15);
        border-color: rgba(0, 229, 160, 0.4);
        color: var(--accent);
    }

    .step-label {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        white-space: nowrap;
    }

    .step.active .step-label {
        color: var(--text-primary);
    }

    .step.done .step-label {
        color: var(--accent);
    }

    .step-line {
        flex: 1;
        height: 1px;
        background: var(--border);
        margin: 0 12px;
        min-width: 24px;
    }

    /* Layout */
    .checkout-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Section Card */
    .co-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .co-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
        background: var(--bg-surface);
    }

    .co-card-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(0, 229, 160, 0.1);
        border: 1px solid rgba(0, 229, 160, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
    }

    .co-card-title {
        font-family: 'Rajdhani', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: 0.5px;
    }

    .co-card-body {
        padding: 18px;
    }

    /* Form Elements */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    @media (max-width: 500px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .form-input {
        width: 100%;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 14px;
        color: var(--text-primary);
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input:focus {
        border-color: rgba(0, 229, 160, 0.5);
        box-shadow: 0 0 0 3px rgba(0, 229, 160, 0.08);
    }

    .form-input::placeholder {
        color: var(--text-muted);
    }

    select.form-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 7L11 1' stroke='%237a859e' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
        cursor: pointer;
    }

    select.form-input option {
        background: var(--bg-card);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 80px;
        line-height: 1.5;
    }

    /* Map placeholder */
    .map-box {
        width: 100%;
        height: 180px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: var(--bg-surface);
        overflow: hidden;
        position: relative;
        margin-bottom: 12px;
        cursor: pointer;
    }

    .map-box iframe {
        width: 100%;
        height: 100%;
        border: none;
        opacity: 0.7;
        pointer-events: none;
    }

    .map-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: rgba(13, 15, 20, 0.6);
        backdrop-filter: blur(2px);
        transition: opacity 0.2s;
    }

    .map-box:hover .map-overlay {
        opacity: 0;
        pointer-events: none;
    }

    .map-overlay-icon {
        font-size: 28px;
    }

    .map-overlay-text {
        font-size: 13px;
        color: var(--text-muted);
        font-family: 'DM Sans', sans-serif;
    }

    /* Detect location button */
    .btn-detect {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(0, 229, 160, 0.08);
        border: 1px solid rgba(0, 229, 160, 0.2);
        color: var(--accent);
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        transition: background 0.2s;
        margin-bottom: 12px;
    }

    .btn-detect:hover {
        background: rgba(0, 229, 160, 0.15);
    }

    /* Courier Options */
    .courier-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    @media (max-width: 500px) {
        .courier-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .courier-option {
        position: relative;
    }

    .courier-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .courier-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 12px 8px;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .courier-option input:checked+.courier-label {
        border-color: rgba(0, 229, 160, 0.5);
        background: rgba(0, 229, 160, 0.06);
    }

    .courier-label:hover {
        border-color: rgba(0, 229, 160, 0.3);
    }

    .courier-name {
        font-family: 'Rajdhani', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .courier-price {
        font-size: 11px;
        color: var(--accent);
        font-weight: 600;
    }

    .courier-eta {
        font-size: 10px;
        color: var(--text-muted);
    }

    /* Payment Options */
    .payment-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .payment-option {
        position: relative;
    }

    .payment-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .payment-label {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .payment-option input:checked+.payment-label {
        border-color: rgba(0, 229, 160, 0.5);
        background: rgba(0, 229, 160, 0.06);
    }

    .payment-label:hover {
        border-color: rgba(0, 229, 160, 0.3);
    }

    .payment-radio {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .payment-option input:checked+.payment-label .payment-radio {
        border-color: var(--accent);
        background: var(--accent);
    }

    .payment-option input:checked+.payment-label .payment-radio::after {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #0d1a14;
    }

    .payment-icon {
        font-size: 22px;
        flex-shrink: 0;
    }

    .payment-info {
        flex: 1;
    }

    .payment-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .payment-desc {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 1px;
    }

    .payment-badge {
        font-size: 10px;
        font-weight: 700;
        background: rgba(0, 229, 160, 0.12);
        border: 1px solid rgba(0, 229, 160, 0.2);
        color: var(--accent);
        padding: 2px 7px;
        border-radius: 4px;
    }

    /* Order notes */
    .voucher-row {
        display: flex;
        gap: 8px;
    }

    .voucher-row .form-input {
        flex: 1;
    }

    .btn-apply {
        background: rgba(0, 229, 160, 0.1);
        border: 1px solid rgba(0, 229, 160, 0.25);
        color: var(--accent);
        padding: 10px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        white-space: nowrap;
        transition: background 0.2s;
    }

    .btn-apply:hover {
        background: rgba(0, 229, 160, 0.18);
    }

    /* ===== ORDER SUMMARY (RIGHT COLUMN) ===== */
    .summary-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        position: sticky;
        top: 80px;
    }

    .summary-header {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
        background: var(--bg-surface);
        font-family: 'Rajdhani', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: 0.5px;
    }

    .summary-body {
        padding: 16px 18px;
    }

    /* Item list */
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid var(--border);
    }

    .summary-item:last-of-type {
        border-bottom: none;
    }

    .summary-item-name {
        font-size: 13px;
        color: var(--text-muted);
        flex: 1;
        line-height: 1.4;
    }

    .summary-item-price {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap;
    }

    /* Summary totals */
    .summary-divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 12px 0;
    }

    .summary-row-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .summary-row-label {
        font-size: 13px;
        color: var(--text-muted);
    }

    .summary-row-value {
        font-size: 13px;
        color: var(--text-primary);
        font-weight: 500;
    }

    .summary-row-value.green {
        color: var(--accent);
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0 0;
        border-top: 1px solid var(--border);
        margin-top: 4px;
    }

    .summary-total-label {
        font-family: 'Rajdhani', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .summary-total-price {
        font-family: 'Rajdhani', sans-serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--accent);
    }

    /* Checkout Button */
    .btn-checkout-main {
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
        margin-top: 16px;
        transition: background 0.2s, transform 0.15s;
    }

    .btn-checkout-main:hover {
        background: var(--accent-dim);
        transform: translateY(-1px);
    }

    .btn-checkout-main:active {
        transform: translateY(0);
    }

    .checkout-note {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 10px;
        font-size: 11px;
        color: var(--text-muted);
        justify-content: center;
    }

    /* ===== MAP STYLE TAMBAHAN ===== */
    #mapBox {
        width: 100%;
        height: 220px;
        border-radius: 10px;
        border: 1px solid var(--border);
    }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
<div class="checkout-wrapper">

    {{-- HEADER --}}
    <div class="checkout-header">
        <div class="checkout-header-icon">💳</div>
        <div>
            <div class="checkout-header-title">Checkout</div>
            <div class="checkout-header-sub">Lengkapi informasi pengiriman dan pembayaran</div>
        </div>
    </div>

    {{-- STEP INDICATOR --}}
    <div class="steps">
        <div class="step done">
            <div class="step-num">✓</div>
            <span class="step-label">Keranjang</span>
        </div>
        <div class="step-line"></div>
        <div class="step active">
            <div class="step-num">2</div>
            <span class="step-label">Checkout</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-num">3</div>
            <span class="step-label">Pembayaran</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-num">4</div>
            <span class="step-label">Selesai</span>
        </div>
    </div>

    <form method="POST" action="/checkout/process" id="checkoutForm">
        @csrf

        <div class="checkout-layout">

            {{-- ===== LEFT COLUMN ===== --}}
            <div>

                {{-- 1. ALAMAT PENGIRIMAN --}}
                <div class="co-card">
                    <div class="co-card-header">
                        <div class="co-card-icon">📍</div>
                        <span class="co-card-title">Alamat Pengiriman</span>
                    </div>
                    <div class="co-card-body">

                        {{-- MAP --}}
                        <div class="map-box" id="mapBox"></div>

                        {{-- Detect location --}}
                        <button type="button" class="btn-detect" onclick="detectLocation()">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <circle cx="7" cy="7" r="3" stroke="currentColor" stroke-width="1.5" />
                                <circle cx="7" cy="7" r="6" stroke="currentColor" stroke-width="1" stroke-dasharray="2 2" />
                                <line x1="7" y1="1" x2="7" y2="3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <line x1="7" y1="11" x2="7" y2="13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <line x1="1" y1="7" x2="3" y2="7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <line x1="11" y1="7" x2="13" y2="7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Deteksi Lokasi Saya
                        </button>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Penerima *</label>
                                <input type="text" name="nama_penerima" class="form-input"
                                    placeholder="Nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">No. Telepon *</label>
                                <input type="tel" name="no_telepon" class="form-input"
                                    placeholder="08xx-xxxx-xxxx" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Lengkap *</label>
                            <textarea name="alamat" class="form-input"
                                placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan..." required></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Kota / Kabupaten *</label>
                                <select name="kota" class="form-input" required>
                                    <option value="" disabled selected>Pilih Kota</option>
                                    <option>Bandung</option>
                                    <option>Jakarta</option>
                                    <option>Surabaya</option>
                                    <option>Yogyakarta</option>
                                    <option>Medan</option>
                                    <option>Makassar</option>
                                    <option>Semarang</option>
                                    <option>Palembang</option>
                                    <option>Depok</option>
                                    <option>Bekasi</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kode Pos *</label>
                                <input type="text" name="kode_pos" class="form-input"
                                    placeholder="40xxx" maxlength="5" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Provinsi *</label>
                            <select name="provinsi" class="form-input" required>
                                <option value="" disabled selected>Pilih Provinsi</option>
                                <option>Jawa Barat</option>
                                <option>DKI Jakarta</option>
                                <option>Jawa Timur</option>
                                <option>DI Yogyakarta</option>
                                <option>Sumatera Utara</option>
                                <option>Sulawesi Selatan</option>
                                <option>Jawa Tengah</option>
                                <option>Sumatera Selatan</option>
                            </select>
                        </div>

                    </div>
                </div>

                {{-- 2. PILIH KURIR --}}
                <div class="co-card">
                    <div class="co-card-header">
                        <div class="co-card-icon">🚚</div>
                        <span class="co-card-title">Pilih Kurir</span>
                    </div>
                    <div class="co-card-body">

                        <div class="courier-grid">

                            <div class="courier-option">
                                <input type="radio" name="kurir" id="jne" value="JNE - REG" checked>
                                <label class="courier-label" for="jne">
                                    <span style="font-size:22px;">📦</span>
                                    <span class="courier-name">JNE</span>
                                    <span class="courier-price">Rp 18.000</span>
                                    <span class="courier-eta">2-3 hari</span>
                                </label>
                            </div>

                            <div class="courier-option">
                                <input type="radio" name="kurir" id="jnt" value="J&T - Regular">
                                <label class="courier-label" for="jnt">
                                    <span style="font-size:22px;">🚀</span>
                                    <span class="courier-name">J&T</span>
                                    <span class="courier-price">Rp 15.000</span>
                                    <span class="courier-eta">2-4 hari</span>
                                </label>
                            </div>

                            <div class="courier-option">
                                <input type="radio" name="kurir" id="sicepat" value="SiCepat - HALU">
                                <label class="courier-label" for="sicepat">
                                    <span style="font-size:22px;">⚡</span>
                                    <span class="courier-name">SiCepat</span>
                                    <span class="courier-price">Rp 20.000</span>
                                    <span class="courier-eta">1-2 hari</span>
                                </label>
                            </div>

                            <div class="courier-option">
                                <input type="radio" name="kurir" id="anteraja" value="AnterAja - Regular">
                                <label class="courier-label" for="anteraja">
                                    <span style="font-size:22px;">🛵</span>
                                    <span class="courier-name">AnterAja</span>
                                    <span class="courier-price">Rp 13.000</span>
                                    <span class="courier-eta">3-5 hari</span>
                                </label>
                            </div>

                            <div class="courier-option">
                                <input type="radio" name="kurir" id="pos" value="Pos Indonesia">
                                <label class="courier-label" for="pos">
                                    <span style="font-size:22px;">🏣</span>
                                    <span class="courier-name">POS ID</span>
                                    <span class="courier-price">Rp 10.000</span>
                                    <span class="courier-eta">4-7 hari</span>
                                </label>
                            </div>

                            <div class="courier-option">
                                <input type="radio" name="kurir" id="gosend" value="GoSend - SameDay">
                                <label class="courier-label" for="gosend">
                                    <span style="font-size:22px;">🟢</span>
                                    <span class="courier-name">GoSend</span>
                                    <span class="courier-price">Rp 35.000</span>
                                    <span class="courier-eta">Hari ini</span>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- 3. METODE PEMBAYARAN --}}
                <div class="co-card">
                    <div class="co-card-header">
                        <div class="co-card-icon">💳</div>
                        <span class="co-card-title">Metode Pembayaran</span>
                    </div>
                    <div class="co-card-body">

                        <div class="payment-list">

                            <div class="payment-option">
                                <input type="radio" name="pembayaran" id="transfer" value="Transfer Bank" checked>
                                <label class="payment-label" for="transfer">
                                    <div class="payment-radio"></div>
                                    <span class="payment-icon">🏦</span>
                                    <div class="payment-info">
                                        <div class="payment-name">Transfer Bank</div>
                                        <div class="payment-desc">BCA, Mandiri, BNI, BRI</div>
                                    </div>
                                </label>
                            </div>

                            <div class="payment-option">
                                <input type="radio" name="pembayaran" id="qris" value="QRIS">
                                <label class="payment-label" for="qris">
                                    <div class="payment-radio"></div>
                                    <span class="payment-icon">📱</span>
                                    <div class="payment-info">
                                        <div class="payment-name">QRIS</div>
                                        <div class="payment-desc">GoPay, OVO, Dana, ShopeePay, dll</div>
                                    </div>
                                    <span class="payment-badge">Instan</span>
                                </label>
                            </div>

                            <div class="payment-option">
                                <input type="radio" name="pembayaran" id="cod" value="COD">
                                <label class="payment-label" for="cod">
                                    <div class="payment-radio"></div>
                                    <span class="payment-icon">💵</span>
                                    <div class="payment-info">
                                        <div class="payment-name">Bayar di Tempat (COD)</div>
                                        <div class="payment-desc">Bayar saat paket tiba</div>
                                    </div>
                                </label>
                            </div>

                            <div class="payment-option">
                                <input type="radio" name="pembayaran" id="va" value="Virtual Account">
                                <label class="payment-label" for="va">
                                    <div class="payment-radio"></div>
                                    <span class="payment-icon">🔢</span>
                                    <div class="payment-info">
                                        <div class="payment-name">Virtual Account</div>
                                        <div class="payment-desc">Nomor unik untuk pembayaran ATM</div>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- 4. VOUCHER & CATATAN --}}
                <div class="co-card">
                    <div class="co-card-header">
                        <div class="co-card-icon">🎟️</div>
                        <span class="co-card-title">Voucher & Catatan</span>
                    </div>
                    <div class="co-card-body">

                        <div class="form-group">
                            <label class="form-label">Kode Voucher</label>
                            <div class="voucher-row">
                                <input type="text" name="voucher" id="voucherInput"
                                    class="form-input" placeholder="Masukkan kode voucher...">
                                <button type="button" class="btn-apply" onclick="applyVoucher()">Pakai</button>
                            </div>
                            <div id="voucherMsg" style="font-size:12px;margin-top:6px;display:none;"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catatan untuk Penjual</label>
                            <textarea name="catatan" class="form-input"
                                placeholder="Contoh: Tolong bubble wrap double, jangan dibuka..."></textarea>
                        </div>

                    </div>
                </div>

            </div>
            {{-- END LEFT COLUMN --}}

            {{-- ===== RIGHT COLUMN (SUMMARY) ===== --}}
            <div>
                <div class="summary-card">
                    <div class="summary-header">Ringkasan Pesanan</div>
                    <div class="summary-body">

                        {{-- Item list --}}
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $index => $build)
                        @foreach($build['items'] as $item)
                        @php $subtotal += $item['price']; @endphp
                        <div class="summary-item">
                            <span class="summary-item-name">{{ $item['name'] }}</span>
                            <span class="summary-item-price">Rp {{ number_format($item['price']) }}</span>
                        </div>
                        @endforeach
                        @endforeach

                        <hr class="summary-divider">

                        <div class="summary-row-item">
                            <span class="summary-row-label">Subtotal</span>
                            <span class="summary-row-value">Rp {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="summary-row-item">
                            <span class="summary-row-label">Ongkir</span>
                            <span class="summary-row-value" id="ongkirDisplay">Rp 18.000</span>
                        </div>
                        <div class="summary-row-item" id="diskonRow" style="display:none;">
                            <span class="summary-row-label">Diskon Voucher</span>
                            <span class="summary-row-value green" id="diskonDisplay">- Rp 0</span>
                        </div>

                        <div class="summary-total">
                            <span class="summary-total-label">Total</span>
                            <span class="summary-total-price" id="totalDisplay">
                                Rp {{ number_format($subtotal + 18000) }}
                            </span>
                        </div>

                        <button type="submit" class="btn-checkout-main">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                <rect x="2" y="5" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.5" />
                                <path d="M5 5V4a4 4 0 0 1 8 0v1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                <circle cx="9" cy="10" r="1.5" fill="currentColor" />
                            </svg>
                            Bayar Sekarang
                        </button>

                        <div class="checkout-note">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1" />
                                <path d="M6 5v4M6 3.5v.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" />
                            </svg>
                            Transaksi aman & terenkripsi
                        </div>

                    </div>
                </div>
            </div>
            {{-- END RIGHT COLUMN --}}

        </div>
        {{-- END checkout-layout --}}

    </form>

</div>
{{-- END checkout-wrapper --}}

<script>
    let map, marker;

    function initMap() {
        const defaultPos = {
            lat: -6.914744,
            lng: 107.609810
        };

        map = new google.maps.Map(document.getElementById("mapBox"), {
            center: defaultPos,
            zoom: 13,
        });

        marker = new google.maps.Marker({
            position: defaultPos,
            map: map,
            draggable: true,
        });

        map.addListener("click", (e) => {
            setMarker(e.latLng);
        });

        marker.addListener("dragend", () => {
            updateInput(marker.getPosition());
        });

        updateInput(marker.getPosition());
    }

    function setMarker(location) {
        marker.setPosition(location);
        updateInput(location);
    }

    function updateInput(pos) {
        document.getElementById("latitude").value = pos.lat();
        document.getElementById("longitude").value = pos.lng();
    }

    window.detectLocation = function() {
        if (!navigator.geolocation) {
            alert("GPS tidak support");
            return;
        }

        navigator.geolocation.getCurrentPosition((pos) => {
            const userPos = {
                lat: pos.coords.latitude,
                lng: pos.coords.longitude
            };

            map.setCenter(userPos);
            marker.setPosition(userPos);
            updateInput(marker.getPosition());
        });
    };

    window.onload = initMap;
    (function() {

        // Ongkir per kurir
        const ongkirMap = {
            'JNE - REG': 18000,
            'J&T - Regular': 15000,
            'SiCepat - HALU': 20000,
            'AnterAja - Regular': 13000,
            'Pos Indonesia': 10000,
            'GoSend - SameDay': 35000,
        };

        const subtotal = parseInt("{{ $subtotal ?? 0 }}") || 0;
        let ongkir = 18000;
        let diskon = 0;

        function updateTotal() {
            const total = subtotal + ongkir - diskon;
            document.getElementById('ongkirDisplay').textContent =
                'Rp ' + ongkir.toLocaleString('id-ID');
            document.getElementById('totalDisplay').textContent =
                'Rp ' + total.toLocaleString('id-ID');
        }

        // Update ongkir saat kurir berubah
        document.querySelectorAll('input[name="kurir"]').forEach(radio => {
            radio.addEventListener('change', () => {
                ongkir = ongkirMap[radio.value] || 0;
                updateTotal();
            });
        });

        // Apply voucher (simulasi)
        const vouchers = {
            'PCRAKIT10': 0.10,
            'HEMAT50K': 50000,
            'NEWUSER': 0.15,
        };

        window.applyVoucher = function() {
            const code = document.getElementById('voucherInput').value.trim().toUpperCase();
            const msg = document.getElementById('voucherMsg');
            const row = document.getElementById('diskonRow');
            const disp = document.getElementById('diskonDisplay');

            if (!code) return;

            if (vouchers[code] !== undefined) {
                const val = vouchers[code];
                diskon = val < 1 ? Math.round(subtotal * val) : val;
                msg.style.display = 'block';
                msg.style.color = 'var(--accent)';
                msg.textContent = '✅ Voucher berhasil dipakai! Hemat Rp ' + diskon.toLocaleString('id-ID');
                row.style.display = 'flex';
                disp.textContent = '- Rp ' + diskon.toLocaleString('id-ID');
            } else {
                diskon = 0;
                msg.style.display = 'block';
                msg.style.color = '#e74c3c';
                msg.textContent = '❌ Kode voucher tidak valid.';
                row.style.display = 'none';
            }
            updateTotal();
        };

        // Detect location
        window.detectLocation = function() {
            if (!navigator.geolocation) {
                alert('Browser tidak mendukung geolocation.');
                return;
            }
            navigator.geolocation.getCurrentPosition(pos => {
                const {
                    latitude,
                    longitude
                } = pos.coords;
                const iframe = document.querySelector('#mapBox iframe');
                const pad = 0.01;
                iframe.src = `https://www.openstreetmap.org/export/embed.html?bbox=${longitude-pad},${latitude-pad},${longitude+pad},${latitude+pad}&layer=mapnik&marker=${latitude},${longitude}`;
                document.querySelector('#mapBox .map-overlay').style.opacity = '0';
            }, () => {
                alert('Gagal mendeteksi lokasi. Pastikan izin lokasi diaktifkan.');
            });
        };

        // Open map in new tab
        window.openMap = function() {
            window.open('https://www.openstreetmap.org/', '_blank');
        };

        updateTotal();
    })();
</script>

@endsection