<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('New Orders', Order::query()->where('status', 'new')->count()),

            Stat::make('Order Processing', Order::query()->where('status', 'processing')->count()),

            Stat::make('Order Shipped', Order::query()->where('status', 'shipped')->count()),

            // Check if avg() returns null and use 0 as default
            Stat::make('Average Price', 
            Number::currency(Order::query()->avg('grand_total') ?? 0, 'KES')
            ),

        ];
    }
}
