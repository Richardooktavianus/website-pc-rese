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
                <select name="cpu" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
                    <option value="">Pilih CPU</option>
                    @foreach($cpu as $c)
                        <option value="{{ $c->id }}" data-price="{{ $c->price }}">
                            {{ $c->name }} - Rp {{ number_format($c->price) }}
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
                <select name="ram" class="builder-input w-full p-4 rounded-xl bg-gray-700 text-white">
                    <option value="">Pilih RAM</option>
                    @foreach($ram as $r)
                        <option value="{{ $r->id }}" data-price="{{ $r->price }}">
                            {{ $r->name }} - Rp {{ number_format($r->price) }}
                        </option>
                    @endforeach
                </select>
            </div>

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
                <span>GPU</span>
                <span id="gpuName">-</span>
            </div>

            <div class="flex justify-between border-b border-gray-700 pb-2">
                <span>RAM</span>
                <span id="ramName">-</span>
            </div>

        </div>

        <div class="mt-8 p-6 bg-gray-700 rounded-xl text-center">
            <p class="text-gray-400 text-lg">Total Build</p>
            <h3 id="totalSummary" class="text-green-400 text-3xl font-bold">
                Rp 0
            </h3>
        </div>

    </div>

</div>

</div>

<!-- SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const inputs = document.querySelectorAll('.builder-input');

    const totalText = document.getElementById('totalPrice');
    const totalSummary = document.getElementById('totalSummary');

    const cpuName = document.getElementById('cpuName');
    const gpuName = document.getElementById('gpuName');
    const ramName = document.getElementById('ramName');

    const compatibilityText = document.getElementById('compatibility');

    function calculateTotal() {
        let total = 0;
        let selectedCount = 0;

        inputs.forEach(input => {
            const selected = input.options[input.selectedIndex];
            const price = selected.getAttribute('data-price');
            const text = selected.text;

            if (input.name === 'cpu') cpuName.innerText = input.value ? text : '-';
            if (input.name === 'gpu') gpuName.innerText = input.value ? text : '-';
            if (input.name === 'ram') ramName.innerText = input.value ? text : '-';

            if (price) {
                total += parseInt(price);
                selectedCount++;
            }
        });

        let formatted = "Rp " + total.toLocaleString();

        totalText.innerText = formatted;
        totalSummary.innerText = formatted;

        if (selectedCount === 3) {
            compatibilityText.innerText = "✔ Komponen Compatible";
            compatibilityText.className = "text-green-400 mt-3";
        } else if (selectedCount > 0) {
            compatibilityText.innerText = "⚠ Lengkapi semua komponen";
            compatibilityText.className = "text-yellow-400 mt-3";
        } else {
            compatibilityText.innerText = "";
        }
    }

    inputs.forEach(input => {
        input.addEventListener('change', calculateTotal);
    });

    window.addToCart = function () {

        let isValid = true;

        inputs.forEach(input => {
            if (!input.value) isValid = false;
        });

        if (!isValid) {
            alert('Pilih semua komponen terlebih dahulu!');
            return;
        }

        const form = document.getElementById('builderForm');
        const formData = new FormData(form);

        fetch('/builder/add-to-cart', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(() => {
            alert('Build PC berhasil ditambahkan!');
        })
        .catch(() => {
            alert('Terjadi kesalahan!');
        });
    }

});
</script>

</body>
</html>