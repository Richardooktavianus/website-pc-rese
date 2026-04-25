@extends('layouts.app')

@section('title', 'Daftar Akun')

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
  }

  /* ── Main container ── */
  .main {
    min-height: calc(100vh - 60px);
    display: flex; align-items: center; justify-content: center;
    padding: 32px 16px 48px;
  }

  /* ── Card ── */
  .card {
    width: 100%; max-width: 440px;
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

  /* ── Logo area ── */
  .card-logo {
    display: flex; flex-direction: column; align-items: center;
    margin-bottom: 26px; gap: 6px;
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

  .card-sub {
    font-size: 13px; color: var(--text-muted);
  }

  /* ── Steps indicator ── */
  .steps {
    display: flex; align-items: center; justify-content: center;
    gap: 0; margin-bottom: 26px;
  }

  .step {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    position: relative;
  }

  .step-dot {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700;
    font-family: 'Rajdhani', sans-serif;
    border: 1.5px solid rgba(255,255,255,0.1);
    color: var(--text-muted);
    background: var(--bg-surface);
    transition: all 0.3s;
    z-index: 1;
  }

  .step.active .step-dot {
    background: var(--accent); color: #0b1c14;
    border-color: var(--accent);
    box-shadow: 0 0 12px rgba(0,229,160,0.4);
  }

  .step.done .step-dot {
    background: rgba(0,229,160,0.15); color: var(--accent);
    border-color: rgba(0,229,160,0.4);
  }

  .step-label {
    font-size: 10px; color: var(--text-muted);
    font-weight: 600; letter-spacing: 0.5px;
    text-transform: uppercase; white-space: nowrap;
  }
  .step.active .step-label { color: var(--accent); }

  .step-line {
    width: 48px; height: 1.5px;
    background: rgba(255,255,255,0.08);
    margin-bottom: 17px; flex-shrink: 0;
  }
  .step-line.done { background: rgba(0,229,160,0.3); }

  /* ── Alert ── */
  .alert {
    border-radius: 10px; padding: 10px 14px;
    font-size: 13px; margin-bottom: 18px;
    display: flex; align-items: flex-start; gap: 8px;
  }
  .alert-error {
    background: var(--error-bg);
    border: 1px solid var(--error-border);
    color: var(--error-text);
  }
  .alert-icon { font-size: 14px; flex-shrink: 0; margin-top: 1px; }

  /* ── Form ── */
  .form-row {
    display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
  }

  .form-group { margin-bottom: 14px; }
  .form-group.full { grid-column: 1 / -1; }

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
    transition: color 0.2s;
  }

  .form-input {
    width: 100%;
    background: var(--bg-surface);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 10px;
    color: var(--text-primary);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    padding: 11px 14px 11px 38px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    -webkit-appearance: none;
  }
  .form-input::placeholder { color: var(--text-muted); }
  .form-input:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(0,229,160,0.08);
  }

  /* Password strength */
  .strength-bar {
    display: flex; gap: 4px; margin-top: 8px;
  }
  .strength-seg {
    height: 3px; flex: 1; border-radius: 2px;
    background: rgba(255,255,255,0.08);
    transition: background 0.3s;
  }
  .strength-label {
    font-size: 11px; color: var(--text-muted);
    margin-top: 4px; text-align: right;
    transition: color 0.3s;
  }

  /* Password toggle */
  .pass-toggle {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: var(--text-muted); font-size: 15px; padding: 2px;
    transition: color 0.2s; line-height: 1;
  }
  .pass-toggle:hover { color: var(--text-primary); }

  /* ── Terms ── */
  .terms-row {
    display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 20px; margin-top: 6px;
  }
  .terms-check {
    width: 16px; height: 16px; border-radius: 4px; flex-shrink: 0; margin-top: 2px;
    border: 1px solid rgba(255,255,255,0.15);
    background: var(--bg-surface); cursor: pointer;
    accent-color: var(--accent);
  }
  .terms-text {
    font-size: 12px; color: var(--text-muted); line-height: 1.5;
  }
  .terms-text a { color: var(--accent); text-decoration: none; }
  .terms-text a:hover { opacity: 0.75; }

  /* ── Submit button ── */
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

  /* ── Divider ── */
  .divider {
    display: flex; align-items: center; gap: 12px;
    margin: 18px 0; color: var(--text-muted); font-size: 12px;
  }
  .divider::before, .divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }

  /* ── Social buttons ── */
  .social-row {
    display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    margin-bottom: 20px;
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

  /* ── Login link ── */
  .login-row {
    text-align: center; font-size: 13px; color: var(--text-muted);
  }
  .login-row a {
    color: var(--accent); text-decoration: none; font-weight: 600;
    transition: opacity 0.2s;
  }
  .login-row a:hover { opacity: 0.75; }

  /* ── Responsive ── */
  @media (max-width: 480px) {
    .card { padding: 28px 18px 24px; border-radius: 16px; }
    .card::before, .card::after { width: 44px; height: 44px; }
    .card-title { font-size: 1.5rem; }
    .form-row { grid-template-columns: 1fr; }
    .social-row { grid-template-columns: 1fr; }
    .step-line { width: 28px; }
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
      <div class="card-brand">RESE PC Rakit Store</div>
      <div class="card-title">Buat Akun Baru</div>
      <div class="card-sub">Bergabung dan mulai rakit PC impianmu</div>
    </div>

    <!-- Step indicator -->
    <div class="steps">
      <div class="step active" id="step1">
        <div class="step-dot">1</div>
        <div class="step-label">Akun</div>
      </div>
      <div class="step-line" id="line1"></div>
      <div class="step active" id="step2">
        <div class="step-dot">2</div>
        <div class="step-label">Keamanan</div>
      </div>
      <div class="step-line" id="line2"></div>
      <div class="step" id="step3">
        <div class="step-dot">3</div>
        <div class="step-label">Selesai</div>
      </div>
    </div>

    <!-- Errors -->
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
    <form method="POST" action="/register" id="regForm">
      @csrf

      <div class="form-row">
        <!-- Name -->
        <div class="form-group">
          <label class="form-label" for="name">Nama Lengkap</label>
          <div class="input-wrap">
            <span class="input-icon">👤</span>
            <input
              id="name" type="text" name="name"
              placeholder="Nama kamu"
              value="{{ old('name') }}"
              class="form-input" autocomplete="name" required
            >
          </div>
        </div>

        <!-- Username / optional, skip if not needed -->
        <div class="form-group">
          <label class="form-label" for="email">Email</label>
          <div class="input-wrap">
            <span class="input-icon">✉</span>
            <input
              id="email" type="email" name="email"
              placeholder="nama@email.com"
              value="{{ old('email') }}"
              class="form-input" autocomplete="email" required
              style="padding-left:38px;"
            >
          </div>
        </div>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <span class="input-icon">🔒</span>
          <input
            id="password" type="password" name="password"
            placeholder="Min. 8 karakter"
            class="form-input" autocomplete="new-password" required
            oninput="checkStrength(this.value)"
          >
          <button type="button" class="pass-toggle" onclick="togglePass('password','toggleBtn1')" id="toggleBtn1">👁</button>
        </div>
        <div class="strength-bar">
          <div class="strength-seg" id="seg1"></div>
          <div class="strength-seg" id="seg2"></div>
          <div class="strength-seg" id="seg3"></div>
          <div class="strength-seg" id="seg4"></div>
        </div>
        <div class="strength-label" id="strengthLabel"></div>
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
        <div class="input-wrap">
          <span class="input-icon">🔑</span>
          <input
            id="password_confirmation" type="password" name="password_confirmation"
            placeholder="Ulangi password"
            class="form-input" autocomplete="new-password" required
            oninput="checkMatch()"
          >
          <button type="button" class="pass-toggle" onclick="togglePass('password_confirmation','toggleBtn2')" id="toggleBtn2">👁</button>
        </div>
        <div class="strength-label" id="matchLabel" style="text-align:left;"></div>
      </div>

      <!-- Terms -->
      <div class="terms-row">
        <input type="checkbox" id="terms" class="terms-check" required>
        <label for="terms" class="terms-text">
          Saya menyetujui <a href="/syarat">Syarat & Ketentuan</a> dan
          <a href="/kebijakan">Kebijakan Privasi</a> PC Rakit Store.
        </label>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn-submit">
        <span>🚀</span> Buat Akun Sekarang
      </button>
    </form>


    <!-- Login link -->
    <div class="login-row">
      Sudah punya akun? <a href="/login">Masuk di sini →</a>
    </div>

  </div>
</div>

<script>
  /* Password visibility toggle */
  function togglePass(inputId, btnId) {
    const inp = document.getElementById(inputId);
    const btn = document.getElementById(btnId);
    const hidden = inp.type === 'password';
    inp.type = hidden ? 'text' : 'password';
    btn.textContent = hidden ? '🙈' : '👁';
  }

  /* Password strength meter */
  function checkStrength(val) {
    const segs = [
      document.getElementById('seg1'),
      document.getElementById('seg2'),
      document.getElementById('seg3'),
      document.getElementById('seg4'),
    ];
    const label = document.getElementById('strengthLabel');

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const colors = ['#e74c3c','#e67e22','#f1c40f','#00E5A0'];
    const labels = ['Lemah','Sedang','Kuat','Sangat Kuat'];

    segs.forEach((s, i) => {
      s.style.background = i < score ? colors[score - 1] : 'rgba(255,255,255,0.08)';
    });

    if (val.length === 0) {
      label.textContent = '';
    } else {
      label.textContent = labels[score - 1] || 'Terlalu Pendek';
      label.style.color = score > 0 ? colors[score - 1] : 'var(--text-muted)';
    }

    checkMatch();
  }

  /* Confirm password match */
  function checkMatch() {
    const pass = document.getElementById('password').value;
    const conf = document.getElementById('password_confirmation').value;
    const label = document.getElementById('matchLabel');
    if (!conf) { label.textContent = ''; return; }
    if (pass === conf) {
      label.textContent = '✓ Password cocok';
      label.style.color = '#00E5A0';
    } else {
      label.textContent = '✗ Password tidak cocok';
      label.style.color = '#ff6b6b';
    }
  }
</script>

@endsection