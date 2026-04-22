<h1>Keranjang</h1>

@foreach($cart as $item)
<div>
    <h3>{{ $item['name'] }}</h3>
    <p>Rp {{ number_format($item['price']) }}</p>
</div>
@endforeach

<a href="/checkout">Checkout</a>