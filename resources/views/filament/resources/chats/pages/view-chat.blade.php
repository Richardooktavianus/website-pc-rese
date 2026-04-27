<x-filament::page>

<style>
    .chat-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 42rem;
        margin: 0 auto;
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.07);
    }

    /* HEADER */
    .chat-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        background: #111318;
        border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .chat-header-avatar {
        position: relative;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(52,211,153,0.1);
        border: 1.5px solid rgba(52,211,153,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
        color: #34d399;
    }
    .chat-header-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 10px;
        height: 10px;
        background: #34d399;
        border-radius: 50%;
        border: 2px solid #111318;
    }
    .chat-header-info { flex: 1; }
    .chat-header-name {
        font-size: 13px;
        font-weight: 600;
        color: #f1f5f9;
    }
    .chat-header-status {
        font-size: 11px;
        color: #34d399;
        margin-top: 2px;
    }
    .chat-header-badge {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.08em;
        color: #34d399;
        background: rgba(52,211,153,0.1);
        border: 1px solid rgba(52,211,153,0.25);
        padding: 3px 10px;
        border-radius: 6px;
    }

    /* CHAT BOX */
    .chat-box {
        display: flex;
        flex-direction: column;
        gap: 10px;
        height: 420px;
        overflow-y: auto;
        padding: 20px 16px;
        background: #0d1017;
    }
    .chat-box::-webkit-scrollbar { width: 4px; }
    .chat-box::-webkit-scrollbar-track { background: transparent; }
    .chat-box::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.08);
        border-radius: 4px;
    }

    /* MESSAGE ROW */
    .msg-row {
        display: flex;
        align-items: flex-end;
        gap: 8px;
    }
    .msg-row.is-admin { flex-direction: row-reverse; }

    .msg-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .msg-avatar.av-user {
        background: #1a1f2e;
        border: 1px solid rgba(255,255,255,0.1);
        color: #6b7280;
    }
    .msg-avatar.av-admin {
        background: rgba(52,211,153,0.1);
        border: 1px solid rgba(52,211,153,0.3);
        color: #34d399;
    }

    .msg-content {
        display: flex;
        flex-direction: column;
        gap: 3px;
        max-width: 72%;
    }
    .msg-row.is-admin .msg-content { align-items: flex-end; }
    .msg-row:not(.is-admin) .msg-content { align-items: flex-start; }

    .bubble {
        padding: 9px 14px;
        border-radius: 16px;
        font-size: 13px;
        line-height: 1.55;
        word-break: break-word;
    }
    .bubble.bubble-user {
        background: #1a1f2e;
        color: #e2e8f0;
        border: 1px solid rgba(255,255,255,0.06);
        border-bottom-left-radius: 4px;
    }
    .bubble.bubble-admin {
        background: linear-gradient(135deg, #34d399, #059669);
        color: #022c22;
        font-weight: 500;
        border-bottom-right-radius: 4px;
        box-shadow: 0 2px 14px rgba(52,211,153,0.2);
    }

    .msg-time {
        font-size: 10px;
        color: #374151;
        padding: 0 4px;
    }

    /* INPUT AREA */
    .chat-input-area {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        background: #111318;
        border-top: 1px solid rgba(255,255,255,0.06);
    }
    .chat-input-wrap {
        flex: 1;
        background: #0d1017;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        padding: 0 14px;
        transition: border-color 0.2s;
    }
    .chat-input-wrap:focus-within {
        border-color: rgba(52,211,153,0.45);
    }
    .chat-input {
        width: 100%;
        background: transparent;
        border: none;
        outline: none;
        padding: 10px 0;
        font-size: 13px;
        color: #e2e8f0;
    }
    .chat-input::placeholder { color: #374151; }

    .send-btn {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        background: #34d399;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.18s, transform 0.15s;
        box-shadow: 0 2px 12px rgba(52,211,153,0.3);
    }
    .send-btn:hover { background: #6ee7b7; transform: scale(1.05); }
    .send-btn:active { transform: scale(0.96); }
    .send-btn svg { color: #022c22; }
</style>

<div class="chat-wrapper">

    {{-- HEADER --}}
    <div class="chat-header">
        <div class="chat-header-avatar">
            &#128100;
            <span class="chat-header-dot"></span>
        </div>
        <div class="chat-header-info">
            <div class="chat-header-name">Customer Support</div>
            <div class="chat-header-status">● online</div>
        </div>
        <span class="chat-header-badge">ADMIN</span>
    </div>

    {{-- CHAT BOX --}}
<div class="chat-box" id="chatBox" wire:poll.2s>
    @foreach($this->messages as $msg)
        <div class="msg-row {{ $msg->sender == 'admin' ? 'is-admin' : '' }}">
            <div class="msg-avatar {{ $msg->sender == 'admin' ? 'av-admin' : 'av-user' }}">
                {{ $msg->sender == 'admin' ? 'A' : 'U' }}
            </div>
            <div class="msg-content">
                <div class="bubble {{ $msg->sender == 'admin' ? 'bubble-admin' : 'bubble-user' }}">
                    {{ $msg->message }}
                </div>
                <span class="msg-time">{{ $msg->created_at->format('H:i') }}</span>
            </div>
        </div>
    @endforeach
</div>

    {{-- INPUT AREA --}}
    <div class="chat-input-area">
        <div class="chat-input-wrap">
            <input
                type="text"
                wire:model="message"
                wire:keydown.enter="sendMessage"
                class="chat-input"
                placeholder="Ketik balasan..." />
        </div>
        <button wire:click="sendMessage" class="send-btn" title="Kirim">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"/>
                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
            </svg>
        </button>
    </div>

</div>

{{-- SCRIPTS --}}
<script>
    window.addEventListener('refreshMessages', () => {
        Livewire.find(
            document.querySelector('[wire\\:id]').getAttribute('wire:id')
        ).call('loadMessages');
    });

    window.addEventListener('scroll-chat', () => {
        let box = document.getElementById('chatBox');
        if (box) {
            setTimeout(() => { box.scrollTop = box.scrollHeight; }, 50);
        }
    });
    
</script>

</x-filament::page>