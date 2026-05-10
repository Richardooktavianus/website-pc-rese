<!DOCTYPE html>
<html>
<head>

    <title>Admin Chat</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR USER -->
    <div class="w-[350px] bg-white border-r overflow-y-auto">

        <div class="p-5 border-b font-bold text-xl">
            Customer Chat
        </div>

        @foreach($users as $user)

            <div
                onclick="openChat(
                    {{ $user->id }},
                    '{{ $user->name }}'
                )"

                class="p-4 border-b cursor-pointer
                       hover:bg-gray-100">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-full
                                bg-black text-white
                                flex items-center
                                justify-center font-bold">

                        {{ strtoupper(substr($user->name,0,1)) }}

                    </div>

                    <div class="flex-1">

                        <div class="font-semibold">

                            {{ $user->name }}

                        </div>

                        <div class="text-sm text-gray-500 truncate">

                            {{ optional(
                                $user->chats->first()
                            )->message }}

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    <!-- CHAT ROOM -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER -->
        <div id="chatHeader"
             class="h-[80px] bg-white border-b
                    flex items-center px-6
                    text-xl font-bold">

            Pilih chat user

        </div>

        <!-- MESSAGE -->
        <div id="chatMessages"
             class="flex-1 overflow-y-auto
                    p-6 space-y-4">

        </div>

        <!-- INPUT -->
        <div class="bg-white border-t p-4 flex gap-3">

            <input
                type="text"
                id="messageInput"
                placeholder="Ketik balasan..."

                class="flex-1 border rounded-xl
                       px-4 py-3">

            <button
                onclick="sendReply()"

                class="bg-black text-white
                       px-6 rounded-xl">

                Kirim

            </button>

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
        .innerHTML = userName;

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

            <div class="${
                msg.sender == 'admin'
                ? 'text-right'
                : 'text-left'
            }">

                <div class="inline-block
                            px-4 py-2 rounded-2xl
                            max-w-[70%]

                            ${
                                msg.sender == 'admin'
                                ? 'bg-black text-white'
                                : 'bg-white border'
                            }">

                    ${msg.message}

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

// =========================
// AUTO REFRESH
// =========================

setInterval(loadMessages, 2000);

</script>

</body>
</html>