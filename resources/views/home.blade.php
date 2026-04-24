<!DOCTYPE html>
<html>
<head>
    <title>PC Rakit Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<!-- NAVBAR -->
<div class="flex justify-between items-center p-4 bg-gray-800 shadow">

    <h1 class="text-xl font-bold">PC Builder</h1>

    <!-- SEARCH -->
    <form class="w-1/3">
        <input
            class="w-full px-4 py-2 rounded-full text-black"
            placeholder="Search produk..."
        >
    </form>

    <!-- RIGHT MENU -->
    <div class="flex items-center gap-4">

        <!-- CART -->
        <a href="/cart" class="relative inline-block">
            <span class="text-2xl">🛒</span>

            @php $cartCount = count(session('cart', [])); @endphp

            <span id="cart-count"
                class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                {{ $cartCount }}
            </span>
        </a>

        <!-- LOGIN -->
        <a href="/login" class="hover:text-blue-400">
            Login
        </a>

        <!-- REGISTER -->
        <a href="/register"
           class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white transition">
            Register
        </a>

    </div> <!-- ❗ INI YANG KURANG -->
</div>

<!-- MENU -->
<div class="flex gap-6 p-4 bg-gray-700 text-sm">
    <a href="/" class="hover:text-blue-400">Home</a>
    <a href="/builder" class="hover:text-blue-400">Rakit PC</a>
    <a href="/cart" class="hover:text-blue-400">Keranjang</a>
    <a href="/checkout" class="hover:text-blue-400">Checkout</a>
</div>

<div class="container mx-auto p-4">

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="bg-green-500 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- BANNER -->
    <!-- BANNER SLIDER -->
<div class="relative w-full h-48 overflow-hidden rounded-xl mb-6">

    <!-- SLIDER -->
    <div id="slider" class="flex transition-transform duration-500">

        <img src="{{ asset('images/banner1.jpg') }}" class="w-full h-48 object-cover flex-shrink-0">
        <img src="{{ asset('images/banner2.jpg') }}" class="w-full h-48 object-cover flex-shrink-0">
        <img src="{{ asset('images/banner3.jpg') }}" class="w-full h-48 object-cover flex-shrink-0">

    </div>

    <!-- BUTTON LEFT -->
    <button onclick="prevSlide()"
        class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 px-3 py-1 rounded">
        ‹
    </button>

    <!-- BUTTON RIGHT -->
    <button onclick="nextSlide()"
        class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 px-3 py-1 rounded">
        ›
    </button>

    <!-- INDICATOR -->
    <div id="dots" class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2">
        <div class="w-2 h-2 bg-white rounded-full"></div>
        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
        <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
    </div>

</div>

    <!-- CATEGORY -->
    <div class="flex justify-between mb-6">
        @for ($i = 0; $i < 6; $i++)
            <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
        @endfor
    </div>

    <!-- BUTTON BUILDER -->
    <div class="text-center mb-6">
        <a href="/builder" class="bg-green-500 hover:bg-green-600 px-6 py-2 rounded">
            🔧 Rakit PC Sekarang
        </a>
    </div>

    <!-- PRODUCT -->
    <h2 class="text-lg font-semibold mb-4">Popular Product</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        @forelse($products as $product)
        <div class="bg-gray-800 p-4 rounded-xl hover:scale-105 transition">

            <!-- IMAGE -->
            <a href="/product/{{ $product->id }}">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}"
                         class="h-32 w-full object-cover rounded mb-3">
                @else
                    <div class="h-32 bg-gray-400 rounded mb-3 flex items-center justify-center">
                        <span class="text-sm text-gray-700">No Image</span>
                    </div>
                @endif
            </a>

            <!-- NAME -->
            <a href="/product/{{ $product->id }}">
                <h3 class="font-semibold hover:text-blue-400">
                    {{ $product->name }}
                </h3>
            </a>

            <!-- PRICE -->
            <p class="text-green-400 mb-2">
                Rp {{ number_format($product->price) }}
            </p>

            <!-- ADD TO CART -->
            <a href="/product/{{ $product->id }}"
   class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600
          text-white py-2 rounded-lg">
    <span>👁</span>
    <span>View Produk</span>
</a>

        </div>
        @empty
            <p>Tidak ada produk tersedia</p>
        @endforelse

    </div>

    <!-- SPECIAL OFFER -->
    <h2 class="text-lg font-semibold mt-8 mb-4">Special Offer</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @for ($i = 0; $i < 4; $i++)
            <div class="h-24 bg-gray-400 rounded flex items-center justify-center">
                Promo
            </div>
        @endfor
    </div>

    <!-- LOAD MORE -->
    <div class="text-center mt-6">
        <button class="bg-white text-black px-4 py-2 rounded hover:bg-gray-200">
            Load More
        </button>
    </div>

    <!-- BANNER -->
    <div class="h-32 bg-gray-600 rounded-xl flex items-center justify-center mt-6">
        Banner
    </div>

</div>

<!-- FOOTER -->
<div class="bg-gray-800 text-center py-6 mt-6">
    © 2026 PC Rakit Store
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    let currentIndex = 0;
    const slider = document.getElementById('slider');
    const slides = slider.children;
    const totalSlides = slides.length;
    const dots = document.getElementById('dots').children;

    function updateSlide() {
        slider.style.transform = `translateX(-${currentIndex * 100}%)`;

        // update indikator
        for (let i = 0; i < dots.length; i++) {
            dots[i].classList.remove('bg-white');
            dots[i].classList.add('bg-gray-400');
        }
        dots[currentIndex].classList.remove('bg-gray-400');
        dots[currentIndex].classList.add('bg-white');
    }

    window.nextSlide = function () {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlide();
    }

    window.prevSlide = function () {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateSlide();
    }

    // auto slide
    setInterval(() => {
        nextSlide();
    }, 3000);

});
</script>

</body>
</html>
