@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6 text-center">
        💳 Checkout
    </h1>

    <div class="bg-gray-800 rounded-2xl shadow-xl p-6">

        <!-- LIST PRODUK -->
        <div class="space-y-3 mb-6">

            @php $total = 0; @endphp

            @foreach($cart as $item)
                @php $total += $item['price']; @endphp

                <div class="flex justify-between items-center border-b border-gray-700 pb-2">
                    <span class="text-gray-300">
                        {{ $item['name'] }}
                    </span>

                    <span class="text-green-400 font-semibold">
                        Rp {{ number_format($item['price']) }}
                    </span>
                </div>
            @endforeach

        </div>

        <!-- TOTAL -->
        <div class="flex justify-between items-center text-xl font-bold mb-6">
            <span>Total</span>
            <span class="text-green-400">
                Rp {{ number_format($total) }}
            </span>
        </div>

        <!-- BUTTON -->
        <form method="POST" action="/checkout/process">
            @csrf

            <button 
                class="w-full bg-green-500 hover:bg-green-600 text-white py-4 rounded-xl text-lg font-bold transition">
                💳 Bayar Sekarang
            </button>
        </form>

    </div>

</div>

@endsection