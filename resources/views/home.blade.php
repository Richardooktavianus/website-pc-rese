@foreach($products as $product)
    <div>
        <h3>{{ $product->name }}</h3>
        <p>Rp {{ number_format($product->price) }}</p>
        <a href="/product/{{ $product->id }}">Detail</a>
    </div>
@endforeach