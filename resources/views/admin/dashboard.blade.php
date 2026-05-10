<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

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

    <main class="flex-1 p-10">

        <h1 class="text-3xl font-bold mb-6">
            Dashboard Admin
        </h1>

        <div class="grid grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-gray-500">Total User</h2>
                <p class="text-3xl font-bold mt-2">
                    {{ \App\Models\User::count() }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-gray-500">Total Produk</h2>
                <p class="text-3xl font-bold mt-2">
                    {{ \App\Models\Product::count() }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-gray-500">Total Chat</h2>
                <p class="text-3xl font-bold mt-2">
                    {{ \App\Models\Chat::count() }}
                </p>
            </div>

        </div>

    </main>

</div>

</body>
</html>