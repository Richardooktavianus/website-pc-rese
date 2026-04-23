@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">🛒 Keranjang Anda</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @forelse(session('cart', []) as $index => $build)

    <div class="bg-gray-800 rounded-xl p-5 mb-6 shadow-lg">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">💻 Build PC</h2>

            <!-- HAPUS -->
            <form method="POST" action="/cart/remove">
                @csrf
                <input type="hidden" name="index" value="{{ $index }}">
                <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded">
                    ❌ Hapus
                </button>
            </form>
        </div>

        <!-- ITEMS -->
        <div class="space-y-2 text-gray-300">
            @foreach($build['items'] as $item)
                <div class="flex justify-between border-b border-gray-700 pb-1">
                    <span>{{ $item['name'] }}</span>
                    <span class="text-green-400">
                        Rp {{ number_format($item['price']) }}
                    </span>
                </div>
            @endforeach
        </div>

        <!-- TOTAL -->
        <div class="mt-4 text-right">
            <p class="text-lg font-bold text-green-400">
                Total: Rp {{ number_format($build['total']) }}
            </p>
        </div>

    </div>

    @empty
        <div class="text-center text-gray-400">
            Keranjang masih kosong 😢
        </div>
    @endforelse

    <!-- BUTTON -->
    @if(count(session('cart', [])) > 0)
    <div class="flex justify-between mt-6">

        <form method="POST" action="/cart/clear">
            @csrf
            <button class="bg-yellow-500 hover:bg-yellow-600 px-5 py-2 rounded">
                🗑 Kosongkan
            </button>
        </form>

        <form method="POST" action="/checkout">
            @csrf
            <button class="bg-green-500 hover:bg-green-600 px-6 py-2 rounded font-bold">
                💳 Checkout
            </button>
        </form>

    </div>
    @endif

</div>

@endsection