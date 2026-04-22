<h1>Checkout</h1>

@foreach($cart as $item)
<p>{{ $item['name'] }} - Rp {{ $item['price'] }}</p>
@endforeach

<form method="POST" action="/checkout/process">
@csrf
<button>Bayar Sekarang</button>
</form>