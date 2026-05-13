<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Informasi PC Gaming</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=DM+Sans:wght@400;500;700&display=swap"
          rel="stylesheet">

    <style>

        :root{
            --primary:#6366f1;
            --dark:#0f172a;
            --surface:#ffffff;
            --bg:#f1f5f9;
        }

        body{
            background: var(--bg);
            font-family: 'DM Sans', sans-serif;
        }

        .title-font{
            font-family: 'Rajdhani', sans-serif;
        }

    </style>

</head>

<body>

<!-- NAVBAR -->
<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-200">

    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <div class="flex items-center gap-3">

            <div class="w-11 h-11 rounded-2xl
                        bg-indigo-600 text-white
                        flex items-center justify-center
                        font-bold text-xl shadow-lg">

                P

            </div>

            <div>

                <h1 class="title-font text-2xl font-bold text-slate-900">
                    PC Rakit Store
                </h1>

                <p class="text-xs text-slate-400">
                    Gaming & Technology
                </p>

            </div>

        </div>

        <!-- MENU -->
        <nav class="hidden md:flex items-center gap-8">

            <a href="/"
               class="font-semibold text-slate-600 hover:text-indigo-600 transition">
                Home
            </a>

            <a href="/komponen"
               class="font-semibold text-slate-600 hover:text-indigo-600 transition">
                Komponen
            </a>

            <a href="/builder"
               class="font-semibold text-slate-600 hover:text-indigo-600 transition">
                PC Builder
            </a>

            <a href="/informasi"
               class="font-semibold text-indigo-600">
                Informasi
            </a>

        </nav>

    </div>

</header>

<!-- HERO -->
<section class="relative overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600"></div>

    <div class="absolute inset-0 opacity-20">

        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>

        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-500 rounded-full blur-3xl"></div>

    </div>

    <div class="relative max-w-6xl mx-auto px-6 py-24">

        <div class="max-w-4xl">

            <div class="inline-flex items-center gap-3
                        bg-white/10 border border-white/20
                        backdrop-blur-xl
                        text-white px-5 py-3
                        rounded-full mb-8">

                🎮 Tutorial PC Gaming

            </div>

            <h1 class="title-font text-6xl md:text-7xl
                       font-bold leading-none
                       text-white mb-8">

                Cara Merakit
                <span class="text-yellow-300">
                    PC Gaming
                </span>

            </h1>

            <p class="text-xl text-indigo-100 leading-relaxed max-w-3xl">

                Pelajari langkah lengkap merakit PC Gaming modern
                mulai dari pemasangan processor, motherboard,
                VGA hingga cable management profesional.

            </p>

        </div>

    </div>

</section>

<!-- CONTENT -->
<section class="max-w-6xl mx-auto px-6 py-14">

    <!-- VIDEO -->
    <div class="bg-white rounded-[35px]
                overflow-hidden
                shadow-xl shadow-slate-200/50
                border border-slate-100 mb-12">

        <div class="p-8 border-b border-slate-100">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="title-font text-3xl font-bold text-slate-900">

                        Video Tutorial

                    </h2>

                    <p class="text-slate-400 mt-2">

                        Tonton panduan lengkap perakitan PC

                    </p>

                </div>

                <div class="bg-red-100 text-red-600
                            px-5 py-3 rounded-2xl
                            font-bold">

                    ▶ YouTube

                </div>

            </div>

        </div>

        <div class="aspect-video bg-black">

            <iframe
                class="w-full h-full"
                src="https://www.youtube.com/embed/tr0AJ2IbbB8?si=NsYDCPhKX_yIec0Q"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>

            </iframe>

        </div>

    </div>

    <!-- ARTICLE -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-2">

            <div class="bg-white rounded-[35px]
                        p-10 shadow-sm
                        border border-slate-100">

                <h2 class="title-font text-4xl font-bold
                           text-slate-900 mb-8">

                    Penjelasan Lengkap

                </h2>

                <div class="space-y-8 text-slate-600 leading-relaxed text-lg">

                    <div>

                        <h3 class="text-2xl font-bold text-slate-900 mb-3">

                            1. Memasang Processor

                        </h3>

                        <p>

                            Langkah pertama adalah memasang processor
                            ke socket motherboard dengan hati-hati.
                            Pastikan arah segitiga processor sesuai
                            dengan tanda pada motherboard.

                        </p>

                    </div>

                    <div>

                        <h3 class="text-2xl font-bold text-slate-900 mb-3">

                            2. Instalasi RAM

                        </h3>

                        <p>

                            Gunakan konfigurasi dual channel agar
                            performa gaming lebih optimal. Tekan RAM
                            hingga pengunci otomatis terkunci.

                        </p>

                    </div>

                    <div>

                        <h3 class="text-2xl font-bold text-slate-900 mb-3">

                            3. Pemasangan VGA

                        </h3>

                        <p>

                            Pasang VGA pada slot PCIe utama lalu
                            sambungkan kabel power PSU sesuai kebutuhan
                            daya VGA.

                        </p>

                    </div>

                    <div>

                        <h3 class="text-2xl font-bold text-slate-900 mb-3">

                            4. Cable Management

                        </h3>

                        <p>

                            Rapikan seluruh kabel agar airflow casing
                            tetap optimal dan tampilan build lebih bersih.

                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- SIDEBAR -->
        <div class="space-y-8">

            <!-- AUTHOR -->
            <div class="bg-white rounded-[35px]
                        p-8 shadow-sm
                        border border-slate-100">

                <div class="flex items-center gap-4 mb-6">

                    <div class="w-16 h-16 rounded-2xl
                                bg-indigo-600 text-white
                                flex items-center justify-center
                                text-2xl font-bold">

                        P

                    </div>

                    <div>

                        <h3 class="font-bold text-xl text-slate-900">

                            PC Rakit Store

                        </h3>

                        <p class="text-slate-400">

                            Official Tutorial

                        </p>

                    </div>

                </div>


            </div>

        </div>

    </div>

</section>

</body>
</html>