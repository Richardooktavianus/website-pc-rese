@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<style>
/* ─── Profile Page ─────────────────────────────── */
.profile-page {
  max-width: 900px;
  margin: 0 auto;
  padding: 24px 0 60px;
}

/* Header */
.profile-header {
  display: flex;
  align-items: center;
  gap: 20px;
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 20px;
  padding: 24px;
  margin-bottom: 20px;
  position: relative;
  overflow: hidden;
}

.profile-header::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--accent), transparent);
}

.profile-avatar {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(0,229,160,0.2), rgba(0,229,160,0.05));
  border: 2px solid rgba(0,229,160,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  flex-shrink: 0;
  position: relative;
}

.profile-avatar-edit {
  position: absolute;
  bottom: 0; right: 0;
  width: 22px; height: 22px;
  background: var(--accent);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 10px;
  cursor: pointer;
  color: #0d1a14;
}

.profile-header-info { flex: 1; min-width: 0; }

.profile-name {
  font-family: 'Rajdhani', sans-serif;
  font-size: 1.4rem;
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1;
  margin-bottom: 4px;
}

.profile-email {
  font-size: 13px;
  color: var(--text-muted);
  margin-bottom: 8px;
}

.profile-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  color: var(--accent);
  background: rgba(0,229,160,0.08);
  border: 1px solid rgba(0,229,160,0.2);
  border-radius: 20px;
  padding: 3px 10px;
  font-family: 'Rajdhani', sans-serif;
}

/* Stats row */
.profile-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
  margin-bottom: 20px;
}

.stat-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 16px;
  text-align: center;
  transition: border-color 0.2s;
}
.stat-card:hover { border-color: rgba(0,229,160,0.2); }

.stat-value {
  font-family: 'Rajdhani', sans-serif;
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--accent);
  line-height: 1;
  margin-bottom: 4px;
}

.stat-label {
  font-size: 11px;
  color: var(--text-muted);
  font-weight: 600;
  letter-spacing: 0.5px;
}

/* Form panel */
.profile-panel {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 20px;
  overflow: hidden;
  margin-bottom: 16px;
}

.panel-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 20px;
  border-bottom: 1px solid var(--border);
}

.panel-title {
  font-family: 'Rajdhani', sans-serif;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--text-muted);
}

.panel-body { padding: 20px; }

/* Form grid */
.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.form-grid.full { grid-template-columns: 1fr; }

@media (max-width: 600px) {
  .form-grid { grid-template-columns: 1fr; }
}

.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group.span2 { grid-column: span 2; }
@media (max-width: 600px) { .form-group.span2 { grid-column: span 1; } }

.form-label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--text-muted);
  font-family: 'Rajdhani', sans-serif;
}

.form-input {
  background: var(--bg-surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  color: var(--text-primary);
  font-size: 13px;
  font-family: 'DM Sans', sans-serif;
  padding: 10px 14px;
  outline: none;
  transition: border-color 0.2s, background 0.2s;
  width: 100%;
}
.form-input:focus {
  border-color: rgba(0,229,160,0.4);
  background: rgba(0,229,160,0.02);
}
.form-input::placeholder { color: var(--text-muted); }
.form-input:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.form-hint {
  font-size: 11px;
  color: var(--text-muted);
  margin-top: 2px;
}

/* Password toggle */
.input-wrap {
  position: relative;
}
.input-wrap .form-input { padding-right: 40px; }
.input-toggle {
  position: absolute;
  right: 12px; top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: var(--text-muted);
  cursor: pointer;
  font-size: 14px;
  padding: 0;
  line-height: 1;
}

/* Actions */
.panel-actions {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 10px;
  padding: 16px 20px;
  border-top: 1px solid var(--border);
  background: rgba(255,255,255,0.01);
}

.btn-cancel {
  padding: 9px 18px;
  background: none;
  border: 1px solid var(--border);
  border-radius: 8px;
  color: var(--text-muted);
  font-size: 13px;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-cancel:hover { color: var(--text-primary); border-color: rgba(255,255,255,0.2); }

.btn-save {
  padding: 9px 20px;
  background: var(--accent);
  border: none;
  border-radius: 8px;
  color: #0d1a14;
  font-size: 13px;
  font-weight: 700;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  transition: background 0.2s;
  display: flex;
  align-items: center;
  gap: 6px;
}
.btn-save:hover { background: var(--accent-dim); }

/* Danger zone */
.danger-zone {
  background: rgba(255,77,77,0.04);
  border: 1px solid rgba(255,77,77,0.15);
  border-radius: 14px;
  padding: 16px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
}

.danger-info h4 {
  font-family: 'Rajdhani', sans-serif;
  font-size: 14px;
  font-weight: 700;
  color: #ff4d4d;
  margin-bottom: 2px;
}

.danger-info p {
  font-size: 12px;
  color: var(--text-muted);
}

.btn-danger {
  padding: 8px 16px;
  background: none;
  border: 1px solid rgba(255,77,77,0.4);
  border-radius: 8px;
  color: #ff4d4d;
  font-size: 12px;
  font-weight: 600;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s;
  flex-shrink: 0;
}
.btn-danger:hover { background: rgba(255,77,77,0.1); }

/* Alert */
.alert {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 16px;
  border-radius: 10px;
  font-size: 13px;
  margin-bottom: 16px;
}
.alert.success {
  background: rgba(0,229,160,0.08);
  border: 1px solid rgba(0,229,160,0.25);
  color: var(--accent);
}
.alert.error {
  background: rgba(255,77,77,0.08);
  border: 1px solid rgba(255,77,77,0.25);
  color: #ff4d4d;
}

/* Responsive */
@media (max-width: 600px) {
  .profile-header { flex-direction: column; text-align: center; }
  .profile-stats { grid-template-columns: repeat(3, 1fr); gap: 8px; }
  .stat-value { font-size: 1.4rem; }
  .danger-zone { flex-direction: column; text-align: center; }
  .btn-danger { width: 100%; }
}

.btn-logout {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: none;
    border: 1px solid rgba(255,77,77,0.3);
    border-radius: 9px;
    color: #ff6b6b;
    font-size: 13px;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    white-space: nowrap;
    flex-shrink: 0;
    align-self: flex-start;
    transition: background 0.2s, border-color 0.2s;
}
.btn-logout:hover {
    background: rgba(255,77,77,0.1);
    border-color: rgba(255,77,77,0.5);
}

@media (max-width: 600px) {
    .btn-logout { align-self: center; width: 100%; justify-content: center; }
}
</style>

<div class="profile-page">

  {{-- Alert sukses --}}
  @if(session('success'))
  <div class="alert success">✓ {{ session('success') }}</div>
  @endif

  @if($errors->any())
  <div class="alert error">✕ {{ $errors->first() }}</div>
  @endif

  {{-- ── PROFILE HEADER ── --}}
<div class="profile-header">
    <div class="profile-avatar">
        👤
        <div class="profile-avatar-edit">✏</div>
    </div>
    <div class="profile-header-info">
        <div class="profile-name">{{ auth()->user()->name }}</div>
        <div class="profile-email">{{ auth()->user()->email }}</div>
        <div class="profile-badge">⚡ Member Aktif</div>
    </div>

    {{-- TOMBOL LOGOUT --}}
    <form method="POST" action="/logout">
        @csrf
        <button type="submit" class="btn-logout">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Logout
        </button>
    </form>
</div>

  {{-- ── STATS ── --}}
  <div class="profile-stats">
    <div class="stat-card">
      <div class="stat-value">{{ $orderCount ?? 0 }}</div>
      <div class="stat-label">Total Order</div>
    </div>
    <div class="stat-card">
      <div class="stat-value">{{ $buildCount ?? 0 }}</div>
      <div class="stat-label">Build Tersimpan</div>
    </div>
    <div class="stat-card">
      <div class="stat-value">{{ $cartCount ?? 0 }}</div>
      <div class="stat-label">Di Keranjang</div>
    </div>
  </div>

  {{-- ── INFORMASI PRIBADI ── --}}
  <div class="profile-panel">
    <div class="panel-header">
      <span class="panel-title">Informasi Pribadi</span>
    </div>
    <form method="POST" action="/profile/update">
      @csrf
      @method('PUT')
      <div class="panel-body">
        <div class="form-grid">

          {{-- Nama --}}
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-input"
              value="{{ old('name', auth()->user()->name) }}"
              placeholder="Masukkan nama lengkap">
          </div>

          {{-- Email --}}
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input"
              value="{{ old('email', auth()->user()->email) }}"
              placeholder="email@contoh.com">
          </div>

          {{-- Nomor Telepon --}}
          <div class="form-group">
            <label class="form-label">Nomor Telepon</label>
            <input type="tel" name="phone" class="form-input"
              value="{{ old('phone', auth()->user()->phone ?? '') }}"
              placeholder="08xx-xxxx-xxxx">
          </div>

          {{-- Kota --}}
          <div class="form-group">
            <label class="form-label">Kota</label>
            <input type="text" name="city" class="form-input"
              value="{{ old('city', auth()->user()->city ?? '') }}"
              placeholder="Bandung">
          </div>

          {{-- Alamat --}}
          <div class="form-group span2">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="address" class="form-input" rows="3"
              placeholder="Jl. Contoh No. 1, Kelurahan, Kecamatan...">{{ old('address', auth()->user()->address ?? '') }}</textarea>
            <span class="form-hint">Digunakan untuk pengiriman komponen</span>
          </div>

        </div>
      </div>
      <div class="panel-actions">
        <button type="button" class="btn-cancel">Batal</button>
        <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
      </div>
    </form>
  </div>

  {{-- ── KEAMANAN ── --}}
  <div class="profile-panel">
    <div class="panel-header">
      <span class="panel-title">Keamanan</span>
    </div>
    <form method="POST" action="/profile/password">
      @csrf
      @method('PUT')
      <div class="panel-body">
        <div class="form-grid">

          {{-- Password lama --}}
          <div class="form-group span2">
            <label class="form-label">Password Saat Ini</label>
            <div class="input-wrap">
              <input type="password" name="current_password" class="form-input"
                placeholder="Masukkan password saat ini" id="oldPass">
              <button type="button" class="input-toggle" onclick="togglePass('oldPass')">👁</button>
            </div>
          </div>

          {{-- Password baru --}}
          <div class="form-group">
            <label class="form-label">Password Baru</label>
            <div class="input-wrap">
              <input type="password" name="password" class="form-input"
                placeholder="Min. 8 karakter" id="newPass">
              <button type="button" class="input-toggle" onclick="togglePass('newPass')">👁</button>
            </div>
          </div>

          {{-- Konfirmasi --}}
          <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-wrap">
              <input type="password" name="password_confirmation" class="form-input"
                placeholder="Ulangi password baru" id="confPass">
              <button type="button" class="input-toggle" onclick="togglePass('confPass')">👁</button>
            </div>
          </div>

        </div>
      </div>
      <div class="panel-actions">
        <button type="submit" class="btn-save">🔒 Ubah Password</button>
      </div>
    </form>
  </div>

  {{-- ── DANGER ZONE ── --}}
  <div class="danger-zone">
    <div class="danger-info">
      <h4>Hapus Akun</h4>
      <p>Semua data kamu akan dihapus permanen dan tidak bisa dikembalikan.</p>
    </div>
    <button class="btn-danger" onclick="confirmDelete()">Hapus Akun</button>
  </div>

</div>

<script>
function togglePass(id) {
  const input = document.getElementById(id);
  input.type  = input.type === 'password' ? 'text' : 'password';
}

function confirmDelete() {
  if (confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.')) {
    fetch('/profile/delete', {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    }).then(r => r.json()).then(d => {
      if (d.success) window.location.href = '/';
    });
  }
}
</script>

@endsection