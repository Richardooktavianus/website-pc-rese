<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#F8F9FA] text-slate-700">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-900 text-white p-6 flex flex-col fixed h-full shadow-2xl">

        <div class="flex items-center gap-3 mb-10 px-2">

            <div class="w-9 h-9 bg-indigo-500 rounded-xl flex items-center justify-center font-bold shadow-lg shadow-indigo-500/40">
                A
            </div>

            <span class="text-xl font-bold tracking-tight">
                Supabase Admin
            </span>

        </div>

        <nav class="flex-1 space-y-2">

            <a href="/admin/dashboard"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">

                <span>🏠</span>

                <span class="font-medium">
                    Dashboard
                </span>

            </a>

            <a href="/admin/products"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">

                <span>📦</span>

                <span class="font-medium">
                    Produk
                </span>

            </a>

            <a href="/admin/orders"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/20 transition">

                <span>🛒</span>

                <span class="font-medium">
                    Orders
                </span>

            </a>

            <a href="/admin/chat"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">

                <span>💬</span>

                <span class="font-medium">
                    Chat User
                </span>

            </a>

        </nav>

        <form action="/admin/logout"
              method="POST"
              class="mt-auto pt-6 border-t border-slate-800">

            @csrf

            <button class="w-full flex items-center justify-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl transition font-semibold text-sm">

                Logout

            </button>

        </form>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 ml-64 p-10">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-10">

            <div>

                <h1 class="text-3xl font-bold text-slate-900">
                    Orders Management
                </h1>

                <p class="text-slate-500 mt-1">
                    Kelola semua pesanan customer.
                </p>

            </div>

            <div class="bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100">

                <span class="text-sm font-medium text-slate-500">
                    Total Orders:
                </span>

                <span class="font-bold text-slate-900 ml-2">
                    {{ count($orders) }}
                </span>

            </div>

        </div>

        <!-- ORDERS -->
        <div class="space-y-5">

            @foreach($orders as $order)

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition">

                <div class="flex items-start justify-between">

                    <!-- LEFT -->
                    <div>

                        <div class="flex items-center gap-3 mb-3">

                            <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                {{ strtoupper(substr(optional($order->user)->name ?? 'U', 0, 1)) }}
                            </div>

                            <div>

                                <h2 class="text-lg font-bold text-slate-900">
                                    {{ optional($order->user)->name ?? 'User Tidak Ditemukan' }}
                                </h2>

                                <p class="text-sm text-slate-400">
                                    Order #{{ $order->id }}
                                </p>

                            </div>

                        </div>

                        <div class="flex flex-wrap gap-3 mt-4">

                            <!-- STATUS -->
                            <div class="px-4 py-2 rounded-xl bg-amber-100 text-amber-700 text-sm font-semibold">
                                {{ strtoupper($order->status) }}
                            </div>

                            <!-- TOTAL -->
                            <div class="px-4 py-2 rounded-xl bg-emerald-100 text-emerald-700 text-sm font-semibold">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </div>

                        </div>

                    </div>

                    <!-- RIGHT -->
                    <div class="flex flex-col items-end gap-3">

                        <div class="text-sm text-slate-400">
                            {{ $order->created_at->format('d M Y • H:i') }}
                        </div>

                        <a href="/admin/orders/{{ $order->id }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-2xl font-semibold transition">

                            Lihat Detail

                        </a>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </main>

</div>

</body>
</html>