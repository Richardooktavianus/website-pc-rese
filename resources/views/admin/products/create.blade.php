<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8F9FA] text-slate-700">

<div class="flex min-h-screen">
    <!-- Sidebar (Sesuai Dashboard) -->
    <aside class="w-64 bg-slate-900 text-white p-6 flex flex-col fixed h-full shadow-2xl">
        <div class="flex items-center gap-3 mb-10 px-2">
            <div class="w-9 h-9 bg-indigo-500 rounded-xl flex items-center justify-center font-bold shadow-lg shadow-indigo-500/40">A</div>
            <span class="text-xl font-bold tracking-tight text-white">Supabase Admin</span>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="/admin/products" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                <span class="font-medium">Produk (CRUD)</span>
            </a>
            <a href="/admin/chat" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                <span class="font-medium">Chat User</span>
            </a>
        </nav>

        <form action="/admin/logout" method="POST" class="mt-auto pt-6 border-t border-slate-800">
            @csrf
            <button class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-xl transition font-semibold text-sm text-left">
                Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-10">
        <!-- Header -->
        <div class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Tambah Produk Baru</h1>
                <p class="text-slate-500 mt-1">Silakan isi formulir di bawah untuk menambahkan item ke Supabase.</p>
            </div>
            <a href="/admin/products" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-50 transition">
                Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="max-w-3xl bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <form method="POST" action="/admin/products/store" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="mb-5">

    <label class="font-semibold">
        Kategori
    </label>

    <select
        name="category_id"
        class="w-full border rounded-xl p-3 mt-2"
        required>

        <option value="">
            Pilih Kategori
        </option>

        @foreach($categories as $category)

            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>

        @endforeach

    </select>

</div>

<div class="mb-5">

    <label class="font-semibold">
        Brand
    </label>

    <input
        type="text"
        name="brand"
        class="w-full border rounded-xl p-3 mt-2"
        placeholder="Contoh: ASUS, MSI, Gigabyte"
        required>

</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Nama Produk</label>
                        <input type="text" name="name" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none" 
                            placeholder="Contoh: SSD Samsung 980 Pro" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Harga (Rp)</label>
                        <input type="number" name="price" 
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none" 
                            placeholder="1500000" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Deskripsi Produk</label>
                    <textarea name="description" rows="5"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition outline-none" 
                        placeholder="Tuliskan spesifikasi lengkap produk..."></textarea>
                </div>

                <div class="mb-5">

    <label class="font-semibold">
        Stock
    </label>

    <input
        type="number"
        name="stock"
        class="w-full border rounded-xl p-3 mt-2"
        placeholder="Masukkan stock produk"
        required>

</div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700 ml-1">Foto Produk</label>
                    <div class="relative group">
                        <input type="file" name="image" 
                            class="w-full bg-slate-50 border border-dashed border-slate-300 rounded-2xl px-4 py-10 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer" 
                            required>
                    </div>
                    <p class="text-[11px] text-slate-400 ml-1 italic">*Format: JPG, PNG, WEBP. Maks 2MB.</p>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full md:w-auto bg-indigo-600 text-white px-10 py-4 rounded-2xl font-bold shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 hover:-translate-y-1 transition-all duration-200">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>