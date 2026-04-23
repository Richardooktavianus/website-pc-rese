<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Product::count())
                ->description('Jumlah semua produk')
                ->color('success'),

            Stat::make('Total Kategori', Category::count())
                ->description('Kategori tersedia')
                ->color('info'),

            Stat::make('Total User', User::count())
                ->description('User terdaftar')
                ->color('warning'),

            Stat::make('Total Order', Order::count())
                ->description('Pesanan masuk')
                ->color('danger'),

            Stat::make('Total Pendapatan', 'Rp ' . number_format(
                Order::where('status', 'paid')->sum('total_price')
            ))
                ->description('Total penjualan')
                ->color('success'),
        ];
    }
}