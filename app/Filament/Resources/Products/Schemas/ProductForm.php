<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required(),
            TextInput::make('brand')->required(),
            TextInput::make('price')->numeric()->required(),
            TextInput::make('stock')->numeric()->required(),

            Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),

            FileUpload::make('image')
                ->image()
                ->directory('products')
                ->disk('public')
                ->visibility('public'),

            Textarea::make('description'),
        ]);
    }
}