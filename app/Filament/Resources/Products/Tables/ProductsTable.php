<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('brand')
                    ->label('Brand')
                    ->searchable(),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('stock')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Kategori'),

                ImageColumn::make('image')
                    ->label('Gambar'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}