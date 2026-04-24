<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>

    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --accent: #00E5A0;
            --bg-main: #0d0f14;
            --bg-card: #161a24;
            --bg-surface: #1c2130;
            --text-primary: #f0f2f8;
            --text-muted: #7a859e;
            --border: rgba(255, 255, 255, 0.07);
        }

        body {
            background: var(--bg-main);
            color: var(--text-primary);
            font-family: 'DM Sans', sans-serif;
        }

        h1, h2, h3 {
            font-family: 'Rajdhani', sans-serif;
        }

        .product-card:hover {
            transform: translateY(-4px);
        }
    </style>
</head>

<body>

<div class="max-w-6xl mx-auto p-6">

    <!-- BACK -->
    <a href="/" class="text-gray-400 hover:text-white text-sm mb-6 inline-block">
        ← Kembali
    </a>

    <!-- DETAIL -->
    <div class="grid md:grid-cols-2 gap-10">

        <!-- IMAGE -->
        <div class="bg-[#161a24] border border-[rgba(255,255,255,0.07)] rounded-xl overflow-hidden">
            <div class="h-96 flex items-center justify-center bg-[#1c2130]">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-gray-500">No Image</span>
                @endif
            </div>
        </div>

        <!-- INFO -->
        <div class="flex flex-col justify-between">

            <div>
                <h1 class="text-3xl font-bold mb-2">
                    {{ $product->name }}
                </h1>

                <p class="text-green-400 text-2xl font-semibold mb-4">
                    Rp {{ number_format($product->price) }}
                </p>

                <p class="text-gray-400 leading-relaxed mb-6">
                    {{ $product->description ?? 'Tidak ada deskripsi tersedia.' }}
                </p>
            </div>

            <!-- BUTTON -->
            <form method="POST" action="/cart/add">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <button class="w-full bg-green-500 hover:bg-green-600 transition py-3 rounded-lg font-semibold">
                    + Tambah ke Keranjang
                </button>
            </form>

        </div>

    </div>

    <!-- REKOMENDASI -->
    <div class="mt-16">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-sm tracking-widest text-gray-500 uppercase">
                Produk Rekomendasi
            </h2>
        </div>

        <div id="productContainer" class="grid grid-cols-2 md:grid-cols-4 gap-5">

            @foreach ($recommended as $index => $item)
                <a href="/product/{{ $item->id }}"
                   class="product-item product-card bg-[#161a24] border border-[rgba(255,255,255,0.07)] rounded-xl overflow-hidden transition duration-300 {{ $index >= 12 ? 'hidden' : '' }}">

                    <!-- IMAGE -->
                    <div class="aspect-square bg-[#1c2130] flex items-center justify-center">
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-500 text-sm">No Image</span>
                        @endif
                    </div>

                    <!-- INFO -->
                    <div class="p-3">
                        <div class="text-sm font-medium mb-1 line-clamp-2">
                            {{ $item->name }}
                        </div>

                        <div class="text-green-400 font-semibold text-sm mb-2">
                            Rp {{ number_format($item->price) }}
                        </div>

                        <div class="text-center text-xs bg-green-500/10 border border-green-500/20 py-1 rounded text-green-400">
                            👁 Lihat Produk
                        </div>
                    </div>

                </a>
            @endforeach

        </div>

        <!-- LOAD MORE -->
        @if ($recommended->count() > 12)
            <div class="mt-8 text-center">
                <button onclick="loadMore()" id="loadMoreBtn"
                        class="px-6 py-2 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-800 transition">
                    Tampilkan Lebih Banyak ↓
                </button>
            </div>
        @endif

    </div>

</div>

<!-- SCRIPT -->
<script>
let visible = 12;

function loadMore() {
    let items = document.querySelectorAll('.product-item');

    let count = 0;

    for (let i = visible; i < items.length && count < 8; i++) {
        items[i].classList.remove('hidden');
        count++;
    }

    visible += count;

    if (visible >= items.length) {
        document.getElementById('loadMoreBtn').style.display = 'none';
    }
}
</script>

</body>
</html>