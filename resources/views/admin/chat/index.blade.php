<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Chat</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>

        body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        ::-webkit-scrollbar{
            width: 6px;
        }

        ::-webkit-scrollbar-thumb{
            background: #cbd5e1;
            border-radius: 20px;
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

        <!-- MENU -->
        <nav class="space-y-3">

            <a href="/admin/dashboard"
               class="flex items-center gap-4
                      hover:bg-slate-800
                      transition
                      px-5 py-4
                      rounded-2xl">

                📊

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

                📦

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

                🛒

                <span class="font-semibold">
                    Orders
                </span>

            </a>

            <a href="/admin/chat"
               class="flex items-center gap-4
                      bg-indigo-600
                      px-5 py-4
                      rounded-2xl
                      shadow-lg shadow-indigo-600/20">

                💬

                <span class="font-semibold">
                    Chat User
                </span>

            </a>

        </nav>

        <!-- LOGOUT -->
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

    <!-- CHAT AREA -->
    <div class="flex-1 flex">

        <!-- USER LIST -->
        <div class="w-[360px]
                    bg-white border-r
                    border-slate-200
                    flex flex-col">

            <!-- HEADER -->
            <div class="p-6 border-b bg-white">

                <h1 class="text-2xl font-extrabold text-slate-900">
                    Customer Chat
                </h1>

                <p class="text-slate-400 text-sm mt-1">
                    Semua percakapan customer
                </p>

            </div>

            <!-- USERS -->
            <div class="flex-1 overflow-y-auto">

                @foreach($users as $user)

                <div
                    onclick="openChat(
                        {{ $user->id }},
                        '{{ $user->name }}'
                    )"

                    class="p-5 border-b border-slate-100
                           hover:bg-slate-50
                           cursor-pointer transition">

                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 rounded-2xl
                                    bg-indigo-600 text-white
                                    flex items-center justify-center
                                    font-bold text-lg shadow">

                            {{ strtoupper(substr($user->name,0,1)) }}

                        </div>

                        <div class="flex-1 min-w-0">

                            <div class="font-bold text-slate-900">

                                {{ $user->name }}

                            </div>

                            <div class="text-sm text-slate-400 truncate mt-1">

                                {{ optional(
                                    $user->chats->first()
                                )->message }}

                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

        <!-- CHAT ROOM -->
        <div class="flex-1 flex flex-col">

            <!-- HEADER -->
            <div id="chatHeader"
                 class="h-[90px]
                        bg-white border-b
                        border-slate-200
                        px-8
                        flex items-center">

                <div>

                    <h2 class="text-2xl font-extrabold text-slate-900">
                        Pilih chat user
                    </h2>

                    <p class="text-slate-400 text-sm">
                        Balas pesan customer secara realtime
                    </p>

                </div>

            </div>

            <!-- MESSAGE -->
            <div id="chatMessages"
                 class="flex-1 overflow-y-auto
                        p-8 space-y-5
                        bg-slate-100">

                <!-- CHAT HERE -->

            </div>

            <!-- INPUT -->
            <div class="bg-white border-t
                        border-slate-200
                        p-5">

                <div class="flex items-center gap-4">

                    <input
                        type="text"
                        id="messageInput"
                        placeholder="Ketik balasan..."

                        class="flex-1 bg-slate-100
                               border-none outline-none
                               rounded-2xl px-6 py-4
                               focus:ring-2
                               focus:ring-indigo-500">

                    <button
                        onclick="sendReply()"

                        class="bg-indigo-600
                               hover:bg-indigo-700
                               transition
                               text-white
                               px-8 py-4
                               rounded-2xl
                               font-bold shadow-lg
                               shadow-indigo-600/20">

                        Kirim

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

let currentUserId = null;

// =========================
// OPEN CHAT
// =========================

async function openChat(userId, userName)
{
    currentUserId = userId;

    document.getElementById('chatHeader')
        .innerHTML = `

            <div class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-2xl
                            bg-indigo-600 text-white
                            flex items-center justify-center
                            font-bold text-lg">

                    ${userName.charAt(0).toUpperCase()}

                </div>

                <div>

                    <h2 class="text-2xl font-extrabold text-slate-900">
                        ${userName}
                    </h2>

                    <p class="text-green-500 text-sm font-medium">
                        ● Online
                    </p>

                </div>

            </div>

        `;

    loadMessages();
}

// =========================
// LOAD MESSAGE
// =========================

async function loadMessages()
{
    if(!currentUserId) return;

    let response = await fetch(
        '/admin/chat/messages/' + currentUserId
    );

    let data = await response.json();

    let html = '';

    data.forEach(msg => {

        html += `

            <div class="flex ${
                msg.sender == 'admin'
                ? 'justify-end'
                : 'justify-start'
            }">

                <div class="${
                    msg.sender == 'admin'
                    ? 'bg-indigo-600 text-white'
                    : 'bg-white text-slate-800 border border-slate-200'
                }

                px-5 py-4 rounded-3xl
                max-w-[70%]
                shadow-sm">

                    <div class="text-sm leading-relaxed">

                        ${msg.message}

                    </div>

                </div>

            </div>

        `;
    });

    document.getElementById(
        'chatMessages'
    ).innerHTML = html;

    let box = document.getElementById(
        'chatMessages'
    );

    box.scrollTop = box.scrollHeight;
}

// =========================
// SEND REPLY
// =========================

async function sendReply()
{
    let input = document.getElementById(
        'messageInput'
    );

    let message = input.value;

    if(message.trim() == '') return;

    await fetch(

        '/admin/chat/reply/' + currentUserId,

        {
            method: 'POST',

            headers: {
                'Content-Type': 'application/json',

                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
            },

            body: JSON.stringify({
                message: message
            })
        }
    );

    input.value = '';

    loadMessages();
}

// ENTER SEND
document.getElementById(
    'messageInput'
).addEventListener('keypress', function(e){

    if(e.key === 'Enter'){
        sendReply();
    }

});

// AUTO REFRESH
setInterval(loadMessages, 2000);

</script>

</body>
</html>