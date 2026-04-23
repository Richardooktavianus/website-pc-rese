<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PC Builder</title>

    <!-- ✅ Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white">

<!-- 🔥 NAVBAR -->
<nav class="bg-gray-800 p-4 flex justify-between items-center">

    <h1 class="text-xl font-bold">💻 PC Builder</h1>

    <div class="flex items-center gap-6">

        <a href="/" class="hover:text-gray-300">Home</a>

        <!-- CART -->
        <a href="/cart" class="relative">
            🛒

            @php $cartCount = count(session('cart', [])); @endphp

            @if($cartCount > 0)
                <span id="cart-count"
                    class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $cartCount }}
                </span>
            @endif
        </a>

    </div>
</nav>

<!-- 🔥 CONTENT -->
<div class="p-6">
    @yield('content')
</div>

</body>
</html>