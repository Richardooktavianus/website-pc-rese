<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow">

<aside class="w-64 bg-black text-white p-6">
        <h1 class="text-2xl font-bold mb-10">
            Admin Panel
        </h1>

        <ul class="space-y-4">
            <li>
                <a href="/admin/dashboard">Dashboard</a>
            </li>

            <li>
                <a href="/admin/chat">Chat User</a>
            </li>
        </ul>

        <form action="/admin/logout" method="POST" class="mt-10">
            @csrf
            <button class="bg-red-500 px-4 py-2 rounded">
                Logout
            </button>
        </form>
    </aside>

    <h1 class="text-3xl font-bold mb-8">
        Edit Produk
    </h1>

    <form method="POST"
          action="/admin/products/update/{{ $product->id }}"
          enctype="multipart/form-data">

        @csrf

        <div class="mb-4">
            <label>Nama Produk</label>

            <input
                type="text"
                name="name"
                value="{{ $product->name }}"
                class="w-full border rounded-lg px-4 py-3"
                required>
        </div>

        <div class="mb-4">
            <label>Harga</label>

            <input
                type="number"
                name="price"
                value="{{ $product->price }}"
                class="w-full border rounded-lg px-4 py-3"
                required>
        </div>

        <div class="mb-4">
            <label>Deskripsi</label>

            <textarea
                name="description"
                class="w-full border rounded-lg px-4 py-3"
                rows="5">{{ $product->description }}</textarea>
        </div>

        <div class="mb-4">

            <img
                src="{{ $product->image }}"
                class="w-32 rounded mb-4">

        </div>

        <div class="mb-6">
            <label>Ganti Gambar</label>

            <input
                type="file"
                name="image"
                class="w-full border rounded-lg px-4 py-3">
        </div>

        <button class="bg-black text-white px-6 py-3 rounded-xl">
            Update
        </button>

    </form>

</div>

</body>
</html>