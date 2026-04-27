<?php

namespace App\Filament\Resources\Chats\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ChatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                Select::make('sender')
                    ->options(['user' => 'User', 'admin' => 'Admin'])
                    ->required(),
            ]);
    }
}
