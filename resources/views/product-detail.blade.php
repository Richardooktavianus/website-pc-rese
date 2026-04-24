<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<div class="container mx-auto p-6">

    <a href="/" class="text-blue-400 mb-4 inline-block">← Kembali</a>

    <div class="grid md:grid-cols-2 gap-6">

        <!-- IMAGE -->
        <div class="bg-gray-700 h-80 rounded flex items-center justify-center">
            <span>Image</span>
        </div>

        <!-- DETAIL -->
        <div>
            <h1 class="text-2xl font-bold mb-2">
                {{ $product->name }}
            </h1>

            <p class="text-green-400 text-xl mb-4">
                Rp {{ number_format($product->price) }}
            </p>

            <p class="text-gray-300 mb-4">
                {{ $product->description ?? 'Tidak ada deskripsi' }}
            </p>

            <!-- ADD TO CART -->
            <form method="POST" action="/cart/add">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <button class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded">
                    + Tambah ke Keranjang
                </button>
            </form>

        </div>

    </div>

</div>
<!-- REKOMENDASI PRODUK -->
<div class="mt-12">

    <h2 class="text-2xl font-bold mb-6">
        🔥 Produk Rekomendasi
    </h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach($recommended as $item)
        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:scale-105 transition">

            <!-- IMAGE -->
            <div class="h-40 bg-gray-700 flex items-center justify-center">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" 
                         class="h-full object-cover">
                @else
                    <span class="text-gray-400">No Image</span>
                @endif
            </div>

            <!-- CONTENT -->
            <div class="p-4">
                <h3 class="font-semibold text-sm mb-1">
                    {{ $item->name }}
                </h3>

                <p class="text-green-400 font-bold mb-3">
                    Rp {{ number_format($item->price) }}
                </p>

                <!-- BUTTON -->
                <a href="/product/{{ $item->id }}" 
                   class="block text-center bg-green-500 hover:bg-green-600 
                          py-2 rounded-lg text-sm">
                    👁 Lihat Produk
                </a>
            </div>

        </div>
        @endforeach

    </div>

</div>

</body>
</html>