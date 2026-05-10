<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'PC Rakit Store')</title>

  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=DM+Sans:wght@400;500;600&family=Orbitron:wght@700&display=swap" rel="stylesheet">
  
  {{-- Leaflet CSS --}}
  <link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' />
  
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    /* ========== GLOBAL THEME ========== */
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

    h1, h2, h3, .logo {
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

    .btn-login, .btn-register {
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

    .subnav a.active, .subnav a:hover {
      color: var(--accent);
      border-bottom: 2px solid var(--accent);
    }

    /* ========== MAIN ========== */
    main {
      max-width: 1200px;
      margin: 0 auto;
      padding: 16px;
    }

    /* ========== STORE LOCATION MAP ========== */
    .map-section {
      background: var(--bg-card);
      border-top: 1px solid var(--border);
      padding: 32px 24px;
    }

    .map-header {
      max-width: 1200px;
      margin: 0 auto 20px;
      text-align: center;
    }

    .map-title {
      font-family: 'Rajdhani', sans-serif;
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 8px;
      letter-spacing: 1px;
    }

    .map-subtitle {
      font-size: 14px;
      color: var(--text-muted);
    }

    .map-container {
      max-width: 1200px;
      margin: 0 auto;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--border);
      background: var(--bg-surface);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    #storeMap {
      width: 100%;
      height: 450px;
      background: var(--bg-surface);
    }

    @media (max-width: 768px) {
      .map-section {
        padding: 24px 16px;
      }

      .map-title {
        font-size: 1.5rem;
      }

      #storeMap {
        height: 350px;
      }
    }

    @media (max-width: 480px) {
      #storeMap {
        height: 280px;
      }
    }

    /* Leaflet popup styling untuk tema dark */
    .leaflet-popup-content-wrapper {
      background: var(--bg-card);
      color: var(--text-primary);
      border: 1px solid var(--border);
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
    }

    .leaflet-popup-tip {
      background: var(--bg-card);
      border: 1px solid var(--border);
    }

    .leaflet-container a.leaflet-popup-close-button {
      color: var(--text-primary);
      font-size: 20px;
      padding: 4px 8px;
    }

    .leaflet-container a.leaflet-popup-close-button:hover {
      color: var(--accent);
    }

    .store-popup {
      padding: 4px;
    }

    .store-popup-title {
      font-family: 'Rajdhani', sans-serif;
      font-size: 15px;
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 4px;
    }

    .store-popup-address {
      font-size: 12px;
      color: var(--text-muted);
      line-height: 1.4;
    }

    /* Leaflet controls styling */
    .leaflet-control-zoom a {
      background: var(--bg-card) !important;
      color: var(--text-primary) !important;
      border-color: var(--border) !important;
    }

    .leaflet-control-zoom a:hover {
      background: var(--bg-surface) !important;
      border-color: var(--accent) !important;
    }

    .leaflet-control-attribution {
      background: rgba(22, 26, 36, 0.8) !important;
      color: var(--text-muted) !important;
      font-size: 10px !important;
    }

    .leaflet-control-attribution a {
      color: var(--accent) !important;
    }

    /* ========== FOOTER ========== */
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

    .btn-user {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 0 12px 0 6px;
      height: 38px;
      text-decoration: none;
      transition: border-color 0.2s;
    }

    .btn-user:hover {
      border-color: rgba(0, 229, 160, 0.4);
    }

    .user-avatar {
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: rgba(0, 229, 160, 0.15);
      border: 1px solid rgba(0, 229, 160, 0.3);
      color: var(--accent);
      font-size: 11px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Rajdhani', sans-serif;
      flex-shrink: 0;
    }

    .user-name {
      font-size: 13px;
      font-weight: 500;
      color: var(--text-primary);
      white-space: nowrap;
      max-width: 80px;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    @media (max-width: 400px) {
      .user-name {
        display: none;
      }

      .btn-user {
        padding: 0 6px;
      }
    }

    /* ========== CUSTOMER SERVICE FLOAT BUTTON ========== */
    #csButton {
      position: fixed;
      bottom: 24px;
      right: 24px;
      width: 52px;
      height: 52px;
      background: #00e5a0;
      color: #022c22;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 20px rgba(0, 229, 160, 0.35);
      z-index: 9999;
      transition: transform 0.2s, box-shadow 0.2s;
      border: none;
    }

    #csButton:hover {
      transform: scale(1.08);
      box-shadow: 0 6px 24px rgba(0, 229, 160, 0.5);
    }

    #csPopup {
      position: fixed;
      bottom: 90px;
      right: 24px;
      width: 300px;
      background: #111318;
      border: 1px solid rgba(255, 255, 255, 0.07);
      border-radius: 16px;
      display: none;
      flex-direction: column;
      overflow: hidden;
      z-index: 9999;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    }

    .cs-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 14px;
      background: #161a24;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .cs-header-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cs-avatar {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: rgba(0, 229, 160, 0.12);
      border: 1.5px solid rgba(0, 229, 160, 0.35);
      color: #00e5a0;
      font-size: 10px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .cs-header-name {
      font-size: 13px;
      font-weight: 600;
      color: #f0f2f8;
    }

    .cs-header-status {
      font-size: 11px;
      color: #00e5a0;
      margin-top: 1px;
    }

    .cs-close-btn {
      background: none;
      border: none;
      color: #6b7280;
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      border-radius: 6px;
      transition: background 0.15s, color 0.15s;
    }

    .cs-close-btn:hover {
      background: rgba(255, 255, 255, 0.07);
      color: #f0f2f8;
    }

    .cs-chat {
      height: 220px;
      overflow-y: auto;
      padding: 12px;
      display: flex;
      flex-direction: column;
      gap: 8px;
      background: #0d1017;
    }

    .cs-chat::-webkit-scrollbar {
      width: 3px;
    }

    .cs-chat::-webkit-scrollbar-track {
      background: transparent;
    }

    .cs-chat::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.08);
      border-radius: 4px;
    }

    .cs-msg {
      display: flex;
    }

    .cs-msg-user {
      justify-content: flex-end;
    }

    .cs-msg-admin {
      justify-content: flex-start;
    }

    .cs-bubble {
      max-width: 80%;
      padding: 8px 12px;
      border-radius: 14px;
      font-size: 13px;
      line-height: 1.5;
      word-break: break-word;
    }

    .cs-msg-user .cs-bubble {
      background: linear-gradient(135deg, #00e5a0, #00b87c);
      color: #022c22;
      font-weight: 500;
      border-bottom-right-radius: 4px;
    }

    .cs-msg-admin .cs-bubble {
      background: #1a1f2e;
      color: #e2e8f0;
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-bottom-left-radius: 4px;
    }

    .cs-input-area {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 12px;
      background: #161a24;
      border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .cs-input-area input {
      flex: 1;
      background: #0d1017;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 8px;
      color: #f0f2f8;
      font-size: 13px;
      padding: 8px 12px;
      outline: none;
      transition: border-color 0.2s;
      font-family: 'DM Sans', sans-serif;
    }

    .cs-input-area input::placeholder {
      color: #4b5563;
    }

    .cs-input-area input:focus {
      border-color: rgba(0, 229, 160, 0.4);
    }

    .cs-send-btn {
      width: 34px;
      height: 34px;
      flex-shrink: 0;
      background: #00e5a0;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #022c22;
      transition: background 0.18s, transform 0.15s;
    }

    .cs-send-btn:hover {
      background: #00f0aa;
      transform: scale(1.05);
    }

    .cs-send-btn:active {
      transform: scale(0.96);
    }

    @media (max-width: 400px) {
      #csPopup {
        right: 12px;
        left: 12px;
        width: auto;
        bottom: 80px;
      }
    }
  </style>
</head>

<body>

  <!-- FLOATING CS BUTTON -->
  <div id="csButton">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
    </svg>
  </div>

<!-- POPUP CUSTOMER SERVICE -->
<div id="csPopup">

    <!-- HEADER -->
    <div class="cs-header">

        <div class="cs-header-left">

            <div class="cs-avatar">
                CS
            </div>

            <div>
                <div class="cs-header-name">
                    Customer Service
                </div>

                <div class="cs-header-status">
                    ● online
                </div>
            </div>

        </div>

        <button class="cs-close-btn" onclick="toggleCS()">

            <svg width="14" height="14"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2.5"
                 stroke-linecap="round">

                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />

            </svg>

        </button>

    </div>

    <!-- CHAT AREA -->
    <div class="cs-chat" id="csChat">

        <!-- pesan otomatis -->
        <div class="cs-msg cs-msg-admin">

            <div class="cs-bubble">
                Halo! 👋 Ada yang bisa kami bantu?
            </div>

        </div>

    </div>

    <!-- INPUT -->
    <div class="cs-input-area">

        <input
            type="text"
            id="csInput"
            placeholder="Ketik pesan..."
            onkeypress="handleEnter(event)" />

        <button onclick="sendMessage()" class="cs-send-btn">

            <svg width="15"
                 height="15"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2.2"
                 stroke-linecap="round"
                 stroke-linejoin="round">

                <line x1="22" y1="2" x2="11" y2="13" />

                <polygon points="22 2 15 22 11 13 2 9 22 2" />

            </svg>

        </button>

    </div>

</div>

<script>

// ===============================
// LOAD CHAT
// ===============================

async function loadMessages()
{
    try {

        let response = await fetch('/chat/messages');

        let data = await response.json();

        let html = '';

        // greeting default
        html += `
            <div class="cs-msg cs-msg-admin">
                <div class="cs-bubble">
                    Halo! 👋 Ada yang bisa kami bantu?
                </div>
            </div>
        `;

        data.forEach(msg => {

            html += `

                <div class="cs-msg ${
                    msg.sender === 'admin'
                    ? 'cs-msg-admin'
                    : 'cs-msg-user'
                }">

                    <div class="cs-bubble">

                        ${msg.message}

                    </div>

                </div>

            `;
        });

        document.getElementById('csChat').innerHTML = html;

        scrollChatBottom();

    } catch(error) {

        console.log(error);

    }
}

// ===============================
// SEND MESSAGE
// ===============================

async function sendMessage()
{
    let input = document.getElementById('csInput');

    let message = input.value.trim();

    if(message === '') return;

    try {

        await fetch('/chat/send', {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
            },

            body: JSON.stringify({

                message: message

            })

        });

        input.value = '';

        loadMessages();

    } catch(error) {

        console.log(error);

    }
}

// ===============================
// ENTER KEY
// ===============================

function handleEnter(event)
{
    if(event.key === 'Enter') {

        sendMessage();
    }
}

// ===============================
// AUTO SCROLL
// ===============================

function scrollChatBottom()
{
    let chatBox = document.getElementById('csChat');

    chatBox.scrollTop = chatBox.scrollHeight;
}

// ===============================
// AUTO REFRESH
// ===============================

loadMessages();

setInterval(loadMessages, 2000);

</script>
  <!-- NAVBAR -->
  <nav class="navbar">
    <a href="/" class="logo">⚡ PC<span style="color:white">Rakit</span></a>

    <form action="/komponen" method="GET" class="search-bar">
      <span class="search-icon">🔍</span>
      <input type="text" name="search" placeholder="Cari komponen..." value="{{ request('search') }}">
    </form>

    <div class="nav-actions">
      <a href="/cart" class="cart-btn">
        🛒
        <span class="cart-badge">{{ count(session('cart', [])) }}</span>
      </a>

      @auth
      <a href="/user" class="btn-user">
        <div class="user-avatar">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <span class="user-name">
          {{ auth()->user()->name }}
        </span>
      </a>
      @endauth

      @guest
      <a href="/login" class="btn-login">Masuk</a>
      <a href="/register" class="btn-register">Daftar</a>
      @endguest
    </div>
  </nav>

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

  <!-- STORE LOCATION MAP -->
  <section class="map-section">
    <div class="map-header">
      <h2 class="map-title">📍 Lokasi Toko Kami</h2>
      <p class="map-subtitle">Kunjungi toko kami untuk konsultasi langsung dan lihat produk</p>
    </div>
    <div class="map-container">
      <div id="storeMap"></div>
    </div>
  </section>

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

  {{-- Leaflet JS --}}
  <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>

  {{-- Scripts from child views --}}
  @yield('scripts')

  {{-- Main Application Scripts --}}
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // ===== CUSTOMER SERVICE POPUP =====
      const btn = document.getElementById('csButton');
      const popup = document.getElementById('csPopup');

      btn.addEventListener('click', function() {
        popup.style.display = popup.style.display === 'flex' ? 'none' : 'flex';
      });

      // ===== LEAFLET MAP INITIALIZATION =====
      initStoreMap();

      // ===== AUTO LOAD CHAT =====
      loadChat();
      setInterval(loadChat, 2000);
    });

    function toggleCS() {
      const popup = document.getElementById('csPopup');
      popup.style.display = popup.style.display === 'flex' ? 'none' : 'flex';
    }

    function sendMessage() {
      const input = document.getElementById('csInput');
      const chat = document.getElementById('csChat');

      if (input.value.trim() === '') return;

      // Tampilkan pesan user
      const userMsg = document.createElement('div');
      userMsg.className = 'cs-msg cs-msg-user';
      const bubble = document.createElement('div');
      bubble.className = 'cs-bubble';
      bubble.innerText = input.value;
      userMsg.appendChild(bubble);
      chat.appendChild(userMsg);

      // Kirim ke backend
      fetch('/chat/send', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          message: input.value
        })
      });

      input.value = '';
      chat.scrollTop = chat.scrollHeight;
    }

    function loadChat() {
      fetch('/chat/me')
        .then(res => res.json())
        .then(data => {
          const chat = document.getElementById('csChat');
          chat.innerHTML = '';
          data.forEach(msg => {
            const row = document.createElement('div');
            row.className = 'cs-msg ' + (msg.sender === 'admin' ? 'cs-msg-admin' : 'cs-msg-user');
            const bubble = document.createElement('div');
            bubble.className = 'cs-bubble';
            bubble.innerText = msg.message;
            row.appendChild(bubble);
            chat.appendChild(row);
          });
          chat.scrollTop = chat.scrollHeight;
        })
        .catch(error => {
          console.error('Error loading chat:', error);
        });
    }

    // ===== STORE MAP FUNCTIONS =====
    let storeMap, storeMarkers = [];

    function initStoreMap() {
      const mapElement = document.getElementById('storeMap');
      if (!mapElement) return;

      // Initialize map
      storeMap = L.map('storeMap', {
        center: [-7.7925927, 110.3658812],
        zoom: 13,
        zoomControl: true,
        scrollWheelZoom: true
      });

      // Add tile layer (dark theme)
      L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors © CARTO',
        maxZoom: 19
      }).addTo(storeMap);

      // Load markers from API
      fetch('/api/markers')
        .then(response => response.json())
        .then(data => {
          initStoreMarkers(data);
        })
        .catch(error => {
          console.error('Error loading store markers:', error);
        });
    }

    function initStoreMarkers(locations) {
      locations.forEach((location, index) => {
        // Custom icon
        const customIcon = L.divIcon({
          className: 'custom-marker',
          html: `
            <div style="
              width: 40px;
              height: 40px;
              background: linear-gradient(135deg, #00e5a0, #00b87c);
              border: 3px solid #0d1a14;
              border-radius: 50%;
              display: flex;
              align-items: center;
              justify-content: center;
              font-size: 20px;
              box-shadow: 0 4px 12px rgba(0, 229, 160, 0.4);
            ">
              🏪
            </div>
          `,
          iconSize: [40, 40],
          iconAnchor: [20, 40],
          popupAnchor: [0, -40]
        });

        const marker = L.marker(location.position, {
          icon: customIcon
        }).addTo(storeMap);

        // Popup content
        const popupContent = `
          <div class="store-popup">
            <div class="store-popup-title">⚡ PC Rakit Store</div>
            <div class="store-popup-address">
              ${location.label || 'Lokasi Toko'}<br>
              <small style="color: var(--text-muted); font-size: 11px;">
                Lat: ${location.position.lat.toFixed(5)}, 
                Lng: ${location.position.lng.toFixed(5)}
              </small>
            </div>
          </div>
        `;

        marker.bindPopup(popupContent);
        
        // Auto open first marker
        if (index === 0) {
          marker.openPopup();
        }

        storeMap.panTo(location.position);
        storeMarkers.push(marker);
      });
    }
  </script>

</body>
</html>