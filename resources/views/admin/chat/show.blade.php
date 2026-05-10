<!DOCTYPE html>
<html>
<head>
    <title>Chat Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto py-10">

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

    <h1 class="text-2xl font-bold mb-6">
        Chat Dengan {{ $user->name }}
    </h1>

    <div class="bg-white rounded-xl shadow p-6 h-[500px] overflow-y-auto mb-6">

        @foreach($messages as $msg)

            <div class="mb-4 {{ $msg->sender == 'admin' ? 'text-right' : '' }}">

                <div class="inline-block px-4 py-3 rounded-xl
                    {{ $msg->sender == 'admin'
                        ? 'bg-green-500 text-white'
                        : 'bg-gray-200 text-black' }}">

                    {{ $msg->message }}

                </div>

            </div>

        @endforeach

    </div>

    <form method="POST">
        @csrf

        <div class="flex gap-4">

            <input
                type="text"
                name="message"
                class="flex-1 border rounded-xl px-4 py-3"
                placeholder="Ketik balasan..."
                required>

            <button class="bg-black text-white px-6 rounded-xl">
                Kirim
            </button>

        </div>

    </form>

</div>

</body>
</html>