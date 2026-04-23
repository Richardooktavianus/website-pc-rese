<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Customer'),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),

                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'primary' => 'process',
                        'info' => 'shipped',
                        'danger' => 'cancel',
                    ]),

                TextColumn::make('created_at')
                    ->since(),
            ])

            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}