<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        <!-- LOGO -->
        <div class="flex items-center gap-4 mb-12">

            <div class="w-14 h-14 rounded-2xl
                        bg-indigo-600
                        flex items-center
                        justify-center
                        text-2xl font-bold
                        shadow-lg shadow-indigo-600/30">

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

        <!-- MENU -->
        <nav class="space-y-3">

            <a href="/admin/dashboard"
               class="flex items-center gap-4
                      bg-indigo-600
                      hover:bg-indigo-500
                      transition
                      px-5 py-4
                      rounded-2xl
                      shadow-lg shadow-indigo-600/20">

                <span class="text-xl">🏠</span>

                <span class="font-semibold">
                    Dashboard
                </span>

            </a>

            <a href="/admin/products"
               class="flex items-center gap-4
                      hover:bg-slate-800
                      transition
                      px-5 py-4
                      rounded-2xl">

                <span class="text-xl">📦</span>

                <span class="font-semibold">
                    Produk
                </span>

            </a>

            <a href="/admin/orders"
               class="flex items-center gap-4
                      hover:bg-slate-800
                      transition
                      px-5 py-4
                      rounded-2xl">

                <span class="text-xl">🛒</span>

                <span class="font-semibold">
                    Orders
                </span>

            </a>

            <a href="/admin/chat"
               class="flex items-center gap-4
                      hover:bg-slate-800
                      transition
                      px-5 py-4
                      rounded-2xl">

                <span class="text-xl">💬</span>

                <span class="font-semibold">
                    Chat User
                </span>

            </a>

        </nav>

        <!-- USER -->
        <div class="mt-auto">

            <div class="bg-slate-900 rounded-2xl p-4 mb-5">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full
                                bg-indigo-600
                                flex items-center
                                justify-center
                                font-bold text-lg">

                        A

                    </div>

                    <div>

                        <h2 class="font-bold">
                            Admin
                        </h2>

                        <p class="text-sm text-slate-400">
                            Online
                        </p>

                    </div>

                </div>

            </div>

            <form action="/admin/logout"
                  method="POST">

                @csrf

                <button
                    class="w-full bg-red-500
                           hover:bg-red-600
                           transition
                           py-3 rounded-2xl
                           font-bold shadow-lg">

                    Logout

                </button>

            </form>

        </div>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-10">

        <!-- TOPBAR -->
        <div class="flex justify-between items-center mb-10">

            <div>

                <h1 class="text-4xl font-extrabold text-slate-900">
                    Dashboard
                </h1>

                <p class="text-slate-500 mt-2">
                    Monitor statistik website & penjualan
                </p>

            </div>

            <div class="bg-white px-5 py-3 rounded-2xl shadow">

                <p class="font-semibold text-slate-700">
                    {{ now()->format('d M Y') }}
                </p>

            </div>

        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

            <!-- USER -->
            <div class="bg-white rounded-[30px]
                        p-8 shadow-sm border border-slate-100">

                <p class="text-slate-400 font-medium">
                    Total User
                </p>

                <h2 class="text-4xl font-extrabold
                           mt-5 text-slate-900">

                    {{ $totalUser }}

                </h2>

            </div>

            <!-- PRODUK -->
            <div class="bg-white rounded-[30px]
                        p-8 shadow-sm border border-slate-100">

                <p class="text-slate-400 font-medium">
                    Total Produk
                </p>

                <h2 class="text-4xl font-extrabold
                           mt-5 text-slate-900">

                    {{ $totalProduct }}

                </h2>

            </div>

            <!-- CHAT -->
            <div class="bg-white rounded-[30px]
                        p-8 shadow-sm border border-slate-100">

                <p class="text-slate-400 font-medium">
                    Total Chat
                </p>

                <h2 class="text-4xl font-extrabold
                           mt-5 text-slate-900">

                    {{ $totalChat }}

                </h2>

            </div>

            <!-- PENJUALAN -->
            <div class="bg-white rounded-[30px]
                        p-8 shadow-sm border border-slate-100">

                <p class="text-slate-400 font-medium">
                    Total Penjualan
                </p>

                <h2 class="text-4xl font-extrabold
                           mt-5 text-slate-900">

                    {{ $totalPenjualan }}

                </h2>

            </div>

          <!-- TOTAL PENJUALAN -->
<div class="bg-white rounded-[30px]
            p-8 shadow-sm border border-slate-100">

    <div class="flex justify-between items-start">

        <div>

            <p class="text-slate-400 font-medium">
                Total Penjualan
            </p>

            <h2 class="text-5xl font-extrabold
                       mt-5 text-slate-900">

                {{ $totalPenjualan }}

            </h2>

        </div>

        <div class="w-16 h-16 rounded-2xl
                    bg-purple-100 text-purple-600
                    flex items-center justify-center">

            🛒

        </div>

    </div>

</div>

<!-- TOTAL PENDAPATAN -->
<div class="bg-white rounded-[30px]
            p-8 shadow-sm border border-slate-100">

    <div class="flex justify-between items-start">

        <div>

            <p class="text-slate-400 font-medium">
                Total Pendapatan
            </p>

            <h2 class="text-3xl font-extrabold
                       mt-5 text-slate-900">

                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}

            </h2>

        </div>

        <div class="w-16 h-16 rounded-2xl
                    bg-green-100 text-green-600
                    flex items-center justify-center">

            💰

        </div>

    </div>

</div>

        <!-- GRAFIK -->
        <div class="mt-10 bg-white rounded-[30px]
                    p-8 shadow-sm border border-slate-100">

            <div class="flex justify-between items-center mb-8">

                <div>

                    <h2 class="text-2xl font-bold text-slate-900">
                        Grafik Pendapatan
                    </h2>

                    <p class="text-slate-400 mt-1">
                        Pendapatan 7 hari terakhir
                    </p>

                </div>

            </div>

            <div class="h-[400px]">

                <canvas id="salesChart"></canvas>

            </div>

        </div>

        <!-- RECENT -->
        <div class="mt-10 bg-white rounded-[30px]
                    p-8 shadow-sm border border-slate-100">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-2xl font-bold">
                    Aktivitas Terbaru
                </h2>

                <span class="text-sm text-slate-400">
                    realtime
                </span>

            </div>

            <div class="space-y-5">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-2xl
                                bg-indigo-100
                                flex items-center
                                justify-center">

                        👤

                    </div>

                    <div>

                        <h3 class="font-semibold">
                            User baru mendaftar
                        </h3>

                        <p class="text-sm text-slate-400">
                            Sistem mendeteksi registrasi baru
                        </p>

                    </div>

                </div>

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 rounded-2xl
                                bg-emerald-100
                                flex items-center
                                justify-center">

                        💬

                    </div>

                    <div>

                        <h3 class="font-semibold">
                            Pesan baru masuk
                        </h3>

                        <p class="text-sm text-slate-400">
                            Customer membutuhkan bantuan
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

<script>

const ctx = document.getElementById('salesChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: {!! json_encode($salesData->pluck('date')) !!},

        datasets: [{

            label: 'Pendapatan',

            data: {!! json_encode($salesData->pluck('total')) !!},

            borderColor: '#4f46e5',

            backgroundColor: 'rgba(79,70,229,0.15)',

            fill: true,

            tension: 0.4,

            pointBackgroundColor: '#4f46e5',

            pointRadius: 5,

            borderWidth: 4

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true,

                ticks: {

                    callback: function(value) {

                        return 'Rp ' + value.toLocaleString();

                    }

                }

            }

        }

    }

});

</script>

</body>
</html>