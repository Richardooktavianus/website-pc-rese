<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Produk</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sidebar-link {
            transition: all .2s ease;
        }

        .sidebar-link:hover {
            transform: translateX(4px);
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

<!-- SIDEBAR -->
<aside class="w-64 bg-slate-900 text-white p-6 flex flex-col fixed h-full shadow-2xl">

    <!-- LOGO -->
    <div class="flex items-center gap-3 mb-10 px-2">

        <div class="w-9 h-9 bg-indigo-500 rounded-xl flex items-center justify-center font-bold shadow-lg shadow-indigo-500/40">
            A
        </div>

        <span class="text-xl font-bold tracking-tight text-white">
            Supabase Admin
        </span>

    </div>

         <!-- MENU -->
    <nav class="flex-1 space-y-2">

        <!-- DASHBOARD -->
        <a href="/admin/dashboard"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />

            </svg>

            <span class="font-medium">
                Dashboard
            </span>

        </a>

        <!-- PRODUK -->
        <a href="/admin/products"
           class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/20 transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />

            </svg>

            <span class="font-medium">
                Produk (CRUD)
            </span>

        </a>

        <!-- CHAT -->
        <a href="/admin/chat"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />

            </svg>

            <span class="font-medium">
                Chat User
            </span>

        </a>

    </nav>

    <!-- LOGOUT -->
    <form action="/admin/logout"
          method="POST"
          class="mt-auto pt-6 border-t border-slate-800">

        @csrf

        <button
            class="w-full flex items-center justify-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl transition font-semibold text-sm">

            Logout

        </button>

    </form>

</aside>

    <!-- MAIN CONTENT -->
   <main class="flex-1 ml-64 p-10">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-10">

            <div>

                <h1 class="text-4xl font-extrabold text-gray-900">
                    Produk
                </h1>

                <p class="text-gray-500 mt-2">
                    Kelola semua produk toko Anda
                </p>

            </div>

            <a href="/admin/products/create"
               class="bg-black hover:bg-zinc-800 transition text-white px-6 py-4 rounded-2xl font-bold shadow-lg">

                + Tambah Produk

            </a>

        </div>

        <!-- CARD -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <!-- TABLE HEAD -->
                    <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="p-6 text-left text-sm font-bold text-gray-600">
                            Gambar
                        </th>

                        <th class="p-6 text-left text-sm font-bold text-gray-600">
                            Nama Produk
                        </th>

                        <th class="p-6 text-left text-sm font-bold text-gray-600">
                            Harga
                        </th>

                        <th class="p-6 text-left text-sm font-bold text-gray-600">
                            Aksi
                        </th>

                    </tr>

                    </thead>

                    <!-- TABLE BODY -->
                    <tbody>

                    @forelse($products as $product)

                        <tr class="border-b hover:bg-gray-50 transition">

                            <!-- IMAGE -->
                            <td class="p-6">

                                <img
                                    src="{{ $product->image }}"
                                    class="w-24 h-24 object-cover rounded-2xl border shadow-sm">

                            </td>

                            <!-- NAME -->
                            <td class="p-6">

                                <div class="font-bold text-lg text-gray-900">
                                    {{ $product->name }}
                                </div>

                            </td>

                            <!-- PRICE -->
                            <td class="p-6">

                                <div class="font-bold text-green-600 text-lg">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>

                            </td>

                            <!-- ACTION -->
                            <td class="p-6">

                                <div class="flex gap-3">

                                    <!-- EDIT -->
                                    <a href="/admin/products/edit/{{ $product->id }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 transition text-black px-5 py-3 rounded-xl font-bold">

                                        Edit

                                    </a>

                                    <!-- DELETE -->
                                    <form method="POST"
                                          action="/admin/products/delete/{{ $product->id }}">

                                        @csrf

                                        <button
                                            onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                            class="bg-red-500 hover:bg-red-600 transition text-white px-5 py-3 rounded-xl font-bold">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="p-10 text-center text-gray-500">

                                Belum ada produk.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

</body>
</html>