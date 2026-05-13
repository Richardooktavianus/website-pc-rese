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

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background: var(--bg-main);
      color: var(--text-primary);
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      line-height: 1.5;
    }

    h1, h2, h3, .logo { font-family: 'Rajdhani', sans-serif; }

    /* ========== NAVBAR (IMPROVED) ========== */
    .navbar {
      position: sticky;
      top: 0;
      z-index: 1000;
      background: rgba(13, 15, 20, 0.95);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      padding: 0 1rem;
      height: 60px;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      background: rgba(13, 15, 20, 0.98);
      box-shadow: 0 4px 24px rgba(0, 0, 0, 0.5);
      border-bottom-color: rgba(0, 229, 160, 0.15);
    }

    .logo-link {
      display: flex;
      align-items: center;
      text-decoration: none;
      flex-shrink: 0;
    }

    .logo-img {
      height: 100px;
      width: 110px;
      object-fit: contain;
      display: block;
    }

    /* ========== SEARCH BAR ========== */
    .search-bar {
      flex: 1;
      display: flex;
      align-items: center;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 0 4px 0 12px;
      height: 38px;
      gap: 8px;
      transition: border-color 0.2s;
    }

    .search-bar:focus-within { border-color: rgba(0, 229, 160, 0.4); }

    .search-bar input {
      width: 100%;
      background: none;
      border: none;
      outline: none;
      color: var(--text-primary);
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
    }

    .search-bar input::placeholder { color: var(--text-muted); }

    .search-submit-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 0 8px;
      height: 100%;
      display: flex;
      align-items: center;
      color: var(--text-muted);
      transition: color 0.2s;
      border-radius: 0 6px 6px 0;
    }

    .search-submit-btn:hover { color: var(--accent); }

    /* ========== NAV ACTIONS ========== */
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

    /* ========== LOGIN BUTTON ========== */
    .btn-login {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      height: 38px;
      padding: 0 16px;
      background: var(--accent);
      color: #022c22;
      font-family: 'DM Sans', sans-serif;
      font-size: 13px;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      letter-spacing: 0.3px;
      transition: background 0.2s, transform 0.15s;
      white-space: nowrap;
    }

    .btn-login:hover { background: #00f0aa; transform: scale(1.03); }
    .btn-login:active { transform: scale(0.97); }

    /* ========== USER BUTTON ========== */
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

    .btn-user:hover { border-color: rgba(0, 229, 160, 0.4); }

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
      .user-name { display: none; }
      .btn-user { padding: 0 6px; }
    }

    /* ========== SUBNAV ========== */
    .subnav {
      position: sticky;
      top: 60px;
      z-index: 999;
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

    /* ========== STORE LOCATION + ABOUT SECTION ========== */
    .map-section {
      background: var(--bg-card);
      border-top: 1px solid var(--border);
      padding: 32px 24px;
    }

    .map-section-header {
      max-width: 1200px;
      margin: 0 auto 20px;
      text-align: center;
    }

    .map-title {
      font-family: 'Rajdhani', sans-serif;
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 6px;
      letter-spacing: 1px;
    }

    .map-subtitle { font-size: 14px; color: var(--text-muted); }

    .map-about-layout {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      gap: 20px;
      align-items: stretch;
    }

    .map-box {
      flex: 1;
      min-width: 0;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--border);
      background: var(--bg-surface);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    #storeMap {
      width: 100%;
      height: 100%;
      background: var(--bg-surface);
    }

    .about-panel {
      width: 320px;
      flex-shrink: 0;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .about-logo-row {
      display: flex;
      align-items: center;
      gap: 12px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--border);
    }

    .about-logo-img { height: 44px; width: auto; object-fit: contain; }

    .about-brand-name {
      font-family: 'Rajdhani', sans-serif;
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--text-primary);
      letter-spacing: 1px;
    }

    .about-brand-name span { color: var(--accent); }

    .about-desc { font-size: 13px; color: var(--text-muted); line-height: 1.6; }

    .contact-list { display: flex; flex-direction: column; gap: 12px; }

    .contact-item { display: flex; align-items: flex-start; gap: 10px; }

    .contact-icon {
      width: 34px;
      height: 34px;
      border-radius: 8px;
      background: rgba(0, 229, 160, 0.08);
      border: 1px solid rgba(0, 229, 160, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
      flex-shrink: 0;
    }

    .contact-text { display: flex; flex-direction: column; gap: 1px; }

    .contact-label {
      font-size: 11px;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: 600;
    }

    .contact-value { font-size: 13px; color: var(--text-primary); line-height: 1.4; }
    .contact-value a { color: var(--accent); text-decoration: none; }
    .contact-value a:hover { text-decoration: underline; }

    .about-social { display: flex; gap: 8px; padding-top: 4px; border-top: 1px solid var(--border); }

    .social-btn {
      flex: 1;
      height: 34px;
      border-radius: 8px;
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--border);
      color: var(--text-muted);
      font-size: 12px;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      text-decoration: none;
      transition: border-color 0.2s, color 0.2s;
    }

    .social-btn:hover { border-color: rgba(0, 229, 160, 0.3); color: var(--accent); }

    @media (max-width: 900px) {
      .map-about-layout { flex-direction: column; }
      .about-panel { width: 100%; }
      .map-section { padding: 24px 16px; }
      .map-title { font-size: 1.5rem; }
      #storeMap { height: 300px; }
    }

    @media (max-width: 480px) { #storeMap { height: 250px; } }

    /* ========== LEAFLET DARK THEME ========== */
    .leaflet-popup-content-wrapper {
      background: var(--bg-card);
      color: var(--text-primary);
      border: 1px solid var(--border);
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
    }

    .leaflet-popup-tip { background: var(--bg-card); }

    .leaflet-container a.leaflet-popup-close-button {
      color: var(--text-primary);
      font-size: 20px;
      padding: 4px 8px;
    }

    .leaflet-container a.leaflet-popup-close-button:hover { color: var(--accent); }

    .store-popup { padding: 4px; }

    .store-popup-title {
      font-family: 'Rajdhani', sans-serif;
      font-size: 15px;
      font-weight: 700;
      color: var(--accent);
      margin-bottom: 4px;
    }

    .store-popup-address { font-size: 12px; color: var(--text-muted); line-height: 1.4; }

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

    .leaflet-control-attribution a { color: var(--accent) !important; }

    /* ========== FLOATING BUTTONS CONTAINER ========== */
    .floating-buttons-container {
      position: fixed;
      bottom: 24px;
      right: 24px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      z-index: 9998;
      align-items: flex-end;
    }

    /* ========== FLOATING LANGUAGE BUTTON ========== */
    #langButton {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, var(--accent), var(--accent-dim));
      color: #022c22;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 6px 24px rgba(0, 229, 160, 0.4);
      border: none;
      font-family: 'Rajdhani', sans-serif;
      font-size: 24px;
      font-weight: 700;
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s;
      flex-shrink: 0;
    }

    #langButton:hover {
      transform: scale(1.1) rotate(10deg);
      box-shadow: 0 8px 32px rgba(0, 229, 160, 0.6);
    }

    #langButton:active {
      transform: scale(0.95);
    }

    /* ========== LANGUAGE POPUP MENU ========== */
    #langPopup {
      position: absolute;
      bottom: 70px;
      right: 0;
      background: linear-gradient(135deg, var(--bg-card) 0%, var(--bg-surface) 100%);
      border: 1px solid rgba(0, 229, 160, 0.3);
      border-radius: 16px;
      display: none;
      flex-direction: column;
      overflow: hidden;
      box-shadow: 0 12px 48px rgba(0, 229, 160, 0.2), 0 0 40px rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(10px);
      min-width: 220px;
      animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    #langPopup.show {
      display: flex;
    }

    .lang-popup-header {
      padding: 14px 16px;
      background: rgba(0, 229, 160, 0.1);
      border-bottom: 1px solid rgba(0, 229, 160, 0.2);
      font-family: 'Rajdhani', sans-serif;
      font-weight: 700;
      color: var(--accent);
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
    }

    .lang-option {
      padding: 14px 16px;
      background: none;
      border: none;
      color: var(--text-primary);
      cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.2s;
      width: 100%;
      text-align: left;
      position: relative;
    }

    .lang-option:hover {
      background: rgba(0, 229, 160, 0.1);
      color: var(--accent);
      padding-left: 22px;
    }

    .lang-option.active {
      background: rgba(0, 229, 160, 0.15);
      color: var(--accent);
      border-left: 3px solid var(--accent);
      padding-left: 13px;
    }

    .lang-flag-large {
      font-size: 18px;
      width: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
    }

    .lang-text {
      flex: 1;
    }

    .lang-check {
      color: var(--accent);
      font-size: 18px;
      font-weight: 700;
      line-height: 1;
    }

    /* ========== RESPONSIVE FLOATING BUTTONS ========== */
    @media (max-width: 768px) {
      .floating-buttons-container {
        bottom: 20px;
        right: 20px;
        gap: 10px;
      }

      #langButton {
        width: 52px;
        height: 52px;
        font-size: 22px;
      }

      #langPopup {
        min-width: 200px;
        bottom: 68px;
      }

      .lang-popup-header {
        padding: 12px 14px;
        font-size: 12px;
      }

      .lang-option {
        padding: 12px 14px;
        gap: 10px;
      }

      .lang-option:hover {
        padding-left: 20px;
      }

      .lang-flag-large {
        font-size: 16px;
        width: 22px;
      }
    }

    @media (max-width: 600px) {
      .floating-buttons-container {
        bottom: 16px;
        right: 16px;
        gap: 8px;
      }

      #langButton {
        width: 48px;
        height: 48px;
        font-size: 20px;
        box-shadow: 0 4px 16px rgba(0, 229, 160, 0.35);
      }

      #langButton:hover {
        box-shadow: 0 6px 20px rgba(0, 229, 160, 0.5);
      }

      #langPopup {
        min-width: 180px;
        bottom: 64px;
        right: 0;
      }

      .lang-popup-header {
        padding: 10px 12px;
        font-size: 11px;
        letter-spacing: 0.6px;
      }

      .lang-option {
        padding: 10px 12px;
        font-size: 13px;
        gap: 8px;
      }

      .lang-option:hover {
        padding-left: 18px;
      }

      .lang-option.active {
        padding-left: 9px;
      }

      .lang-flag-large {
        font-size: 14px;
        width: 20px;
        min-width: 20px;
      }

      .lang-check {
        font-size: 16px;
      }
    }

    @media (max-width: 400px) {
      .floating-buttons-container {
        bottom: 12px;
        right: 12px;
        gap: 6px;
      }

      #langButton {
        width: 44px;
        height: 44px;
        font-size: 18px;
        box-shadow: 0 3px 12px rgba(0, 229, 160, 0.3);
      }

      #langButton:hover {
        box-shadow: 0 5px 16px rgba(0, 229, 160, 0.4);
      }

      #langPopup {
        min-width: 160px;
        bottom: 60px;
        max-width: calc(100vw - 24px);
      }

      .lang-popup-header {
        padding: 9px 11px;
        font-size: 10px;
      }

      .lang-option {
        padding: 9px 11px;
        font-size: 12px;
        gap: 6px;
      }

      .lang-option:hover {
        padding-left: 16px;
      }

      .lang-option.active {
        padding-left: 8px;
      }

      .lang-text {
        white-space: nowrap;
      }

      .lang-flag-large {
        font-size: 12px;
        width: 18px;
        min-width: 18px;
      }

      .lang-check {
        font-size: 14px;
      }
    }

    /* ========== CUSTOMER SERVICE FLOAT BUTTON (IMPROVED) ========== */
    #csButton {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, #00e5a0 0%, #00b87c 100%);
      color: #022c22;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 8px 32px rgba(0, 229, 160, 0.5), 0 0 0 0 rgba(0, 229, 160, 0.7);
      border: none;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
      flex-shrink: 0;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%, 100% {
        box-shadow: 0 8px 32px rgba(0, 229, 160, 0.5), 0 0 0 0 rgba(0, 229, 160, 0.7);
      }
      50% {
        box-shadow: 0 8px 32px rgba(0, 229, 160, 0.5), 0 0 0 10px rgba(0, 229, 160, 0);
      }
    }

    #csButton:hover {
      transform: scale(1.1) rotate(10deg);
      box-shadow: 0 12px 40px rgba(0, 229, 160, 0.6);
      animation: none;
    }

    #csButton:active {
      transform: scale(0.95);
    }

    /* ========== CS POPUP (IMPROVED DESIGN) ========== */
    #csPopup {
      position: absolute;
      bottom: 70px;
      right: 0;
      width: 360px;
      background: linear-gradient(145deg, #13161f 0%, #0f1118 100%);
      border: 1px solid rgba(0, 229, 160, 0.2);
      border-radius: 20px;
      display: none;
      flex-direction: column;
      overflow: hidden;
      box-shadow: 
        0 20px 60px rgba(0, 0, 0, 0.8),
        0 0 80px rgba(0, 229, 160, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
      animation: slideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #csPopup.show {
      display: flex;
    }

    /* ========== CS HEADER (IMPROVED) ========== */
    .cs-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 18px;
      background: linear-gradient(135deg, rgba(0, 229, 160, 0.1) 0%, rgba(0, 184, 124, 0.05) 100%);
      border-bottom: 1px solid rgba(0, 229, 160, 0.15);
      position: relative;
    }

    .cs-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(0, 229, 160, 0.5), transparent);
    }

    .cs-header-left { display: flex; align-items: center; gap: 12px; }

    .cs-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, rgba(0, 229, 160, 0.2) 0%, rgba(0, 184, 124, 0.1) 100%);
      border: 2px solid rgba(0, 229, 160, 0.4);
      color: #00e5a0;
      font-size: 12px;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(0, 229, 160, 0.3), inset 0 1px 2px rgba(255, 255, 255, 0.1);
      font-family: 'Rajdhani', sans-serif;
      letter-spacing: 0.5px;
    }

    .cs-header-info {
      display: flex;
      flex-direction: column;
      gap: 2px;
    }

    .cs-header-name { 
      font-size: 14px; 
      font-weight: 700; 
      color: #f0f2f8; 
      font-family: 'Rajdhani', sans-serif;
      letter-spacing: 0.5px;
    }

    .cs-header-status { 
      font-size: 11px; 
      color: #00e5a0; 
      display: flex;
      align-items: center;
      gap: 6px;
      font-weight: 500;
    }

    .cs-status-dot {
      width: 6px;
      height: 6px;
      background: #00e5a0;
      border-radius: 50%;
      animation: blink 2s infinite;
      box-shadow: 0 0 8px rgba(0, 229, 160, 0.8);
    }

    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.3; }
    }

    .cs-close-btn {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #9ca3af;
      cursor: pointer;
      padding: 6px;
      display: flex;
      align-items: center;
      border-radius: 8px;
      transition: all 0.2s;
    }

    .cs-close-btn:hover { 
      background: rgba(239, 68, 68, 0.15); 
      border-color: rgba(239, 68, 68, 0.3);
      color: #ef4444; 
      transform: rotate(90deg);
    }

    /* ========== CS CHAT AREA (IMPROVED) ========== */
    .cs-chat {
      height: 280px;
      overflow-y: auto;
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      background: #0a0c11;
      position: relative;
    }

    .cs-chat::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 20px;
      background: linear-gradient(to bottom, rgba(10, 12, 17, 0.9), transparent);
      pointer-events: none;
      z-index: 1;
    }

    .cs-chat::-webkit-scrollbar { width: 4px; }
    .cs-chat::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.02); }
    .cs-chat::-webkit-scrollbar-thumb { 
      background: rgba(0, 229, 160, 0.3); 
      border-radius: 4px; 
    }
    .cs-chat::-webkit-scrollbar-thumb:hover { background: rgba(0, 229, 160, 0.5); }

    .cs-msg { 
      display: flex; 
      animation: messageIn 0.3s ease-out;
    }

    @keyframes messageIn {
      from {
        opacity: 0;
        transform: translateY(10px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .cs-msg-user { justify-content: flex-end; }
    .cs-msg-admin { justify-content: flex-start; }

    .cs-bubble {
      max-width: 75%;
      padding: 10px 14px;
      border-radius: 16px;
      font-size: 13px;
      line-height: 1.5;
      word-break: break-word;
      position: relative;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .cs-msg-user .cs-bubble {
      background: linear-gradient(135deg, #00e5a0 0%, #00c589 100%);
      color: #022c22;
      font-weight: 500;
      border-bottom-right-radius: 4px;
      box-shadow: 0 4px 12px rgba(0, 229, 160, 0.3);
    }

    .cs-msg-admin .cs-bubble {
      background: linear-gradient(135deg, #1f2937 0%, #1a1f2e 100%);
      color: #e5e7eb;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-bottom-left-radius: 4px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .cs-bubble::before {
      content: '';
      position: absolute;
      bottom: 0;
      width: 0;
      height: 0;
      border-style: solid;
    }

    .cs-msg-user .cs-bubble::before {
      right: -6px;
      border-width: 0 0 12px 8px;
      border-color: transparent transparent #00c589 transparent;
    }

    .cs-msg-admin .cs-bubble::before {
      left: -6px;
      border-width: 0 8px 12px 0;
      border-color: transparent #1a1f2e transparent transparent;
    }

    /* ========== CS INPUT AREA (IMPROVED) ========== */
    .cs-input-area {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 14px 16px;
      background: linear-gradient(135deg, rgba(28, 33, 48, 0.8) 0%, rgba(22, 26, 36, 0.9) 100%);
      border-top: 1px solid rgba(0, 229, 160, 0.1);
      position: relative;
    }

    .cs-input-area::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(0, 229, 160, 0.3), transparent);
    }

    .cs-input-area input {
      flex: 1;
      background: rgba(10, 12, 17, 0.6);
      border: 1px solid rgba(0, 229, 160, 0.15);
      border-radius: 10px;
      color: #f0f2f8;
      font-size: 13px;
      padding: 10px 14px;
      outline: none;
      transition: all 0.2s;
      font-family: 'DM Sans', sans-serif;
    }

    .cs-input-area input::placeholder { color: #6b7280; }
    .cs-input-area input:focus { 
      border-color: rgba(0, 229, 160, 0.5); 
      background: rgba(10, 12, 17, 0.8);
      box-shadow: 0 0 0 3px rgba(0, 229, 160, 0.1);
    }

    .cs-send-btn {
      width: 38px;
      height: 38px;
      flex-shrink: 0;
      background: linear-gradient(135deg, #00e5a0 0%, #00b87c 100%);
      border: none;
      border-radius: 10px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #022c22;
      transition: all 0.2s;
      box-shadow: 0 4px 12px rgba(0, 229, 160, 0.3);
    }

    .cs-send-btn:hover { 
      background: linear-gradient(135deg, #00f0aa 0%, #00c589 100%); 
      transform: scale(1.05) rotate(5deg);
      box-shadow: 0 6px 16px rgba(0, 229, 160, 0.5);
    }

    .cs-send-btn:active { 
      transform: scale(0.95); 
    }

    /* ========== RESPONSIVE CS ========== */
    @media (max-width: 768px) {
      #csButton {
        width: 52px;
        height: 52px;
      }

      #csPopup {
        width: 340px;
        bottom: 68px;
      }

      .cs-chat {
        height: 260px;
      }
    }

    @media (max-width: 600px) {
      #csButton {
        width: 48px;
        height: 48px;
        box-shadow: 0 6px 24px rgba(0, 229, 160, 0.4);
      }

      #csPopup {
        width: 320px;
        bottom: 64px;
      }

      .cs-header {
        padding: 14px 16px;
      }

      .cs-avatar {
        width: 36px;
        height: 36px;
        font-size: 11px;
      }

      .cs-header-name {
        font-size: 13px;
      }

      .cs-header-status {
        font-size: 10px;
      }

      .cs-chat {
        height: 240px;
        padding: 14px;
        gap: 10px;
      }

      .cs-bubble {
        font-size: 12px;
        padding: 9px 12px;
        max-width: 78%;
      }

      .cs-input-area {
        padding: 12px 14px;
        gap: 8px;
      }

      .cs-input-area input {
        font-size: 12px;
        padding: 9px 12px;
      }

      .cs-send-btn {
        width: 36px;
        height: 36px;
      }

      .cs-send-btn svg {
        width: 14px;
        height: 14px;
      }
    }

    @media (max-width: 400px) {
      #csButton {
        width: 44px;
        height: 44px;
        font-size: 16px;
        box-shadow: 0 4px 16px rgba(0, 229, 160, 0.35);
      }

      #csPopup {
        width: calc(100vw - 24px);
        max-width: 300px;
        bottom: 60px;
      }

      .cs-header {
        padding: 12px 14px;
      }

      .cs-avatar {
        width: 32px;
        height: 32px;
        font-size: 10px;
      }

      .cs-header-name {
        font-size: 12px;
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .cs-header-status {
        font-size: 9px;
      }

      .cs-close-btn {
        padding: 4px;
      }

      .cs-close-btn svg {
        width: 12px;
        height: 12px;
      }

      .cs-chat {
        height: 220px;
        padding: 12px;
        gap: 8px;
      }

      .cs-bubble {
        font-size: 11px;
        padding: 8px 11px;
        max-width: 80%;
      }

      .cs-input-area {
        padding: 10px 12px;
        gap: 6px;
      }

      .cs-input-area input {
        font-size: 11px;
        padding: 8px 11px;
      }

      .cs-send-btn {
        width: 34px;
        height: 34px;
      }

      .cs-send-btn svg {
        width: 13px;
        height: 13px;
      }
    }
  </style>
</head>

<body>

  <!-- FLOATING BUTTONS CONTAINER -->
  <div class="floating-buttons-container">
    
    <!-- FLOATING LANGUAGE BUTTON -->
    <button id="langButton" onclick="toggleLangPopup()" title="Pilih Bahasa">
      🌐
    </button>

    <!-- LANGUAGE POPUP MENU (di dalam container) -->
    <div id="langPopup">
      <div class="lang-popup-header">Pilih Bahasa</div>
      <button class="lang-option" onclick="setLang('id')" id="langOptId">
        <span class="lang-flag-large">ID</span>
        <span class="lang-text">Bahasa Indonesia</span>
        <span class="lang-check" id="langCheckId">✓</span>
      </button>
      <button class="lang-option" onclick="setLang('en')" id="langOptEn">
        <span class="lang-flag-large">EN</span>
        <span class="lang-text">English</span>
        <span class="lang-check" id="langCheckEn"></span>
      </button>
    </div>

    <!-- FLOATING CS BUTTON -->
    <button id="csButton">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
      </svg>
    </button>

    <!-- POPUP CUSTOMER SERVICE (di dalam container) -->
    <div id="csPopup">
      <div class="cs-header">
        <div class="cs-header-left">
          <div class="cs-avatar">CS</div>
          <div class="cs-header-info">
            <div class="cs-header-name">Customer Service</div>
            <div class="cs-header-status">
              <span class="cs-status-dot"></span>
              <span>online</span>
            </div>
          </div>
        </div>
        <button class="cs-close-btn" onclick="toggleCS()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg>
        </button>
      </div>
      <div class="cs-chat" id="csChat">
        <div class="cs-msg cs-msg-admin">
          <div class="cs-bubble" data-i18n="cs.halo">Halo! 👋 Ada yang bisa kami bantu?</div>
        </div>
      </div>
      <div class="cs-input-area">
        <input type="text" id="csInput" data-i18n-placeholder="cs.placeholder" placeholder="Ketik pesan..." />
        <button onclick="sendMessage()" class="cs-send-btn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="22" y1="2" x2="11" y2="13" />
            <polygon points="22 2 15 22 11 13 2 9 22 2" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- NAVBAR -->
  <nav class="navbar" id="mainNavbar">
    <a href="/" class="logo-link">
      <img src="{{ asset('images/banner/LOGO RESE.png') }}" alt="PC Rakit Store" class="logo-img">
    </a>

    <form action="/komponen" method="GET" class="search-bar" id="searchForm">
      <input
        type="text"
        name="search"
        id="searchInput"
        data-i18n-placeholder="nav.search.placeholder"
        placeholder="Cari komponen, brand, atau kategori..."
        value="{{ request('search') }}"
        autocomplete="off"
      >
      <button type="submit" class="search-submit-btn" title="Cari">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
      </button>
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
        <span class="user-name">{{ auth()->user()->name }}</span>
      </a>
      @endauth

      @guest
      <a href="/login" class="btn-login">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" y1="12" x2="3" y2="12"/>
        </svg>
        <span data-i18n="nav.masuk">Masuk</span>
      </a>
      @endguest
    </div>
  </nav>

  <!-- SUBNAV -->
  <div class="subnav">
    <a href="{{ url('/') }}"         class="{{ request()->is('/')           ? 'active' : '' }}" data-i18n="nav.home">Home</a>
    <a href="{{ url('/transaksi') }}" class="{{ request()->is('transaksi*')  ? 'active' : '' }}" data-i18n="nav.transaksi">Transaksi</a>
    <a href="{{ url('/builder') }}"  class="{{ request()->is('builder*')    ? 'active' : '' }}" data-i18n="nav.builder">Builder</a>
    <a href="{{ url('/cart') }}"     class="{{ request()->is('cart*')       ? 'active' : '' }}" data-i18n="nav.keranjang">Keranjang</a>
    <a href="{{ url('/promo') }}"    class="{{ request()->is('promo*')      ? 'active' : '' }}" data-i18n="nav.promo">Promo</a>
  </div>

  <!-- CONTENT -->
  <main>
    @yield('content')
  </main>

  <!-- STORE LOCATION + ABOUT SECTION -->
  <section class="map-section">
    <div class="map-section-header">
      <h2 class="map-title" data-i18n="map.title">📍 Lokasi & Tentang Kami</h2>
      <p class="map-subtitle" data-i18n="map.subtitle">Kunjungi toko kami untuk konsultasi langsung dan lihat produk secara nyata</p>
    </div>

    <div class="map-about-layout">
      <div class="map-box">
        <div id="storeMap"></div>
      </div>

      <div class="about-panel">
        <div class="about-logo-row">
          <img src="{{ asset('images/banner/LOGO RESE.png') }}" alt="PC Rakit" class="about-logo-img">
          <div class="about-brand-name">PC <span>Rakit</span> Store</div>
        </div>

        <p class="about-desc" data-i18n="map.about.desc">
          Rese Rakit Store adalah toko komputer terpercaya yang menghadirkan komponen PC berkualitas tinggi dengan harga kompetitif. Kami membantu Anda membangun PC impian dari nol dengan panduan kompatibilitas otomatis.
        </p>

        <div class="contact-list">
          <div class="contact-item">
            <div class="contact-icon">📍</div>
            <div class="contact-text">
              <span class="contact-label" data-i18n="map.alamat">Alamat</span>
              <span class="contact-value">Jl. Ir. H. Juanda No.96, Lebakgede, Kecamatan Coblong, Kota Bandung,<br> Jawa Barat 40132</span>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon">📞</div>
            <div class="contact-text">
              <span class="contact-label" data-i18n="map.telepon">Telepon / WhatsApp</span>
              <span class="contact-value">
                <a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a>
              </span>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon">📧</div>
            <div class="contact-text">
              <span class="contact-label" data-i18n="map.email">Email</span>
              <span class="contact-value">
                <a href="mailto:support@pcrakit.id">support@pcrakit.id</a>
              </span>
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon">🕐</div>
            <div class="contact-text">
              <span class="contact-label" data-i18n="map.jam">Jam Operasional</span>
              <span class="contact-value" data-i18n="map.jam.value">Senin – Sabtu: 09.00 – 20.00<br>Minggu: 10.00 – 17.00</span>
            </div>
          </div>
        </div>

        <div class="about-social">
          <a href="#" class="social-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            Instagram
          </a>
          <a href="#" class="social-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            Facebook
          </a>
          <a href="#" class="social-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V9.17a8.18 8.18 0 0 0 4.78 1.52V7.25a4.85 4.85 0 0 1-1.01-.56z"/></svg>
            TikTok
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- Leaflet JS --}}
  <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>

  {{-- Scripts from child views --}}
  @yield('scripts')

  {{-- Main Application Scripts --}}
  <script>

    // ============================================================
    //  NAVBAR SCROLL EFFECT
    // ============================================================
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('mainNavbar');
      if (window.scrollY > 20) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // ============================================================
    //  TRANSLATE SYSTEM
    //  Hanya menerjemahkan elemen dengan data-i18n="key"
    //  Nama produk, harga, deskripsi produk TIDAK disentuh
    // ============================================================
    const i18n = {
      id: {
        'nav.home':                   'Home',
        'nav.transaksi':              'Transaksi',
        'nav.builder':                'Builder',
        'nav.keranjang':              'Keranjang',
        'nav.promo':                  'Promo',
        'nav.masuk':                  'Masuk',
        'nav.search.placeholder':     'Cari komponen, brand, atau kategori...',

        'home.kategori':              'Kategori',
        'home.lihat.semua':           'Lihat Semua →',
        'home.top.brand':             'TOP BRAND',
        'home.builder.title':         'Rakit PC Sekarang',
        'home.builder.sub':           'Pilih komponen & cek kompatibilitas otomatis',
        'home.popular':               'Popular Product',
        'home.semua.arrow':           'Semua →',
        'home.lihat.produk':          '👁 Lihat Produk',
        'home.lihat.banyak':          'Lihat Lebih Banyak',
        'home.sembunyikan':           'Sembunyikan',
        'home.special.offer':         'Special Offer',
        'home.semua.promo':           'Semua Promo →',
        'home.promo.referral':        'Program Referral',
        'home.promo.title':           'Ajak Teman, Dapatkan<br>Cashback Rp 100.000',
        'home.promo.sub':             'Berlaku untuk setiap teman yang berhasil melakukan pembelian pertama.',
        'home.promo.cta':             'Ikut Sekarang →',
        'home.offer.msi':             'MSI Gaming Bundle',
        'home.offer.intel':           'Intel Core i9 Bundle',
        'home.offer.cooling':         'Cooling Bundle Set',
        'home.offer.ram':             'RAM + SSD Paket',

        'komp.search.placeholder':    'Cari komponen...',
        'komp.all':                   'Semua',
        'komp.semua.komponen':        'Semua Komponen',
        'komp.kategori':              'Kategori',
        'komp.cari.kategori':         'Cari kategori...',
        'komp.pc.builder':            'PC Builder',
        'komp.promo.aktif':           'Promo Aktif',
        'komp.judul':                 'Semua Komponen',
        'komp.subtitle':              'Pilih komponen terbaik untuk build kamu',
        'komp.urutkan':               'Urutkan',
        'komp.harga.terendah':        'Harga: Terendah',
        'komp.harga.tertinggi':       'Harga: Tertinggi',
        'komp.nama.az':               'Nama: A–Z',
        'komp.nama.za':               'Nama: Z–A',
        'komp.bestseller':            '🔥 Best Seller',
        'komp.semua.produk':          '📦 Semua Produk',
        'komp.menampilkan':           'Menampilkan',
        'komp.produk':                'produk',
        'komp.tersedia':              'Tersedia',
        'komp.lihat.detail':          '👁 Lihat Detail',
        'komp.terlaris':              'Terlaris',
        'komp.load.more':             'Tampilkan Lebih Banyak ↓',
        'komp.tidak.ada':             'Belum Ada Produk',
        'komp.tidak.ada.sub':         'Produk akan segera tersedia.',
        'komp.tidak.ditemukan':       'Produk Tidak Ditemukan',
        'komp.tidak.ditemukan.sub':   'Coba kata kunci atau kategori lain.',

        'detail.kembali':             'Kembali',
        'detail.stok.ada':            '✅ Stok Tersedia',
        'detail.stok.habis':          '❌ Stok Habis',
        'detail.tambah.cart':         'Tambah ke Keranjang',
        'detail.rekomendasi':         'Produk Rekomendasi',
        'detail.lihat.produk':        '👁 Lihat Produk',
        'detail.selengkapnya':        'Selengkapnya',
        'detail.sembunyikan':         'Sembunyikan',
        'detail.no.image':            'Tidak ada gambar',
        'detail.no.desc':             'Tidak ada deskripsi tersedia.',
        'detail.produk.label':        'Produk',

        'map.title':                  '📍 Lokasi & Tentang Kami',
        'map.subtitle':               'Kunjungi toko kami untuk konsultasi langsung dan lihat produk secara nyata',
        'map.about.desc':             'Rese Rakit Store adalah toko komputer terpercaya yang menghadirkan komponen PC berkualitas tinggi dengan harga kompetitif. Kami membantu Anda membangun PC impian dari nol dengan panduan kompatibilitas otomatis.',
        'map.alamat':                 'Alamat',
        'map.telepon':                'Telepon / WhatsApp',
        'map.email':                  'Email',
        'map.jam':                    'Jam Operasional',
        'map.jam.value':              'Senin – Sabtu: 09.00 – 20.00<br>Minggu: 10.00 – 17.00',

        'cs.halo':                    'Halo! 👋 Ada yang bisa kami bantu?',
        'cs.placeholder':             'Ketik pesan...',
      },

      en: {
        'nav.home':                   'Home',
        'nav.transaksi':              'Transactions',
        'nav.builder':                'Builder',
        'nav.keranjang':              'Cart',
        'nav.promo':                  'Promo',
        'nav.masuk':                  'Sign In',
        'nav.search.placeholder':     'Search components, brands, or categories...',

        'home.kategori':              'Category',
        'home.lihat.semua':           'View All →',
        'home.top.brand':             'TOP BRAND',
        'home.builder.title':         'Build Your PC Now',
        'home.builder.sub':           'Choose components & check compatibility automatically',
        'home.popular':               'Popular Product',
        'home.semua.arrow':           'All →',
        'home.lihat.produk':          '👁 View Product',
        'home.lihat.banyak':          'Load More',
        'home.sembunyikan':           'Hide',
        'home.special.offer':         'Special Offer',
        'home.semua.promo':           'All Promos →',
        'home.promo.referral':        'Referral Program',
        'home.promo.title':           'Invite Friends, Get<br>Cashback IDR 100,000',
        'home.promo.sub':             'Valid for every friend who successfully makes their first purchase.',
        'home.promo.cta':             'Join Now →',
        'home.offer.msi':             'MSI Gaming Bundle',
        'home.offer.intel':           'Intel Core i9 Bundle',
        'home.offer.cooling':         'Cooling Bundle Set',
        'home.offer.ram':             'RAM + SSD Package',

        'komp.search.placeholder':    'Search components...',
        'komp.all':                   'All',
        'komp.semua.komponen':        'All Components',
        'komp.kategori':              'Category',
        'komp.cari.kategori':         'Search category...',
        'komp.pc.builder':            'PC Builder',
        'komp.promo.aktif':           'Active Promos',
        'komp.judul':                 'All Components',
        'komp.subtitle':              'Pick the best components for your build',
        'komp.urutkan':               'Sort By',
        'komp.harga.terendah':        'Price: Lowest',
        'komp.harga.tertinggi':       'Price: Highest',
        'komp.nama.az':               'Name: A–Z',
        'komp.nama.za':               'Name: Z–A',
        'komp.bestseller':            '🔥 Best Sellers',
        'komp.semua.produk':          '📦 All Products',
        'komp.menampilkan':           'Showing',
        'komp.produk':                'products',
        'komp.tersedia':              'In Stock',
        'komp.lihat.detail':          '👁 View Detail',
        'komp.terlaris':              'Best Seller',
        'komp.load.more':             'Load More ↓',
        'komp.tidak.ada':             'No Products Yet',
        'komp.tidak.ada.sub':         'Products will be available soon.',
        'komp.tidak.ditemukan':       'No Products Found',
        'komp.tidak.ditemukan.sub':   'Try a different keyword or category.',

        'detail.kembali':             'Back',
        'detail.stok.ada':            '✅ In Stock',
        'detail.stok.habis':          '❌ Out of Stock',
        'detail.tambah.cart':         'Add to Cart',
        'detail.rekomendasi':         'Recommended Products',
        'detail.lihat.produk':        '👁 View Product',
        'detail.selengkapnya':        'Show More',
        'detail.sembunyikan':         'Hide',
        'detail.no.image':            'No image available',
        'detail.no.desc':             'No description available.',
        'detail.produk.label':        'Products',

        'map.title':                  '📍 Location & About Us',
        'map.subtitle':               'Visit our store for direct consultation and see products in person',
        'map.about.desc':             'PC Rakit Store is a trusted computer store delivering high-quality PC components at competitive prices. We help you build your dream PC from scratch with automatic compatibility guidance.',
        'map.alamat':                 'Address',
        'map.telepon':                'Phone / WhatsApp',
        'map.email':                  'Email',
        'map.jam':                    'Operating Hours',
        'map.jam.value':              'Mon – Sat: 09:00 – 20:00<br>Sun: 10:00 – 17:00',

        'cs.halo':                    'Hello! 👋 How can we help you?',
        'cs.placeholder':             'Type a message...',
      }
    };

    // Terapkan terjemahan ke semua elemen [data-i18n]
    function applyLang(lang) {
      const dict = i18n[lang];

      // Teks biasa (innerHTML)
      document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (dict[key] !== undefined) el.innerHTML = dict[key];
      });

      // Placeholder inputs
      document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
        const key = el.getAttribute('data-i18n-placeholder');
        if (dict[key] !== undefined) el.placeholder = dict[key];
      });

      localStorage.setItem('pcrakit_lang', lang);
      window.__currentLang = lang;

      // Update status di popup
      updateLangStatus();

      // Trigger event agar halaman child bisa bereaksi
      document.dispatchEvent(new CustomEvent('langChanged', { detail: { lang } }));
    }

    function toggleLangPopup() {
      const popup = document.getElementById('langPopup');
      popup.classList.toggle('show');
    }

    function setLang(lang) {
      applyLang(lang);
      setTimeout(() => {
        document.getElementById('langPopup').classList.remove('show');
      }, 200);
    }

    function updateLangStatus() {
      const currentLang = localStorage.getItem('pcrakit_lang') || 'id';
      
      document.getElementById('langCheckId').textContent = currentLang === 'id' ? '✓' : '';
      document.getElementById('langCheckEn').textContent = currentLang === 'en' ? '✓' : '';

      document.getElementById('langOptId').classList.toggle('active', currentLang === 'id');
      document.getElementById('langOptEn').classList.toggle('active', currentLang === 'en');
    }

    // Expose helper untuk dipakai di halaman child
    window.getLang  = () => localStorage.getItem('pcrakit_lang') || 'id';
    window.getI18n  = (key) => {
      const lang = window.getLang();
      return (i18n[lang] && i18n[lang][key]) ? i18n[lang][key] : key;
    };

    // ============================================================
    //  TOGGLE CS POPUP (dipanggil dari onclick di HTML)
    // ============================================================
    function toggleCS() {
      const popup = document.getElementById('csPopup');
      if (popup.style.display === 'flex') {
        popup.style.display = 'none';
      } else {
        popup.style.display = 'flex';
        popup.classList.add('show');
      }
    }

    // ============================================================
    //  SEND CHAT MESSAGE
    // ============================================================
    function sendMessage() {
      const input = document.getElementById('csInput');
      const chat  = document.getElementById('csChat');
      if (!input || input.value.trim() === '') return;

      const userMsg = document.createElement('div');
      userMsg.className = 'cs-msg cs-msg-user';
      const bubble = document.createElement('div');
      bubble.className = 'cs-bubble';
      bubble.innerText = input.value;
      userMsg.appendChild(bubble);
      chat.appendChild(userMsg);

      fetch('/chat/send', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message: input.value })
      });

      input.value = '';
      chat.scrollTop = chat.scrollHeight;
    }

    // ============================================================
    //  LOAD CHAT HISTORY
    // ============================================================
    function loadChat() {
      fetch('/chat/me')
        .then(res => res.json())
        .then(data => {
          const chat = document.getElementById('csChat');
          if (!chat) return;
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
        .catch(err => console.error('Chat load error:', err));
    }

    // ============================================================
    //  STORE MAP
    // ============================================================
    let storeMap, storeMarkers = [];

    function initStoreMap() {
      const mapEl = document.getElementById('storeMap');
      if (!mapEl) return;

      storeMap = L.map('storeMap', {
        center: [-7.7925927, 110.3658812],
        zoom: 14,
        zoomControl: true,
        scrollWheelZoom: false
      });

      L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors © CARTO',
        maxZoom: 19
      }).addTo(storeMap);

      fetch('/api/markers')
        .then(res => res.json())
        .then(data => initStoreMarkers(data))
        .catch(err => console.error('Markers load error:', err));
    }

    function initStoreMarkers(locations) {
      locations.forEach((loc, idx) => {
        const icon = L.divIcon({
          className: 'custom-marker',
          html: `<div style="
            width:38px;height:38px;
            background:linear-gradient(135deg,#00e5a0,#00b87c);
            border:3px solid #0d1a14;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            font-size:18px;box-shadow:0 4px 12px rgba(0,229,160,0.4);">🏪</div>`,
          iconSize: [38, 38],
          iconAnchor: [19, 38],
          popupAnchor: [0, -38]
        });

        const marker = L.marker(loc.position, { icon }).addTo(storeMap);
        marker.bindPopup(`
          <div class="store-popup">
            <div class="store-popup-title">⚡ PC Rakit Store</div>
            <div class="store-popup-address">
              ${loc.label || 'Lokasi Toko'}<br>
              <small style="color:var(--text-muted);font-size:11px;">
                Lat: ${loc.position.lat.toFixed(5)}, Lng: ${loc.position.lng.toFixed(5)}
              </small>
            </div>
          </div>
        `);

        if (idx === 0) marker.openPopup();
        storeMap.panTo(loc.position);
        storeMarkers.push(marker);
      });
    }

    // ============================================================
    //  SEARCH: Redirect ke komponen dengan cat atau keyword
    // ============================================================
    const categoryKeywords = {
      'ssd': 'Storage', 'hdd': 'Storage', 'storage': 'Storage',
      'ram': 'RAM', 'memori': 'RAM', 'memory': 'RAM',
      'cpu': 'CPU', 'prosesor': 'CPU', 'processor': 'CPU',
      'gpu': 'GPU', 'vga': 'GPU', 'kartu grafis': 'GPU', 'graphic': 'GPU',
      'psu': 'PSU', 'power supply': 'PSU', 'power': 'PSU',
      'mobo': 'Motherboard', 'motherboard': 'Motherboard',
      'casing': 'Casing', 'case': 'Casing',
      'cooling': 'Cooling', 'pendingin': 'Cooling', 'cooler': 'Cooling',
      'monitor': 'Monitor',
      'periferal': 'Periferal', 'peripheral': 'Periferal',
      'mouse': 'Periferal', 'keyboard': 'Periferal',
    };

    // ============================================================
    //  DOM CONTENT LOADED — inisialisasi semua fitur
    // ============================================================
    document.addEventListener('DOMContentLoaded', function () {

      // 1. Init bahasa tersimpan
      const savedLang = localStorage.getItem('pcrakit_lang') || 'id';
      applyLang(savedLang);

      // 2. CS Popup toggle
      document.getElementById('csButton').addEventListener('click', function () {
        toggleCS();
      });

      // 3. CS Input enter key
      const csInput = document.getElementById('csInput');
      if (csInput) {
        csInput.addEventListener('keydown', function (e) {
          if (e.key === 'Enter') sendMessage();
        });
      }

      // 4. Map init
      initStoreMap();

      // 5. Auto refresh chat setiap 2 detik
      loadChat();
      setInterval(loadChat, 2000);

      // 6. Search form handler
      const searchInput = document.getElementById('searchInput');
const searchForm = document.getElementById('searchForm');

if (searchInput && searchForm) {
  searchForm.addEventListener('submit', function (e) {
    e.preventDefault();
    
    // Normalisasi input
    const fullText = searchInput.value.trim().toLowerCase();
    if (!fullText) return;

    // Strategi 1: Cari apakah ada kata kunci kategori di dalam input user
    let matchedCat = null;
    
    // Kita pecah input menjadi kata-kata (untuk menghindari pencarian parsial yang salah)
    const words = fullText.split(/\s+/); 

    // Cek setiap kata, apakah terdaftar di categoryKeywords
    for (const word of words) {
      if (categoryKeywords[word]) {
        matchedCat = categoryKeywords[word];
        break; // Ambil kategori pertama yang cocok
      }
    }

    // Strategi 2: Jika tidak ada kata yang cocok persis, coba cari substring (opsional)
    if (!matchedCat) {
      for (const [key, value] of Object.entries(categoryKeywords)) {
        if (fullText.includes(key)) {
          matchedCat = value;
          break;
        }
      }
    }

    // Redirect Logic
    if (matchedCat) {
      // Jika ketemu kategorinya, arahkan ke filter kategori
      window.location.href = `/komponen?cat=${encodeURIComponent(matchedCat)}`;
    } else {
      // Jika tidak ada keyword kategori, lakukan pencarian teks biasa
      window.location.href = `/komponen?search=${encodeURIComponent(fullText)}`;
    }
  });

  // Listener 'keydown' sebenarnya opsional jika button type="submit", 
  // tapi jika ingin dipertahankan, ini versi yang lebih clean:
  searchInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      searchForm.requestSubmit(); // Lebih modern daripada dispatchEvent
    }
  });
}

      // 7. Close lang popup ketika klik di luar
      document.addEventListener('click', function (e) {
        const popup = document.getElementById('langPopup');
        const btn = document.getElementById('langButton');
        if (!popup.contains(e.target) && !btn.contains(e.target)) {
          popup.classList.remove('show');
        }
      });

      // 8. Close CS popup ketika klik di luar
      document.addEventListener('click', function (e) {
        const csPopup = document.getElementById('csPopup');
        const csButton = document.getElementById('csButton');
        if (csPopup.style.display === 'flex' && 
            !csPopup.contains(e.target) && 
            !csButton.contains(e.target)) {
          csPopup.style.display = 'none';
        }
      });

    }); // end DOMContentLoaded

  </script>

</body>
</html>