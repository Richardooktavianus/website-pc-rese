<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">

    <h1 class="text-3xl font-bold mb-6 text-center">
        Admin Login
    </h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/admin/login">

        @csrf

        <div class="mb-4">
            <label>Email</label>

            <input
                type="email"
                name="email"
                class="w-full border rounded-lg px-4 py-3"
                required>
        </div>

        <div class="mb-6">
            <label>Password</label>

            <input
                type="password"
                name="password"
                class="w-full border rounded-lg px-4 py-3"
                required>
        </div>

        <button class="w-full bg-black text-white py-3 rounded-lg">
            Login Admin
        </button>

    </form>

</div>

</body>
</html>