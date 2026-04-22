<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen">

<div class="bg-gray-800 p-8 rounded-xl w-96 shadow-lg text-center">

    <!-- LOGO -->
    <img 
        src="{{ asset('images/logo.png') }}" 
        alt="Logo"
        class="w-20 mx-auto mb-2 hover:scale-110 transition"
    >

    <!-- BRAND -->
    <p class="text-gray-400 text-sm mb-2">PC Rakit Store</p>

    <!-- TITLE -->
    <h2 class="text-2xl font-bold mb-6 text-white">Login</h2>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div class="bg-green-500 p-2 rounded mb-4 text-white text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- ERROR MESSAGE -->
    @if(session('error'))
        <div class="bg-red-500 p-2 rounded mb-4 text-white text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- VALIDATION ERROR -->
    @if($errors->any())
        <div class="bg-red-400 p-2 rounded mb-4 text-white text-sm">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- FORM -->
    <form method="POST" action="/login">
        @csrf

        <!-- EMAIL -->
        <input 
            type="email" 
            name="email" 
            placeholder="Email"
            value="{{ old('email') }}"
            class="w-full p-3 mb-4 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
        >

        <!-- PASSWORD -->
        <input 
            type="password" 
            name="password" 
            placeholder="Password"
            class="w-full p-3 mb-2 rounded text-black focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
        >

        <!-- REMEMBER -->
        <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="remember">
                Remember me
            </label>

            <a href="#" class="hover:text-blue-400">Lupa password?</a>
        </div>

        <!-- BUTTON -->
        <button 
            type="submit" 
            class="w-full bg-blue-500 hover:bg-blue-600 p-3 rounded text-white font-semibold transition"
        >
            Login
        </button>
    </form>

    <!-- LINK REGISTER -->
    <p class="text-center text-sm mt-4 text-gray-400">
        Belum punya akun? 
        <a href="/register" class="text-blue-400 hover:underline">Register</a>
    </p>

</div>

</body>
</html>