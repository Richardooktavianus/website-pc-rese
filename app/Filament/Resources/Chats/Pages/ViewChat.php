<?php

namespace App\Filament\Resources\Chats\Pages;

use App\Filament\Resources\Chats\ChatResource;
use App\Models\Chat;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Livewire\Attributes\On;

class ViewChat extends ViewRecord
{
    protected static string $resource = ChatResource::class;
    protected string $view = 'filament.resources.chats.pages.view-chat';

    public $messages = [];
    public $message = '';

    public function mount($record): void
    {
        parent::mount($record);

        $this->loadMessages();
    }

    #[On('refreshMessages')]
    public function loadMessages(): void
    {
        // 🔥 FIX: pakai user_id yang benar (konsisten dengan create)
        $this->messages = Chat::where('user_id', $this->record->user_id)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage(): void
    {
        if (!trim($this->message)) return;

        Chat::create([
            // 🔥 FIX: konsisten pakai user_id
            'user_id' => $this->record->user_id,
            'message' => $this->message,
            'sender'  => 'admin',
        ]);

        $this->message = '';

        // refresh chat
        $this->loadMessages();

        // optional event untuk scroll
        $this->dispatch('scroll-chat');

        Notification::make()
            ->title('Pesan terkirim')
            ->success()
            ->send();
    }
}