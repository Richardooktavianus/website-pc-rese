@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
  :root {
    --accent: #00E5A0;
    --accent-dim: #00b87c;
    --bg-card: #161a24;
    --bg-surface: #1c2130;
    --text-primary: #f0f2f8;
    --text-muted: #7a859e;
    --border: rgba(255,255,255,0.07);
    --border-focus: rgba(0,229,160,0.45);
    --error-bg: rgba(231,76,60,0.1);
    --error-border: rgba(231,76,60,0.35);
    --error-text: #ff6b6b;
    --success-bg: rgba(0,229,160,0.1);
    --success-border: rgba(0,229,160,0.3);
  }

  .main {
    min-height: calc(100vh - 60px);
    display: flex; align-items: center; justify-content: center;
    padding: 32px 16px 48px;
  }

  .card {
    width: 100%; max-width: 420px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 36px 32px 32px;
    position: relative;
    box-shadow: 0 0 0 1px rgba(0,229,160,0.04), 0 24px 60px rgba(0,0,0,0.5);
    animation: cardIn 0.5s cubic-bezier(0.22,1,0.36,1) both;
  }

  @keyframes cardIn {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .card::before {
    content: '';
    position: absolute; top: 0; left: 0;
    width: 60px; height: 60px;
    border-top: 2px solid rgba(0,229,160,0.4);
    border-left: 2px solid rgba(0,229,160,0.4);
    border-radius: 20px 0 0 0;
    pointer-events: none;
  }
  .card::after {
    content: '';
    position: absolute; bottom: 0; right: 0;
    width: 60px; height: 60px;
    border-bottom: 2px solid rgba(0,229,160,0.15);
    border-right: 2px solid rgba(0,229,160,0.15);
    border-radius: 0 0 20px 0;
    pointer-events: none;
  }

  .card-logo {
    display: flex; flex-direction: column; align-items: center;
    margin-bottom: 28px; gap: 6px;
  }

  .card-logo-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: linear-gradient(135deg, rgba(0,229,160,0.15), rgba(0,229,160,0.05));
    border: 1px solid rgba(0,229,160,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 4px;
  }
  .card-logo-icon img {
    width: 52px; height: 52px; object-fit: contain; border-radius: 12px;
  }

  .card-brand {
    font-family: 'Orbitron', sans-serif;
    font-size: 9px; letter-spacing: 3px;
    color: var(--text-muted); text-transform: uppercase;
  }

  .card-title {
    font-family: 'Rajdhani', sans-serif;
    font-size: 1.7rem; font-weight: 700;
    color: var(--text-primary); letter-spacing: 0.5px;
  }

  .card-sub { font-size: 13px; color: var(--text-muted); }

  .alert {
    border-radius: 10px; padding: 10px 14px;
    font-size: 13px; margin-bottom: 18px;
    display: flex; align-items: flex-start; gap: 8px;
  }
  .alert-success {
    background: var(--success-bg);
    border: 1px solid var(--success-border);
    color: var(--accent);
  }
  .alert-error {
    background: var(--error-bg);
    border: 1px solid var(--error-border);
    color: var(--error-text);
  }
  .alert-icon { font-size: 14px; flex-shrink: 0; margin-top: 1px; }

  .form-group { margin-bottom: 16px; }

  .form-label {
    display: block;
    font-size: 11px; font-weight: 600;
    color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 0.8px; margin-bottom: 7px;
  }

  .input-wrap { position: relative; }

  .input-icon {
    position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
    font-size: 14px; color: var(--text-muted); pointer-events: none;
  }

  .form-input {
    width: 100%;
    background: var(--bg-surface);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 10px;
    color: var(--text-primary);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    padding: 12px 14px 12px 40px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    -webkit-appearance: none;
  }
  .form-input::placeholder { color: var(--text-muted); }
  .form-input:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(0,229,160,0.08);
  }

  .pass-toggle {
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: var(--text-muted); font-size: 15px; padding: 2px;
    transition: color 0.2s; line-height: 1;
  }
  .pass-toggle:hover { color: var(--text-primary); }

  .form-extras {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 22px; gap: 8px;
  }

  .remember-label {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--text-muted); cursor: pointer;
    user-select: none;
  }

  .remember-check {
    width: 16px; height: 16px; border-radius: 4px;
    border: 1px solid rgba(255,255,255,0.15);
    background: var(--bg-surface); cursor: pointer;
    accent-color: var(--accent); flex-shrink: 0;
  }

  .forgot-link {
    font-size: 13px; color: var(--accent);
    text-decoration: none; white-space: nowrap;
    transition: opacity 0.2s;
  }
  .forgot-link:hover { opacity: 0.7; }

  .btn-submit {
    width: 100%; height: 48px;
    background: var(--accent);
    border: none; border-radius: 12px;
    color: #0b1c14; font-family: 'Rajdhani', sans-serif;
    font-size: 1rem; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; cursor: pointer;
    position: relative; overflow: hidden;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
  }
  .btn-submit::before {
    content: '';
    position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
    transition: left 0.4s;
  }
  .btn-submit:hover {
    background: var(--accent-dim);
    box-shadow: 0 6px 24px rgba(0,229,160,0.3);
    transform: translateY(-1px);
  }
  .btn-submit:hover::before { left: 100%; }
  .btn-submit:active { transform: translateY(0); box-shadow: none; }

  .divider {
    display: flex; align-items: center; gap: 12px;
    margin: 20px 0; color: var(--text-muted); font-size: 12px;
  }
  .divider::before, .divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }

  .social-row {
    display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    margin-bottom: 22px;
  }
  .btn-social {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    height: 42px; border: 1px solid var(--border);
    background: var(--bg-surface); border-radius: 10px;
    font-family: 'DM Sans', sans-serif; font-size: 13px; font-weight: 500;
    color: var(--text-muted); cursor: pointer; text-decoration: none;
    transition: border-color 0.2s, color 0.2s, background 0.2s;
  }
  .btn-social:hover {
    border-color: rgba(255,255,255,0.18); color: var(--text-primary);
    background: rgba(255,255,255,0.04);
  }

  .register-row {
    text-align: center; font-size: 13px; color: var(--text-muted);
  }
  .register-row a {
    color: var(--accent); text-decoration: none; font-weight: 600;
    transition: opacity 0.2s;
  }
  .register-row a:hover { opacity: 0.75; }

  @media (max-width: 480px) {
    .main { padding: 20px 12px 40px; }
    .card { padding: 28px 20px 24px; border-radius: 16px; }
    .card::before, .card::after { width: 44px; height: 44px; }
    .card-title { font-size: 1.5rem; }
    .social-row { grid-template-columns: 1fr; }
  }
</style>

<div class="main">
  <div class="card">

    <!-- Logo + title -->
    <div class="card-logo">
      <div class="card-logo-icon">
        @if(file_exists(public_path('images/logo.png')))
          <img src="{{ asset('images/logo.png') }}" alt="Logo">
        @else
          ⚡
        @endif
      </div>
      <div class="card-brand">PC Rakit Store</div>
      <div class="card-title">Selamat Datang</div>
      <div class="card-sub">Masuk ke akunmu untuk melanjutkan</div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
      <div class="alert alert-success">
        <span class="alert-icon">✓</span>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-error">
        <span class="alert-icon">!</span>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-error">
        <span class="alert-icon">!</span>
        <div>
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      </div>
    @endif

    <!-- FORM -->
    <form method="POST" action="/login">
      @csrf

      <!-- Email -->
      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <div class="input-wrap">
          <span class="input-icon">✉</span>
          <input
            id="email" type="email" name="email"
            placeholder="nama@email.com"
            value="{{ old('email') }}"
            class="form-input" autocomplete="email" required
          >
        </div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <span class="input-icon">🔒</span>
          <input
            id="password" type="password" name="password"
            placeholder="••••••••"
            class="form-input" autocomplete="current-password" required
          >
          <button type="button" class="pass-toggle" onclick="togglePassword()" id="passToggleBtn" aria-label="Toggle password">
            👁
          </button>
        </div>
      </div>

      <!-- Extras -->
      <div class="form-extras">
        <label class="remember-label">
          <input type="checkbox" name="remember" class="remember-check" id="rememberMe">
          Ingat saya
        </label>
        <a href="#" class="forgot-link">Lupa password?</a>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn-submit">
        <span>⚡</span> Masuk Sekarang
      </button>
    </form>

    <!-- Register link -->
    <div class="register-row">
      Belum punya akun? <a href="/register">Daftar gratis →</a>
    </div>

  </div>
</div>

<script>
  function togglePassword() {
    const inp = document.getElementById('password');
    const btn = document.getElementById('passToggleBtn');
    const isHidden = inp.type === 'password';
    inp.type = isHidden ? 'text' : 'password';
    btn.textContent = isHidden ? '🙈' : '👁';
  }
</script>

@endsection