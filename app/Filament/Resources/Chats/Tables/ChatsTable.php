<?php

namespace App\Filament\Resources\Chats\Tables;

use App\Models\Chat;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // 🔥 FIX: AMBIL CHAT TERBARU PER USER (SAFE MYSQL STRICT MODE)
            ->query(
                Chat::query()
                    ->select('chats.*')
                    ->whereIn('id', function ($query) {
                        $query->selectRaw('MAX(id)')
                            ->from('chats')
                            ->groupBy('user_id');
                    })
                    ->orderBy('created_at', 'desc')
            )

            ->columns([
                TextColumn::make('user_id')
                    ->label('User ID')
                    ->sortable(),

                TextColumn::make('message')
                    ->label('Last Message')
                    ->limit(40)
                    ->wrap(),

                TextColumn::make('sender')
                    ->badge()
                    ->color(fn ($state) => $state === 'admin' ? 'success' : 'primary'),

                TextColumn::make('created_at')
                    ->label('Last Chat')
                    ->dateTime()
                    ->sortable(),
            ])

            ->filters([
                //
            ])

            ->recordActions([
                ViewAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}