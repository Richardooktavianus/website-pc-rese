<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen">

<div class="bg-gray-800 p-8 rounded-xl w-96 shadow-lg text-center">

    <!-- LOGO -->
    <img 
        src="{{ asset('images/logo.png') }}" 
        class="w-20 mx-auto mb-3"
    >

    <h2 class="text-2xl font-bold mb-6 text-white">Register</h2>

    <!-- ERROR -->
    @if($errors->any())
        <div class="bg-red-500 p-2 rounded mb-4 text-white text-sm">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        <!-- NAME -->
        <input 
            type="text" 
            name="name" 
            placeholder="Nama"
            value="{{ old('name') }}"
            class="w-full p-3 mb-4 rounded text-black"
            required
        >

        <!-- EMAIL -->
        <input 
            type="email" 
            name="email" 
            placeholder="Email"
            value="{{ old('email') }}"
            class="w-full p-3 mb-4 rounded text-black"
            required
        >

        <!-- PASSWORD -->
        <input 
            type="password" 
            name="password" 
            placeholder="Password"
            class="w-full p-3 mb-4 rounded text-black"
            required
        >

        <!-- CONFIRM PASSWORD -->
        <input 
            type="password" 
            name="password_confirmation" 
            placeholder="Konfirmasi Password"
            class="w-full p-3 mb-4 rounded text-black"
            required
        >

        <button 
            type="submit"
            class="w-full bg-green-500 hover:bg-green-600 p-3 rounded text-white font-semibold"
        >
            Register
        </button>
    </form>

    <p class="text-sm mt-4 text-gray-400">
        Sudah punya akun? 
        <a href="/login" class="text-blue-400 hover:underline">Login</a>
    </p>

</div>

</body>
</html>