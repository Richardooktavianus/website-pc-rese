<!-- resources/views/admin/orders/show.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detail Order</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>

        body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

    </style>

</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-slate-950 text-white p-6 flex flex-col shadow-2xl">

        <div class="flex items-center gap-4 mb-12">

            <div class="w-14 h-14 rounded-2xl
                        bg-indigo-600
                        flex items-center
                        justify-center
                        text-2xl font-bold">

                A

            </div>

            <div>

                <h1 class="text-2xl font-extrabold">
                    Admin Panel
                </h1>

                <p class="text-slate-400 text-sm">
                    PC Rakit Store
                </p>

            </div>

        </div>

        <nav class="space-y-3">

            <a href="/admin/dashboard"
               class="flex items-center gap-4 hover:bg-slate-800 transition px-5 py-4 rounded-2xl">

                📊

                <span class="font-semibold">
                    Dashboard
                </span>

            </a>

            <a href="/admin/products"
               class="flex items-center gap-4 hover:bg-slate-800 transition px-5 py-4 rounded-2xl">

                📦

                <span class="font-semibold">
                    Produk
                </span>

            </a>

            <a href="/admin/orders"
               class="flex items-center gap-4 bg-indigo-600 px-5 py-4 rounded-2xl">

                🛒

                <span class="font-semibold">
                    Orders
                </span>

            </a>

            <a href="/admin/chat"
               class="flex items-center gap-4 hover:bg-slate-800 transition px-5 py-4 rounded-2xl">

                💬

                <span class="font-semibold">
                    Chat User
                </span>

            </a>

        </nav>

        <div class="mt-auto">

            <form action="/admin/logout"
                  method="POST">

                @csrf

                <button
                    class="w-full bg-red-500
                           hover:bg-red-600
                           transition
                           py-3 rounded-2xl
                           font-bold">

                    Logout

                </button>

            </form>

        </div>

    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-10">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-10">

            <div>

                <h1 class="text-4xl font-extrabold text-slate-900">
                    Detail Order #{{ $order->id }}
                </h1>

                <p class="text-slate-500 mt-2">
                    Informasi lengkap pesanan customer
                </p>

            </div>

            <a href="/admin/orders"
               class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-semibold">

                ← Kembali

            </a>

        </div>

        <!-- CUSTOMER -->
        <div class="bg-white rounded-[30px]
                    p-8 shadow-sm border border-slate-100 mb-8">

            <h2 class="text-2xl font-bold mb-6">
                Informasi Customer
            </h2>

            <div class="grid grid-cols-2 gap-6">

                <div>

                    <p class="text-slate-400 text-sm">
                        Nama
                    </p>

                    <h3 class="font-bold text-lg">
                        {{ $order->nama_penerima }}
                    </h3>

                </div>

                <div>

                    <p class="text-slate-400 text-sm">
                        No Telepon
                    </p>

                    <h3 class="font-bold text-lg">
                        {{ $order->no_telepon }}
                    </h3>

                </div>

                <div>

                    <p class="text-slate-400 text-sm">
                        Kota
                    </p>

                    <h3 class="font-bold text-lg">
                        {{ $order->kota }}
                    </h3>

                </div>

                <div>

                    <p class="text-slate-400 text-sm">
                        Provinsi
                    </p>

                    <h3 class="font-bold text-lg">
                        {{ $order->provinsi }}
                    </h3>

                </div>

                <div class="col-span-2">

                    <p class="text-slate-400 text-sm">
                        Alamat
                    </p>

                    <h3 class="font-bold text-lg">
                        {{ $order->alamat }}
                    </h3>

                </div>

            </div>

        </div>

  <!-- ORDER -->
<div class="bg-white rounded-[30px]
            p-8 shadow-sm border border-slate-100 mb-8">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold">
            Produk Dipesan
        </h2>

        <span class="bg-indigo-100 text-indigo-700
                     px-4 py-2 rounded-xl text-sm font-semibold">

            {{ $order->items->count() }} Item

        </span>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead>

                <tr class="border-b border-slate-200 text-slate-500">

                    <th class="text-left py-4 font-semibold">
                        Produk
                    </th>

                    <th class="text-left py-4 font-semibold">
                        Komponen
                    </th>

                    <th class="text-center py-4 font-semibold">
                        Qty
                    </th>

                    <th class="text-right py-4 font-semibold">
                        Harga
                    </th>

                    <th class="text-right py-4 font-semibold">
                        Total
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($order->items as $item)

                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                    <!-- NAMA PRODUK -->
                    <td class="py-5">

                        <div class="font-bold text-slate-800">

                            {{ $item->product_name ?? 'Produk Tidak Ditemukan' }}

                        </div>

                    </td>

                    <!-- KOMPONEN -->
                    <td class="py-5 text-slate-600">

                        {{ $item->component ?? '-' }}

                    </td>

                    <!-- QTY -->
                    <td class="py-5 text-center">

                        <span class="bg-slate-100
                                     px-3 py-1 rounded-lg
                                     font-semibold">

                            {{ $item->quantity ?? 1 }}

                        </span>

                    </td>

                    <!-- HARGA -->
                    <td class="py-5 text-right font-medium">

                        Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}

                    </td>

                    <!-- TOTAL -->
                    <td class="py-5 text-right">

                        <span class="font-extrabold text-indigo-600">

                            Rp {{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 0, ',', '.') }}

                        </span>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="py-10 text-center text-slate-400">

                        Belum ada item pada order ini.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

        <!-- PAYMENT -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-white rounded-[30px]
                        p-8 shadow-sm border border-slate-100">

                <h2 class="text-2xl font-bold mb-6">
                    Pembayaran
                </h2>

                <div class="space-y-5">

                    <div>

                        <p class="text-slate-400 text-sm">
                            Metode Pembayaran
                        </p>

                        <h3 class="font-bold text-lg">
                            {{ $order->pembayaran }}
                        </h3>

                    </div>

                    <div>

                        <p class="text-slate-400 text-sm">
                            Kurir
                        </p>

                        <h3 class="font-bold text-lg">
                            {{ $order->kurir }}
                        </h3>

                    </div>

                    <div>

                        <p class="text-slate-400 text-sm">
                            Status
                        </p>

                        <span class="inline-block
                                     px-4 py-2 rounded-xl
                                     bg-amber-100 text-amber-700
                                     font-bold">

                            {{ strtoupper($order->status) }}

                        </span>

                    </div>

                </div>

            </div>

            <!-- TOTAL -->
            <div class="bg-indigo-600 rounded-[30px]
                        p-8 text-white shadow-lg">

                <h2 class="text-2xl font-bold mb-8">
                    Ringkasan
                </h2>

                <div class="space-y-5">

                    <div class="flex justify-between">

                        <span>
                            Ongkir
                        </span>

                        <span class="font-bold">
                            Rp {{ number_format($order->ongkir) }}
                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>
                            Diskon
                        </span>

                        <span class="font-bold">
                            Rp {{ number_format($order->discount) }}
                        </span>

                    </div>

                    <div class="border-t border-white/20 pt-5
                                flex justify-between text-2xl font-extrabold">

                        <span>
                            Total
                        </span>

                        <span>
                            Rp {{ number_format($order->total_price) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>