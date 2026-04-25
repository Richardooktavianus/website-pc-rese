@extends('layouts.app')

@section('title', 'PC Builder')

@section('content')

<style>
:root {
  --accent:    #00E5A0;
  --accent-dim:#00b87c;
  --bg-main:   #0d0f14;
  --bg-card:   #161a24;
  --bg-surface:#1c2130;
  --text-primary: #f0f2f8;
  --text-muted:   #7a859e;
  --border: rgba(255,255,255,0.07);
  --danger: #ff4d4d;
  --warn:   #ffb400;
}

/* ── Layout ── */
.builder-page {
  max-width: 1280px;
  margin: 0 auto;
  padding: 24px 16px 60px;
}

.builder-header {
  margin-bottom: 24px;
}
.builder-header h1 {
  font-family: 'Rajdhani', sans-serif;
  font-size: clamp(1.6rem, 4vw, 2.2rem);
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1;
}
.builder-header p {
  font-size: 13px;
  color: var(--text-muted);
  margin-top: 4px;
}

.builder-grid {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 20px;
  align-items: start;
}
@media (max-width: 960px) {
  .builder-grid { grid-template-columns: 1fr; }
}

/* ── Form Panel ── */
.builder-form-panel {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 20px;
  overflow: hidden;
}

.form-section-title {
  font-family: 'Rajdhani', sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 2.5px;
  text-transform: uppercase;
  color: var(--text-muted);
  padding: 20px 20px 10px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 8px;
}
.form-section-title::after {
  content: '';
  flex: 1;
  height: 1px;
  background: var(--border);
}

/* Component rows */
.component-list { padding: 8px 12px 16px; }

.comp-row {
  display: grid;
  grid-template-columns: 36px 1fr;
  gap: 0 12px;
  align-items: center;
  padding: 10px 8px;
  border-radius: 12px;
  transition: background 0.15s;
}
.comp-row:hover { background: rgba(255,255,255,0.02); }

.comp-icon {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: var(--bg-surface);
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  flex-shrink: 0;
}

.comp-body { min-width: 0; }

.comp-label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--text-muted);
  margin-bottom: 4px;
  font-family: 'Rajdhani', sans-serif;
}

.comp-select {
  width: 100%;
  background: var(--bg-surface);
  border: 1px solid var(--border);
  border-radius: 8px;
  color: var(--text-primary);
  font-size: 13px;
  font-family: 'DM Sans', sans-serif;
  padding: 8px 10px;
  outline: none;
  cursor: pointer;
  transition: border-color 0.2s;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%237a859e' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 10px center;
  padding-right: 28px;
}
.comp-select:focus { border-color: rgba(0,229,160,0.4); }
.comp-select option { background: #1c2130; }

.comp-divider {
  height: 1px;
  background: var(--border);
  margin: 4px 8px;
}

/* ── Summary Panel (sticky) ── */
.summary-panel {
  position: sticky;
  top: 76px;
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 20px;
  overflow: hidden;
}

.summary-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.summary-header-title {
  font-family: 'Rajdhani', sans-serif;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--text-muted);
}

.summary-list { padding: 8px 0; }

.summary-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 9px 20px;
  gap: 12px;
  transition: background 0.15s;
}
.summary-row:hover { background: rgba(255,255,255,0.02); }

.summary-row-left {
  display: flex;
  align-items: center;
  gap: 10px;
  min-width: 0;
}
.summary-row-icon {
  font-size: 14px;
  flex-shrink: 0;
  opacity: 0.6;
}
.summary-row-info { min-width: 0; }
.summary-row-label {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  color: var(--text-muted);
  font-family: 'Rajdhani', sans-serif;
}
.summary-row-name {
  font-size: 12px;
  color: var(--text-primary);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 140px;
}
.summary-row-name.empty { color: var(--text-muted); font-style: italic; }

.summary-row-price {
  font-size: 12px;
  font-weight: 600;
  color: var(--accent);
  white-space: nowrap;
  flex-shrink: 0;
}
.summary-row-price.empty { color: var(--text-muted); font-weight: 400; }

/* Total box */
.summary-total {
  margin: 8px 16px 0;
  background: rgba(0,229,160,0.06);
  border: 1px solid rgba(0,229,160,0.15);
  border-radius: 14px;
  padding: 16px;
  text-align: center;
}
.summary-total-label {
  font-size: 11px;
  color: var(--text-muted);
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  font-family: 'Rajdhani', sans-serif;
  margin-bottom: 4px;
}
.summary-total-price {
  font-family: 'Rajdhani', sans-serif;
  font-size: 2rem;
  font-weight: 700;
  color: var(--accent);
  line-height: 1;
}

/* Compat message */
.compat-msg {
  margin: 10px 16px 0;
  padding: 10px 14px;
  border-radius: 10px;
  font-size: 12px;
  display: none;
}
.compat-msg.show { display: flex; align-items: center; gap: 8px; }
.compat-msg.ok   { background: rgba(0,229,160,0.08); border: 1px solid rgba(0,229,160,0.2); color: var(--accent); }
.compat-msg.warn { background: rgba(255,180,0,0.08); border: 1px solid rgba(255,180,0,0.2); color: var(--warn); }
.compat-msg.err  { background: rgba(255,77,77,0.08);  border: 1px solid rgba(255,77,77,0.2);  color: var(--danger); }

/* Add to cart btn */
.btn-addcart {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: calc(100% - 32px);
  margin: 12px 16px 16px;
  padding: 13px;
  background: var(--accent);
  border: none;
  border-radius: 12px;
  color: #0d1a14;
  font-size: 14px;
  font-weight: 700;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  transition: background 0.2s, transform 0.15s;
}
.btn-addcart:hover { background: var(--accent-dim); transform: translateY(-1px); }
.btn-addcart:active { transform: translateY(0); }

/* Reset btn */
.btn-reset {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  width: calc(100% - 32px);
  margin: 0 16px 16px;
  padding: 9px;
  background: none;
  border: 1px solid var(--border);
  border-radius: 10px;
  color: var(--text-muted);
  font-size: 13px;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  transition: color 0.2s, border-color 0.2s;
}
.btn-reset:hover { color: var(--text-primary); border-color: rgba(255,255,255,0.2); }

/* Toast */
.builder-toast {
  position: fixed;
  bottom: 24px;
  right: 24px;
  z-index: 999;
  padding: 12px 18px;
  border-radius: 12px;
  font-size: 13px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 8px;
  transform: translateY(20px);
  opacity: 0;
  transition: all 0.3s ease;
  pointer-events: none;
  font-family: 'DM Sans', sans-serif;
  max-width: 320px;
}
.builder-toast.show { opacity: 1; transform: translateY(0); }
.builder-toast.success { background: #0d2b1e; border: 1px solid rgba(0,229,160,0.4); color: var(--accent); }
.builder-toast.error   { background: #2b0d0d; border: 1px solid rgba(255,77,77,0.4);  color: var(--danger); }

@media (max-width: 960px) {
  .summary-panel { position: static; }
  .summary-row-name { max-width: 180px; }
}
@media (max-width: 480px) {
  .builder-page { padding: 16px 12px 48px; }
  .comp-row { grid-template-columns: 32px 1fr; gap: 0 8px; }
  .comp-icon { width: 32px; height: 32px; font-size: 14px; }
}
</style>

<div class="builder-page">

  <!-- Header -->
  <div class="builder-header">
    <h1>🔧 PC Builder</h1>
    <p>Pilih komponen dan bangun PC impianmu — harga dihitung otomatis</p>
  </div>

  <form id="builderForm">
    @csrf
    <div class="builder-grid">

      <!-- ══ FORM PANEL ══ -->
      <div class="builder-form-panel">

        <div class="form-section-title">Komponen Utama</div>
        <div class="component-list">

          {{-- CPU --}}
          <div class="comp-row">
            <div class="comp-icon">🧠</div>
            <div class="comp-body">
              <div class="comp-label">Processor (CPU)</div>
              <select name="cpu" id="cpu" class="comp-select builder-input" data-summary="cpuRow">
                <option value="" data-price="0">— Pilih CPU —</option>
                @foreach($cpu as $c)
                  <option value="{{ $c->id }}"
                    data-price="{{ $c->price }}"
                    data-socket="{{ $c->socket ?? '' }}">
                    {{ $c->name }} · Rp {{ number_format($c->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="comp-divider"></div>

          {{-- Motherboard --}}
          <div class="comp-row">
            <div class="comp-icon">🔧</div>
            <div class="comp-body">
              <div class="comp-label">Motherboard</div>
              <select name="motherboard" id="motherboard" class="comp-select builder-input" data-summary="moboRow">
                <option value="" data-price="0">— Pilih Motherboard —</option>
                @foreach($motherboard as $m)
                  <option value="{{ $m->id }}"
                    data-price="{{ $m->price }}"
                    data-socket="{{ $m->socket ?? '' }}"
                    data-ram="{{ $m->ram_type ?? '' }}">
                    {{ $m->name }} · Rp {{ number_format($m->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="comp-divider"></div>

          {{-- GPU --}}
          <div class="comp-row">
            <div class="comp-icon">🎮</div>
            <div class="comp-body">
              <div class="comp-label">GPU / VGA</div>
              <select name="gpu" class="comp-select builder-input" data-summary="gpuRow">
                <option value="" data-price="0">— Pilih GPU —</option>
                @foreach($gpu as $g)
                  <option value="{{ $g->id }}"
                    data-price="{{ $g->price }}"
                    data-watt="{{ $g->watt ?? '' }}">
                    {{ $g->name }} · Rp {{ number_format($g->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="comp-divider"></div>

          {{-- RAM --}}
          <div class="comp-row">
            <div class="comp-icon">💾</div>
            <div class="comp-body">
              <div class="comp-label">RAM</div>
              <select name="ram" id="ram" class="comp-select builder-input" data-summary="ramRow">
                <option value="" data-price="0">— Pilih RAM —</option>
                @foreach($ram as $r)
                  <option value="{{ $r->id }}"
                    data-price="{{ $r->price }}"
                    data-ram="{{ $r->ram_type ?? '' }}">
                    {{ $r->name }} · Rp {{ number_format($r->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

        </div>

        <div class="form-section-title">Storage</div>
        <div class="component-list">

          {{-- SSD --}}
          <div class="comp-row">
            <div class="comp-icon">💿</div>
            <div class="comp-body">
              <div class="comp-label">SSD</div>
              <select name="ssd" class="comp-select builder-input" data-summary="ssdRow">
                <option value="" data-price="0">— Pilih SSD (opsional) —</option>
                @foreach($ssd as $s)
                  <option value="{{ $s->id }}" data-price="{{ $s->price }}">
                    {{ $s->name }} · Rp {{ number_format($s->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="comp-divider"></div>

          {{-- HDD --}}
          <div class="comp-row">
            <div class="comp-icon">🖴</div>
            <div class="comp-body">
              <div class="comp-label">HDD</div>
              <select name="hdd" class="comp-select builder-input" data-summary="hddRow">
                <option value="" data-price="0">— Pilih HDD (opsional) —</option>
                @foreach($hdd as $h)
                  <option value="{{ $h->id }}" data-price="{{ $h->price }}">
                    {{ $h->name }} · Rp {{ number_format($h->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

        </div>

        <div class="form-section-title">Casing & Pendingin</div>
        <div class="component-list">

          {{-- Case --}}
          <div class="comp-row">
            <div class="comp-icon">🗄️</div>
            <div class="comp-body">
              <div class="comp-label">Casing</div>
              <select name="case" class="comp-select builder-input" data-summary="caseRow">
                <option value="" data-price="0">— Pilih Casing —</option>
                @foreach($case as $c)
                  <option value="{{ $c->id }}" data-price="{{ $c->price }}">
                    {{ $c->name }} · Rp {{ number_format($c->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="comp-divider"></div>

          {{-- Cooler --}}
          <div class="comp-row">
            <div class="comp-icon">❄️</div>
            <div class="comp-body">
              <div class="comp-label">CPU Cooler</div>
              <select name="cooler" class="comp-select builder-input" data-summary="coolerRow">
                <option value="" data-price="0">— Pilih Cooler (opsional) —</option>
                @foreach($cooler as $c)
                  <option value="{{ $c->id }}" data-price="{{ $c->price }}">
                    {{ $c->name }} · Rp {{ number_format($c->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="comp-divider"></div>

          {{-- Fan --}}
          <div class="comp-row">
            <div class="comp-icon">🌀</div>
            <div class="comp-body">
              <div class="comp-label">Case Fan</div>
              <select name="fan" class="comp-select builder-input" data-summary="fanRow">
                <option value="" data-price="0">— Pilih Fan (opsional) —</option>
                @foreach($fan as $f)
                  <option value="{{ $f->id }}" data-price="{{ $f->price }}">
                    {{ $f->name }} · Rp {{ number_format($f->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

        </div>

        <div class="form-section-title">Power Supply</div>
        <div class="component-list">

          {{-- PSU --}}
          <div class="comp-row">
            <div class="comp-icon">⚡</div>
            <div class="comp-body">
              <div class="comp-label">PSU</div>
              <select name="psu" class="comp-select builder-input" data-summary="psuRow">
                <option value="" data-price="0">— Pilih PSU —</option>
                @foreach($psu as $p)
                  <option value="{{ $p->id }}"
                    data-price="{{ $p->price }}"
                    data-watt="{{ $p->watt ?? '' }}">
                    {{ $p->name }} · Rp {{ number_format($p->price) }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

        </div>

      </div><!-- end form panel -->

      <!-- ══ SUMMARY PANEL ══ -->
      <div class="summary-panel">

        <div class="summary-header">
          <span class="summary-header-title">Ringkasan Build</span>
          <span style="font-size:11px;color:var(--text-muted);" id="compCount">0 komponen</span>
        </div>

        <div class="summary-list">
          <div class="summary-row" id="cpuRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">🧠</span>
              <div class="summary-row-info">
                <div class="summary-row-label">CPU</div>
                <div class="summary-row-name empty" id="cpuName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="cpuPrice">—</div>
          </div>

          <div class="summary-row" id="moboRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">🔧</span>
              <div class="summary-row-info">
                <div class="summary-row-label">Motherboard</div>
                <div class="summary-row-name empty" id="moboName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="moboPrice">—</div>
          </div>

          <div class="summary-row" id="gpuRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">🎮</span>
              <div class="summary-row-info">
                <div class="summary-row-label">GPU</div>
                <div class="summary-row-name empty" id="gpuName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="gpuPrice">—</div>
          </div>

          <div class="summary-row" id="ramRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">💾</span>
              <div class="summary-row-info">
                <div class="summary-row-label">RAM</div>
                <div class="summary-row-name empty" id="ramName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="ramPrice">—</div>
          </div>

          <div class="summary-row" id="ssdRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">💿</span>
              <div class="summary-row-info">
                <div class="summary-row-label">SSD</div>
                <div class="summary-row-name empty" id="ssdName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="ssdPrice">—</div>
          </div>

          <div class="summary-row" id="hddRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">🖴</span>
              <div class="summary-row-info">
                <div class="summary-row-label">HDD</div>
                <div class="summary-row-name empty" id="hddName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="hddPrice">—</div>
          </div>

          <div class="summary-row" id="caseRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">🗄️</span>
              <div class="summary-row-info">
                <div class="summary-row-label">Casing</div>
                <div class="summary-row-name empty" id="caseName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="casePrice">—</div>
          </div>

          <div class="summary-row" id="coolerRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">❄️</span>
              <div class="summary-row-info">
                <div class="summary-row-label">Cooler</div>
                <div class="summary-row-name empty" id="coolerName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="coolerPrice">—</div>
          </div>

          <div class="summary-row" id="fanRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">🌀</span>
              <div class="summary-row-info">
                <div class="summary-row-label">Fan</div>
                <div class="summary-row-name empty" id="fanName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="fanPrice">—</div>
          </div>

          <div class="summary-row" id="psuRow">
            <div class="summary-row-left">
              <span class="summary-row-icon">⚡</span>
              <div class="summary-row-info">
                <div class="summary-row-label">PSU</div>
                <div class="summary-row-name empty" id="psuName">Belum dipilih</div>
              </div>
            </div>
            <div class="summary-row-price empty" id="psuPrice">—</div>
          </div>
        </div>

        <!-- Total -->
        <div class="summary-total">
          <div class="summary-total-label">Total Estimasi</div>
          <div class="summary-total-price" id="totalPrice">Rp 0</div>
        </div>

        <!-- Compat msg -->
        <div class="compat-msg" id="compatMsg"></div>

        <!-- Buttons -->
        <button type="button" class="btn-addcart" onclick="submitBuild()">
          🛒 Tambahkan ke Keranjang
        </button>
        <button type="button" class="btn-reset" onclick="resetForm()">
          ↺ Reset Build
        </button>

      </div><!-- end summary panel -->

    </div><!-- end builder-grid -->
  </form>

</div><!-- end builder-page -->

<!-- Toast -->
<div class="builder-toast" id="builderToast"></div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  /* ── Map: select name → summary IDs ── */
  const summaryMap = {
    cpu:         { name: 'cpuName',    price: 'cpuPrice'    },
    motherboard: { name: 'moboName',   price: 'moboPrice'   },
    gpu:         { name: 'gpuName',    price: 'gpuPrice'    },
    ram:         { name: 'ramName',    price: 'ramPrice'    },
    ssd:         { name: 'ssdName',    price: 'ssdPrice'    },
    hdd:         { name: 'hddName',    price: 'hddPrice'    },
    case:        { name: 'caseName',   price: 'casePrice'   },
    cooler:      { name: 'coolerName', price: 'coolerPrice' },
    fan:         { name: 'fanName',    price: 'fanPrice'    },
    psu:         { name: 'psuName',    price: 'psuPrice'    },
  };

  const inputs = document.querySelectorAll('.builder-input');

  /* ── Format rupiah ── */
  function formatRp(num) {
    return 'Rp ' + Number(num).toLocaleString('id-ID');
  }

  /* ── Update summary row ── */
  function updateSummaryRow(name, text, price) {
    const ids = summaryMap[name];
    if (!ids) return;

    const nameEl  = document.getElementById(ids.name);
    const priceEl = document.getElementById(ids.price);
    if (!nameEl || !priceEl) return;

    if (text && price > 0) {
      // Truncate long names
      nameEl.textContent  = text.length > 28 ? text.slice(0, 26) + '…' : text;
      nameEl.classList.remove('empty');
      priceEl.textContent = formatRp(price);
      priceEl.classList.remove('empty');
    } else {
      nameEl.textContent  = 'Belum dipilih';
      nameEl.classList.add('empty');
      priceEl.textContent = '—';
      priceEl.classList.add('empty');
    }
  }

  /* ── Recalculate total ── */
  function recalculate() {
    let total = 0;
    let count = 0;

    inputs.forEach(sel => {
      const opt   = sel.options[sel.selectedIndex];
      const price = opt ? parseInt(opt.getAttribute('data-price') || 0) : 0;
      const name  = sel.name;

      // Strip price part from option text for display
      let displayText = '';
      if (opt && opt.value) {
        displayText = opt.text.replace(/\s·\sRp[\d.,]+$/, '').trim();
        count++;
      }

      updateSummaryRow(name, displayText, price);
      total += price;
    });

    document.getElementById('totalPrice').textContent = formatRp(total);
    document.getElementById('compCount').textContent  = count + ' komponen';

    checkCompatibility();
  }

  /* ── Compatibility check (if socket/ram_type data exists) ── */
  function checkCompatibility() {
    const msg = document.getElementById('compatMsg');

    const cpuSel  = document.getElementById('cpu');
    const moboSel = document.getElementById('motherboard');
    const ramSel  = document.getElementById('ram');

    const cpuOpt  = cpuSel  ? cpuSel.options[cpuSel.selectedIndex]   : null;
    const moboOpt = moboSel ? moboSel.options[moboSel.selectedIndex]  : null;
    const ramOpt  = ramSel  ? ramSel.options[ramSel.selectedIndex]    : null;

    const cpuSocket  = cpuOpt  ? cpuOpt.getAttribute('data-socket')  : '';
    const moboSocket = moboOpt ? moboOpt.getAttribute('data-socket')  : '';
    const moboRam    = moboOpt ? moboOpt.getAttribute('data-ram')     : '';
    const ramType    = ramOpt  ? ramOpt.getAttribute('data-ram')      : '';

    // Only check if data exists
    const hasCpu  = cpuSel  && cpuSel.value;
    const hasMobo = moboSel && moboSel.value;
    const hasRam  = ramSel  && ramSel.value;

    if (hasCpu && hasMobo && cpuSocket && moboSocket && cpuSocket !== moboSocket) {
      showCompat('err', '⚠️ Socket CPU & Motherboard tidak cocok (' + cpuSocket + ' vs ' + moboSocket + ')');
      return;
    }

    if (hasMobo && hasRam && moboRam && ramType && moboRam !== ramType) {
      showCompat('warn', '⚠️ Tipe RAM tidak cocok dengan Motherboard (' + ramType + ' vs ' + moboRam + ')');
      return;
    }

    if (hasCpu && hasMobo && hasRam) {
      showCompat('ok', '✓ Komponen utama kompatibel');
    } else {
      msg.className = 'compat-msg';
    }
  }

  function showCompat(type, text) {
    const msg = document.getElementById('compatMsg');
    msg.className = 'compat-msg show ' + type;
    msg.textContent = text;
  }

  /* ── CPU change → filter Motherboard (if socket data exists) ── */
  const cpuSel  = document.getElementById('cpu');
  const moboSel = document.getElementById('motherboard');
  const ramSel  = document.getElementById('ram');

  const allMobos = moboSel ? Array.from(moboSel.options) : [];
  const allRams  = ramSel  ? Array.from(ramSel.options)  : [];

  if (cpuSel && moboSel) {
    cpuSel.addEventListener('change', function () {
      const socket = this.options[this.selectedIndex]?.getAttribute('data-socket');

      // Only filter if socket data exists
      if (socket) {
        moboSel.innerHTML = '';
        allMobos.forEach(opt => {
          const optSocket = opt.getAttribute('data-socket');
          if (!opt.value || !optSocket || optSocket === socket) {
            moboSel.appendChild(opt.cloneNode(true));
          }
        });
        // Reset RAM when CPU changes
        if (ramSel) {
          ramSel.innerHTML = '';
          allRams.forEach(opt => ramSel.appendChild(opt.cloneNode(true)));
        }
      }
      recalculate();
    });
  }

  if (moboSel && ramSel) {
    moboSel.addEventListener('change', function () {
      const ramType = this.options[this.selectedIndex]?.getAttribute('data-ram');

      if (ramType) {
        ramSel.innerHTML = '';
        allRams.forEach(opt => {
          const optRam = opt.getAttribute('data-ram');
          if (!opt.value || !optRam || optRam === ramType) {
            ramSel.appendChild(opt.cloneNode(true));
          }
        });
      }
      recalculate();
    });
  }

  /* ── Attach change listener to all selects ── */
  inputs.forEach(sel => {
    sel.addEventListener('change', recalculate);
  });

  /* ── Toast ── */
  function showToast(type, msg) {
    const el = document.getElementById('builderToast');
    el.textContent = msg;
    el.className   = 'builder-toast ' + type + ' show';
    setTimeout(() => el.className = 'builder-toast', 3000);
  }

  /* ── Submit build ── */
  window.submitBuild = function () {
    const form = document.getElementById('builderForm');
    const data = new FormData(form);

    fetch('/builder/add-to-cart', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': data.get('_token') },
      body: data
    })
    .then(res => res.json())
    .then(json => {
      if (json.error) {
        showToast('error', '✕ ' + json.error);
      } else {
        showToast('success', '✓ Build berhasil ditambahkan ke keranjang!');
        // Update cart badge if exists
        const badge = document.querySelector('.cart-badge');
        if (badge && json.cart_count) badge.textContent = json.cart_count;
      }
    })
    .catch(() => showToast('error', '✕ Terjadi kesalahan, coba lagi.'));
  };

  /* ── Reset ── */
  window.resetForm = function () {
    inputs.forEach(sel => sel.selectedIndex = 0);
    recalculate();
    const msg = document.getElementById('compatMsg');
    msg.className = 'compat-msg';
  };

  /* ── Init ── */
  recalculate();
});
</script>
@endsection