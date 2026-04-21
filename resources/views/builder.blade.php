<form method="POST" action="/builder/save">
@csrf

<h3>Pilih CPU</h3>
<select name="cpu">
@foreach($cpu as $item)
<option value="{{ $item->price }}">{{ $item->name }}</option>
@endforeach
</select>

<h3>Pilih GPU</h3>
<select name="gpu">
@foreach($gpu as $item)
<option value="{{ $item->price }}">{{ $item->name }}</option>
@endforeach
</select>

<h3>Pilih RAM</h3>
<select name="ram">
@foreach($ram as $item)
<option value="{{ $item->price }}">{{ $item->name }}</option>
@endforeach
</select>

<button type="submit">Hitung Total</button>
</form>