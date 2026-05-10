<!DOCTYPE html>
<html>
<head>
    <title>Admin Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

<div class="flex justify-between items-center mb-8">

    <h1 class="text-3xl font-bold">
        Produk
    </h1>

    <a href="/admin/products/create"
       class="bg-black text-white px-5 py-3 rounded-xl">
        Tambah Produk
    </a>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">Gambar</th>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-left">Harga</th>
                <th class="p-4 text-left">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @foreach($products as $product)

            <tr class="border-t">

                <td class="p-4">
                    <img
                        src=\"{{ $product->image }}\"
                        class=\"w-20 h-20 object-cover rounded\">
                </td>

                <td class="p-4">
                    {{ $product->name }}
                </td>

                <td class="p-4">
                    Rp {{ number_format($product->price) }}
                </td>

                <td class="p-4 flex gap-2">

                    <a href=\"/admin/products/edit/{{ $product->id }}\"
                       class=\"bg-yellow-500 text-white px-4 py-2 rounded\">
                        Edit
                    </a>

                    <form method=\"POST\"
                          action=\"/admin/products/delete/{{ $product->id }}\">
                        @csrf

                        <button class=\"bg-red-500 text-white px-4 py-2 rounded\">
                            Hapus
                        </button>
                    </form>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

</body>
</html>