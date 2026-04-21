@foreach(session('cart', []) as $item)
    <div>
        <h3>{{ $item['name'] }}</h3>
        <p>{{ $item['price'] }}</p>
    </div>
@endforeach