<!DOCTYPE html>
            <br><br>

        @endforeach

    </div>

    <div style="flex:1;">

        <div
            id="chatBox"
            style="height:400px; overflow-y:auto; border:1px solid #ccc; padding:10px;">
        </div>

        <br>

        <input type="text" id="replyInput">

        <button onclick="sendReply()">
            Kirim
        </button>

    </div>

</div>

<script>

let currentUser = null;

async function selectUser(userId)
{
  currentUser = userId;

  loadAdminMessages();
}

async function loadAdminMessages()
{
  if(!currentUser) return;

  const response = await fetch('/admin/chat/messages/' + currentUser);

  const data = await response.json();

  const chatBox = document.getElementById('chatBox');

  chatBox.innerHTML = '';

  data.forEach(msg => {

    const div = document.createElement('div');

    div.style.marginBottom = '10px';

    div.innerHTML =
      '<b>' + msg.sender + ':</b> ' + msg.message;

    chatBox.appendChild(div);

  });

  chatBox.scrollTop = chatBox.scrollHeight;
}

async function sendReply()
{
  if(!currentUser) return;

  const input = document.getElementById('replyInput');

  const message = input.value.trim();

  if(message === '') return;

  await fetch('/admin/chat/reply/' + currentUser, {

    method: 'POST',

    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },

    body: JSON.stringify({
      message: message
    })

  });

  input.value = '';

  loadAdminMessages();
}

setInterval(() => {

  loadAdminMessages();

}, 2000);

</script>

</body>
</html>