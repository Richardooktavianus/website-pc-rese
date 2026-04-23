<!DOCTYPE html>
<html>
<head>
    <title>PC Builder</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="min-h-screen flex items-center justify-center">

<div class="w-full max-w-6xl mx-auto grid md:grid-cols-2 gap-8 p-6">

    <!-- LEFT -->
    <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl">

        <h2 class="text-3xl font-bold mb-8 text-center">
            🔧 Rakit PC Anda
        </h2>

        <form id="builderForm" class="space-y-6">
            @csrf

            <!-- CPU -->
            <div>
                <label class="block mb-2 text-lg font-semibold">🧠 Processor</label>
                <select name="cpu" id="cpu" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
                    <option value="">Pilih CPU</option>
                    @foreach($cpu as $c)
                        <option value="{{ $c->id }}"
                            data-socket="{{ $c->socket }}"
                            data-price="{{ $c->price }}">
                            {{ $c->name }} - Rp {{ number_format($c->price) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- MOBO -->
            <div>
                <label class="block mb-2 text-lg font-semibold">🧩 Motherboard</label>
                <select name="motherboard" id="motherboard" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
                    <option value="">Pilih Motherboard</option>
                    @foreach($motherboard as $m)
                        <option value="{{ $m->id }}"
                            data-socket="{{ $m->socket }}"
                            data-ram="{{ $m->ram_type }}"
                            data-price="{{ $m->price }}">
                            {{ $m->name }} - Rp {{ number_format($m->price) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- GPU -->
            <div>
                <label class="block mb-2 text-lg font-semibold">🎮 GPU</label>
                <select name="gpu" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
                    <option value="">Pilih GPU</option>
                    @foreach($gpu as $g)
                        <option value="{{ $g->id }}" data-price="{{ $g->price }}">
                            {{ $g->name }} - Rp {{ number_format($g->price) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- RAM -->
            <div>
                <label class="block mb-2 text-lg font-semibold">💾 RAM</label>
                <select name="ram" id="ram" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
                    <option value="">Pilih RAM</option>
                    @foreach($ram as $r)
                        <option value="{{ $r->id }}"
                            data-ram="{{ $r->ram_type }}"
                            data-price="{{ $r->price }}">
                            {{ $r->name }} - Rp {{ number_format($r->price) }}
                        </option>
                    @endforeach
                </select>
            </div>

                    <!-- SSD -->
        <select name="ssd" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
            <option value="">Pilih SSD</option>
            @foreach($ssd as $s)
                <option value="{{ $s->id }}" data-price="{{ $s->price }}">
                    {{ $s->name }} - Rp {{ number_format($s->price) }}
                </option>
            @endforeach
        </select>

        <!-- HDD -->
        <select name="hdd" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
            <option value="">Pilih HDD</option>
            @foreach($hdd as $h)
                <option value="{{ $h->id }}" data-price="{{ $h->price }}">
                    {{ $h->name }} - Rp {{ number_format($h->price) }}
                </option>
            @endforeach
        </select>

        <!-- CASE -->
        <select name="case" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
            <option value="">Pilih Case</option>
            @foreach($case as $c)
                <option value="{{ $c->id }}" data-price="{{ $c->price }}">
                    {{ $c->name }} - Rp {{ number_format($c->price) }}
                </option>
            @endforeach
        </select>
        <!-- PSU -->
        <div>
            <label class="block mb-2 text-lg font-semibold">🔌 Power Supply (PSU)</label>
            <select name="psu"
                class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
                <option value="">Pilih PSU</option>
                @foreach($psu as $p)
                    <option value="{{ $p->id }}" data-price="{{ $p->price }}">
                        {{ $p->name }} - Rp {{ number_format($p->price) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- COOLER -->
        <select name="cooler" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
            <option value="">Pilih Cooler</option>
            @foreach($cooler as $c)
                <option value="{{ $c->id }}" data-price="{{ $c->price }}">
                    {{ $c->name }} - Rp {{ number_format($c->price) }}
                </option>
            @endforeach
        </select>

        <!-- FAN -->
        <select name="fan" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
            <option value="">Pilih Fan</option>
            @foreach($fan as $f)
                <option value="{{ $f->id }}" data-price="{{ $f->price }}">
                    {{ $f->name }} - Rp {{ number_format($f->price) }}
                </option>
            @endforeach
        </select>

            <!-- TOTAL -->
            <div class="bg-gray-700 p-6 rounded-xl text-center">
                <p class="text-gray-300 text-lg">💰 Total Harga</p>
                <h3 id="totalPrice" class="text-green-400 text-4xl font-bold mt-2">
                    Rp 0
                </h3>
                <p id="compatibility" class="mt-3 text-lg"></p>
            </div>

            <!-- BUTTON -->
            <button type="button" onclick="addToCart()" 
                class="w-full bg-blue-500 hover:bg-blue-600 p-4 rounded-xl text-lg font-bold">
                🛒 Simpan ke Keranjang
            </button>

        </form>

    </div>

   <!-- RIGHT -->
<div class="bg-gray-800 p-8 rounded-2xl shadow-2xl">

    <h3 class="text-2xl font-bold mb-6">🧾 Ringkasan Build</h3>

    <div class="space-y-4 text-lg">

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>CPU</span>
            <span id="cpuName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>Motherboard</span>
            <span id="motherboardName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>GPU</span>
            <span id="gpuName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>RAM</span>
            <span id="ramName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>SSD</span>
            <span id="ssdName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>HDD</span>
            <span id="hddName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>CASE</span>
            <span id="caseName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>PSU</span>
            <span id="psuName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>COOLER</span>
            <span id="coolerName">-</span>
        </div>

        <div class="flex justify-between border-b border-gray-700 pb-2">
            <span>FAN</span>
            <span id="fanName">-</span>
        </div>

    </div>

    <div class="mt-8 p-6 bg-gray-700 rounded-xl text-center">
        <p class="text-gray-400 text-lg">Total Build</p>
        <h3 id="totalSummary" class="text-green-400 text-3xl font-bold">
            Rp 0
        </h3>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const inputs = document.querySelectorAll('.builder-input');

    const cpuSelect = document.getElementById('cpu');
    const motherboardSelect = document.getElementById('motherboard');
    const ramSelect = document.getElementById('ram');

    const totalText = document.getElementById('totalPrice');
    const totalSummary = document.getElementById('totalSummary');

    const cpuName = document.getElementById('cpuName');
    const motherboardName = document.getElementById('motherboardName');
    const gpuName = document.getElementById('gpuName');
    const ramName = document.getElementById('ramName');

    const ssdName = document.getElementById('ssdName');
    const hddName = document.getElementById('hddName');
    const caseName = document.getElementById('caseName');
    const psuName = document.getElementById('psuName');
    const coolerName = document.getElementById('coolerName');
    const fanName = document.getElementById('fanName');

    const compatibilityText = document.getElementById('compatibility');

    // 🔥 SIMPAN DATA AWAL
    const allMotherboards = Array.from(motherboardSelect.options);
    const allRams = Array.from(ramSelect.options);

    // ======================
    // 🔥 AUTO FILTER CPU → MOBO
    // ======================
    cpuSelect.addEventListener('change', function () {

        const selected = cpuSelect.options[cpuSelect.selectedIndex];
        const cpuSocket = selected.getAttribute('data-socket');

        motherboardSelect.innerHTML = '<option value="">Pilih Motherboard</option>';

        allMotherboards.forEach(option => {
            if (!option.value) return;

            if (!cpuSocket || option.getAttribute('data-socket') === cpuSocket) {
                motherboardSelect.appendChild(option.cloneNode(true));
            }
        });

        ramSelect.innerHTML = '<option value="">Pilih RAM</option>';
    });

    // ======================
    // 🔥 AUTO FILTER MOBO → RAM
    // ======================
    motherboardSelect.addEventListener('change', function () {

        const selected = motherboardSelect.options[motherboardSelect.selectedIndex];
        const ramType = selected.getAttribute('data-ram');

        ramSelect.innerHTML = '<option value="">Pilih RAM</option>';

        allRams.forEach(option => {
            if (!option.value) return;

            if (!ramType || option.getAttribute('data-ram') === ramType) {
                ramSelect.appendChild(option.cloneNode(true));
            }
        });
    });

    // ======================
    // 🔥 HITUNG TOTAL + RINGKASAN
    // ======================
    function calculateTotal() {
        let total = 0;

        inputs.forEach(input => {
            const selected = input.options[input.selectedIndex];
            const price = selected.getAttribute('data-price');
            const text = selected.text;

            if (input.name === 'cpu') cpuName.innerText = input.value ? text : '-';
            if (input.name === 'motherboard') motherboardName.innerText = input.value ? text : '-';
            if (input.name === 'gpu') gpuName.innerText = input.value ? text : '-';
            if (input.name === 'ram') ramName.innerText = input.value ? text : '-';
            if (input.name === 'ssd') ssdName.innerText = input.value ? text : '-';
            if (input.name === 'hdd') hddName.innerText = input.value ? text : '-';
            if (input.name === 'case') caseName.innerText = input.value ? text : '-';
            if (input.name === 'psu') psuName.innerText = input.value ? text : '-';
            if (input.name === 'cooler') coolerName.innerText = input.value ? text : '-';
            if (input.name === 'fan') fanName.innerText = input.value ? text : '-';

            if (price) total += parseInt(price);
        });

        let formatted = "Rp " + total.toLocaleString();
        totalText.innerText = formatted;
        totalSummary.innerText = formatted;
    }

    inputs.forEach(input => {
        input.addEventListener('change', calculateTotal);
    });

    // ======================
    // 🔥 ADD TO CART
    // ======================
    window.addToCart = function () {

        const form = document.getElementById('builderForm');
        const formData = new FormData(form);

        fetch('/builder/add-to-cart', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            alert('Build berhasil ditambahkan!');
        })
        .catch(() => {
            alert('Terjadi kesalahan!');
        });
    }

});
</script>

</body>
</html>